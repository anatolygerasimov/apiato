<?php

declare(strict_types=1);

namespace App\Containers\User\Actions;

use App\Containers\User\Models\User;
use App\Containers\User\UI\API\Requests\FindUserByIdRequest;
use App\Ship\Core\Foundation\Facades\Apiato;
use App\Ship\Exceptions\NotFoundException;
use App\Ship\Parents\Actions\Action;

/**
 * Class FindUserByIdAction.
 */
class FindUserByIdAction extends Action
{
    public function run(FindUserByIdRequest $userData): User
    {
        $user = Apiato::call('User@FindUserByIdTask', [$userData->id]);

        if (!$user) {
            throw new NotFoundException();
        }

        return $user;
    }
}
