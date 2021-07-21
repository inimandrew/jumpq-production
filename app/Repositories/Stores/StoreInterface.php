<?php

namespace App\Repositories\Stores;

interface StoreInterface {

    public function create(array $data);

    public function showAll();

    public function branchCount($store_id);

    public function getOne($id);

}
