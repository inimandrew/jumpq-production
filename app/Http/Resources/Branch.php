<?php

namespace App\Http\Resources;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Resources\Json\JsonResource;

class Branch extends JsonResource
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
        $check_url1 = explode('?', $check_url);

        if ($check_url1[0] == '/api/all_branches') {
            $result = [
                'unique_id' => encrypt($this->id),
                'branch_id' => $this->unique_id,
                'name' => $this->name,
            ];
        } else {
            $result = [
                'unique_id' => encrypt($this->id),
                'branch_id' => $this->unique_id,
                'name' => $this->name,
                'itemMax' => $this->itemMax,
                'staffs_count' => $this->staffs->count(),
                'registered_on' => str_replace(" ", " @ ", (string) $this->created_at),
                'address' => $this->address . ', ' . $this->state . ',' . $this->country . '.',
                'phone' => $this->phone,
                'currency' => $this->currency->name . ' - ' . $this->currency->symbol,
                'status' => $this->status,
                'staffs_url' => $this->getStaffUrl($this)
            ];
        }
        return $result;
    }

    public function getStaffUrl($branch)
    {
        if (Auth::guard('admin')->check()) {
            $route = route('staffs_page', [encrypt($branch->id)]);
        } else if (Auth::guard('staff')->check()) {
            $route =  route('branch_staffs', [encrypt($branch->id)]);
        }

        return $route;
    }
}
