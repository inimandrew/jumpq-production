<?php

namespace App\Http\Resources;
use App\Http\Resources\ProductImages;

use Illuminate\Http\Resources\Json\JsonResource;

class cart extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'product_id' => $this->product->id,
            'product' => $this->product->name,
            'quantity' => $this->getQuantity($this),
            'currency' => $this->product->branch->currency->symbol,
            'price' => $this->price,
            'thumbnail' => new ProductImages($this->product->product_images->where('image_type','thumbnail')->first()),
        ];
    }

    public function getQuantity($cart){
        if($cart->product->product_type == '0'){
            $result = $cart->carted()->count();
        }else{
            $result = $cart->quantity;
        }

        return $result;
    }
}
