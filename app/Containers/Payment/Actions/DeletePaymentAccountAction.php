<?php

namespace App\Containers\Payment\Actions;

use App\Containers\Payment\UI\API\Requests\DeletePaymentAccountRequest;
use App\Ship\Core\Foundation\Facades\Apiato;
use App\Ship\Parents\Actions\Action;

/**
 * Class DeletePaymentAccountAction.
 */
class DeletePaymentAccountAction extends Action
{
    public function run(DeletePaymentAccountRequest $request): void
    {
        $authUser = Apiato::call('Authentication@GetAuthenticatedUserTask');

        $paymentAccount = Apiato::call('Payment@FindPaymentAccountByIdTask', [$request->id]);

        // check if this account belongs to our user
        Apiato::call('Payment@CheckIfPaymentAccountBelongsToUserTask', [$authUser, $paymentAccount]);

        Apiato::call('Payment@DeletePaymentAccountTask', [$paymentAccount]);
    }
}
