<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;

/**
 * @apiGroup           RolePermission
 * @apiName            createRole
 *
 * @api                {post} /v1/roles Create a Role
 *
 * @apiVersion         1.0.0
 * @apiPermission      Authenticated User
 *
 * @apiParam           {String} name Unique Role Name
 * @apiParam           {String} [description]
 * @apiParam           {String} [display_name]
 *
 * @apiUse             RoleSuccessSingleResponse
 */

/** @var Route $router */
$router->post('roles', [
    'as'         => 'api_authorization_create_role',
    'uses'       => 'Controller@createRole',
    'middleware' => [
        'auth:api',
    ],
]);
