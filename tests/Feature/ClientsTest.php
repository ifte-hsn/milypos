<?php

namespace Tests\Feature;


use App\Models\Client;
use App\Models\User;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Faker\Factory as FakerFactory;
use Tests\TestCase;

class ClientsTest extends TestCase
{
    private $superAdmin;
    private $faker;

    public function setUp()
    {
        parent::setUp();


        $this->superAdmin = factory(User::class)->create(['activated' => 1]);

        // Only super admin can access all the features
        // so for the time being we will assign Super Admin
        // Role to the user. To test other role and their
        // permissions we have separate test.
        $this->superAdmin->assignRole(Role::findByName('Super Admin'));
        $this->faker = FakerFactory::create();
    }


    /** @test */
    public function unauthenticated_user_redirects_to_login_page_when_he_tries_to_access_client_index_page()
    {

        $this->get(route('clients.index'))
            ->assertRedirect('login');
    }

    /** @test */
    public function user_can_not_see_client_index_page_if_he_is_not_authorized_to_view_client()
    {
        $unauthorized_user = factory(User::class)->create(['activated' => 1]);
        $role = Role::findByName('Admin');
        $unauthorized_user->assignRole($role);

        $this->actingAs($unauthorized_user)
            ->get(route('clients.index'))
            ->assertStatus(403);
    }


    /** @test */
    public function user_can_see_client_index_page_if_he_is_authorized_to_view_client()
    {
        $authorized_user = factory(User::class)->create(['activated' => 1]);
        $role = Role::findByName('Admin');

        $permission = Permission::findByName('view_client');
        $permission->assignRole($role);

        $authorized_user->assignRole($role);

        $this->actingAs($authorized_user)
            ->get(route('clients.index'))->assertViewIs('clients.index');
    }

    /** @test */
    public function unauthenticated_user_redirect_to_login_page_when_try_to_see_clients_list()
    {
        $this->get(route('clients.list'))
            ->assertRedirect('login');
    }

    /** @test */
    public function if_the_user_is_unauthorized_to_view_client_will_get_403_status_when_trying_to_view_client_list()
    {
        $user = factory(User::class)->create(['activated' => 1]);
        $role = Role::findByName('Admin');
        $user->assignRole($role);

        $permission = Permission::findByName('view_user');
        $role->givePermissionTo($permission);

        $this->actingAs($user)
            ->get(route('clients.list'))
            ->assertStatus(403);
    }

    /** @test */
    public function if_the_user_is_authorized_to_view_client_will_be_able_to_view_client_list()
    {
        $user = factory(User::class)->create(['activated' => 1]);
        $role = Role::findByName('Admin');
        $user->assignRole($role);

        $permission = Permission::findByName('view_client');
        $role->givePermissionTo($permission);

        $client = factory(Client::class)->create();

        $this->actingAs($user)
            ->get(route('clients.list'))
            ->assertJson([
                "total" => 1,
                "rows" => [
                    [
                        "id" => $client->id,
                        "email" => $client->email,
                        "name" => $client->fullName,
                        "first_name" => $client->first_name,
                        "last_name" => $client->last_name,
                        "phone" => $client->phone,
                        "address" => $client->address,
                        "city" => $client->city,
                        "state" => $client->state,
                        "country" => $client->country->name,
                        "zip" => $client->zip,
                        'sex' => $client->sex,
                        'shopping' => $client->shopping,
                    ]
                ]
            ]);
    }


    /** @test */
    public function super_admin_can_see_client_list()
    {
        $client = factory(Client::class)->create();

        $this->actingAs($this->superAdmin)
            ->get(route('clients.list'))
            ->assertJson([
                "total" => 1,
                "rows" => [
                    [
                        "id" => $client->id,
                        "email" => $client->email,
                        "name" => $client->fullName,
                        "first_name" => $client->first_name,
                        "last_name" => $client->last_name,
                        "phone" => $client->phone,
                        "address" => $client->address,
                        "city" => $client->city,
                        "state" => $client->state,
                        "country" => $client->country->name,
                        "zip" => $client->zip,
                        'sex' => $client->sex,
                        'shopping' => $client->shopping,
                    ]
                ]
            ]);
    }

    /** @test */
    public function unauthenticated_user_will_redirect_to_login_page_if_he_tries_to_go_client_create_page()
    {
        $this->get(route('clients.create'))
            ->assertRedirect('login');
    }

    /** @test */
    public function if_user_is_unauthorized_to_create_new_client_then_he_will_get_403_status_when_he_tries_to_visit_client_create_page()
    {
        $user = factory(User::class)->create(['activated' => 1]);
        $role = Role::findByName('Admin');

        $permission = Permission::findByName('view_user');
        $role->givePermissionTo($permission);

        $user->assignRole($role);

        $this->actingAs($user)
            ->get(route('clients.create'))
            ->assertStatus(403);
    }


