<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class StoreCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'data' => $this->collection,

                'count' => $this->count(),
                'total' => $this->total(),
                'prev'  => $this->previousPageUrl(),
                'next'  => $this->nextPageUrl(),
                'current_page' => $this->currentPage(),
                'last_page' => $this->lastPage(),
                'last_page_url' => $this->url($this->lastPage()),
                'from' => $this->firstItem()
        ];
    }
}
