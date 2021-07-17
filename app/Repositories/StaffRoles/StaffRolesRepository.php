<?php

namespace App\Repositories\StaffRoles;
use App\Models\Roles;

class StaffRolesRepository implements StaffRolesInterface{

    public function show(){
        return Roles::all();
    }

}
