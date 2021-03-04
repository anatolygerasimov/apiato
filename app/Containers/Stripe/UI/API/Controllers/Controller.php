<?php

namespace App\Containers\Stripe\UI\API\Controllers;

use App\Containers\Stripe\UI\API\Requests\CreateStripeAccountRequest;
use App\Containers\Stripe\UI\API\Requests\UpdateStripeAccountRequest;
use App\Ship\Core\Foundation\Facades\Apiato;
use App\Ship\Parents\Controllers\ApiController;
use App\Ship\Transporters\DataTransporter;
use Illuminate\Http\JsonResponse;

/**
 * Class Controller.
 */
class Controller extends ApiController
{
    /**
     * @return JsonResponse
     */
    public function createStripeAccount(CreateStripeAccountRequest $request)
    {
        $stripeAccount = Apiato::call('Stripe@CreateStripeAccountAction', [new DataTransporter($request)]);

        return $this->accepted([
            'message'           => 'Stripe account created successfully.',
            'stripe_account_id' => $stripeAccount->id,
        ]);
    }

    /**
     * @return JsonResponse
     */
    public function updateStripeAccount(UpdateStripeAccountRequest $request)
    {
        $stripeAccount = Apiato::call('Stripe@UpdateStripeAccountAction', [$request]);

        return $this->accepted([
            'message'           => 'Stripe account updated successfully.',
            'stripe_account_id' => $stripeAccount->id,
        ]);
    }
}
