<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cart_Payment extends Model
{
    protected $table = 'cart_payments';
    protected $fillable = [
        'transaction_id', 'payment_type_id', 'staff_id', 'service_charge', 'total', 'store_branch_id', 'status'
    ];
    protected $appends = ['transaction_date', 'staff_name'];

    public function getTransactionDateAttribute()
    {
        return str_replace(" ", " @ ", (string) $this->created_at);
    }

    public function sales()
    {
        return $this->hasMany(Sales::class, 'cart_payment_id', 'id');
    }

    public function staff()
    {
        return $this->belongsTo(Staffs::class, 'staff_id');
    }

    public function branch()
    {
        return $this->belongsTo(Stores_Branch::class, 'store_branch_id');
    }

    public function payer()
    {
        return $this->morphTo();
    }

    public function payment_type()
    {
        return $this->belongsTo(PaymentType::class);
    }

    public function getStaffNameAttribute()
    {
        if (!empty($this->staff_id)) {
            $staff = $this->staff->firstname . ' ' . $this->staff->lastname;
        } else {
            $staff = 'Paid through the App';
        }
        return $staff;
    }

}
