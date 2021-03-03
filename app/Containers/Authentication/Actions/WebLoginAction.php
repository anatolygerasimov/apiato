<?php

declare(strict_types=1);

namespace App\Containers\Authentication\Actions;

use App\Containers\Authentication\Data\Transporters\LoginTransporter;
use App\Containers\User\Models\User;
use App\Ship\Core\Foundation\Facades\Apiato;
use App\Ship\Parents\Actions\Action;

/**
 * Class WebLoginAction.
 */
class WebLoginAction extends Action
{
    public function run(LoginTransporter $data): ?User
    {
        return Apiato::call('Authentication@LoginSubAction', [$data]);
    }
}
