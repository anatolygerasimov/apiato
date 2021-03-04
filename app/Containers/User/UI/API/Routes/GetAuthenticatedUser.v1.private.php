<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;

/**
 * @apiGroup           Users
 * @apiName            getAuthenticatedUser
 *
 * @api                {GET} /v1/users/profile Find Logged in User data (Profile Information)
 * @apiDescription     Find the user details of the logged in user from its Token. (without specifying his ID)
 *
 * @apiVersion         1.0.0
 * @apiPermission      none
 */

/** @var Route $router */
$router->get('users/profile', [
    'as'         => 'api_user_get_authenticated_user',
    'uses'       => 'Controller@getAuthenticatedUser',
    'middleware' => [
        'auth:api',
    ],
]);
