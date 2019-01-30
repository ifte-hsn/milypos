<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UsersTest extends TestCase
{
    use DatabaseMigrations;

    public function setUp()
    {
        parent::setUp();
        $this->super_admin_role = Role::create(['name' => 'Super Admin']);
        $this->admin_role = Role::create(['name' => 'Admin']);
    }

    /** @test */
    public function user_can_login_to_the_system()
    {
        $user = factory(User::class)->create();
        $this->actingAs($user)
            ->get('/')
            ->assertSee('dashboard');
    }

    /** @test */
    public function a_user_with_without_add_user_permission_can_not_access_create_new_user_page() {
        $user = factory(User::class)->create();
        $this->actingAs($user)
            ->get('/users/create')
            ->assertStatus(403);
    }
}
