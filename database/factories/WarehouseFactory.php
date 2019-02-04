<?php

use Faker\Generator as Faker;

$factory->define(App\Models\Warehouse::class, function (Faker $faker) {
    return [
        'code' => $faker->unique()->randomDigitNotNull,
        'name' => $faker->name(),
        'email' => $faker->unique()->safeEmail,
        'phone' => $faker->phoneNumber(),
        'address' => $faker->address,
    ];
});
