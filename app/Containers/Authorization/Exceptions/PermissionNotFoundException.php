<?php

namespace App\Containers\Authorization\Exceptions;

use App\Ship\Parents\Exceptions\Exception;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class RoleNotFoundException.
 */
class PermissionNotFoundException extends Exception
{
    public int $httpStatusCode = Response::HTTP_NOT_FOUND;

    /**
     * @var string
     */
    public $message = 'The requested Permission was not found.';
}
