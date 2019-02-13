<?php

use Faker\Generator as Faker;

$factory->define(App\Models\Product::class, function (Faker $faker) {
    return [
        'name' => $faker->unique()->name,
        'code' => $faker->numberBetween(1000, 9999),
        'stock' => $faker->numberBetween(1, 10),
        'description' => $faker->paragraph,
        'purchase_price' => $purchase_price = round($faker->randomFloat(2, 1, 100), 2),
        'selling_price' => round($purchase_price + ($purchase_price * 0.25), 2),
        'sales' => $faker->numberBetween(1, 10),
        'category_id' => $faker->numberBetween(1, 20)
    ];
});