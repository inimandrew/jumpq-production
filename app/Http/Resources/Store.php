<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Store extends JsonResource
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
            'name' => $this->name,
            'branch_count' => $this->branches->count(),
            'registered_on' => str_replace(" ", " @ ", (string) $this->created_at),
            'branches_url' => route('store_branches',[encrypt($this->id)]),
        ];
    }
}
