<?php

namespace App\Containers\Payment\Actions;

use App\Containers\Payment\Models\PaymentAccount;
use App\Ship\Core\Foundation\Facades\Apiato;
use App\Ship\Core\Traits\AuthenticatedUserTrait;
use App\Ship\Parents\Actions\Action;
use Illuminate\Database\Eloquent\Collection;

/**
 * Class GetAllPaymentAccountsAction.
 */
class GetAllPaymentAccountsAction extends Action
{
    /**
     * @use AuthenticatedUserTrait<\App\Containers\User\Models\User>
     */
    use AuthenticatedUserTrait;

    /**
     * @return Collection|array<array-key, PaymentAccount>
     */
    public function run()
    {
        return Apiato::call('Payment@GetAllPaymentAccountsTask',
            [],
            [
                'addRequestCriteria',
                'ordered',
                ['filterByUser' => [$this->getStrictlyAuthUserId()]],
            ]
        );
    }
}
