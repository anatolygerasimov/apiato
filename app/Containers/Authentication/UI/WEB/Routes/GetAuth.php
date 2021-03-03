<?php

declare(strict_types=1);

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/** @var Route $router */
$router->get('auth', function (Request $request) {
    dd($request->query());
});
