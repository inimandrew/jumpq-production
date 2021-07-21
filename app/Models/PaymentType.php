<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PaymentType extends Model
{
    protected $table = 'payment_type';
    public $timestamps = false;
    protected $fillable = [
        'name'
    ];

    public function product(){
        return $this->belongsToMany(Products::class,'product_payments','payment_type_id','product_id');
    }

    public function campaign(){
        return $this->hasMany(Campaigns::class,'payment_type_id','id');
    }
}
