<?php

declare(strict_types=1);

use App\Containers\User\Models\User;
use Faker\Generator;
use Illuminate\Database\Eloquent\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @var Factory $factory
 */
$factory->define(User::class, function (Generator $faker) {
    static $password;

    return [
        'username'       => $faker->name,
        'first_name'     => $faker->firstName,
        'last_name'      => $faker->lastName,
        'email'          => $faker->unique()->safeEmail,
        'password'       => $password ?: $password = Hash::make('testing-password'),
        'remember_token' => Str::random(10),
        'is_client'      => false,
        'data_source'    => $faker->randomElement(array_keys(config('init-container.data_sources'))),
        'last_login_at'  => now(),
        'last_login_ip'  => $faker->ipv4,
    ];
});

$factory->state(User::class, 'client', fn (Generator $faker) => [
    'is_client' => true,
]);
