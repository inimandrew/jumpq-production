<?php

namespace App\Repositories\StoreBranch;

use App\Http\Resources\BranchCollection;
use App\Models\Stores_Branch;
use App\Models\Configurations;
use Illuminate\Support\Facades\Config;

class StoreBranchRepository implements StoreBranchInterface
{

    public function create(array $data)
    {
        $branch = Stores_Branch::create($data);
        return $branch;

    }

    public function getAllBlade()
    {
        return Stores_Branch::where('status', '1')->has('products')->paginate(10);
    }

    public function getAllBranches(){
        return Stores_Branch::all();
    }


    public function getBranches($store_id)
    {
        $branches = Stores_Branch::where('store_id', $store_id)->paginate(15);
        return new BranchCollection($branches);
    }

    public function update($data, $store_branch_id)
    {
        $success = Stores_Branch::where('id', $store_branch_id)->update($data);
        return $success;
    }

    public function getStoreId($branch_id)
    {
        $branch = Stores_Branch::find($branch_id);
        return $branch->store_id;
    }

    public function getBranch($branch_id)
    {
        return Stores_Branch::find($branch_id);
    }

    public function deleteBranch($store_branch_id)
    {
        return Stores_Branch::destroy($store_branch_id);
    }

    public function getBranchByUniqueId($unique_id)
    {
        return Stores_Branch::where('unique_id', $unique_id)->firstOrFail();
    }

    public function getPaystackId($branch){
        $config = $branch->config()->where('type','paystack')->first();
        return $config->value;
    }
}
