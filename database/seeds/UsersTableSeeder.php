<?php

use Illuminate\Database\Seeder;
use App\Models\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->delete();

        User::create([
            'first_name' => 'Iftekhar',
            'last_name' => 'Hossain',
            'email' => 'ifte510@gmail.com',
            'password' => bcrypt('freshmilk'),
            'activated' => '1',
        ]);
    }
}
