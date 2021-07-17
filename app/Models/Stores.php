<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Stores extends Model
{
    protected $table = "stores";

    protected $fillable = [
        'name','unique_id'
    ];

    public function branches(){
        return $this->hasMany(Stores_Branch::class,'store_id','id');
    }

    public function store(){
        return $this->belongsTo(Stores::class);
    }
}
