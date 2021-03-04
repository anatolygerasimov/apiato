<?php

namespace App\Containers\Stripe\Exceptions;

use App\Ship\Parents\Exceptions\Exception;
use Symfony\Component\HttpFoundation\Response as SymfonyResponse;

/**
 * Class PaymentFailedException.
 */
class PaymentFailedException extends Exception
{
    public int $httpStatusCode = SymfonyResponse::HTTP_PAYMENT_REQUIRED;

    /**
     * @var string
     */
    public $message = 'Payment failed!';
}
