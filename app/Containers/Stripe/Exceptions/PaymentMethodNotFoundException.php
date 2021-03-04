<?php

namespace App\Containers\Stripe\Exceptions;

use App\Ship\Parents\Exceptions\Exception;
use Symfony\Component\HttpFoundation\Response as SymfonyResponse;

/**
 * Class PaymentMethodNotFoundException.
 */
class PaymentMethodNotFoundException extends Exception
{
    public int $httpStatusCode = SymfonyResponse::HTTP_PAYMENT_REQUIRED;

    /**
     * @var string
     */
    public $message = 'Payment method is not found.';
}
