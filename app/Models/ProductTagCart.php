<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductTagCart extends Model
{
    protected $table = 'product_tag_carts';
    protected $fillable = [
        'cart_id','status'
    ];
    public $timestamps = false;

    public function cart(){
        return $this->belongsTo(Cart::class,'cart_id','id');
    }

    public function product_tag(){
        return $this->belongsTo(Products_Tags::class,'product_tag_id','id');
    }
}
