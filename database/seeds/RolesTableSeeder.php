<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('roles')->delete();

        $roles = [
            'Super Admin',
            'Admin'
        ];
        foreach ($roles as $role) {
            Role::create(['name' => $role]);
        }


        // Sync Permissions
        $adminRole = Role::findByName('Admin');

        // Create permission
        $adminRole->syncPermissions([
            // User Module
            Permission::findByName('add_user'),
            Permission::findByName('view_user'),
            Permission::findByName('edit_user'),
            Permission::findByName('delete_user'),
            Permission::findByName('restore_user'),
            Permission::findByName('bulk_delete_users'),
            Permission::findByName('export_users'),

            // Category
            Permission::findByName('add_category'),
            Permission::findByName('view_category'),
            Permission::findByName('edit_category'),
            Permission::findByName('delete_category'),
            Permission::findByName('restore_category'),
            Permission::findByName('export_categories'),
            Permission::findByName('bulk_delete_categories'),

            // Role
            Permission::findByName('add_role'),
            Permission::findByName('view_role'),
            Permission::findByName('edit_role'),
            Permission::findByName('delete_role'),
            Permission::findByName('restore_role'),

            // Settings
            Permission::findByName('update_settings'),
        ]);
    }
}
