<?php

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Category::truncate();

        Category::create(['name'=>'Mobiles']);
        Category::create(['name'=>'Tablets']);
        Category::create(['name'=>'Laptops']);
        Category::create(['name'=>'Gaming Consoles']);
        Category::create(['name'=>'DSLR']);
        Category::create(['name'=>'Video Camera']);
        Category::create(['name'=>'Television']);
        Category::create(['name'=>'Printers']);
        Category::create(['name'=>'Watch']);
        Category::create(['name'=>'Motorcycle']);
        Category::create(['name'=>'Shoes']);
        Category::create(['name'=>'Headphones']);
        Category::create(['name'=>'Books']);
        Category::create(['name'=>'Lighting']);
        Category::create(['name'=>'Dog']);
        Category::create(['name'=>'Cat']);
        Category::create(['name'=>'Bird']);
        Category::create(['name'=>'Pendrive']);
        Category::create(['name'=>'Furniture']);
        Category::create(['name'=>'Bags']);
    }
}
