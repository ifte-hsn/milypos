<?php

use App\Models\Client;
use Illuminate\Database\Seeder;
class ClientsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker\Factory::create();

        for ($i=0; $i<100; $i++) {
            Client::create([
                'first_name' => $faker->firstNameMale,
                'last_name'  => $faker->lastName,
                'email'      => $faker->email,
                'phone'      => $faker->phoneNumber,
                'address'    => $faker->address,
                'city'       => $faker->city,
                'dob'        => $faker->date('Y-m-d', now())
            ]);
        }
    }
}
