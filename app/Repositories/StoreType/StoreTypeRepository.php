<?php

namespace App\Repositories\StoreType;
use App\Models\Store_Type;
use Illuminate\Http\Request;


class StoreTypeRepository implements StoreTypeInterface{

    public function getTypes()
    {
        return Store_Type::all();
    }


}
