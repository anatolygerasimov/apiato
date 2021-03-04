<?php

namespace App\Containers\Stripe\Exceptions;

use App\Ship\Parents\Exceptions\Exception;
use Symfony\Component\HttpFoundation\Response as SymfonyResponse;

/**
 * Class ObjectNonChargeableException.
 */
class ObjectNonChargeableException extends Exception
{
    public int $httpStatusCode = SymfonyResponse::HTTP_INTERNAL_SERVER_ERROR;

    /**
     * @var string
     */
    public $message = 'This object is not chargeable. Maybe you are missing an Interface?';
}
