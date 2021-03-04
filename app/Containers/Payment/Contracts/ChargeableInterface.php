<?php

namespace App\Containers\Payment\Contracts;

use App\Containers\Payment\Models\PaymentAccount;
use App\Containers\Payment\Models\PaymentTransaction;

/**
 * Interface ChargeableInterface.
 */
interface ChargeableInterface
{
    /**
     * Get the value of the model's primary key.
     *
     * @return int
     */
    public function getKey();

    /**
     * Charge the user on a given account.
     *
     * @param int|float   $amount
     * @param string|null $currency
     */
    public function charge(PaymentAccount $account, $amount, $currency): PaymentTransaction;
}
