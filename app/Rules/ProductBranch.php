<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use App\Models\Products;
use App\Repositories\Staffs\StaffRepository;
use Illuminate\Http\Request;

class ProductBranch implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    private $staff;
    private $request;
    private $product_id;
    public function __construct(StaffRepository $staff,$request,$product_id = NULL)
    {
        $this->staff = $staff;
        $this->request = $request;
        $this->product_id = $product_id;
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
        $store_branch_id = $this->staff->getBranchId($this->request->header('api_token'));

        $product_check = Products::where('store_branch_id',$store_branch_id)->where('name',$value)->first();

            if(!isset($this->product_id)){
                if(!empty($product_check) && $product_check->count() > 0){
                    $result = false;
                }else{
                    $result = true;
                }
            }else{
                if($product_check->id == $this->product_id){
                    $result = true;
                }else{
                    $result = false;
                }
            }

            return $result;

    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'This Product name has been registered by your branch';
    }
}
