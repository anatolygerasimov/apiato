<?php

declare(strict_types=1);

namespace App\Containers\Authentication\Exceptions;

use Illuminate\Auth\AuthenticationException as LaravelAuthenticationException;
use Symfony\Component\HttpFoundation\Response;

class AuthenticationException extends LaravelAuthenticationException
{
    public int $httpStatusCode = Response::HTTP_UNAUTHORIZED;

    /**
     * @var string
     */
    public $message = 'An Exception occurred when trying to authenticate the User.';

    /**
     * Create a new authentication exception.
     */
    public function __construct(?string $message = null, array $guards = [], ?string $redirectTo = null)
    {
        parent::__construct($message ?? $this->message, $guards, $redirectTo);
    }
}
