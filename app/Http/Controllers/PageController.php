<?php

namespace App\Http\Controllers;

use App\Models\Cart_Payment;
use App\Models\Configurations;
use App\Models\PaymentType;
use App\Models\Plans;
use App\Models\Stores;
use App\Models\SubAccounts;
use Illuminate\Http\Request;
use App\Repositories\StoreBranch\StoreBranchRepository;

class PageController extends Controller
{
    private $branch;
    public function __construct(StoreBranchRepository $branch)
    {
        $this->branch = $branch;
    }

    public function index(Request $request)
    {
        $stores = Stores::Paginate(10);
        return view('main_site.index', ['stores' => $stores]);
    }

    public function aboutUs(Request $request)
    {
        $title = "About Us";
        return view('main_site.about', ['title' => $title]);
    }

    public function privacy(Request $request)
    {
        $title = 'Privacy';
        return view('main_site.privacy', ['title' => $title]);
    }

    public function contactUs(Request $request)
    {
        $title = "Contact Us";
        return view('main_site.contact', ['title' => $title]);
    }

    public function register(Request $request)
    {
        $title = "Sign up";
        return view('main_site.register', ['title' => $title]);
    }

    public function login(Request $request)
    {
        $title = "Sign in";
        return view('main_site.login', ['title' => $title]);
    }

    public function products(Request $request, $branch_id)
    {
        $id = \decrypt($branch_id);
        $branch = $this->branch->getBranch($id);
        $title = ' ' . $branch->name . ' Products';
        return view('main_site.product', ['title' => $title, 'branch_id' => $branch_id]);
    }

    public function product(Request $request, $product_id)
    {
        $title = 'Product';
        return view('main_site.single_product', ['title' => $title, 'product_id' => $product_id]);
    }

    public function pay(Request $request, $transaction_id)
    {
        $title = 'Payment';
        $transaction = Cart_Payment::where('transaction_id', $transaction_id)->first();
        if ($transaction) {
            if ($transaction->status == '1') {
                return redirect()->route('successful_payment', [$transaction_id]);
            } else {
                if ($transaction->payment_type_id == '3') {
                    $sub_account = SubAccounts::where('payment_type_id','3')->where('store_branch_id',$transaction->store_branch_id)->first();
                    $main_sub_account = $sub_account->sub_account_code;
                    $public_key = Configurations::where('type', 'paystack_public_key')->first();
                    return view('user.paystack', ['title' => $title, 'transaction' => $transaction, 'public_key' => $public_key->value, 'sub_account' => $main_sub_account]);
                } else if ($transaction->payment_type_id == '4') {
                    $sub_account = SubAccounts::where('payment_type_id','4')->where('store_branch_id',$transaction->store_branch_id)->first();
                    $main_sub_account = $sub_account->sub_account_code;
                    $public_key = Configurations::where('type', 'flutterwave_public_key')->first();
                    return view('user.flutterwave', ['title' => $title, 'transaction' => $transaction, 'public_key' => $public_key->value, 'sub_account' => $main_sub_account]);
                }
            }
        } else {
            return redirect()->route('landing_page');
        }
    }

    public function successPayment(Request $request, $transaction_id)
    {
        $title = 'Payment';
        $transaction = Cart_Payment::where('transaction_id', $transaction_id)->first();
        if ($transaction) {
            return view('user.complete', ['title' => $title, 'transaction' =>  $transaction]);
        } else {
            return redirect()->route('landing_page');
        }
    }

    public function activateUser(Request $request)
    {
        $title = 'Activate User';
        return view('emails.user_activation', ['title' => $title]);
    }

    public function forgotPassword(Request $request)
    {
        $title = 'Forgot Password';
        return view('main_site.forgot_password', ['title' => $title]);
    }

    public function email()
    {
        return view('emails.password_reset', ['link' => '1']);
    }

    public function advert(Request $request)
    {
        $title = 'Place an Ad';
        return view('main_site.ads', ['title' => $title]);
    }

    public function pricing(Request $request)
    {
        $title = 'Pricing';
        $plans = Plans::where('status','1')->get();
        return view('main_site.pricing', ['title' => $title,'plans' => $plans]);
    }

    public function adsHome(Request $request)
    {
        $title = 'Ads';
        $data['paystack'] = Configurations::where('type','paystack_public_key')->first();
        $data['flutter'] = Configurations::where('type','flutterwave_public_key')->first();
        return view('ads.home', ['title' => $title,'data' => $data]);
    }

    public function profile(Request $request){
        $title = 'Profile';
        return view('ads.profile', ['title' => $title]);
    }

    public function createCampaign(Request $request){
        $title = 'Create Campaign';
        $plans = Plans::where('status','1')->get();
        $config = Configurations::where('type','service_charge')->first();
        $payments = PaymentType::where('id','>','2')->get();
        return view('ads.campaign', ['title' => $title,'plans' => $plans,'payment_types' => $payments,'config' => $config]);
    }
}
