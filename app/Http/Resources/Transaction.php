<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Transaction extends JsonResource
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
            'transaction_id' => $this->transaction_id,
            'buyer_name' => $this->payer->name,
            'buyer_phone' => $this->payer->phone,
            'staff' => $this->staff_name,
            'transaction_date' => $this->transaction_date,
            'status' => $this->status,
            'currency' => $this->branch->currency->symbol,
            'purchases' => $this->getPurchases($this),
            'service_charge' => number_format($this->service_charge, 2, '.', ','),
            'sub_total' => number_format($this->total, 2, '.', ','),
            'payment' => $this->payment_type->name,
            'total' => number_format(($this->total + $this->service_charge), 2, '.', ','),
            'receipt_url' => route('receipt', [$this->transaction_id]),
            'branch' => $this->branch->name,
            'address' => $this->branch->address . ', ' . $this->branch->state . ', ' . $this->branch->country . '.',
            'phone' => $this->branch->phone,
        ];
    }

    public function getPurchases($transaction)
    {
        $sales = [];
        foreach ($transaction->sales as $sale) {
            if ($sale->cart->product->product_type == 1) {
                array_push($sales, [
                    'product' => $sale->cart->product->name,
                    'price' => $sale->cart->price,
                    'quantity' => $sale->cart->quantity,
                    'barcode' => $this->getCodes($sale->cart),
                    'rfids' => [],
                ]);
            } else {
                $rfids = $this->getRfid($sale->cart);
                array_push($sales, [
                    'product' => $sale->cart->product->name,
                    'price' => $sale->cart->price,
                    'quantity' => count($rfids),
                    'barcode' => $this->getCodes($sale->cart),
                    'rfids' => $rfids,
                ]);
            }
        }

        return $sales;
    }

    public function getCodes($cart)
    {
        $array = [];
        array_push($array, $cart->product->barcode->barcode);

        return $array;
    }

    public function getRfid($cart)
    {

        $array = [];
        foreach ($cart->carted as $key => $value) {
            array_push($array,$value->product_tag->tag->rfid);
        }

        return $array;
    }
}
