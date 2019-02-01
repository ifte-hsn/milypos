<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Spatie\Permission\Models\Role;
use Tests\BaseTest;

class UsersTest extends BaseTest
{
    private $user;
    private $role;

    public function setUp()
    {
        parent::setUp();
        $this->user = factory(User::class)->create();

        // Only super admin can access all the features
        // so for the time being we will assign Super Admin
        // Role to the user. To test other role and their
        // permissions we have separate test.
        $this->role = Role::create(['name' => 'Super Admin']);
        $this->user->assignRole($this->role);
    }

    /** @test */
    public function site_header_shows_authenticated_users_fullname() {
        $this->actingAs($this->user)
            ->get('/')
            ->assertSee($this->user->fullName);
    }

    /** @test */
    public function an_authenticated_user_can_see_user_list() {
        $this->actingAs($this->user)
            ->get(route('users.list'))
            ->assertJson([
                "total" => 1,
                "rows" => [
                    [
                        "id" => $this->user->id,
                        "name" => $this->user->fullName,
                        "first_name" => $this->user->first_name,
                        "last_name" => $this->user->last_name,
                        "phone" => $this->user->phone,
                        "address" => $this->user->address,
                        "city" => $this->user->city,
                        "state" => $this->user->state,
                        "country" => $this->user->country,
                        "zip" => $this->user->zip,
                        "email" => $this->user->email,
                        "activated" => $this->user->activated,
                        "website" => $this->user->website,
                    ]
                ]
            ]);
    }

}
