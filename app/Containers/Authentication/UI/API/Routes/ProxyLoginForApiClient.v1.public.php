<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;

/**
 * @apiGroup           OAuth2
 * @apiName            proxyLoginForApiClient
 *
 * @api                {post} /v1/login Login (Password Grant with proxy)
 * @apiDescription     Login Users using their email and password, without client_id and client_secret.
 *
 * @apiVersion         1.0.0
 *
 * @apiParam           {String}  email user email
 * @apiParam           {String}  password user password
 *
 * @apiUse             AuthLoginSuccessResponse
 */

/** @var Route $router */
$router->post('login', [
    'as'   => 'api_authentication_client_api_app_login_proxy',
    'uses' => 'Controller@proxyLoginForApiClient',
]);
