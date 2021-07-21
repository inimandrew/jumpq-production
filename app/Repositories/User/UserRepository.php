<?php

namespace App\Repositories\User;
use App\Models\User;
use Illuminate\Http\Request;
use Str;


class UserRepository implements UserInterface{

    public function create(array $data)
    {
        $data['profile_image_location'] = "images.jpg";
        return User::create($data);
    }

    public function setApiKey($username){
        $token =  Str::random(60);
        $user = User::where('username',$username)->first();
        $user->api_token = $token;
        $user->save();
        return $user->api_token;
    }

    public function logout($api_token){
        $user = User::where('api_token',$api_token)->update(['api_token'=> NULL]);
        return true;
    }

    public function update(array $data,array $where){
        $success = User::where($where)->update($data);
        return $success;
    }

    public function getUser($api_token){
        return User::where('api_token',$api_token)->first();
    }

    


}
