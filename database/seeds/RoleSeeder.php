<?php

use Illuminate\Database\Seeder;
use App\Models\Roles;
class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roles = ['Super Administrator','Admin Staff','Normal Staff'];
            foreach($roles as $role){
                Roles::create(
                    ['name' => $role]
                );
            }
    }
}
