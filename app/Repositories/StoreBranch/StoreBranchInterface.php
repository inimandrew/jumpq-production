<?php

namespace App\Repositories\StoreBranch;

interface StoreBranchInterface {

    public function create(array $data);

    public function getBranches($store_id);

    public function getAllBranches();

    public function update($data,$store_branch_id);

    public function deleteBranch($store_branch_id);

    public function getBranch($branch_id);

    public function getBranchByUniqueId($unique_id);

    public function getPaystackId($branch);

}
