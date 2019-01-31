<?php

namespace Tests\Unit;

use App\Models\Country;
use App\Models\User;
use Tests\BaseTest;

class UserTest extends BaseTest
{
    /** @test */
    public function a_user_has_has_full_name(){
        $user = factory(User::class)->create();
        $this->assertEquals($user->fullName, $user->first_name." ".$user->last_name);
    }

    /** @test */
    public function a_user_could_not_be_saved_without_first_name() {
        $users = User::create([
            'email' => 'ifte510@gmail.com',
            'password' => bcrypt('secret')
        ]);
        $this->assertDatabaseMissing('users', $users->toArray());
    }

    /** @test */
    public function a_user_could_not_be_saved_without_email() {
        $users = User::create([
            'first_name' => 'Iftekhar',
            'password' => bcrypt('secret')
        ]);
        $this->assertDatabaseMissing('users', $users->toArray());
    }

    /** @test */
    public function a_user_could_not_be_saved_without_password() {
        $users = User::create([
            'first_name' => 'Iftekhar',
            'email' => 'ifte.hsn@gmail.com',
        ]);
        $this->assertDatabaseMissing('users', $users->toArray());
    }



    /** @test */
    public function a_user_could_not_be_saved_if_number_of_character_in_first_name_is_below_three() {
        $users = User::create([
            'first_name' => 'If',
            'email' => 'ifte.hsn@gmail.com',
            'password' => bcrypt('secret')
        ]);
        $this->assertDatabaseMissing('users', $users->toArray());
    }

    /** @test */
    public function a_user_could_not_be_saved_without_proper_website_url() {
        $users = User::create([
            'first_name' => 'If',
            'email' => 'ifte.hsn@gmail.com',
            'password' => bcrypt('secret'),
            'website' => 'google'
        ]);
        $this->assertDatabaseMissing('users', $users->toArray());
    }

    /** @test */
    public function a_user_can_be_soft_deleted() {
        $users = factory(User::class, 5)->create();
        $users[3]->delete();
        $this->assertSoftDeleted('users', $users[3]->toArray());
    }


    /** @test */
    public function a_user_is_belongs_to_a_country()
    {
        $user = factory(User::class)->create();
        $country = Country::create(['name'=> 'Bangladesh']);
        $user->country = $country;
        $this->assertInstanceOf('App\Models\Country', $user->country);
    }
}
