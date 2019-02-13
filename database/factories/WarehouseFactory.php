<?php

use Faker\Generator as Faker;

$factory->define(App\Models\Warehouse::class, function (Faker $faker) {
    return [
        'code' => $faker->unique()->ean8,
        'name' => $faker->unique()->name(),
        'email' => $faker->unique()->safeEmail,
        'phone' => $faker->phoneNumber(),
        'address' => $faker->address,
    ];
});
