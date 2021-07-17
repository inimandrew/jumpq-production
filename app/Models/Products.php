<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Products extends Model
{
    protected $table = "products";

    protected $fillable = [
        'store_branch_id', 'category_id', 'name', 'unit_price', 'description','product_type','quantity','cost_price','reorder_level','uniqueId'
    ];

    protected $appends = ['category_name'];

    public function category()
    {
        return $this->belongsTo(Categories::class);
    }

    public function product_images()
    {
        return $this->hasMany(Product_Images::class, 'product_id', 'id');
    }

    public function payments()
    {
        return $this->belongsToMany(PaymentType::class, 'product_payments', 'product_id', 'payment_type_id');
    }

    public function tags()
    {
        return $this->hasMany(Products_Tags::class, 'product_id', 'id');
    }

    public function getCategoryNameAttribute()
    {

        if($this->category){
            $name = $this->category->name;
        }else{
            $name = 'Uncategorized';
        }
        return $name;
    }

    public function branch(){
        return $this->belongsTo(Stores_Branch::class,'store_branch_id','id');
    }

    public function barcode(){
        return $this->hasOne(Barcode::class,'product_id','id');
    }

}
