<?php

namespace App\Containers\Authorization\Actions;

use App\Containers\Authorization\Exceptions\PermissionNotFoundException;
use App\Containers\Authorization\Models\Permission;
use App\Containers\Authorization\UI\API\Requests\FindPermissionRequest;
use App\Ship\Core\Foundation\Facades\Apiato;
use App\Ship\Parents\Actions\Action;
use Dto\Exceptions\UnstorableValueException;

/**
 * Class FindPermissionAction.
 */
class FindPermissionAction extends Action
{
    /**
     * @throws PermissionNotFoundException|UnstorableValueException
     */
    public function run(FindPermissionRequest $request): Permission
    {
        $permission = Apiato::call('Authorization@FindPermissionTask', [$request->id]);

        if (!$permission) {
            throw new PermissionNotFoundException();
        }

        return $permission;
    }
}
