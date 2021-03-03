<?php

declare(strict_types=1);

namespace App\Containers\Authorization\Data\Seeders;

use App\Ship\Core\Foundation\Facades\Apiato;
use App\Ship\Parents\Seeders\Seeder;
use Illuminate\Support\Facades\Artisan;

/**
 * Class AuthorizationRolesSeeder_2.
 */
class AuthorizationRolesSeeder_2 extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Default Roles ----------------------------------------------------------------
        Apiato::call('Authorization@CreateRoleTask', ['admin', 'Administrator', 'Administrator Role', 'web', 999]);
        Apiato::call('Authorization@CreateRoleTask', ['user', 'User', 'User Role', 'web', 100]);

        //Give all system Permissions to a user Role.
        Artisan::call('blocks:permissions:toRole admin web');
//        Artisan::call('blocks:permissions:toRole user web');
    }
}
