<?php

declare(strict_types=1);

namespace App\Containers\Authentication\Exceptions;

use App\Ship\Parents\Exceptions\Exception;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class UserNotConfirmedException.
 */
class UserNotConfirmedException extends Exception
{
    public int $httpStatusCode = Response::HTTP_CONFLICT;

    /**
     * @var string
     */
    public $message = 'The user email is not confirmed yet. Please verify your email before trying to login.';
}
