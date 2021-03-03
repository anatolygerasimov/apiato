<?php

declare(strict_types=1);

namespace App\Containers\Authentication\Actions;

use App\Ship\Core\Traits\AuthenticatedUserTrait;
use App\Ship\Parents\Actions\Action;

/**
 * Class UserHasRoleAction.
 */
class UserHasRoleAction extends Action
{
    /**
     * @use AuthenticatedUserTrait<\App\Containers\User\Models\User>
     */
    use AuthenticatedUserTrait;

    public function run(): bool
    {
        $user = $this->getAuthUserModel();

        return $user && $user->hasUserRole();
    }
}
