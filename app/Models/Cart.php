<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    protected $table = 'carts';
    public $timestamps = false;

    protected $fillable = [
        'purchaser_id','purchaser_type','product_id','quantity','price','cost_price','status'
    ];

    public function purchaser()
    {
        return $this->morphTo();
    }

    public function product(){
        return $this->belongsTo(Products::class,'product_id');
    }

    public function sales(){
        return $this->hasOne(Sales::class,'cart_id','id');
    }

    public function carted(){
        return $this->HasMany(ProductTagCart::class,'cart_id','id');
    }
}
