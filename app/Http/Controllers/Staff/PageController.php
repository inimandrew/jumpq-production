<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Repositories\StoreType\StoreTypeRepository as Type;
use App\Repositories\Products\ProductRepository;
use App\Repositories\Stores\StoreRepository as Store;
use App\Repositories\Staffs\StaffRepository as Staff;
use App\Repositories\Others\OtherRepository;
use App\Repositories\StoreBranch\StoreBranchRepository as StoreBranch;
use App\Repositories\StaffRoles\StaffRolesRepository as Role;
use Auth;
use App\Models\Configurations;
use Session;
use Illuminate\Http\Request;
use App\Models\Cart_Payment;
use App\Models\PaymentType;
use App\Models\Banks;
use App\Models\Currency;
use App\Models\SubAccounts;
use Faker\Provider\Payment;
use Payments;

class PageController extends Controller
{
    private $type;
    private $store;
    private $branch;
    private $role;
    private $other;
    private $staff;
    private $product;

    public function __construct(Type $type, Store $store, StoreBranch $branch, Role $role, OtherRepository $other, Staff $staff, ProductRepository $product)
    {
        $this->type = $type;
        $this->store = $store;
        $this->branch = $branch;
        $this->role = $role;
        $this->other = $other;
        $this->staff = $staff;
        $this->product = $product;
    }
    public function returnTypes()
    {
        return $this->type->getTypes();
    }

    public function returnBranches()
    {
        return $this->branch->getAllBlade();
    }

    public function returnRoles()
    {
        return $this->role->show();
    }

    public function index(Request $request)
    {
        return redirect()->route('staff_login');
    }


    public function templatePages($body, $title, array $data = NULL)
    {
        $template = 'includes';
        $pages['head'] = $template . '.head';
        $pages['navbar'] = $template . '.navbar1';
        $pages['sidebar'] = $template . '.sidebar1';
        $pages['footer'] = $template . '.footer';
        $pages['scripts'] = $template . '.script';
        $pages['body'] = $body;

        return view('includes.master', ['title' => $title, 'pages' => $pages, 'data' => $data]);
    }

    public function loginPage(Request $request)
    {
        if (Auth::guard('staff')->check() && !empty(Auth::guard('staff')->user()->api_token)) {
            return redirect()->route('staff_home');
        } else {
            return view('landing.staff.login', ['title' => 'Staff Login']);
        }
    }

    public function home(Request $request)
    {
        $title = "Home";
        $data = [];
        $data['available_tags'] = $this->other->countAvailableTags(Auth::guard('staff')->user()->store_branch_id);
        $data['sales'] = 0;
        $data['staffs'] = $this->staff->countStaffs(Auth::guard('staff')->user()->store_branch_id);
        $data['products'] = $this->product->countProducts(Auth::guard('staff')->user()->store_branch_id);
        return $this->templatePages('staff.home', $title, $data);
    }

    public function profile(Request $request)
    {
        $title = 'Account Profile';
        return $this->templatePages('staff.profile', $title);
    }

    public function new_branch(Request $request)
    {
        $title = "New Branch";
        $store_types = $this->returnTypes();
        $parent_store = [Auth::guard('staff')->user()->branch->store];

        $data = ['stores' => $parent_store, 'store_types' => $store_types];
        return $this->templatePages('staff_admin.new_branch', $title, $data);
    }

    public function new_staff(Request $request)
    {
        $title = 'New Staff';
        $store_branches = [Auth::guard('staff')->user()->branch];
        $roles = $this->returnRoles();
        $data = ['branches' => $store_branches, 'roles' => $roles];
        return $this->templatePages('staff_admin.new_staff', $title, $data);
    }

    public function branches(Request $request, $store_id)
    {
        $id = decrypt($store_id);
        $title = "Store Branches";
        $store = $this->store->getOne($id);
        $data = ['store_id' => $store_id, 'store_name' => $store->name];
        return $this->templatePages('admin.branches', $title, $data);
    }

