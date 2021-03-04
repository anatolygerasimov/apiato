<?php

namespace App\Containers\Payment\Exceptions;

use App\Ship\Parents\Exceptions\Exception;
use Symfony\Component\HttpFoundation\Response;

class PaymentAccountDoesNotBelongToUserException extends Exception
{
    public int $httpStatusCode = Response::HTTP_CONFLICT;

    /**
     * @var string
     */
    public $message = 'The selected Payment Account does not belong to the current User.';
}
