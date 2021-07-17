<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Campaign extends JsonResource
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
            'plan' => $this->plan->name,
            'owner' => $this->account->company_name,
            'title' => $this->title,
            'description' => $this->description,
            'url_redirect' => $this->url_link,
            'asset_type' => $this->asset->type,
            'asset' => route('download_asset',[$this->asset_url]),
        ];
    }
}
