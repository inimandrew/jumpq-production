<?php

namespace App\Repositories\Staffs;
use App\Http\Resources\StaffsCollection;
use App\Models\Staffs;
use Illuminate\Http\Request;
use Str;

class StaffRepository implements StaffInterface{

    public function create(array $data){
        $data['profile_image_location'] = 'images.jpg';
        return Staffs::create($data);
    }

    public function getStaffs($branch_id){
        $staffs = Staffs::where('store_branch_id',$branch_id)->paginate(15);
        return new StaffsCollection($staffs);
    }

    public function getOne($staff_id){
        return Staffs::find($staff_id);
    }

    public function update(array $data,array $where){
        $success = Staffs::where($where)->update($data);
        return $success;
    }

    public function getIdByApiToken($api_token){
        $staff = Staffs::where('api_token',$api_token)->first();
        return $staff->id;
    }

    public function delete($staff_id){
        return Staffs::destroy($staff_id);
    }

    public function staffCount($branch_id){
        $staffs_count = Staffs::where('store_branch_id',$branch_id)->count();
        return $staffs_count;
    }

    public function setAPiKey($username){
        $staff = Staffs::where('username',$username)->first();
        $staff->api_token = Str::random(60);
        $staff->save();

        return $staff;
    }

    public function logout($api_token){
        $staff = Staffs::where('api_token',$api_token)->update(['api_token'=>NULL]);
        return true;
    }

    public function getBranchId($api_token){
        $staff = Staffs::where('api_token',$api_token)->first();
        return $staff->store_branch_id;
    }

    public function getBranch($api_token){
        $staff = Staffs::where('api_token',$api_token)->first();
        return $staff;
    }

    public function countStaffs($store_branch_id){
        return Staffs::where('store_branch_id',$store_branch_id)->count();
    }

}
