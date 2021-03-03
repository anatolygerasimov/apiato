<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;

/**
 * @apiGroup           RolePermission
 * @apiName            getRole
 *
 * @api                {get} /v1/roles/:id Find a Role by ID
 *
 * @apiVersion         1.0.0
 * @apiPermission      Authenticated User
 *
 * @apiUse             RoleSuccessSingleResponse
 */

/** @var Route $router */
$router->get('roles/{id}', [
    'as'         => 'api_authorization_get_role',
    'uses'       => 'Controller@findRole',
    'middleware' => [
        'auth:api',
    ],
]);
