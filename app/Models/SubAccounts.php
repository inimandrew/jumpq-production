<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SubAccounts extends Model
{
    protected $table = 'sub_accounts';
    protected $fillable = [
        'currency_id','bank_id','store_branch_id','account_number','sub_account_code','payment_type_id'
    ];
    public function currency(){
        return $this->belongsTo(Currency::class);
    }

    public function bank(){
        return $this->belongsTo(Banks::class);
    }

    public function payment(){
        return $this->belongsTo(PaymentType::class,'payment_type_id','id');
    }
}
