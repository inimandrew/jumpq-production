<?php

namespace App\Rules;
use Validator;

use Illuminate\Contracts\Validation\Rule;

class Token implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
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
        $data['api_token'] = $value;
        $validation = Validator::make($data,[
            'api_token' => 'exists:admins,api_token'
        ]);

        $validation2 = Validator::make($data,[
            'api_token' => 'exists:staffs,api_token'
        ]);

        if(($validation->fails()) & ($validation2->fails())){
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
        return 'Invalid Api Key.';
    }
}
