<?php

declare(strict_types=1);

use App\Containers\Authorization\Models\Permission;
use Faker\Generator;
use Illuminate\Database\Eloquent\Factory;

/**
 * @var Factory $factory
 */
$factory->define(Permission::class, fn (Generator $faker) => [
    'name' => $faker->slug,
]);
