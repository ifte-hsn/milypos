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
        DB::table('users')->delete();
        DB::table('roles')->delete();
        DB::table('permissions')->delete();
        DB::table('model_has_permissions')->delete();
        DB::table('model_has_roles')->delete();
        DB::table('role_has_permissions')->delete();

        $user = User::create([
            'first_name' => 'Iftekhar',
            'last_name' => 'Hossain',
            'email' => 'ifte510@gmail.com',
            'password' => bcrypt('freshmilk'),
            'activated' => '1',
        ]);


        $role = Role::create(['name' => 'Super Admin']);
        $user->assignRole($role);
    }
}
