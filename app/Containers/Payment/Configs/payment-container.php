<?php

use App\Containers\Stripe\Tasks\ChargeWithStripeTask;

return [

    /*
    |--------------------------------------------------------------------------
    | Payment Container
    |--------------------------------------------------------------------------
    */

    /**
     * The default currency if no currency is passed.
     *
     * @example add new gateway 'paypal' => [],
     */
    'currency' => 'USD',

    'gateways' => [
        'stripe' => [
            'container'   => 'Stripe',
            'charge_task' => ChargeWithStripeTask::class,
        ],
    ],

];
