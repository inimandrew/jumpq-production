<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sales extends Model
{
    protected $table = 'sales';
    public $timestamps = false;
    protected $fillable = [
        'cart_id','cart_payment_id'
    ];


    public function tag(){
        return $this->hasOne(Products_Tags::class,'id','product_tag_id');
    }

    public function payment(){
        return $this->belongsTo(Cart_Payment::class,'cart_payment_id','id');
    }

    public function buyer(){
        return $this->belongsTo(Buyer::class);
    }

    public function cart(){
        return $this->belongsTo(Cart::class);
    }

}
