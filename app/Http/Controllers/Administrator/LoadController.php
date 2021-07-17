<?php

namespace App\Http\Controllers\Administrator;

use App\Repositories\Administrator\AdminRepository;
use App\Repositories\Others\OtherRepository;
use App\Repositories\Stores\StoreRepository;
use App\Repositories\StoreBranch\StoreBranchRepository;
use App\Repositories\Staffs\StaffRepository;
use App\Http\Controllers\Controller;
use App\Http\Controllers\FileController;
use Illuminate\Http\Request;
use Validator;
use Hash;
use Auth;
use App\Http\Controllers\Single\StoreController;
use App\Models\Accounts;
use App\Models\Campaigns;
use App\Models\Plans;
use Session;

class LoadController extends Controller
{
    private $admin, $file, $store, $branch, $staff, $s, $other;

    public function __construct(AdminRepository $admin, StoreRepository $store, StoreBranchRepository $branch, StaffRepository $staff, FileController $file, StoreController $s, OtherRepository $other)
    {
        $this->admin = $admin;
        $this->staff = $staff;
        $this->store = $store;
        $this->file = $file;
        $this->branch = $branch;
        $this->s = $s;
        $this->other = $other;
    }

    public function register(Request $request)
    {
        try {
            $data = $request->except('_token');
            $rules = [
                'firstname' => 'required|alpha|max:25',
                'lastname' => 'required|alpha|max:25',
                'email' => 'required|email|unique:admins,email',
                'username' => 'required|alpha_dash|max:25|unique:admins,username',
                'password' => 'required|min:10',
                'phone' => 'required|numeric|unique:admins,phone|min:11'
            ];

            $validation = Validator::make($data, $rules);
            if ($validation->fails()) {
                return response()->json(['errors' => $validation->errors()], 300);
            } else {
                $data['firstname'] = ucfirst(strtolower($data['firstname']));
                $data['lastname'] = ucfirst(strtolower($data['lastname']));
                $data['password'] = Hash::make($data['password']);
                $data['profile_image_location'] = "images.jpg";
                $status = $this->admin->create($data);

                if ($status == '0') {
                    return response()->json(['message' => ['User was Created Successfully']], 200);
                } else {
                    return response()->json(['errors' => ['An Error Occured while creating new User']], 300);
                }
            }
        } catch (\Exception $e) {
            return response()->json(['errors' => ['Opps, An Error Occured. Please Try again .']]);
        }
    }

    public function authenticate(Request $request)
    {
        try {

            $rules = [
                'username' => 'required|alpha_dash|max:25|exists:admins,username',
                'password' => 'required'
            ];

            $validation = Validator::make($request->except('_token'), $rules);

            if ($validation->fails()) {
                return response()->json(['errors' => $validation->errors()]);
            } else {
                if (Auth::guard('admin')->attempt(['username' => $request['username'], 'password' => $request['password'], 'status' => '2'], 1)) {
                    return response()->json(['errors' => ['Your Account has been Suspended and placed Under Review. Please Contact Support']]);
                } elseif (Auth::guard('admin')->attempt(['username' => $request['username'], 'password' => $request['password']], 1)) {
                    $this->admin->setApiKey($request['username']);
                    return response()->json(['message' => ['Login Successful']]);
                } else {
                    return response()->json(['errors' => ['Password is Incorrect']]);
                }
            }
        } catch (\Exception $e) {
            return response()->json(['errors' => ['Opps, An Error Occured. Please Try again .']]);
        }
    }

    public function logout(Request $request)
    {
        $api_token = $request->header('api_token');
        $this->admin->logout($api_token);
        Auth::guard('admin')->logout();
        return response()->json(['message' => ['Logout Successful']]);
    }

