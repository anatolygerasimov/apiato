<?php

declare(strict_types=1);

namespace App\Containers\Authentication\Tasks;

use App\Ship\Parents\Tasks\Task;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Support\Facades\Auth;

/**
 * Class GetAuthenticatedUserTask.
 */
class GetAuthenticatedUserTask extends Task
{
    public function run(): ?Authenticatable
    {
        return Auth::user();
    }
}
