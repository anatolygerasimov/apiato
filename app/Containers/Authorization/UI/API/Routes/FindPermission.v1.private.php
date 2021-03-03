<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;

/**
 * @apiGroup           RolePermission
 * @apiName            getPermission
 *
 * @api                {get} /v1/permissions/:id Find a Permission by ID
 *
 * @apiVersion         1.0.0
 * @apiPermission      Authenticated User
 *
 * @apiUse             PermissionSuccessSingleResponse
 */

/** @var Route $router */
$router->get('permissions/{id}', [
    'as'         => 'api_authorization_get_permission',
    'uses'       => 'Controller@findPermission',
    'middleware' => [
        'auth:api',
    ],
]);
