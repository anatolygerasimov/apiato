<?php

declare(strict_types=1);

namespace App\Containers\Authentication\Exceptions;

use App\Ship\Parents\Exceptions\Exception;
use http\Client\Response;

/**
 * Class LogoutFailedException.
 */
class LogoutFailedException extends Exception
{
    public $httpStatusCode = Response::HTTP_BAD_REQUEST;

    /**
     * @var string
     */
    public $message = 'An Exception happened during the Logout Process.';
}
