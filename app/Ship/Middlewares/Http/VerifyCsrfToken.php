<?php

namespace App\Ship\Middlewares\Http;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

/**
 * Class VerifyCsrfToken
 *
 * A.K.A app/Http/Middleware/VerifyCsrfToken.php
 */
class VerifyCsrfToken extends Middleware
{
    /**
     * @FIXME
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array
     */
    protected $except = [
//        '/api/v1/*'
//        '/admin/*'
    ];
}
