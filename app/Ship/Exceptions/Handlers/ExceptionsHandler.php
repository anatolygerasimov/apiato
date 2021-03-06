<?php

namespace App\Ship\Exceptions\Handlers;

use App\Ship\Core\Exceptions\Handlers\ExceptionsHandler as CoreExceptionsHandler;

/**
 * Class ExceptionsHandler
 *
 * A.K.A (app/Exceptions/Handler.php)
 */
class ExceptionsHandler extends CoreExceptionsHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
