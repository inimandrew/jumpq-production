<?php

namespace App\Http\Controllers;

use App\Models\Accounts;
use App\Models\Campaigns;
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

    public function landing(Request $request)
    {
        return view('landing.home', ['title' => 'Home']);
    }

    public function contact(Request $request)
    {
        return view('landing.contact-us', ['title' => 'Contact Us']);
    }

    public function plans(Request $request)
    {
        $plans = Plans::with('assets_allowed')->where('status', '1')->get();
        return view('landing.plans', ['title' => 'Plans', 'plans' => $plans]);
    }

    public function authLogin(Request $request)
    {
        return view('landing.auth.login', ['title' => 'Login']);
    }

    public function authRegister(Request $request)
    {
        return view('landing.auth.register', ['title' => 'Sign up']);
    }

    public function privacyPage(Request $request)
    {
        return view('landing.privacy', ['title' => 'Privacy']);
    }

    public function AppDownload(Request $request)
    {
        $title = "Download App";
        return view('landing.download', ['title' => $title]);
    }

    public function downloadApp(Request $request)
    {
        return response()->download(public_path() . '/assets/jumpq.apk', [
            'Content-Type' => 'application/vnd.android.package-archive',
            'Content-Disposition' => 'attachment; filename="jumpq.apk"',
        ]);
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
                    $sub_account = SubAccounts::where('payment_type_id', '3')->where('store_branch_id', $transaction->store_branch_id)->first();
                    $main_sub_account = $sub_account->sub_account_code;
                    $public_key = Configurations::where('type', 'paystack_public_key')->first();
                    return view('landing.paystack', ['title' => $title, 'transaction' => $transaction, 'public_key' => $public_key->value, 'sub_account' => $main_sub_account]);
                } else if ($transaction->payment_type_id == '4') {
                    $sub_account = SubAccounts::where('payment_type_id', '4')->where('store_branch_id', $transaction->store_branch_id)->first();
                    $main_sub_account = $sub_account->sub_account_code;
                    $public_key = Configurations::where('type', 'flutterwave_public_key')->first();
                    return view('landing.flutterwave', ['title' => $title, 'transaction' => $transaction, 'public_key' => $public_key->value, 'sub_account' => $main_sub_account]);
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
            return view('landing.complete', ['title' => $title, 'transaction' =>  $transaction]);
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
        return view('landing.auth.forgot-password', ['title' => $title]);
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

    public function advertLogin(Request $request)
    {
        $title = 'Place an Ad';
        return view('landing.ads.auth.login', ['title' => $title]);
    }

    public function advertRegistration(Request $request)
    {
        $title = 'Place an Ad';
        return view('landing.ads.auth.register', ['title' => $title]);
    }

    public function pricing(Request $request)
    {
        $title = 'Pricing';
        $plans = Plans::where('status', '1')->get();
        return view('main_site.pricing', ['title' => $title, 'plans' => $plans]);
    }

    public function adsHome(Request $request)
    {
        $title = 'Ads';
        $data['paystack'] = Configurations::where('type', 'paystack_public_key')->first();
        $data['flutter'] = Configurations::where('type', 'flutterwave_public_key')->first();
        $campaigns = Campaigns::where('id', $request->user('ads')->id)->with(['payment', 'account'])->get();
        return view('landing.ads.dashboard', ['title' => $title, 'data' => $data, 'campaigns' => $campaigns]);
    }

    public function profile(Request $request)
    {
        $title = 'Profile';
        return view('landing.ads.profile', ['title' => $title]);
    }

    public function createCampaign(Request $request)
    {
        $title = 'Create Campaign';
        $plans = Plans::where('status', '1')->get();
        $config = Configurations::where('type', 'service_charge')->first();
        $payments = PaymentType::where('id', '>', '2')->get();
        return view('landing.ads.new-campaign', ['title' => $title, 'plans' => $plans, 'payment_types' => $payments, 'config' => $config]);
    }
}