<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Stores_Branch extends Model
{
    protected $table = "stores_branches";

    protected $fillable = [
        'name','store_type_id','store_id','address','phone','currency_id','unique_id','country','state',"itemMax"
    ];

    public function staffs(){
        return $this->hasMany(Staffs::class,'store_branch_id','id');
    }

    public function store(){
        return $this->belongsTo(Stores::class,'store_id');
    }

    public function products(){
        return $this->hasMany(Products::class,'store_branch_id','id');
    }

    public function currency(){
        return $this->belongsTo(Currency::class);
    }

    public function sub_account(){
        return $this->hasOne(SubAccounts::class,'store_branch_id','id');
    }


}
