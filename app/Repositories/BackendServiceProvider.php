<?php
namespace App\Repositories;

use Illuminate\Support\ServiceProvider;

class BackendServiceProvider extends ServiceProvider
{

    public function register()
    {
        $this->app->bind(
            'App\Repositories\Administrator\AdminInterface',
            'App\Repositories\Administrator\AdminRepository'
        );

        $this->app->bind(
            'App\Repositories\StoreType\StoreTypeInterface',
            'App\Repositories\StoreType\StoreTypeRepository'
        );

        $this->app->bind(
            'App\Repositories\StoreBranch\StoreBranchInterface',
            'App\Repositories\StoreBranch\StoreBranchRepository'
        );

        $this->app->bind(
            'App\Repositories\Staffs\StaffInterface',
            'App\Repositories\Staffs\StaffRepository'
        );

        $this->app->bind(
            'App\Repositories\Stores\StoreInterface',
            'App\Repositories\Stores\StoreRepository'
        );

        $this->app->bind(
            'App\Repositories\StaffRoles\StaffRolesInterface',
            'App\Repositories\StaffRoles\StaffRolesRepository'
        );

        $this->app->bind(
            'App\Repositories\User\UserInterface',
            'App\Repositories\User\UserRepository'
        );

        $this->app->bind(
            'App\Repositories\Others\OtherInterface',
            'App\Repositories\Others\OtherRepository'
        );


    }
}
