<?php

namespace App\Containers\Stripe\Actions;

use App\Containers\Stripe\Models\StripeAccount;
use App\Containers\Stripe\UI\API\Requests\UpdateStripeAccountRequest;
use App\Ship\Core\Foundation\Facades\Apiato;
use App\Ship\Parents\Actions\Action;

/**
 * Class UpdateStripeAccountAction.
 */
class UpdateStripeAccountAction extends Action
{
    public function run(UpdateStripeAccountRequest $request): StripeAccount
    {
        $authUser = Apiato::call('Authentication@GetAuthenticatedUserTask');

        // check, if this account does - in fact - belong to our user
        $account        = Apiato::call('Stripe@FindStripeAccountByIdTask', [$request->id]);
        $paymentAccount = $account->paymentAccount;
        Apiato::call('Payment@CheckIfPaymentAccountBelongsToUserTask', [$authUser, $paymentAccount]);

        // we own this account - so it is safe to update it
        $sanitizedData = $request->sanitizeInput([
            'customer_id',
            'card_id',
            'card_funding',
            'card_last_digits',
            'card_fingerprint',
        ]);

        return Apiato::call('Stripe@UpdateStripeAccountTask', [$account, $sanitizedData]);
    }
}
