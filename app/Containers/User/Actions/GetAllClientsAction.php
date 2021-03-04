<?php

declare(strict_types=1);

namespace App\Containers\User\Actions;

use App\Containers\User\Models\User;
use App\Ship\Core\Foundation\Facades\Apiato;
use App\Ship\Parents\Actions\Action;
use Illuminate\Database\Eloquent\Collection;

/**
 * Class GetAllClientsAction.
 */
class GetAllClientsAction extends Action
{
    /**
     * @return User[]|Collection
     */
    public function run()
    {
        return Apiato::call('User@GetAllUsersTask',
            [],
            [
                'addRequestCriteria',
                ['withRole' => ['user']],
                'ordered',
            ]
        );
    }
}
