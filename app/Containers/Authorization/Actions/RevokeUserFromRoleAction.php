<?php

declare(strict_types=1);

namespace App\Containers\Authorization\Actions;

use App\Containers\Authorization\UI\API\Requests\RevokeUserFromRoleRequest;
use App\Containers\User\Models\User;
use App\Ship\Core\Foundation\Facades\Apiato;
use App\Ship\Parents\Actions\Action;
use Illuminate\Database\Eloquent\Collection;

/**
 * Class RevokeUserFromRoleAction.
 */
class RevokeUserFromRoleAction extends Action
{
    public function run(RevokeUserFromRoleRequest $request): User
    {
        // if user ID is passed then convert it to instance of User (could be user Id Or Model)
        $user = $request->user_id;

        if (!$user instanceof User) {
            $user = Apiato::call('User@FindUserByIdTask', [$request->user_id]);
        }

        $rolesIds = $request->roles_ids;

        $roles = new Collection();

        foreach ($rolesIds as $roleId) {
            $role = Apiato::call('Authorization@FindRoleTask', [$roleId]);
            $roles->add($role);
        }

        foreach ($roles->pluck('name')->toArray() as $roleName) {
            $user->removeRole($roleName);
        }

        return $user;
    }
}
