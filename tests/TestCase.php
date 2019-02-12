<?php

namespace Tests;

use App\Models\User;
use Spatie\Permission\Models\Role;
use Faker\Factory as FakerFactory;
use Spatie\Permission\Models\Permission;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;
    use DatabaseMigrations;

    protected $superAdmin;
    protected $faker;

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

        $this->superAdmin = factory(User::class)->create(['activated' => 1]);



        // Only super admin can access all the features
        // so for the time being we will assign Super Admin
        // Role to the user. To test other role and their
        // permissions we have separate test.
        $this->superAdmin->assignRole(Role::findByName('Super Admin'));
        $this->faker = FakerFactory::create();
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
