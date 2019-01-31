<?php

namespace Tests;

use App\Models\Setting;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class BaseTest extends TestCase
{
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