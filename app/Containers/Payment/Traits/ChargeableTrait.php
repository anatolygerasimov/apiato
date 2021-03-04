<?php

namespace App\Containers\Payment\Traits;

use App\Containers\Payment\Gateway\PaymentsGateway;
use App\Containers\Payment\Models\PaymentAccount;
use App\Containers\Payment\Models\PaymentTransaction;
use Illuminate\Support\Facades\App;

/**
 * Class ChargeableTrait.
 */
trait ChargeableTrait
{
    /**
     * @param int|float   $amount
     * @param string|null $currency
     */
    public function charge(PaymentAccount $account, $amount, $currency = null): PaymentTransaction
    {
        return App::make(PaymentsGateway::class)->charge($this, $account, $amount, $currency);
    }
}
