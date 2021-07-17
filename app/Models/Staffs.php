<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Staffs extends Authenticatable
{
    use Notifiable;

    protected $table = "staffs";

    protected $fillable = [
        'firstname', 'lastname', 'email', 'username', 'password','phone','status','role_id','store_branch_id','status','profile_image_location'
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    public function role(){
        return $this->belongsTo(Roles::class);
    }

    public function branch(){
        return $this->belongsTo(Stores_Branch::class,'store_branch_id');
    }
}
