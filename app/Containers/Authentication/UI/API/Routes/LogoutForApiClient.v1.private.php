<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;

/**
 * @apiGroup           OAuth2
 * @apiName            LogoutForApiClient
 *
 * @api                {DELETE} /v1/logout Logout
 * @apiDescription     User Logout. (Revoking Access Token)
 *
 * @apiVersion         1.0.0
 * @apiPermission      Authenticated User
 *
 * @apiSuccessExample  {json}       Success-Response:
 * HTTP/1.1 202 Accepted
 * {
 *   "message": "Token revoked successfully."
 * }
 */

/** @var Route $router */
$router->delete('logout', [
    'as'         => 'api_authentication_logout_api_client',
    'uses'       => 'Controller@logoutForApiClient',
    'middleware' => [
        'auth:api',
    ],
]);
