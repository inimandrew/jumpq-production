<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Buyer extends Model
{
    protected $table = "buyers";
    protected $fillable = [
        'name', 'phone'
    ];
    protected $hidden = [
        'created_at','updated_at'
    ];

    protected $appends = ['transaction_date'];

    public function getTransactionDateAttribute()
    {
        return str_replace(" ", " @ ", (string) $this->created_at);
    }

    public function topurchase()
    {
        return $this->morphMany(Cart::class, 'purchaser');
    }

    public function paid(){
        return $this->morphMany(Cart_Payment::class, 'payer');
    }
}
