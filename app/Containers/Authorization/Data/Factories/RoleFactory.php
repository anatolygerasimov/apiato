<?php

declare(strict_types=1);

use App\Containers\Authorization\Models\Role;
use Faker\Generator;
use Illuminate\Database\Eloquent\Factory;

/**
 * @var Factory $factory
 */
$factory->define(Role::class, fn (Generator $faker) => [
    'name' => $faker->slug,
]);
