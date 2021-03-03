<?php

declare(strict_types=1);

namespace App\Containers\Authentication\Actions;

use App\Containers\Authentication\Data\Transporters\LoginTransporter;
use App\Containers\User\Models\User;
use App\Ship\Core\Foundation\Facades\Blocks;
use App\Ship\Parents\Actions\Action;

/**
 * Class LoginSubAction.
 */
class LoginSubAction extends Action
{
    public function run(LoginTransporter $data): ?User
    {
        $loginCustomAttribute = Blocks::call('Authentication@ExtractLoginCustomAttributeTask', [$data]);

        $user = Blocks::call('Authentication@WebLoginTask', [
            $loginCustomAttribute['username'],
            $data->password,
            $loginCustomAttribute['login_attribute'],
            $data->remember_me,
        ]);

        Blocks::call('Authentication@CheckIfUserIsConfirmedEmailTask', [], [['setAuthUser' => [$user]]]);

        return $user;
    }
}
