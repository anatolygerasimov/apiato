<?php

namespace App\Containers\SocialAuth\Exceptions;

use App\Ship\Parents\Exceptions\Exception;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class AccountFailedException.
 */
class AccountFailedException extends Exception
{
    public int $httpStatusCode = Response::HTTP_CONFLICT;

    /**
     * @var string
     */
    public $message = 'Failed creating a new User for Social Authentication.';
}
