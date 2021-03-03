<?php

namespace App\Containers\Authorization\Actions;

use App\Containers\Authorization\Exceptions\RoleNotFoundException;
use App\Containers\Authorization\Models\Role;
use App\Containers\Authorization\UI\API\Requests\FindRoleRequest;
use App\Ship\Core\Foundation\Facades\Apiato;
use App\Ship\Parents\Actions\Action;
use Dto\Exceptions\UnstorableValueException;

/**
 * Class FindRoleAction.
 */
class FindRoleAction extends Action
{
    /**
     * @throws RoleNotFoundException|UnstorableValueException
     */
    public function run(FindRoleRequest $request): Role
    {
        $role = Apiato::call('Authorization@FindRoleTask', [$request->id]);

        if (!$role) {
            throw new RoleNotFoundException();
        }

        return $role;
    }
}
