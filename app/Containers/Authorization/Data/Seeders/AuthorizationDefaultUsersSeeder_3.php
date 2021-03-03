<?php

declare(strict_types=1);

namespace App\Containers\Authorization\Data\Seeders;

use App\Containers\User\Models\User;
use App\Ship\Core\Foundation\Facades\Apiato;
use App\Ship\Parents\Seeders\Seeder;

/**
 * Class AuthorizationDefaultUsersSeeder_3.
 */
class AuthorizationDefaultUsersSeeder_3 extends Seeder
{
    /**
     * Add Default Users (with their roles).
     *
     * @return void
     */
    public function run()
    {
        /** @var User $user */
        $user = Apiato::call('User@CreateUserByCredentialsTask', [
            'admin@admin.com',
            'Q97ZgyvUvwBsuumf9NLdYmgx',
            'Super Admin',
            $isClient = false,
        ]);

        Apiato::call('Authorization@AssignUserToRoleTask', [$user, ['admin']]);

        Apiato::call('User@UpdateUserTask', [['last_login_at' => now()], $user->id]);

        $user->markEmailAsVerified();

        /** @var User $user */
        $user = Apiato::call('User@CreateUserByCredentialsTask', [
            'user@user.com',
            'SWWdxzgP6EeVL3JSYvQfYfTP',
            'Super User',
            $isClient = true,
        ]);

        Apiato::call('Authorization@AssignUserToRoleTask', [$user, ['user']]);

        Apiato::call('User@UpdateUserTask', [['last_login_at' => now()], $user->id]);

        $user->markEmailAsVerified();
    }
}
