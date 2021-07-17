<?php

namespace App\Repositories\Stores;
use App\Http\Resources\StoreCollection;
use Illuminate\Http\Request;
use App\Models\Stores;

class StoreRepository implements StoreInterface{

    public function create(array $data){
        return Stores::create($data);
    }

    public function showAll(){
        $stores = Stores::paginate(15);
        return new StoreCollection($stores);
    }

    public function showAllBlade(){
        return Stores::all();
    }

    public function getOne($id){
        return Stores::find($id);
    }


    public function branchCount($store_id){
        $store = Stores::find($store_id);
        return $store->branches->count();
    }

}
