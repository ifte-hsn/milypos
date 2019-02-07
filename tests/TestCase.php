<?php

namespace Tests;

use App\Models\Setting;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

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

}
