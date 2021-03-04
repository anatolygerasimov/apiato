<?php

namespace App\Containers\Stripe\Actions;

use App\Ship\Core\Foundation\Facades\Apiato;
use App\Ship\Parents\Actions\Action;
use App\Ship\Transporters\DataTransporter;
use Illuminate\Database\Eloquent\Model;

/**
 * Class CreateStripeAccountAction.
 */
class CreateStripeAccountAction extends Action
{
    /**
     * @return Model
     */
    public function run(DataTransporter $data)
    {
        $authUser = Apiato::call('Authentication@GetAuthenticatedUserTask');

        $sanitizedData = $data->sanitizeInput([
            'customer_id',
            'card_id',
            'card_funding',
            'card_last_digits',
            'card_fingerprint',
            'nickname',
        ]);

        $account = Apiato::call('Stripe@CreateStripeAccountTask', [$sanitizedData]);

        return Apiato::call('Payment@AssignPaymentAccountToUserTask', [$account, $authUser, $sanitizedData['nickname']]);
    }
}
