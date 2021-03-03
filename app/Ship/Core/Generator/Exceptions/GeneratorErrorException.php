<?php

namespace App\Ship\Core\Generator\Exceptions;

use App\Ship\Parents\Exceptions\Exception;
use Symfony\Component\HttpFoundation\Response as SymfonyResponse;

/**
 * Class GeneratorErrorException
 */
class GeneratorErrorException extends Exception
{
    public $httpStatusCode = SymfonyResponse::HTTP_BAD_REQUEST;

    public $message = 'Generator Error.';
}
