<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;

/**
 * @apiGroup           Settings
 * @apiName            updateSetting
 *
 * @api                {PATCH} /v1/settings/:id Update Setting
 * @apiDescription     Updates a setting entry (both key / value)
 *
 * @apiVersion         1.0.0
 * @apiPermission      none
 *
 * @apiParam           {String}  parameters here..
 *
 * @apiSuccessExample  {json}  Success-Response:
 * HTTP/1.1 200 OK
 * {
 * "data": {
 * "object": "Setting",
 * "id": "aadfa72342sa",
 * "key": "foo",
 * "value": "bar"
 * },
 * "meta": {
 * "include": [],
 * "custom": []
 * }
 * }
 */

/** @var Route $router */
$router->patch('settings/{id}', [
    'as'         => 'api_settings_update_setting',
    'uses'       => 'Controller@updateSetting',
    'middleware' => [
        'auth:api',
    ],
]);
