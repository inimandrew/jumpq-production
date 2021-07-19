<?php

namespace App\Repositories\Administrator;

use Illuminate\Http\Request;
use Hash;
use App\Models\Admin;
use App\Http\Resources\AdminCollection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class AdminRepository implements AdminInterface
{

    public function create(array $data)
    {
        $new_admin =  Admin::create($data);

        if (!empty($new_admin->id)) {
            return '0';
        } else {
            return '1';
        }
    }

    public function getAll()
    {
        $admins = Admin::paginate(15);
        return new AdminCollection($admins);
    }

    public function getOne($username)
    {
        return Admin::where('username', $username)->first();
    }

    public function logout($api_token)
    {
        $admin = Admin::where('api_token', $api_token)->update(['api_token' => NULL]);
        return true;
    }

    public function setAPiKey($username)
    {
        $admin = Admin::where('username', $username)->first();
        $admin->api_token = Str::random(60);
        $admin->save();

        return $admin->api_token;
    }

    public function update(array $data)
    {
        unset($data['admin_username']);
        $success = Admin::where('username', $data['username'])->update($data);
        return $success;
    }
}
