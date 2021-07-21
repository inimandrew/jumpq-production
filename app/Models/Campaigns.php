<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Campaigns extends Model
{
    protected $fillable = [
        'account_id', 'plan_id', 'amount', 'title', 'description', 'status', 'paid', 'approved', 'start_date', 'end_date', 'payment_type_id', 'asset_type_id', 'asset_url', 'url_link'
    ];

    public function setTitleAttribute($value)
    {
        $this->attributes['title'] = ucwords(strtolower($value));
    }

    public function account()
    {
        return $this->belongsTo(Accounts::class);
    }

    public function payment()
    {
        return $this->belongsTo(PaymentType::class, 'payment_type_id', 'id');
    }

    public function plan()
    {
        return $this->belongsTo(Plans::class, 'plan_id', 'id');
    }

    public function asset()
    {
        return $this->belongsTo(AssetType::class, 'asset_type_id', 'id');
    }

    public function campaign_count()
    {
        return $this->hasMany(CampaignCount::class, 'campaign_id', 'id');
    }
}
