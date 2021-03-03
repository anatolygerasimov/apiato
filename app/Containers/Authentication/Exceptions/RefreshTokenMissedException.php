<?php

declare(strict_types=1);

namespace App\Containers\Authentication\Exceptions;

use App\Ship\Parents\Exceptions\Exception;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class RefreshTokenMissedException.
 */
class RefreshTokenMissedException extends Exception
{
    public int $httpStatusCode = Response::HTTP_BAD_REQUEST;

    /**
     * @var string
     */
    public $message = 'We could not find the Refresh Token. Maybe none is provided?';
}
