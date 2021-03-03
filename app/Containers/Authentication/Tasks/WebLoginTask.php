<?php

declare(strict_types=1);

namespace App\Containers\Authentication\Tasks;

use App\Containers\Authentication\Exceptions\LoginFailedException;
use App\Ship\Parents\Tasks\Task;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Support\Facades\Auth;

/**
 * Class WebLoginTask.
 */
class WebLoginTask extends Task
{
    public function run(string $email, string $password, string $field = 'email', bool $remember = false): ?Authenticatable
    {
        if (!Auth::attempt([$field => $email, 'password' => $password], $remember)) {
            throw new LoginFailedException();
        }

        return Auth::user();
    }
}
