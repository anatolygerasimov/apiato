<?php

declare(strict_types=1);

namespace App\Containers\User\Actions;

use App\Containers\User\Models\User;
use App\Ship\Core\Traits\AuthenticatedUserTrait;
use App\Ship\Exceptions\NotFoundException;
use App\Ship\Parents\Actions\Action;

/**
 * Class GetAuthenticatedUserAction.
 */
class GetAuthenticatedUserAction extends Action
{
    /**
     * @use AuthenticatedUserTrait<\App\Containers\User\Models\User>
     */
    use AuthenticatedUserTrait;

    public function run(): User
    {
        $user = $this->getAuthUserModel();

        if (!$user) {
            throw new NotFoundException();
        }

        return $user;
    }
}