    public function updateProfile(Request $request)
    {
        $data = $request->except('_token');

        $rules = [
            'firstname' => 'required|alpha|max:25',
            'lastname' => 'required|alpha|max:25',
            'username' => 'required|alpha_dash|max:25|exists:admins,username',
            'password' => 'nullable|alpha_dash|min:10',
            'phone' => 'required|digits:11',
            'photo' => 'nullable|image|mimes:png,jpg,jpeg|max:2048',
        ];

        $validation = Validator::make($data, $rules);

        if ($validation->fails()) {
            return response()->json(['errors' => $validation->errors()]);
        } else {

            $data['firstname'] = ucfirst(strtolower($data['firstname']));
            $data['lastname'] = ucfirst(strtolower($data['lastname']));
            if (empty($data['password'])) {
                unset($data['password']);
            } else {
                $data['password'] = Hash::make($data['password']);
            }
            if (empty($data['photo'])) {
                unset($data['photo']);
            } else {
                $path = $this->file->uploadProfileImage($request->file('photo'));
                unset($data['photo']);
                $data['profile_image_location'] = $path;
            }
            $update_count = $this->admin->update($data);

            if ($update_count == 1) {
                return response()->json(['message' => ['Profile Updated Successfully']]);
            }
        }
    }

    public function getAdmins()
    {
        $admins = $this->admin->getAll();
        return response()->json($admins);
    }

    public function changeStatus(Request $request)
    {
        $rules = [
            'username' => 'required|exists:admins,username',
            'action' => 'required|alpha'
        ];
        $data = $request->toArray();
        $validation = Validator::make($data, $rules);

        if ($validation->fails()) {
            return response()->json(['errors' => $validation->errors()]);
        } else {
            $action = $data['action'];
            unset($data['action']);

            if ($action == 'suspend') {
                $data['status'] = '2';
                $message = "User Suspended";
            } else if ($action == 'activate' | $action == 'unsuspend') {
                $data['status'] = '1';
                $message = "User Activated Successfully";
            }

            $success = $this->admin->update($data);

            if ($success) {
                return response()->json(['message' => [$message]]);
            }
        }
    }

    public function createStore(Request $request)
    {
        $data = $request->except('_token');
        $rules = [
            'store_type' => 'required|exists:stores_type,id',
            'organisation' => 'required|string|unique:stores,name',
            'branch_name' => 'required|unique:stores_branches,name',
            'branch_address' => 'required|string',
            'branch_phone' => 'required|numeric',
            'admin_firstname' => 'required|alpha|max:30',
            'admin_lastname' => 'required|alpha|max:30',
            'admin_email' => 'required|email|unique:staffs,email',
            'admin_username' => 'required|alpha_dash|unique:staffs,username',
            'admin_phone' => 'required|max:11|unique:staffs,phone',
            'currency' => 'required|exists:currencies,id',
            'password' => 'required|alpha_dash|confirmed|min:10',
            'password_confirmation' => 'required',
            'country' => 'required|string',
            'state' => 'required|string'
        ];

        $validation = Validator::make($data, $rules);

        if ($validation->fails()) {
            return response()->json(['errors' => $validation->errors()]);
        } else {
            $store_data = [
                'name' => ucwords($data['organisation']),
                'unique_id' => $this->s->getRandomDigits()
            ];

            $store_saved = $this->store->create($store_data);

            if ($store_saved) {
                $branch_data = [
                    'store_type_id' => $data['store_type'],
                    'store_id' => $store_saved->id,
                    'unique_id' => $this->s->getRandomDigits(),
                    'name' => ucwords($data['branch_name']),
                    'phone' => $data['branch_phone'],
                    'address' => ucwords($data['branch_address']),
                    'country' => $data['country'],
                    'currency_id' => $data['currency'],
                    'state' => $data['state'],
                    'country' => $data['country']
                ];
                $branch_saved = $this->branch->create($branch_data);
                if ($branch_saved) {
                    $staff_data = [
                        'firstname' => ucfirst(strtolower($data['admin_firstname'])),
                        'lastname' => ucfirst(strtolower($data['admin_lastname'])),
                        'email' => $data['admin_email'],
                        'username' => $data['admin_username'],
                        'phone' => $data['admin_phone'],
                        'password' => Hash::make($data['password']),
                        'store_branch_id' => $branch_saved->id,
                        'role_id' => '1',
                        'status' => '0'
                    ];
                    $staff_saved = $this->staff->create($staff_data);
                    if ($staff_saved->id) {
                        return response()->json(['message' => ['Store Created Successfully. Please Confirm Email Address to Activate Account']]);
                    } else {
                        return response()->json(['errors' => ['Oops, An Error Occurred. Reload Page and Try Again']]);
                    }
                } else {
                    return response()->json(['errors' => ['Oops, An Error Occurred. Reload Page and Try Again']]);
                }
            } else {
                return response()->json(['errors' => ['Oops, An Error Occurred. Reload Page and Try Again']]);
            }
        }
    }

