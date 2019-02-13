<?php

use Faker\Generator as Faker;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(App\Models\User::class, function (Faker $faker) {
    return [
//        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'email_verified_at' => now(),
        'password' => '$2y$10$TKh8H1.PfQx37YgCzwiKb.KjNyWgaHb9cbcoQgdIVFlYg7B77UdFm', // secret
        'remember_token' => str_random(10),
        'last_login' => $faker->dateTime($max = 'now', $timezone = null),
        'first_name' => $faker->unique()->firstName,
        'last_name' => $faker->unique()->lastName,
        'employee_num' => $faker->unique()->randomNumber(),
        'phone' => $faker->phoneNumber(),
        'fax' => $faker->phoneNumber(),
        'website' => $faker->url(),
        'address' => $faker->address,
        'city' => $faker->city,
        'state' =>  $faker->state(),
        'zip' => $faker->postcode,
        'activated' => $faker->biasedNumberBetween($min = 0, $max = 1),
        'sex' => 'Male',
        'country_id' => $faker->biasedNumberBetween($min = 1, $max = 109),
    ];
});
