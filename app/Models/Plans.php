<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Plans extends Model
{
    protected $fillable = [
        'name', 'daily_counts','status','price'
    ];

    public function assets_allowed(){
        return $this->belongsToMany(AssetType::class,'plan_assets','plan_id','asset_type_id')->withTimestamps();
    }
}
