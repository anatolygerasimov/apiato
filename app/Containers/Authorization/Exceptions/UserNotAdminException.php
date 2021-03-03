<?php

namespace App\Containers\Authorization\Exceptions;

use App\Ship\Parents\Exceptions\Exception;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class UserNotAdminException.
 */
class UserNotAdminException extends Exception
{
    public int $httpStatusCode = Response::HTTP_FORBIDDEN;

    /**
     * @var string
     */
    public $message = 'This User does not have an Admin permission.';
}
