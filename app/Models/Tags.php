<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tags extends Model
{
    protected $table = "tags";
    protected $fillable = [
        'rfid','status','store_branch_id'
    ];

    public function product_tag(){
        return $this->hasOne(Products_Tags::class,'tag_id');
    }
    public function batch(){
        return $this->belongsTo(Batch::class);
    }
}
