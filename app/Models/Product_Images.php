<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product_Images extends Model
{
    protected $table = "product_images";

    protected $fillable = [
        'product_id','location','image_type'
    ];
    protected $visible = [
        'id','location','image_type'
    ];
}
