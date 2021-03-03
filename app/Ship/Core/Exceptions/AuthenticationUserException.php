<?php

declare(strict_types=1);

namespace App\Ship\Core\Exceptions;

use App\Ship\Parents\Exceptions\Exception;
use Symfony\Component\HttpFoundation\Response;

class AuthenticationUserException extends Exception
{
    public int $httpStatusCode = Response::HTTP_UNAUTHORIZED;

    /**
     * @var string
     */
    public $message = 'An Exception was thrown while trying to get an authenticated User.';
}
