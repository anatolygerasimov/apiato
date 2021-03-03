<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;

/**
 * @apiGroup           RolePermission
 * @apiName            getAllPermissions
 *
 * @api                {get} /v1/permissions Get All Permission
 *
 * @apiVersion         1.0.0
 * @apiPermission      Authenticated User
 *
 * @apiUse             GeneralSuccessMultipleResponse
 */

/** @var Route $router */
$router->get('permissions', [
    'as'         => 'api_authorization_get_all_permissions',
    'uses'       => 'Controller@getAllPermissions',
    'middleware' => [
        'auth:api',
    ],
]);
