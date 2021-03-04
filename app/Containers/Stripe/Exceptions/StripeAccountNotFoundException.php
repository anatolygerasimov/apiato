<?php

namespace App\Containers\Stripe\Exceptions;

use App\Ship\Parents\Exceptions\Exception;
use Symfony\Component\HttpFoundation\Response as SymfonyResponse;

/**
 * Class StripeAccountNotFoundException.
 */
class StripeAccountNotFoundException extends Exception
{
    public int $httpStatusCode = SymfonyResponse::HTTP_EXPECTATION_FAILED;

    /**
     * @var string
     */
    public $message = 'Stripe Account not found.';
}
