<?php

namespace App\Ship\Exceptions;

use App\Ship\Parents\Exceptions\Exception;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class NotImplementedException.
 *
 */
class NotImplementedException extends Exception
{

    public $httpStatusCode = Response::HTTP_NOT_IMPLEMENTED;

    public $message = 'This method is not yet implemented.';

}
