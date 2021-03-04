<?php

declare(strict_types=1);

use App\Ship\Core\Foundation\Facades\Apiato;
use Illuminate\Support\Facades\Route;

/** @var Route $router */
$router->get('login', [
    'as'     => Apiato::getLoginWebPageName(),
    'uses'   => 'Controller@showLoginPage',
]);
