<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CampaignCount extends Model
{
    protected $fillable = [
        'campaign_id','count','date'
    ];

    public function campaign(){
        return $this->belongsTo(Campaigns::class);
    }
}
