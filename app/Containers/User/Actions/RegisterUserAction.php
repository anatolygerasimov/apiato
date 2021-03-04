<?php

declare(strict_types=1);

namespace App\Containers\User\Actions;

use App\Containers\User\Models\User;
use App\Containers\User\UI\API\Requests\RegisterUserRequest;
use App\Ship\Core\Foundation\Facades\Apiato;
use App\Ship\Parents\Actions\Action;
use Illuminate\Auth\Events\Registered;

/**
 * Class RegisterUserAction.
 */
class RegisterUserAction extends Action
{
    public function run(RegisterUserRequest $userData): User
    {
        /**
         * Create user record in the database and return it.
         *
         * @var User $user
         */
        $user = Apiato::call('User@CreateUserByCredentialsTask', [
            $userData->email,
            $userData->password,
            $userData->username,
        ]);

        // assign a base role to user
        Apiato::call('Authorization@AssignUserToRoleTask', [$user, ['user']]);

        /** Upon this event, newly registered users will automatically be sent an email containing an email verification link. */
        event(new Registered($user));

        return $user;
    }
}
