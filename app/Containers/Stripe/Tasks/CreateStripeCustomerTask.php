<?php

namespace App\Containers\Stripe\Tasks;

use App\Containers\Stripe\Exceptions\StripeApiErrorException;
use App\Ship\Parents\Tasks\Task;
use Cartalyst\Stripe\Api\Customers;
use Cartalyst\Stripe\Stripe;
use Exception;

/**
 * Class CreateStripeCustomerTask.
 */
class CreateStripeCustomerTask extends Task
{
    private Stripe $stripe;

    /**
     * StripeApi constructor.
     */
    public function __construct(Stripe $stripe)
    {
        $this->stripe = $stripe->make(config('settings.stripe.secret'), config('settings.stripe.version'));
    }

    /**
     * @param string $email
     * @param string $description
     *
     * @return array stripe customer object
     *
     * @throws StripeApiErrorException
     */
    public function run($email, $description = '')
    {
        try {
            /** @var Customers $customers */
            $customers = $this->stripe->customers();
            $response  = $customers->create([
                'email'       => $email,
                'description' => $description,
            ]);
        } catch (Exception $e) {
            throw (new StripeApiErrorException('Stripe API error (createCustomer)'))->debug($e->getMessage(), true);
        }

        return $response;
    }
}
