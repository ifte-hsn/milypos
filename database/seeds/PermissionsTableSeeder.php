<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('permissions')->delete();
        DB::table('model_has_permissions')->delete();
        DB::table('model_has_roles')->delete();
        DB::table('role_has_permissions')->delete();

        /**
         * Create Permission
         */

        // User
        Permission::create(['name'=>'add_user']);
        Permission::create(['name'=>'view_user']);
        Permission::create(['name'=>'edit_user']);
        Permission::create(['name' => 'delete_user']);
        Permission::create(['name' => 'restore_user']);
        Permission::create(['name' => 'bulk_delete_users']);
        Permission::create(['name' => 'export_users']);

        // Categories
        Permission::create(['name'=>'add_category']);
        Permission::create(['name'=>'view_category']);
        Permission::create(['name'=>'edit_category']);
        Permission::create(['name' => 'delete_category']);
        Permission::create(['name' => 'restore_category']);
        Permission::create(['name' => 'export_categories']);
        Permission::create(['name' => 'bulk_delete_categories']);


        // Role
        Permission::create(['name' => 'add_role']);
        Permission::create(['name' => 'view_role']);
        Permission::create(['name' => 'edit_role']);
        Permission::create(['name' => 'delete_role']);
        Permission::create(['name' => 'restore_role']);

        // Settings
        Permission::create(['name'=>'update_settings']);

    }
}
