<?php

declare(strict_types=1);

use App\Ship\Core\Foundation\Facades\Blocks;
use Illuminate\Support\Facades\Route;

/** @var Route $router */
$router->get('login', [
    'as'     => Blocks::getLoginWebPageName(),
    'uses'   => 'Controller@showLoginPage',
]);
