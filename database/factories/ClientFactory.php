<?php

use App\Models\Client;
use Faker\Generator as Faker;

$factory->define(Client::class, function (Faker $faker) {
    return [
        'email' => $faker->unique()->safeEmail,
        'first_name' => $faker->firstName,
        'last_name' => $faker->lastName,
        'phone' => $faker->phoneNumber(),
        'address' => $faker->address,
        'city' => $faker->city,
        'state' =>  $faker->state(),
        'zip' => $faker->postcode,
        'shopping' => $faker->randomNumber(),
        'last_purchase' => $faker->dateTime($max = 'now', $timezone = null),
        'dob' => $faker->date('Y-m-d', now()),
        'sex' => 'Female'
    ];
});
