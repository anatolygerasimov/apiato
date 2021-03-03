<?php

declare(strict_types=1);

namespace App\Containers\Authentication\Tasks;

use App\Containers\Authentication\Exceptions\LoginFailedException;
use App\Containers\Authentication\Exceptions\UserNotConfirmedException;
use App\Ship\Core\Traits\AuthenticatedUserTrait;
use App\Ship\Parents\Tasks\Task;

class CheckIfUserIsConfirmedEmailTask extends Task
{
    /**
     * @use AuthenticatedUserTrait<\App\Containers\User\Models\User>
     */
    use AuthenticatedUserTrait;

    public function run(): void
    {
        if (config('authentication-container.require_email_confirmation')) {
            $user = $this->getAuthUserModel();

            if ($user === null) {
                throw new LoginFailedException();
            }

            if (!$user->hasVerifiedEmail()) {
                throw new UserNotConfirmedException();
            }
        }
    }
}
