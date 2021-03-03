<?php

namespace App\Containers\Authorization\Actions;

use App\Containers\Authorization\Models\Role;
use App\Ship\Core\Foundation\Facades\Apiato;
use App\Ship\Parents\Actions\Action;
use Illuminate\Database\Eloquent\Collection;

/**
 * Class GetAllRolesAction.
 */
class GetAllRolesAction extends Action
{
    /**
     * @return Collection|array<array-key, Role>
     */
    public function run()
    {
        return Apiato::call('Authorization@GetAllRolesTask', [], ['addRequestCriteria']);
    }
}
