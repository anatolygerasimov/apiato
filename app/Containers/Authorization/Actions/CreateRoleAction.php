<?php

declare(strict_types=1);

namespace App\Containers\Authorization\Actions;

use App\Containers\Authorization\Models\Role;
use App\Containers\Authorization\UI\API\Requests\CreateRoleRequest;
use App\Ship\Core\Foundation\Facades\Apiato;
use App\Ship\Parents\Actions\Action;

/**
 * Class CreateRoleAction.
 */
class CreateRoleAction extends Action
{
    public function run(CreateRoleRequest $request): Role
    {
        $level      = $request->level           ?? 0;
        $guard_name = $request->guard_name      ?? config('auth.defaults.guard');

        return Apiato::call('Authorization@CreateRoleTask',
            [$request->name, $request->description, $request->display_name, $guard_name, $level]
        );
    }
}
