<?php

namespace Tests\Unit;

use App\Models\Country;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function a_user_is_belongs_to_a_country()
    {
        $user = factory(User::class)->create();
        $country = Country::create(['name'=> 'Bangladesh']);
        $user->country = $country;
        $this->assertInstanceOf('App\Models\Country', $user->country);
    }
}
