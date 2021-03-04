<?php

declare(strict_types=1);

namespace App\Containers\User\Data\Seeders;

use App\Ship\Core\Foundation\Facades\Apiato;
use App\Ship\Parents\Seeders\Seeder;

/**
 * Class UserPermissionsSeeder_1.
 */
class UserPermissionsSeeder_1 extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Default Permissions ----------------------------------------------------------
        Apiato::call('Authorization@CreatePermissionTask', ['search-users', 'Find a User in the DB.']);
        Apiato::call('Authorization@CreatePermissionTask', ['list-users', 'Get All Users.']);
        Apiato::call('Authorization@CreatePermissionTask', ['update-users', 'Update a User.']);
        Apiato::call('Authorization@CreatePermissionTask', ['delete-users', 'Delete a User.']);
        Apiato::call('Authorization@CreatePermissionTask', ['refresh-users', 'Refresh User data.']);
    }
}
