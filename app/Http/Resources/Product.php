<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use App\Http\Resources\ProductImages;
use Illuminate\Http\Resources\Json\JsonResource;

class Product extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $base_url = url()->to('/');
        $check_url = \str_replace($base_url, '', url()->full());

        if ($check_url == '/api/staff/all_products') {
            $result = [
                'id' => $this->id,
                'name' => $this->name,
                'product_type' => $this->product_type,
                'price' => $this->unit_price,
                'currency' => $this->branch->currency->symbol,
            ];
        } else if (!(empty($request['start'])) && !empty($request['end'])) {
            if ($request['start'] == 'null' && $request['end'] == 'null') {
                $result = [
                    'id' => $this->id,
                    'name' => $this->name,
                    'product_type' => $this->product_type,
                    'quantity' => $this->getQuantity($this),
                    'price' => $this->unit_price,
                    'cost_price' => $this->cost_price,
                    'description' => $this->description,
                    'images' =>  ProductImages::collection($this->product_images->where('image_type', 'medium')),
                    'category_name' => $this->category_name,
                    'category_id' => $this->category_id,
                    'currency' => $this->branch->currency->symbol,
                ];
            } else {
                $result = [
                    'id' => $this->id,
                    'name' => $this->name,
                    'product_type' => $this->product_type,
                    'quantity' => $this->getQuantity($this,$request['start'],$request['end']),
                    'price' => $this->unit_price,
                    'cost_price' => $this->cost_price,
                    'description' => $this->description,
                    'medium' =>  ProductImages::collection($this->product_images->where('image_type', 'medium')),
                    'category_name' => $this->category_name,
                    'category_id' => $this->category_id,
                    'start' => $request['start'],
                    'end' => $request['end'],
                    'currency' => $this->branch->currency->symbol,
                ];
            }
        } else {
            $result = [
                'id' => $this->id,
                'name' => $this->name,
                'product_type' => $this->product_type,
                'quantity' => $this->getQuantity($this),
                'price' => $this->unit_price,
                'cost_price' => $this->cost_price,
                'description' => $this->description,
                'thumbnail' =>  ProductImages::collection($this->product_images->where('image_type', 'thumbnail')),
                'medium' =>  ProductImages::collection($this->product_images->where('image_type', 'medium')),
                'big_images' =>  ProductImages::collection($this->product_images->where('image_type', 'large')),
                'category_name' => $this->category_name,
                'category_id' => $this->category_id,
                'currency' => $this->branch->currency->symbol,
                'barcode'=> $this->getBarcode($this),
            ];
        }
        return $result;
    }

    public function getQuantity($product,$start = null,$end = null){
        if($this->product_type == '1'){
            $quantity = $product->quantity;
        }elseif(!empty($start) && !empty($end)){
            if(($start == 'null') & $end == 'null'){
                $quantity = $this->tags()->doesntHave('carted')->count();
            }else{
                $quantity = $this->tags()->whereDate('product_tags.created_at', '>=', $start)->whereDate('product_tags.created_at', '<=', $end)->count();
            }

        }else{
            $quantity = $this->tags()->doesntHave('carted')->count();
        }
        return $quantity;
    }

    public function getBarcode($product){
        if($product->barcode()->count()){
            $barcode = $product->barcode->barcode;
        }else{
            $barcode = '';
        }
        return $barcode;
    }
}
