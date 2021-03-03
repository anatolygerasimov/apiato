<?php

declare(strict_types=1);

namespace App\Containers\Authentication\Exceptions;

use App\Ship\Parents\Exceptions\Exception;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class OAuthException.
 */
class OAuthException extends Exception
{
    public int $httpStatusCode = Response::HTTP_INTERNAL_SERVER_ERROR;

    /**
     * @var string
     */
    public $message = 'OAuth 2.0 is not installed.';
}
