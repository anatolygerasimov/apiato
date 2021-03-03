<?php

declare(strict_types=1);

namespace App\Containers\Authentication\Tasks;

use App\Containers\User\Models\User;
use App\Ship\Parents\Tasks\Task;
use Laravel\Passport\PersonalAccessTokenResult;

/**
 * Class ApiLoginFromUserTask.
 */
class ApiLoginFromUserTask extends Task
{
    /**
     * @return PersonalAccessTokenResult
     */
    public function run(User $user)
    {
        return $user->createToken('social');
    }
}
