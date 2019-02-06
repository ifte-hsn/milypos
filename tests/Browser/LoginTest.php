<?php

namespace Tests\Browser;

use App\Models\Setting;
use App\Models\User;
use Tests\Browser\Pages\Login;
use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class LoginTest extends DuskTestCase
{
    use DatabaseMigrations;

    /** @test */
    public function unauthenticated_user_see_login_page()
    {

        $this->browse(function (Browser $browser) {
            $browser->visit('/')
                    ->assertSee('Sign in to start your session');
        });
    }

    /** @test */
    public function login_using_currect_credential() {

        $this->browse(function (Browser $browser){
            $user = factory(User::class)->create([
                'activated' => 1
            ]);
           $browser->visit(new Login())
               ->value('@email', $user->email)
               ->value('@pass', 'secret')
               ->press('@submit')
               ->assertRouteIs('home');
        });
    }


    /** @test */
    public function authenticated_user_can_see_his_name_on_header(){
        $this->browse(function (Browser $browser) {
            $user = factory(User::class)->create([
                'activated' => 1
            ]);

            $browser->loginAs($user)
                ->visit('/home')
                ->assertSee($user->first_name)
                ->click('li.user-menu')
                ->assertSee($user->fullName);
        });
    }

    /** @test */
    public function authenticated_user_can_see_his_profile_edit_page(){
        $this->browse(function (Browser $browser) {
            $user = factory(User::class)->create([
                'activated' => 1
            ]);

            $browser->loginAs($user)
                ->visit('/home')
                ->click('li.user-menu')
                ->clickLink('Edit Profile')
                ->assertRouteIs('users.edit', ['user'=>$user->id])
                ->assertValue('#first-name', $user->first_name)
                ->assertValue('#last-name', $user->last_name)
                ->assertValue('#email', $user->email)
                ->assertSelected('#sex', $user->sex)
                ->assertValue('#employee-num', $user->employee_num)
                ->assertValue('#website', $user->website)
                ->assertValue('#phone', $user->phone)
                ->assertValue('#fax', $user->fax)
                ->assertValue('#address', $user->address)
                ->assertValue('#city', $user->city)
                ->assertValue('#state', $user->state)
                ->assertValue('#zip', $user->zip);

        });
    }

    /** @test */
    public function logged_in_user_can_logged_out(){
        $this->browse(function (Browser $browser) {
            $user = factory(User::class)->create([
                'activated' => 1
            ]);

            $browser->loginAs($user)
                ->visit('/home')
                ->click('li.user-menu')
                ->press('Sign out')
                ->assertPathIs('/login');
        });
    }
}