    public function getStores(Request $request)
    {
        $stores = $this->store->showAll();
        return response()->json($stores);
    }

    public function updateCommission(Request $request)
    {
        $data = $request->all();
        $data['store_branch_id'] = \decrypt($data['store_branch_id']);
        $rules = [
            'commission_rate' => ['required', 'numeric'],
            'store_branch_id' => ['required', 'exists:stores_branches,id']
        ];
        $validation = Validator::make($data, $rules);

        if ($validation->fails()) {
            return response()->json(['errors' => $validation->errors()]);
        } else {
            $api_token = $request->header('api_token');
            $branch_id = $data['store_branch_id'];
            unset($data['store_branch_id']);
            $update_count = $this->branch->update($data, $branch_id);
            return response()->json(['message' => ['Commission Rate Successfully Updated']]);
        }
    }

    public function createPlan(Request $request)
    {
        $data = $request->all();
        $rules = [
            'name' => ['required', 'alpha', 'unique:plans'],
            'daily_counts' => ['required', 'numeric', 'unique:plans'],
            'price' => ['required', 'numeric', 'unique:plans'],
            'assets.*' => ['required', 'numeric'],
        ];
        $messages = [
            'daily_counts.unique' => 'Two Plans cannot have the same Daily Counts',
            'price.unique' => 'Two Plans cannot have the same price',
        ];
        $validation = Validator::make($data, $rules, $messages);

        if ($validation->fails()) {
            Session::put('red', 1);
            return redirect()->back()->withErrors($validation->errors())->withInput();
        } else {
            $new_plan = Plans::create([
                'name' => $data['name'],
                'daily_counts' => $data['daily_counts'],
                'price' => $data['price'],
            ]);
            foreach ($data['assets'] as $key => $value) {
                $new_plan->assets_allowed()->attach($value);
            }
            Session::put('green', 1);
            return redirect()->back()->withErrors(['message' => 'Plan Created Successfully']);
        }
    }

    public function toggleStatus(Request $request, $id, $status)
    {
        Plans::where('id', $id)->update(['status' => $status]);
        Session::put('green', 1);
        return redirect()->back()->withErrors(['message' => 'Plan Status Changed Successfully']);
    }

    public function toggleAccountStatus(Request $request, $id, $status)
    {
        Accounts::where('id', $id)->update(['status' => $status]);
        Session::put('green', 1);
        return redirect()->back()->withErrors(['message' => 'Ad-Account Status Changed Successfully']);
    }

    public function toggleApprovalStatus(Request $request, $id, $status)
    {
        Campaigns::where('id', $id)->update(['approved' => $status]);
        Session::put('green', 1);
        return redirect()->back()->withErrors(['message' => 'Campaign Approval Status Changed Successfully']);
    }

    public function toggleCampaignStatus(Request $request, $id, $status)
    {
        if ($status == 0) {
            Campaigns::where('id', $id)->update(['status' => $status]);
        } else {
            $this->other->activateCampaign($id);
        }
        Session::put('green', 1);
        return redirect()->back()->withErrors(['message' => 'Campaign Status Changed Successfully']);
    }

    public function editBranch(Request $request){
        $data = $request->only(['itemMax','branch']);
        $rules = [
            'itemMax' => 'required|numeric|min:1',
            'branch' => 'required|numeric|exists:stores_branches,id',
        ];
        $validation = Validator::make($data, $rules);
        if ($validation->fails()) {
            Session::put('red', 1);
            return redirect()->back()->withErrors($validation->errors());
        }else{
            $this->branch->update(["itemMax" => $data["itemMax"]], $data["branch"]);
            Session::put('green', 1);
            return redirect()->back()->withErrors(['message' => "Branch Maximum Items for Customers Updated"]);

        }
    }
}
