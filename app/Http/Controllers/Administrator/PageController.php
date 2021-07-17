<?php

namespace App\Http\Controllers\Administrator;
use App\Repositories\StoreType\StoreTypeRepository as Type;
use App\Repositories\Stores\StoreRepository as Store;
use App\Repositories\StoreBranch\StoreBranchRepository as StoreBranch;
use App\Repositories\StaffRoles\StaffRolesRepository as Role;
use App\Models\Products;
use App\Models\Stores_Branch;
use App\Models\Stores;
use App\Models\Staffs;
use Auth;
use App\Http\Controllers\Controller;
use App\Models\Accounts;
use App\Models\AssetType;
use App\Models\Campaigns;
use App\Models\Plans;
use Illuminate\Http\Request;

class PageController extends Controller
{
    private $type;
    private $store;
    private $branch;
    private $role;

    public function __construct(Type $type,Store $store,StoreBranch $branch,Role $role){
        $this->type = $type;
        $this->store = $store;
        $this->branch = $branch;
        $this->role = $role;
    }

    public function index(Request $request){
        return redirect()->route('admin_login');
    }

    public function login(Request $request){
        if(Auth::guard('admin')->check() && Auth::guard('admin')->user()->api_token){
            return redirect()->route('admin_home');
        }else{
            return view('admin.login');
        }

    }

    public function templatePages($body,$title,array $data = NULL){
        $template = 'includes';
        $pages['head'] = $template.'.head';
        $pages['navbar'] = $template.'.navbar';
        $pages['sidebar'] = $template.'.sidebar';
        $pages['footer'] = $template.'.footer';
        $pages['scripts'] = $template.'.script';
        $pages['body'] = $body;

        return view('includes.master',['title'=> $title,'pages' => $pages,'data' => $data]);
    }

    public function dashboard(Request $request){
        $title = "Admin - Dashboard";
        $data = array();
        $data['products_count'] = Products::count();
        $data['staff_count'] = Staffs::count();
        $data['stores_count'] = Stores::count();
        $data['branches_count'] = Stores_Branch::count();
        return $this->templatePages('admin.home',$title,$data);
    }

    public function createAdminPage(Request $request){
        $title = "Admin - Create Admin Account";
        return $this->templatePages('admin.create_admin',$title);
    }

    public function profilePage(Request $request){
        $title = "Admin - Profile";
        return $this->templatePages('admin.profile',$title);
    }

    public function displayAdmins(Request $request){
        $title = "Admins";
        return $this->templatePages('admin.admins',$title);

    }

    public function newStorePage(Request $request){
        $title = "Admin - New Store";
        $data = ['store_types' => $this->returnTypes()];
        return $this->templatePages('admin.create_store',$title,['store_types' => $this->returnTypes()]);
    }

    public function returnTypes(){
        return $this->type->getTypes();
    }

    public function returnBranches(){
        return $this->branch->getAllBlade();
    }

    public function returnRoles(){
        return $this->role->show();
    }

    public function storesPage(Request $request){
        $title = "Admin - Stores";
        return $this->templatePages('admin.stores',$title);
    }

    public function editBranch(Request $request){
        $title = "Admin - Edit Stores";
        $data['branches'] = $this->branch->getAllBranches();
        return $this->templatePages('admin.edit-store',$title,$data);
    }

    public function branchPage(Request $request){
        $title = "Admin - New Branch";
        $store_types = $this->returnTypes();
        $registered_stores = $this->store->showAllBlade();
        $data = ['stores' => $registered_stores,'store_types' => $store_types];
        return $this->templatePages('staff_admin.new_branch', $title,$data);
    }

    public function staffPage(Request $request){
        $title = "Admin - New Staff";
        $store_branches = $this->returnBranches();
        $roles = $this->returnRoles();
        $data = ['branches' => $store_branches,'roles' => $roles];
        return $this->templatePages('staff_admin.new_staff', $title,$data);
    }

    public function branchesPage(Request $request,$store_id){
        $id = decrypt($store_id);
        $title = "Admin - Store Branches";
        $store = $this->store->getOne($id);
        $data = ['store_id'=>$store_id,'store_name' => $store->name];
        return $this->templatePages('admin.branches', $title,$data);
    }

    public function staffsPage(Request $request,$branch_id){
        $id = decrypt($branch_id);
        $title = "Admin - Staffs";
        $branch = $this->branch->getBranch($id);
        $data = ['branch_name'=>$branch->name,'branch_id' => $branch_id];
        return $this->templatePages('admin.staffs', $title,$data);
    }

    public function plansPage(Request $request){
        $title = 'Adverts Payment Plans';
        $data['plans'] = Plans::all();
        $data['assets'] = AssetType::all();
        return $this->templatePages('admin.plans', $title,$data);
    }

    public function adsAccount(Request $request){
        $title = 'Adverts Accounts';
        $data['accounts'] = Accounts::all();
        return $this->templatePages('admin.ads_accounts', $title,$data);
    }

    public function campaigns(Request $request){
        $title = 'Campaigns';
        $data['campaigns'] = Campaigns::all();
        return $this->templatePages('admin.campaigns', $title,$data);
    }
}
