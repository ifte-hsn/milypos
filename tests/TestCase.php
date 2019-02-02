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

        Setting::create([
            'site_name' => 'Mily POS',
            'logo' => 'logo.png',
            'login_logo' => 'login_logo.png',
            'favicon' => 'favicon.png',
            'currency_id' => 1
        ]);
    }

}
