<?php

namespace App\Repositories\Administrator;

interface AdminInterface {

    public function create(array $data);

    public function getAll();

    public function getOne($username);

    public function setAPiKey($username);

    public function update(array $data);

    public function logout($api_token);

}
