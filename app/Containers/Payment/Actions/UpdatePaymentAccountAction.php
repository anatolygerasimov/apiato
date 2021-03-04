<?php

namespace App\Containers\Payment\Actions;

use App\Containers\Payment\Models\PaymentAccount;
use App\Containers\Payment\UI\API\Requests\UpdatePaymentAccountRequest;
use App\Ship\Core\Foundation\Facades\Apiato;
use App\Ship\Parents\Actions\Action;

/**
 * Class UpdatePaymentAccountAction.
 */
class UpdatePaymentAccountAction extends Action
{
    public function run(UpdatePaymentAccountRequest $request): PaymentAccount
    {
        $authUser = Apiato::call('Authentication@GetAuthenticatedUserTask');

        $paymentAccount = Apiato::call('Payment@FindPaymentAccountByIdTask', [$request->id]);

        // check if this account belongs to our user
        Apiato::call('Payment@CheckIfPaymentAccountBelongsToUserTask', [$authUser, $paymentAccount]);

        $request = $request->sanitizeInput([
            'name',
        ]);

        return Apiato::call('Payment@UpdatePaymentAccountTask', [$paymentAccount, $request]);
    }
}
