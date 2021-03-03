<?php

namespace App\Containers\Authorization\Actions;

use App\Containers\Authorization\Models\Role;
use App\Containers\Authorization\UI\API\Requests\SyncUserRolesRequest;
use App\Containers\User\Models\User;
use App\Ship\Core\Foundation\Facades\Apiato;
use App\Ship\Parents\Actions\Action;

/**
 * Class SyncUserRolesAction.
 */
class SyncUserRolesAction extends Action
{
    public function run(SyncUserRolesRequest $request): User
    {
        $user = Apiato::call('User@FindUserByIdTask', [$request->user_id]);

        $rolesIds = $request->roles_ids;

        $roles = array_map(fn ($roleId): ?Role => Apiato::call('Authorization@FindRoleTask', [$roleId]), $rolesIds);

        $user->syncRoles($roles);

        return $user;
    }
}
