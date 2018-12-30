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

        // Create Role
        $superAdminRole = Role::create(['name' => 'Super Admin']);
        $adminRole = Role::create(['name' => 'Admin']);


        /**
         * Create Permission
         */

        // User
        $createUser = Permission::create(['name'=>'Create User']);
        $viewUser = Permission::create(['name'=>'View User']);
        $editUser = Permission::create(['name'=>'Edit User']);
        $deleteUser = Permission::create(['name' => 'Delete User']);

        // Categories
        $createCategory = Permission::create(['name'=>'Create Category']);
        $readCategory = Permission::create(['name'=>'Read Category']);
        $updateCategory = Permission::create(['name'=>'Update Category']);
        $deleteCategory = Permission::create(['name' => 'Delete Category']);


        // Role
        $createRole = Permission::create(['name' => 'Create Role']);
        $readRole = Permission::create(['name' => 'Read Role']);
        $updateRole = Permission::create(['name' => 'Update Role']);
        $deleteRole = Permission::create(['name' => 'Delete Role']);

        // Settings
        $updateSettings = Permission::create(['name'=>'Update Settings']);

        // Assign Roles
        $superAdminUser->assignRole($superAdminRole);
        $adminUser->assignRole($adminRole);

        // Create permission
        $adminRole->syncPermissions([
            $createUser,
            $viewUser,
            $editUser,
            $deleteUser,
            $createCategory,
            $readCategory,
            $updateCategory,
            $deleteCategory,
            $updateSettings,
        ]);
        factory(App\Models\User::class, 200)->create();
    }


    /**
     * Create Roles
     */
    private function createRoles() {

    }

    private function createPermissions() {

    }
}
