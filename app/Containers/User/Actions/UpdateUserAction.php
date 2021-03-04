<?php

declare(strict_types=1);

namespace App\Containers\User\Actions;

use App\Containers\User\Models\User;
use App\Containers\User\UI\API\Requests\UpdateUserRequest;
use App\Ship\Core\Foundation\Facades\Apiato;
use App\Ship\Parents\Actions\Action;

/**
 * Class UpdateUserAction.
 */
class UpdateUserAction extends Action
{
    public function run(UpdateUserRequest $userData): User
    {
        $input = $userData->sanitizeInput([
            'username',
            'first_name',
            'last_name',
            'avatar',
            'company_name',
            'data_source',
        ]);

        return Apiato::call('User@UpdateUserTask', [$input, $userData->id]);
    }
}
