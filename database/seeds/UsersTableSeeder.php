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
        $addUser = Permission::create(['name'=>'add_user']);
        $viewUser = Permission::create(['name'=>'view_user']);
        $editUser = Permission::create(['name'=>'edit_user']);
        $deleteUser = Permission::create(['name' => 'delete_user']);
        $restoreUser = Permission::create(['name' => 'restore_user']);
        $bulkDeleteUser = Permission::create(['name' => 'bulk_delete_users']);
        $exportUser = Permission::create(['name' => 'export_users']);

        // Categories
        $createCategory = Permission::create(['name'=>'add_category']);
        $readCategory = Permission::create(['name'=>'view_category']);
        $updateCategory = Permission::create(['name'=>'edit_category']);
        $deleteCategory = Permission::create(['name' => 'delete_category']);
        $restoreCategory = Permission::create(['name' => 'restore_category']);
        $exportCategory = Permission::create(['name' => 'export_categories']);
        $bulkDeleteCategory = Permission::create(['name' => 'bulk_delete_categories']);


        // Role
        $addRole = Permission::create(['name' => 'add_role']);
        $viewRole = Permission::create(['name' => 'view_role']);
        $editRole = Permission::create(['name' => 'edit_role']);
        $deleteRole = Permission::create(['name' => 'delete_role']);
        $restoreRole = Permission::create(['name' => 'restore_role']);

        // Settings
        $updateSettings = Permission::create(['name'=>'update_settings']);

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
