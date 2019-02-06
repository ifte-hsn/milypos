<?php

use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class UsersTableSeeder extends Seeder
{

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::truncate();

        $superAdminUser = User::create([
            'first_name' => 'Iftekhar',
            'last_name' => 'Hossain',
            'email' => 'ifte510@gmail.com',
            'password' => bcrypt('freshmilk'),
            'activated' => '1',
        ]);

        $adminUser = User::create([
            'first_name' => 'Shishir',
            'last_name' => 'Hossain',
            'email' => 'ifte.hsn@gmail.com',
            'password' => bcrypt('freshmilk'),
            'activated' => '1',
        ]);

        // Assign Roles
        $superAdminUser->assignRole(Role::findByName('Super Admin'));
        $adminUser->assignRole(Role::findByName('Admin'));

        factory(App\Models\User::class, 200)->create();
    }
}
