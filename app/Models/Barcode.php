<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Barcode extends Model
{
    protected $table = 'barcodes';

    protected $fillable = [
        'product_id','barcode'
    ];

    public $timestamps = false;

    public function product(){
        return $this->belongsTo(Products::class);
    }
}
