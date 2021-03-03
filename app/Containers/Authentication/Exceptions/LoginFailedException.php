<?php

declare(strict_types=1);

namespace App\Containers\Authentication\Exceptions;

use App\Ship\Parents\Exceptions\Exception;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class LoginFailedException.
 */
class LoginFailedException extends Exception
{
    public int $httpStatusCode = Response::HTTP_BAD_REQUEST;

    /**
     * @var string
     */
    public $message = 'An Exception happened during the Login Process.';
}
