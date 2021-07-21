<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use App\Models\Cart_Payment;
class Transaction implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    private $branch;

    public function __construct($branch)
    {
        $this->branch = $branch;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $transaction = Cart_Payment::where('transaction_id',$value)->first();
            if($transaction->store_branch_id != $this->branch){
                return false;
            }else{
                return true;
            }
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Transaction is not Registered under your store';
    }
}
