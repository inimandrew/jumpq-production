<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use App\Models\Barcode;
class BarcodeValidation implements Rule
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
        $barcode_exists = Barcode::where('barcode',$value)->whereHas('product',function($query){
            $query->where('store_branch_id',$this->branch);
        })->count();

            if($barcode_exists){
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
        return 'Barcode is used by another product in your store.';
    }
}