    public function staffs(Request $request, $branch_id)
    {
        $id = decrypt($branch_id);
        $title = "Admin - Staffs";
        $branch = $this->branch->getBranch($id);
        $data = ['branch_name' => $branch->name, 'branch_id' => $branch_id];
        return $this->templatePages('admin.staffs', $title, $data);
    }

    public function category(Request $request)
    {
        $title = 'Categories';
        return $this->templatePages('staff.categories', $title);
    }

    public function product(Request $request)
    {
        $title = 'New Product';
        return $this->templatePages('staff.new_products', $title);
    }

    public function deleteProducts(Request $request)
    {
        $branch = Auth::guard('staff')->user()->store_branch_id;
        $this->product->deleteProductsByBranch($branch);
        Session::put('green', 1);
        return redirect()->back()->withErrors(['message' => 'Products Deleted']);
    }

    public function products(Request $request)
    {
        $title = 'Products';
        return $this->templatePages('staff.products', $title);
    }

    public function editProduct(Request $request, $product_id)
    {
        $title = 'Edit Product';
        $data['product_id'] = $product_id;
        return $this->templatePages('staff.edit_product', $title, $data);
    }

    public function allocateTags(Request $request)
    {
        $title = 'Allocate Product to Tags';
        return $this->templatePages('staff.allocation', $title);
    }

    // public function salesRecords(Request $request)
    // {
    //     $title = 'Sales Records';
    //     $branch = $this->staff->getBranchId(Auth::guard('staff')->user()->api_token);
    //     $data['buyers'] = $this->other->getSalesRecordsAll($branch);
    //     return $this->templatePages('staff.sales_records', $title, $data);
    // }

    public function checkIn(Request $request)
    {
        $title = 'Barcode only Check In';
        return $this->templatePages('staff.only_barcode', $title);
    }

    public function checkout(Request $request)
    {
        $title = 'Product CheckOut';
        $data['service_charge'] = Configurations::where('type', 'service_charge')->first();
        return $this->templatePages('staff.checkout', $title, $data);
    }

    public function invoice(Request $request, $transaction_id)
    {
        $title = 'Reciept';
        $cart_payment = Cart_Payment::where('transaction_id', $transaction_id)->first();
        if ($cart_payment) {
            $data['cart_payment'] = $cart_payment;
            return $this->templatePages('staff.invoice', $title, $data);
        } else {
            Session::put('red', 1);
            return redirect()->route('staff_home')->WithErrors(['errors' => 'Invalid Transaction Id']);
        }
    }

    public function checkoutProducts(Request $request)
    {
        $title = "CheckOut Products";
        $tags = $this->other->checkOutTags(Auth::guard('staff')->user()->store_branch_id);
        $data['tags'] = $tags;
        return $this->templatePages('staff.log_checkout', $title, $data);
    }


    public function addAccount(Request $request)
    {
        $title = "Add Business Account";
        $data['currencies'] = Currency::all();
        $data['banks'] = Banks::all();
        $payment_array = [];
        if (Auth::guard('staff')->user()->branch->sub_account) {
            $data['paystack'] = SubAccounts::where('store_branch_id', Auth::guard('staff')->user()->store_branch_id)->where('payment_type_id', '3')->first();
            $data['flutter'] = SubAccounts::where('store_branch_id', Auth::guard('staff')->user()->store_branch_id)->where('payment_type_id', '4')->first();
        }

        if (empty($data['paystack'])) {
            array_push($payment_array, 'paystack');
        }
        if (empty($data['flutter'])) {
            array_push($payment_array, 'flutter');
        }
        $data['payments'] = PaymentType::whereIn('name', $payment_array)->get();
        return $this->templatePages('staff.sub_accounts', $title, $data);
    }

    public function transactions(Request $request)
    {
        $title = 'Transactions';
        return $this->templatePages('staff.transactions', $title);
    }

    public function tagsAllocation(Request $request)
    {
        $title = 'Tags Allocation';
        return $this->templatePages('staff.allocations', $title);
    }
}
