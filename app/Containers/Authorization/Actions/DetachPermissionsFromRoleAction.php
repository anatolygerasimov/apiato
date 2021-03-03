<?php

namespace App\Containers\Authorization\Actions;

use App\Containers\Authorization\Models\Role;
use App\Containers\Authorization\UI\API\Requests\DetachPermissionToRoleRequest;
use App\Ship\Core\Foundation\Facades\Apiato;
use App\Ship\Parents\Actions\Action;

/**
 * Class DetachPermissionsFromRoleAction.
 */
class DetachPermissionsFromRoleAction extends Action
{
    public function run(DetachPermissionToRoleRequest $request): Role
    {
        $role = Apiato::call('Authorization@FindRoleTask', [$request->role_id]);

        return Apiato::call('Authorization@DetachPermissionsFromRoleTask', [$role, $request->permissions_ids]);
    }
}
