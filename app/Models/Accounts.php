<?php

namespace App\Models;

use Hash;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Accounts extends Authenticatable
{
    use Notifiable;

    protected $fillable = ['company_name', 'email', 'phone', 'address', 'website_url', 'password','cac_number','status'];

    public function setCompanyNameAttribute($value)
    {
        $this->attributes['company_name'] = ucwords(strtolower($value));
    }

    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = Hash::make($value);
    }

    public function campaign(){
        return $this->hasMany(Campaigns::class,'account_id','id');
    }
}
