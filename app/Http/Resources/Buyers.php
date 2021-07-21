<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Buyers extends JsonResource
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
            'name' => $this->name,
            'phone' => $this->phone,
            'transaction_date'=> $this->transaction_date,
            'currency' => $this->staff->branch->currency->symbol,
            'purchases' => $this->getPurchases($this)
        ];

    }

    public function getPurchases($buyer){
        $sales = [];
        foreach($buyer->sales as $sale){
            if(!array_search($sale->tag->product->id,array_column($sales, 'product_id'))){
                array_push($sales,[
                    'product_id' => $sale->tag->product->id,
                    'price' => $sale->price,
                    'product' => $sale->tag->product->name,
                    'quantity' => $sale->quantity
                ]);
            }

        }

        return $sales;

    }
}