    /** @test */
    public function if_a_user_is_authorized_to_create_new_client_then_he_is_able_to_create_new_client()
    {
        $user = factory(User::class)->create(['activated' => 1]);
        $role = Role::findByName('Admin');

        $permission = Permission::findByName('add_client');
        $role->givePermissionTo($permission);

        $user->assignRole($role);

        $client = factory(Client::class)->make();

        $this->actingAs($user)
            ->from(route('clients.create'))
            ->post(route('clients.store'), [
                'email' => $client->email,
                'first_name' => $client->first_name,
                'last_name' => $client->last_name,
                'sex' => $client->sex,
                'phone' => $client->phone,
                'address' => $client->address,
                'city' => $client->city,
                'state' => $client->state,
                'zip' => $client->zip,
                'shopping' => $client->shopping,
                'last_purchase' => $client->last_purchase,
                'dob' => $client->dob,
                'country' => $client->country->id,
            ])->assertStatus(302);

        $this->assertDatabaseHas('clients', [
            'email' => $client->email,
            'first_name' => $client->first_name,
            'last_name' => $client->last_name,
            'sex' => $client->sex,
            'phone' => $client->phone,
            'address' => $client->address,
            'city' => $client->city,
            'state' => $client->state,
            'zip' => $client->zip,
            'country_id' => $client->country->id,
        ]);
    }

    /** @test */
    public function super_user_can_create_new_client()
    {
        $user = factory(User::class)->create(['activated' => 1]);
        $role = Role::findByName('Super Admin');

        $user->assignRole($role);

        $client = factory(Client::class)->make();

        $this->actingAs($user)
            ->from(route('clients.create'))
            ->post(route('clients.store'), [
                'email' => $client->email,
                'first_name' => $client->first_name,
                'last_name' => $client->last_name,
                'sex' => $client->sex,
                'phone' => $client->phone,
                'address' => $client->address,
                'city' => $client->city,
                'state' => $client->state,
                'zip' => $client->zip,
                'shopping' => $client->shopping,
                'last_purchase' => $client->last_purchase,
                'dob' => $client->dob,
                'country' => $client->country->id,
            ])->assertStatus(302);

        $this->assertDatabaseHas('clients', [
            'email' => $client->email,
            'first_name' => $client->first_name,
            'last_name' => $client->last_name,
            'sex' => $client->sex,
            'phone' => $client->phone,
            'address' => $client->address,
            'city' => $client->city,
            'state' => $client->state,
            'zip' => $client->zip,
            'country_id' => $client->country->id,
        ]);
    }

    /** @test */
    public function unauthorized_user_redirect_to_login_page_if_user_tries_to_go_client_edit_page()
    {
        $client = factory(Client::class)->create();
        $this->get(route('clients.edit', ['client' => $client->id]))
            ->assertRedirect('login');
    }

    /** @test */
    public function if_user_is_unauthorized_to_update_client_will_get_403_status_when_try_to_view_client_edit_page()
    {
        $user = factory(User::class)->create(['activated' => 1]);
        $role = Role::findByName('Admin');
        $permission = Permission::findByName('view_user');
        $role->givePermissionTo($permission);

        $user->assignRole($role);

        $client = factory(Client::class)->create();

        $this->actingAs($user)
            ->get(route('clients.edit', ['client' => $client->id]))
            ->assertStatus(403);
    }

    /** @test */
    public function if_user_is_authorized_to_update_client_will_be_able_to_see_client_edit_page()
    {
        $user = factory(User::class)->create(['activated' => 1]);
        $role = Role::findByName('Admin');
        $permission = Permission::findByName('edit_client');
        $role->givePermissionTo($permission);

        $user->assignRole($role);

        $client = factory(Client::class)->create();
        $this->actingAs($user)
            ->get(route('clients.edit', ['client' => $client->id]))
            ->assertViewIs('clients.edit');
    }

    /** @test */
    public function if_user_is_authorized_to_update_client_then_he_will_be_able_to_update_clients()
    {
        $user = factory(User::class)->create(['activated' => 1]);
        $role = Role::findByName('Admin');
        $permission = Permission::findByName('edit_client');
        $role->givePermissionTo($permission);

        $user->assignRole($role);

        $clients = factory(Client::class, 10)->create();

        // Get the client which we will update
        $client = $clients[5];
        $client->first_name = 'John Doe';

        $this->actingAs($user)
            ->from(route('clients.edit', ['client' => $client->id]))
            ->put(route('clients.update', ['client'=>$client->id]), $client->toArray());

        $updated_client = Client::findOrFail($clients[5]->id);

        $this->assertEquals($updated_client->first_name, $client->first_name);
    }

    /** @test */
    public function super_admin_can_update_client()
    {
        $clients = factory(Client::class, 10)->create();

        $client = $clients[3];
        $first_name = $this->faker->firstName;
        $client->first_name = $first_name;

        $this->actingAs($this->superAdmin)
            ->put(route('clients.update', ['client' => $client->id]), $client->toArray());

        $updated_client = Client::findOrFail($client->id);
        $this->assertEquals($first_name, $updated_client->first_name);
    }
}