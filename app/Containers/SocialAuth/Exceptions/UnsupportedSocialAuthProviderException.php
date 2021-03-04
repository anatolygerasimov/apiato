<?php

namespace App\Containers\SocialAuth\Exceptions;

use App\Ship\Parents\Exceptions\Exception;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class UnsupportedSocialAuthProviderException.
 */
class UnsupportedSocialAuthProviderException extends Exception
{
    public int $httpStatusCode = Response::HTTP_NOT_ACCEPTABLE;

    /**
     * @var string
     */
    public $message = 'Unsupported Social Auth Provider.';
}
