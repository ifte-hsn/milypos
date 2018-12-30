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
        $addUser = Permission::create(['name'=>'Add User']);
        $viewUser = Permission::create(['name'=>'View User']);
        $editUser = Permission::create(['name'=>'Edit User']);
        $deleteUser = Permission::create(['name' => 'Delete User']);
        $restoreUser = Permission::create(['name' => 'Restore User']);
        $bulkDeleteUser = Permission::create(['name' => 'Bulk Delete Users']);
        $exportUser = Permission::create(['name' => 'Export Users']);

        // Categories
        $createCategory = Permission::create(['name'=>'Add Category']);
        $readCategory = Permission::create(['name'=>'View Category']);
        $updateCategory = Permission::create(['name'=>'Edit Category']);
        $deleteCategory = Permission::create(['name' => 'Delete Category']);
        $restoreCategory = Permission::create(['name' => 'Restore Category']);
        $exportCategory = Permission::create(['name' => 'Export Categories']);
        $bulkDeleteCategory = Permission::create(['name' => 'Bulk Delete Categories']);


        // Role
        $addRole = Permission::create(['name' => 'Add Role']);
        $viewRole = Permission::create(['name' => 'View Role']);
        $editRole = Permission::create(['name' => 'Edit Role']);
        $deleteRole = Permission::create(['name' => 'Delete Role']);
        $restoreRole = Permission::create(['name' => 'Restore Role']);

        // Settings
        $updateSettings = Permission::create(['name'=>'Update Settings']);

        // Assign Roles
        $superAdminUser->assignRole($superAdminRole);
        $adminUser->assignRole($adminRole);

        // Create permission
        $adminRole->syncPermissions([
            $addUser,
            $viewUser,
            $editUser,
            $deleteUser,
            $restoreUser,
            $bulkDeleteUser,
            $createCategory,
            $readCategory,
            $updateCategory,
            $deleteCategory,
            $updateSettings,
            $addRole,
            $viewRole,
            $editRole,
            $deleteRole,
            $restoreRole
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
