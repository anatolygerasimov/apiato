<?php

declare(strict_types=1);

namespace App\Containers\Authorization\Actions;

use App\Containers\Authorization\Models\Role;
use App\Containers\Authorization\UI\API\Requests\AssignUserToRoleRequest;
use App\Containers\User\Models\User;
use App\Ship\Core\Foundation\Facades\Apiato;
use App\Ship\Parents\Actions\Action;

/**
 * Class AssignUserToRoleAction.
 */
class AssignUserToRoleAction extends Action
{
    public function run(AssignUserToRoleRequest $request): User
    {
        $user = Apiato::call('User@FindUserByIdTask', [$request->user_id]);

        $rolesIds = $request->roles_ids;

        $roles = array_map(fn (int $roleId): ?Role => Apiato::call('Authorization@FindRoleTask', [$roleId]), $rolesIds);

        return Apiato::call('Authorization@AssignUserToRoleTask', [$user, $roles]);
    }
}
