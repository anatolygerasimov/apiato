<?php

declare(strict_types=1);

use App\Containers\Stripe\Models\StripeAccount;
use Faker\Generator;
use Illuminate\Database\Eloquent\Factory;

/**
 * @var Factory $factory
 */
$factory->define(StripeAccount::class, fn (Generator $faker) => [
    'customer_id' => $faker->text(10),
]);
