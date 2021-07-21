<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use App\Models\Tags;
use App\Models\Barcode;

class Code implements Rule
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
        $branch_to_use = $this->branch;

        $tag = Tags::where('rfid', $value)->whereHas('batch', function ($query) use ($branch_to_use) {
            $query->where('store_branch_id', $branch_to_use);
        })->whereHas('product_tag', function ($qq) {
            $qq->doesntHave('carted');
        })->first();

        $barcode = Barcode::where('barcode', $value)->whereHas('product', function ($query) use ($branch_to_use) {
            $query->where('store_branch_id', $branch_to_use);
        })->first();


        if (empty($tag) & empty($barcode)) {
            return false;
        } else {
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
        return 'The Code Scanned is Invalid.';
    }
}
