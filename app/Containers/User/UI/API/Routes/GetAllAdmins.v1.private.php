<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;

/**
 * @apiGroup           Users
 * @apiName            getAllAdmins
 *
 * @api                {get} /v1/admins Get All Admin Users
 * @apiDescription     Get All Users where role `Admin`.
 *                     You can search for Users by email, username and ID.
 *                     Example: `?search=User` or `?search=whatever@mail.com`.
 *                     You can specify the field as follow `?search=email:whatever@mail.com` or `?search=id:20`.
 *                     You can search by multiple fields as follow: `?search=username:User&email:whatever@mail.com`.
 *
 * @apiVersion         1.0.0
 * @apiPermission      Authenticated Admin
 *
 * @apiUse             GeneralSuccessMultipleResponse
 */

/** @var Route $router */
$router->get('admins', [
    'as'         => 'api_user_get_all_admins',
    'uses'       => 'Controller@getAllAdmins',
    'middleware' => [
        'auth:api',
    ],
]);
