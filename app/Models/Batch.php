<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Batch extends Model
{
    protected $table = 'batches';

    protected $fillable = [
        'store_branch_id','activity_type'
    ];

    public function tag(){
        return $this->hasMany(Tags::class,'batch_id','id');
    }

    public function branch(){
        return $this->belongsTo(Stores_Branch::class);
    }
}
