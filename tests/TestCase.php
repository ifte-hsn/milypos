<?php

namespace Tests;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;
    use DatabaseMigrations;

    public function setUp()
    {
        parent::setUp();

        $countries = new \CountriesTableSeeder();
        $countries->run();

        $currencies = new \CurrenciesTableSeeder();
        $currencies->run();

        $settings = new \SettingsTableSeeder();
        $settings->run();

        $permissions = new \PermissionsTableSeeder();
        $permissions->run();

        $roles = new \RolesTableSeeder();
        $roles->run();
    }

    protected function create_user_and_assign_role_and_permission($role, $permission = null) {
        $user = factory(User::class)->create(['activated' => 1]);
        $role = Role::findByName($role);

        if($permission != null) {
            $permission = Permission::findByName($permission);
            $role->givePermissionTo($permission);
        }
        $user->assignRole($role);

        return $user;
    }

}
