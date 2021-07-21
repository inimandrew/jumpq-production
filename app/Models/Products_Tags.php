<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Products_Tags extends Model
{
    protected $table = "product_tags";

    protected $fillable = [
        'product_id','tag_id'
    ];

    public function product(){
        return $this->belongsTo(Products::class,'product_id','id');
    }

    public function carted(){
        return $this->hasOne(ProductTagCart::class,'product_tag_id','id');
    }

    public function tag(){
        return $this->belongsTo(Tags::class);
    }
}
