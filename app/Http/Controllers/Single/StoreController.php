<?php

namespace App\Http\Controllers\Single;

use App\Repositories\StoreBranch\StoreBranchRepository;
use App\Repositories\Stores\StoreRepository;
use App\Repositories\Staffs\StaffRepository;
use App\Http\Controllers\Controller;
use Validator;
use Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class StoreController extends Controller
{
    private $branch, $staff, $store;

    public function __construct(StoreBranchRepository $branch, StaffRepository $staff, StoreRepository $store)
    {
        $this->staff = $staff;
        $this->branch = $branch;
        $this->store = $store;
    }

    public function getRandomDigits()
    {
        return random_int(10000, 99999);
    }


    public function newBranch(Request $request)
    {
        $data = $request->except('_token');
        $rules = [
            'store_type' => 'required|exists:stores_type,id',
            'parent' => 'required|numeric|exists:stores,id',
            'branch_name' => 'required|unique:stores_branches,name',
            'branch_address' => 'required|string',
            'branch_phone' => 'required|numeric',
            'admin_firstname' => 'required|alpha|max:30',
            'admin_lastname' => 'required|alpha|max:30',
            'admin_email' => 'required|email|unique:staffs,email',
            'admin_username' => 'required|alpha_dash|unique:staffs,username',
            'admin_phone' => 'required|max:11|unique:staffs,phone',
            'password' => 'required|alpha_dash|confirmed',
            'password_confirmation' => 'required',
            'currency' => 'required|exists:currencies,id',
            'country' => 'required|string',
            'state' => 'required|string'
        ];

        $validation = Validator::make($data, $rules);

        if ($validation->fails()) {
            return response()->json(['errors' => $validation->errors()]);
        } else {

            $branch_data = [
                'store_type_id' => $data['store_type'],
                'unique_id' => $this->getRandomDigits(),
                'store_id' => $data['parent'],
                'name' => ucwords($data['branch_name']),
                'phone' => $data['branch_phone'],
                'address' => ucwords($data['branch_address']),
                'commission_rate' => 10,
                'currency_id' => $data['currency'],
                'state' => $data['state'],
                'country' => $data['country']
            ];
            $branch_saved = $this->branch->create($branch_data);
            if ($branch_saved) {
                $staff_data = [
                    'firstname' => ucfirst(strtolower($data['admin_firstname'])),
                    'lastname' => ucfirst(strtolower($data['admin_lastname'])),
                    'unique_id' => $this->getRandomDigits(),
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
                    return response()->json(['message' => ['New Branch Created Successfully. Please Confirm Email Address to Activate Account']]);
                } else {
                    return response()->json(['errors' => ['Oops, An Error Occurred. Reload Page and Try Again']]);
                }
            } else {
                return response()->json(['errors' => ['Oops, An Error Occurred. Reload Page and Try Again']]);
            }
        }
    }

    public function newStaff(Request $request)
    {
        $data = $request->except('_token');
        $rules = [
            'branch' => 'required|exists:stores_branches,id',
            'admin_firstname' => 'required|alpha|max:30',
            'admin_lastname' => 'required|alpha|max:30',
            'admin_email' => 'required|email|unique:staffs,email',
            'admin_username' => 'required|alpha_dash|unique:staffs,username',
            'admin_phone' => 'required|max:11|unique:staffs,phone',
            'role' => 'required|exists:roles,id',
            'password' => 'required|alpha_dash|confirmed',
            'password_confirmation' => 'required',
        ];

        $validation = Validator::make($data, $rules);

        if ($validation->fails()) {
            return response()->json(['errors' => $validation->errors()]);
        } else {


            $staff_data = [
                'firstname' => ucfirst(strtolower($data['admin_firstname'])),
                'lastname' => ucfirst(strtolower($data['admin_lastname'])),
                'email' => $data['admin_email'],
                'username' => $data['admin_username'],
                'phone' => $data['admin_phone'],
                'password' => Hash::make($data['password']),
                'store_branch_id' => $data['branch'],
                'role_id' => $data['role'],
                'status' => '0'
            ];
            $staff_saved = $this->staff->create($staff_data);
            if ($staff_saved->id) {
                return response()->json(['message' => ['Staff Account Created Successfully. Please Confirm Email Address to Activate Account']]);
            } else {
                return response()->json(['errors' => ['Oops, An Error Occurred. Reload Page and Try Again']]);
            }
        }
    }

    public function getBranches(Request $request, $store_id)
    {
        $id = decrypt($store_id);
        $branches = $this->branch->getBranches($id);
        return response()->json($branches);
    }

    public function changeStatus(Request $request)
    {
        $id = decrypt($request['branch_unique_id']);
        $action = $request['action'];

        if ($action == 'activate') {
            $data['status'] = '1';
            $message = "Branch Activated Successfully";
        } else if ($action == 'suspend') {
            $data['status'] = '2';
            $message = "Branch Suspended";
        } else if ($action == 'unsuspend') {
            $data['status'] = '1';
            $message = "Branch Unsuspended";
        }
        $success = $this->branch->update($data, $id);

        return response()->json(['message' => [$message]]);
    }

    public function deleteBranch(Request $request)
    {
        $id = decrypt($request['branch_unique_id']);
        $store_id = $this->branch->getStoreId($id);
        $remaining_branches_count = $this->store->branchCount($store_id);
        if ($remaining_branches_count > 1) {
            $success = $this->branch->deleteBranch($id);
            if ($success) {
                return response()->json(['message' => ['Branch Deleted Successfully']]);
            } else {
                return response()->json(['errors' => ['Oops, An Error Occurred. Please Reload and Try again']]);
            }
        } else {
            return response()->json(['errors' => ['You cannot delete the last branch']]);
        }
    }

    public function getStaffs(Request $request, $branch_id)
    {
        $id = decrypt($branch_id);
        $staffs = $this->staff->getStaffs($id);
        return response()->json($staffs);
    }

    public function changeStaffStatus(Request $request)
    {
        $data = $request->toArray();
        $data['id'] = decrypt($data['staff_unique_id']);
        $rules = [
            'id' => 'required|exists:staffs,id',
            'action' => 'required|string'
        ];
        $validation = Validator::make($data, $rules);
        if ($validation->fails()) {
            return response()->json(['errors' => $validation->errors()]);
        } else {
            if ($data['action'] == 'activate') {
                $data['status'] = '1';
                $message = "Staff Accout has been Activated Successfully";
            } else if ($data['action'] == 'suspend') {
                $data['status'] = '2';
                $message = "Staff Accout has been Suspended";
            } else if ($data['action'] == 'unsuspend') {
                $data['status'] = '1';
                $message = "Staff Accout has been Activated Successfully";
            }
            unset($data['staff_unique_id']);
            unset($data['action']);
            $where['id'] = $data['id'];

            $success = $this->staff->update($data, $where);
            if ($success) {
                return response()->json(['message' => [$message]]);
            }
        }
    }

    public function deleteStaff(Request $request)
    {
        $staff_id = decrypt($request['staff_unique_id']);
        $staff = $this->staff->getOne($staff_id);
        $staff_count = $this->staff->staffCount($staff->store_branch_id);
        if ($staff_count > 1) {
            $success = $this->staff->delete($staff_id);
            return response()->json(['message' => ['Staff Account Deleted Successfully']]);
        } else {
            return response()->json(['errors' => ['You cannot delete the last Admin Account']]);
        }
    }
}
