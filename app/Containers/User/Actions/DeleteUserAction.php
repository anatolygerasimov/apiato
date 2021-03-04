<?php

declare(strict_types=1);

namespace App\Containers\User\Actions;

use App\Containers\User\UI\API\Requests\DeleteUserRequest;
use App\Ship\Core\Foundation\Facades\Apiato;
use App\Ship\Parents\Actions\Action;

/**
 * Class DeleteUserAction.
 */
class DeleteUserAction extends Action
{
    public function run(DeleteUserRequest $userData): void
    {
        $user = $userData->id ?
          Apiato::call('User@FindUserByIdTask', [$userData->id])
            :
          Apiato::call('Authentication@GetAuthenticatedUserTask');

        Apiato::call('User@DeleteUserTask', [$user]);
    }
}
