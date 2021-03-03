<?php

declare(strict_types=1);

namespace App\Containers\Authorization\Actions;

use App\Containers\Authorization\Models\Permission;
use App\Containers\Authorization\UI\API\Requests\CreatePermissionRequest;
use App\Ship\Core\Foundation\Facades\Apiato;
use App\Ship\Parents\Actions\Action;

/**
 * Class CreatePermissionAction.
 */
class CreatePermissionAction extends Action
{
    public function run(CreatePermissionRequest $request): Permission
    {
        $guard_name = $request->guard_name ?? config('auth.defaults.guard');

        return Apiato::call('Authorization@CreatePermissionTask',
            [$request->name, $request->description, $request->display_name, $guard_name]
        );
    }
}
