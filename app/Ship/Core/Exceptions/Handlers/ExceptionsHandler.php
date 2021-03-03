<?php

namespace App\Ship\Core\Exceptions\Handlers;

use Illuminate\Foundation\Exceptions\Handler as LaravelExceptionHandler;
use Throwable;

/**
 * Class ExceptionsHandler.
 */
class ExceptionsHandler extends LaravelExceptionHandler
{
    /**
     * @FIXME : decide and define a list of ignored errors
     * A list of the internal exception types that should not be reported.
     *
     * @var string[]
     */
    protected $internalDontReport = [
        //        AuthenticationException::class,
        //        AuthorizationException::class,
        //        HttpException::class,
        //        HttpResponseException::class,
        //        ModelNotFoundException::class,
        //        SuspiciousOperationException::class,
        //        TokenMismatchException::class,
        //        ValidationException::class,
    ];

    /**
     * Report or log an exception.
     *
     * @param Throwable $e
     *
     * @return void
     *
     * @throws Throwable
     */
    public function report(Throwable $e)
    {
        if ($this->shouldReport($e) && app()->bound('sentry')) {
            app('sentry')->captureException($e);
        }

        parent::report($e);
    }
}
