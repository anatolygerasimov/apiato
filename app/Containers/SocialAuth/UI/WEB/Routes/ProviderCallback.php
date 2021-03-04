<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;

// provider callback handler

/** @var Route $router */
$router->any('auth/{provider}/callback', [
    'as'   => 'web_socialauth_callback',
    'uses' => 'Controller@handleCallbackAll',
]);
