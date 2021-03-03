<?php

declare(strict_types=1);

namespace App\Containers\Authentication\Actions;

use App\Containers\Authentication\Exceptions\LogoutFailedException;
use App\Ship\Core\Traits\AuthenticatedUserTrait;
use App\Ship\Parents\Actions\Action;

/**
 * Class ApiLogoutAction.
 */
class ApiLogoutAction extends Action
{
    /**
     * @use AuthenticatedUserTrait<\App\Containers\User\Models\User>
     */
    use AuthenticatedUserTrait;

    public function run(): bool
    {
        $user  = $this->getStrictlyAuthUserModel();
        $token = $user->token();

        if (is_null($token)) {
            throw new LogoutFailedException();
        }

        return $token->revoke();
    }
}
