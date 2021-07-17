<?php

namespace App\Repositories\Staffs;

interface StaffInterface {

    public function create(array $data);

    public function getStaffs($branch_id);

    public function update(array $data,array $where);

    public function delete($staff_id);

    public function staffCount($branch_id);

    public function getOne($staff_id);

    public function setApiKey($username);

    public function logout($api_token);

    public function getIdByApiToken($api_token);

    public function getBranchId($api_token);

    public function getBranch($api_token);

    public function countStaffs($store_branch_id);

}
