<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Staffs extends JsonResource
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
            'unique_id' => encrypt($this->id),
            'firstname' => $this->firstname,
            'lastname' => $this->lastname,
            'email' => $this->email,
            'username' => $this->username,
            'phone' => $this->phone,
            'registered_on' => str_replace(" ", " @ ", (string) $this->created_at),
            'status' => $this->status,
            'role' => $this->role->name
        ];
    }
}
