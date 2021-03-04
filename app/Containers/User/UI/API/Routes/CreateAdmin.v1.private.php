<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;

/**
 * @apiGroup           Users
 * @apiName            createAdmin
 *
 * @api                {post} /v1/admins Create Admin type Users
 * @apiDescription     Create non client users for the Dashboard.
 *
 * @apiVersion         1.0.0
 * @apiPermission      none
 *
 * @apiParam           {String}  email
 * @apiParam           {String}  password
 * @apiParam           {String}  username
 */

/** @var Route $router */
$router->post('admins', [
    'as'         => 'api_user_create_admin',
    'uses'       => 'Controller@createAdmin',
    'middleware' => [
        'auth:api',
    ],
]);
