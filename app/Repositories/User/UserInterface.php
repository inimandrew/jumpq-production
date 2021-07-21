<?php

namespace App\Repositories\User;

interface UserInterface {

    public function create(array $data);

    public function setApiKey($username);

    public function logout($api_token);

    public function update(array $data,array $where);

    public function getUser($api_token);

}
