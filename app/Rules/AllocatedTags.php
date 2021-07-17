<?php

namespace App\Rules;

use App\Models\Tags;
use Illuminate\Contracts\Validation\Rule;

class AllocatedTags implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    private $branch, $message;

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
        })->first();

        if ($tag->product_tag()->count()) {
            if ($tag->product_tag->carted()->count()) {
                return true;
            } else {
                return false;
            }
        }
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return ':input has not been allocated to a product';
    }
}
