<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;

/**
 * @apiGroup           RolePermission
 * @apiName            getAllRoles
 *
 * @api                {get} /v1/roles Get All Roles
 *
 * @apiVersion         1.0.0
 * @apiPermission      Authenticated User
 *
 * @apiUse             GeneralSuccessMultipleResponse
 */

/** @var Route $router */
$router->get('roles', [
    'as'         => 'api_authorization_get_all_roles',
    'uses'       => 'Controller@getAllRoles',
    'middleware' => [
        'auth:api',
    ],
]);
