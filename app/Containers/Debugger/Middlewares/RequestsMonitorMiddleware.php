<?php

namespace App\Containers\Debugger\Middlewares;

use App\Containers\Debugger\Values\Output;
use App\Containers\Debugger\Values\RequestsLogger;
use App\Ship\Parents\Middlewares\Middleware;
use Closure;
use Illuminate\Http\Request;

/**
 * Class RequestsMonitorMiddleware.
 */
class RequestsMonitorMiddleware extends Middleware
{
    /**
     * @psalm-return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);

        $output = new Output($request, $response);

        $output->newRequest();
        $output->spaceLine();

        $output->header('REQUEST INFO');
        $output->endpoint();
        $output->version();
        $output->ip();
        $output->format();
        $output->spaceLine();

        $output->header('USER INFO');
        $output->userInfo();
        $output->spaceLine();

        $output->header('REQUEST DATA');
        $output->requestData();
        $output->spaceLine();

        $output->header('RESPONSE DATA');
        $output->responseData();
        $output->spaceLine();

        (new RequestsLogger())->releaseOutput($output);

        return $response;
    }
}
