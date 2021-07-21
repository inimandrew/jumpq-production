<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Store_Type extends Model
{
    protected $table = "stores_type";
    public $timestamps = false;

    protected $fillable = [
        'name'
    ];
}
