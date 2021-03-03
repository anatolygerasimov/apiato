<?php

namespace App\Containers\Authorization\Exceptions;

use App\Ship\Parents\Exceptions\Exception;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class RoleNotFoundException.
 */
class RoleNotFoundException extends Exception
{
    public int $httpStatusCode = Response::HTTP_NOT_FOUND;

    /**
     * @var string
     */
    public $message = 'The requested Role was not found.';
}
