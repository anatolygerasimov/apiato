<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;

/** @var Route $router */
$router->get('logout', [
    'as'     => 'post_logout_form',
    'uses'   => 'Controller@logout',
]);
