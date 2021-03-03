<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;

/**
 * @apiGroup           OAuth2
 * @apiName            proxyRefreshForApiClient
 *
 * @api                {post} /v1/refresh Refresh
 * @apiDescription     If `refresh_token` is not provided the we'll try to get it from the http cookie.
 *
 * @apiVersion         1.0.0
 *
 * @apiParam           {String}  [refresh_token] The refresh Token
 *
 * @apiUse             AuthLoginSuccessResponse
 */

/** @var Route $router */
$router->post('refresh', [
    'as'   => 'api_authentication_client_api_app_refresh_proxy',
    'uses' => 'Controller@proxyRefreshForApiClient',
]);
