<?php

namespace App\Containers\Payment\Actions;

use App\Containers\Payment\Models\PaymentAccount;
use App\Containers\Payment\UI\API\Requests\FindPaymentAccountRequest;
use App\Ship\Core\Foundation\Facades\Apiato;
use App\Ship\Parents\Actions\Action;

/**
 * Class FindPaymentAccountDetailsAction.
 */
class FindPaymentAccountDetailsAction extends Action
{
    public function run(FindPaymentAccountRequest $request): PaymentAccount
    {
        $authUser = Apiato::call('Authentication@GetAuthenticatedUserTask');

        $paymentAccount = Apiato::call('Payment@FindPaymentAccountByIdTask', [$request->id]);

        // check if this account belongs to our user
        Apiato::call('Payment@CheckIfPaymentAccountBelongsToUserTask', [$authUser, $paymentAccount]);

        return $paymentAccount;
    }
}
