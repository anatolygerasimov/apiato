<?php

namespace App\Ship\Exceptions\Builders;

use Exception;
use Illuminate\Http\JsonResponse;
use Throwable;

/**
 * Class ExceptionBuilder
 */
class ExceptionBuilder
{

    /**
     * @param Exception|Throwable $e
     *
     * @return  JsonResponse
     */
    public static function make(Throwable $e)
    {
        return new JsonResponse([
            'status' => 'error',
        ]);
    }
}
