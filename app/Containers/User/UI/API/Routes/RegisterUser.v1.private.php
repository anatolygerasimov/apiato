<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;

/**
 * @apiGroup           Users
 * @apiName            registerUser
 *
 * @api                {post} /v1/register Register User (create client)
 * @apiDescription     Register users as (client).
 *
 * @apiVersion         1.0.0
 * @apiPermission      none
 *
 * @apiParam           {String}  email (required)
 * @apiParam           {String}  password (required)
 * @apiParam           {String}  username (optional)
 */

/** @var Route $router */
$router->post('/register', [
    'as'   => 'api_user_register_user',
    'uses' => 'Controller@registerUser',
]);
