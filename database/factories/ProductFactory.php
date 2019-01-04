<?php

use Faker\Generator as Faker;

$factory->define(App\Models\Product::class, function (Faker $faker) {
    return [
        'name' => $faker->word,
        'code' => $faker->numberBetween(1000, 9999),
        'stock' => $faker->numberBetween(1, 1000),
        'description' => $faker->paragraph,
        'purchase_price' => $faker->randomFloat(2, 1, 100),
        'selling_price' => $faker->randomFloat(2, 2, 100),
        'sales' => $faker->numberBetween(1, 1000),
        'category_id' => $faker->numberBetween(1, 20)
    ];
});