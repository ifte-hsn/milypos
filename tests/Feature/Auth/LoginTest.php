<?php

namespace Tests\Feature\Auth;

use App\Models\Setting;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;


class LoginTest extends TestCase
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

    /** @test */
    public function user_can_view_a_login_form() {
        $response = $this->get('/login');
        $response->assertViewIs('auth.login');
    }

    /** @test */
    public function a_user_cannot_view_login_page_if_authenticated() {
        $user = factory(User::class)->create();

        $this->actingAs($user)
            ->get('/login')
            ->assertRedirect(route('home'));
    }

    /** @test */
    public function a_user_can_login_with_correct_credential(){
        $user = factory(User::class)->create([
            'activated' => 1
        ]);
        $response = $this->post('/login', [
            'email' => $user->email,
            'password' => 'secret'
        ]);
        $response->assertStatus(302);
        $this->assertAuthenticatedAs($user);
    }


    /** @test */
    public function a_user_cannot_login_with_incorrect_password() {
        $user = factory(User::class)->create([ 'password' => bcrypt('i-love-milypos')]);

        $response = $this->from('/login')
            ->post('/login', [
                'email' => $user->email,
                'password' => 'some-invalid-password'
            ]);

        $response->assertRedirect('/login');
        $response->assertSessionHasErrors('email');
        $this->assertTrue(session()->hasOldInput('email'));
        $this->assertFalse(session()->hasOldInput('password'));
        $this->assertGuest();
    }


    /** @test */
    public function deactivated_user_cannot_login() {
        $user = factory(User::class)->create([ 'password' => bcrypt('i-love-milypos'), 'activated' => 0]);

        $response = $this->from('/login')
            ->post('/login', [
                'email' => $user->email,
                'password' => 'i-love-milypos'
            ]);

        $response->assertRedirect('/login');
        $response->assertSessionHasErrors('email');
        $this->assertTrue(session()->hasOldInput('email'));
        $this->assertFalse(session()->hasOldInput('password'));
        $this->assertGuest();
    }

    /** @test */
    public function logout_authenticated_user(){
        $user = factory(User::class)->create();
        $this->actingAs($user)->post('/logout')
            ->assertRedirect('/');
        $this->assertGuest();
    }
}
