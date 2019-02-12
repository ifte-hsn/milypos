<?php

namespace Tests\Feature;


use App\Helpers\Helper;
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
        $unauthorized_user = $this->create_user_and_assign_role_and_permission('Admin');

        $this->actingAs($unauthorized_user)
            ->get(route('clients.index'))
            ->assertStatus(403);
    }


    /** @test */
    public function user_can_see_client_index_page_if_he_is_authorized_to_view_client()
    {
        $authorized_user = $this->create_user_and_assign_role_and_permission('Admin', 'view_client');

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
        $user = $this->create_user_and_assign_role_and_permission('Admin', 'view_user');

        $this->actingAs($user)
            ->get(route('clients.list'))
            ->assertStatus(403);
    }

    /** @test */
    public function if_the_user_is_authorized_to_view_client_will_be_able_to_view_client_list()
    {
        $user = $this->create_user_and_assign_role_and_permission('Admin', 'view_client');

        $client = factory(Client::class)->create();

        $client = Client::findOrFail($client->id);

        $this->actingAs($user)
            ->get(route('clients.list'))
            ->assertJson([
                "total" => 1,
                "rows" => [
                    [
                        "id" => $client->id,
                        "email" => $client->email,
                        "name" => e($client->fullName),
                        "first_name" => e($client->first_name),
                        "last_name" => e($client->last_name),
                        "phone" => e($client->phone),
                        "address" => e($client->address),
                        "city" => e($client->city),
                        "state" => e($client->state),
                        "country" => e($client->country->name),
                        "zip" => e($client->zip),
                        'sex' => e($client->sex),
                        'shopping' => e($client->shopping),
                        'last_purchase' => Helper::getFormattedDateObject($client->last_purchase, 'datetime'),
                        'dob' => ($client->dob) ? Helper::getFormattedDateObject($client->dob, 'datetime') : null,
                    ]
                ]
            ]);
    }


    /** @test */
    public function super_admin_can_see_client_list()
    {
        $client = factory(Client::class)->create();

        $client = Client::findOrFail($client->id);

        $this->actingAs($this->superAdmin)
            ->get(route('clients.list'))
            ->assertJson([
                "total" => 1,
                "rows" => [
                    [
                        "id" => $client->id,
                        "email" => $client->email,
                        "name" => e($client->fullName),
                        "first_name" => e($client->first_name),
                        "last_name" => e($client->last_name),
                        "phone" => e($client->phone),
                        "address" => e($client->address),
                        "city" => e($client->city),
                        "state" => e($client->state),
                        "country" => e($client->country->name),
                        "zip" => e($client->zip),
                        'sex' => e($client->sex),
                        'shopping' => e($client->shopping),
                        'last_purchase' => Helper::getFormattedDateObject($client->last_purchase, 'datetime'),
                        'dob' => ($client->dob) ? Helper::getFormattedDateObject($client->dob, 'datetime') : null,
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
    public function if_user_is_unauthorized_to_create_new_client_then_he_will_get_403_status_when_he_tries_to_visit_client_create_page(
    )
    {
        $user = $this->create_user_and_assign_role_and_permission('Admin', 'view_user');

        $this->actingAs($user)
            ->get(route('clients.create'))
            ->assertStatus(403);
    }


    /** @test */
    public function if_a_user_is_authorized_to_create_new_client_then_he_is_able_to_create_new_client()
    {
        $user = $this->create_user_and_assign_role_and_permission('Admin', 'add_client');

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
            'first_name' => e($client->first_name),
            'last_name' => e($client->last_name),
            'sex' => e($client->sex),
            'phone' => e($client->phone),
            'address' => e($client->address),
            'city' => e($client->city),
            'state' => e($client->state),
            'zip' => e($client->zip),
            'country_id' => $client->country->id,
        ]);
    }

    /** @test */
    public function super_user_can_create_new_client()
    {
        $client = factory(Client::class)->make();

        $this->actingAs($this->superAdmin)
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
        $user = $this->create_user_and_assign_role_and_permission('Admin', 'view_user');


        $client = factory(Client::class)->create();

        $this->actingAs($user)
            ->get(route('clients.edit', ['client' => $client->id]))
            ->assertStatus(403);
    }

    /** @test */
    public function if_user_is_authorized_to_update_client_will_be_able_to_see_client_edit_page()
    {
        $user = $this->create_user_and_assign_role_and_permission('Admin', 'edit_client');

        $client = factory(Client::class)->create();
        $this->actingAs($user)
            ->get(route('clients.edit', ['client' => $client->id]))
            ->assertViewIs('clients.edit');
    }

    /** @test */
    public function if_user_is_authorized_to_update_client_then_he_will_be_able_to_update_clients()
    {
        $user = $this->create_user_and_assign_role_and_permission('Admin', 'edit_client');

        $clients = factory(Client::class, 10)->create();

        // Get the client which we will update
        $client = $clients[5];
        $client->first_name = 'John Doe';

        $this->actingAs($user)
            ->from(route('clients.edit', ['client' => $client->id]))
            ->put(route('clients.update', ['client' => $client->id]), $client->toArray());

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


    /** @test */
    public function client_cannot_be_created_without_first_name()
    {
        $this->actingAs($this->superAdmin)
            ->from(route('clients.create'))
            ->post(route('clients.store'), [
                'email' => $this->faker->email,
                'password' => 'secret',
            ])
            ->assertRedirect(route('clients.create'))
            ->assertSessionHasErrors('first_name');

        $this->assertTrue(session()->hasOldInput('email'));
        $this->assertFalse(session()->hasOldInput('password'));
    }


    /** @test */
    public function client_cannot_be_created_without_email()
    {
        $this->actingAs($this->superAdmin)
            ->from(route('clients.create'))
            ->post(route('clients.store'), [
                'first_name' => $this->faker->firstName,
                'password' => 'secret',
            ])
            ->assertRedirect(route('clients.create'))
            ->assertSessionHasErrors('email');

        $this->assertTrue(session()->hasOldInput('first_name'));
        $this->assertFalse(session()->hasOldInput('password'));
    }

    /** @test */
    public function email_address_must_be_unique()
    {

        $email = $this->faker->unique()->safeEmail;

        $client1 = factory(Client::class)->make([
            'email' => $email,
        ]);


        $client2 = factory(Client::class)->make([
            'email' => $email,
        ]);

        $this->actingAs($this->superAdmin)
            ->from(route('clients.create'))
            ->post(route('clients.store'), [
                'email' => $client1['email'],
                'first_name' => $client1['first_name'],
            ]);

        $this->assertDatabaseHas('clients', [
            'email' => $email,
            'first_name' => $client1['first_name']
        ]);
//
        $this->from(route('clients.create'))
            ->post(route('clients.store'), [
                'email' => $client2['email'],
                'first_name' => $client2['first_name'],
            ])
            ->assertRedirect(route('clients.create'));


        $this->assertTrue(session()->hasOldInput('first_name'));
        $this->assertTrue(session()->hasOldInput('email'));
        $this->assertFalse(session()->hasOldInput('password'));

        $this->assertDatabaseMissing('clients', [
            'email' => $email,
            'first_name' => $client2['first_name']
        ]);
    }

    /** @test */
    public function client_can_be_deleted()
    {
        $client = factory(Client::class)->create();

        $this->actingAs($this->superAdmin)
            ->delete(route('clients.destroy', ['client' => $client->id]));

        $this->get(route('clients.list'))
            ->assertJson(["total" => 0]);
    }

    /** @test */
    public function unauthenticated_user_redirect_to_login_page_when_they_try_to_delete_a_client_entry()
    {
        $clients = factory(Client::class, 10)->create();

        $this->delete(route('clients.destroy', ['client' => $clients[3]]))
            ->assertRedirect('login');
    }


    /** @test */
    public function if_a_user_is_not_authorized_to_delete_entry_then_they_will_get_403_status()
    {
        $user = $this->create_user_and_assign_role_and_permission('Admin', 'view_user');

        $client = factory(Client::class)->create();

        $this->actingAs($user)
            ->delete(route('clients.destroy', ['client' => $client->id]))
            ->assertStatus(403);
    }


    /** @test */
    public function if_a_user_is_authorized_to_delete_client_entry_then_he_will_able_to_delete()
    {
        $clients = factory(Client::class, 10)->create();

        $user = $this->create_user_and_assign_role_and_permission('Admin', 'delete_client');


        $this->actingAs($user)
            ->delete(route('clients.destroy', ['client' => $clients[3]->id]));

        $url = route('clients.list') . '?deleted=true';

        // Give permission to view user;
        // without view user permission
        // the user will not able to
        // see deleted user
        $role = Role::findByName('Admin');
        $role->givePermissionTo(Permission::findByName('view_client'));

        $this->get($url)
            ->assertJson(
                [
                    "total" => 1,
                    "rows" => [
                        [
                            "email" => $clients[3]->email,
                            "name" => e($clients[3]->fullName),
                            "first_name" => e($clients[3]->first_name),
                            "last_name" => e($clients[3]->last_name),
                            "phone" => e($clients[3]->phone),
                            "address" => e($clients[3]->address),
                            "city" => e($clients[3]->city),
                            "state" => e($clients[3]->state),
                            "country" => e($clients[3]->country->name),
                            "zip" => e($clients[3]->zip),
                        ]
                    ]
                ]
            );
    }

    /** @test */
    public function it_can_show_deleted_clients()
    {
        $clients = factory(Client::class, 10)->create();

        $id = $clients[3]->id;

        $url = route('clients.list') . '?deleted=true';

        $this->actingAs($this->superAdmin)
            ->delete(route('clients.destroy', ['client' => $id]));

        $this->get($url)
            ->assertJson(
                [
                    "total" => 1,
                    "rows" => [
                        [
                            "id" => $clients[3]->id,
                            "email" => $clients[3]->email,
                            "name" => $clients[3]->fullName,
                            "first_name" => $clients[3]->first_name,
                            "last_name" => $clients[3]->last_name,
                            "phone" => $clients[3]->phone,
                            "address" => $clients[3]->address,
                            "city" => $clients[3]->city,
                            "state" => $clients[3]->state,
                            "country" => $clients[3]->country->name,
                            "zip" => $clients[3]->zip
                        ]
                    ]
                ]
            );
    }

    /** @test */
    public function if_a_user_is_not_authenticated_then_he_will_redirect_to_login_page_when_he_try_to_restore_client()
    {
        $client = factory(Client::class)->create();

        $this->get(route('clients.restore', ['client' => $client->id]))
            ->assertRedirect('login');
    }

    /** @test */
    public function if_the_user_is_unauthorized_to_restore_he_will_get_403_status_when_he_try_to_restore_deleted_client(
    )
    {
        $user = $this->create_user_and_assign_role_and_permission('Admin', 'view_user');


        $clients = factory(Client::class, 10)->create();

        $clients[4]->delete();

        $this->actingAs($user)
            ->get(route('clients.restore', ['client' => $clients[4]->id]))->assertStatus(403);
    }


    /** @test */
    public function if_a_user_is_authorized_then_he_will_be_able_to_restore_client()
    {
        $user = $this->create_user_and_assign_role_and_permission('Admin', 'restore_client');

        $client_to_delete = factory(Client::class)->create();

        $client_to_delete->delete();

        $url = route('clients.list') . '?deleted=true';

        $role = Role::findByName('Admin');

        $role->givePermissionTo(Permission::findByName('view_client'));

        $this->actingAs($user)
            ->get($url)
            ->assertJson([
                "total" => 1,
                "rows" => [
                    [
                        "id" => $client_to_delete->id,
                        "email" => $client_to_delete->email,
                        "name" => $client_to_delete->fullName,
                        "first_name" => $client_to_delete->first_name,
                        "last_name" => $client_to_delete->last_name,
                        "phone" => $client_to_delete->phone,
                        "address" => $client_to_delete->address,
                        "city" => $client_to_delete->city,
                        "state" => $client_to_delete->state,
                        "country" => $client_to_delete->country->name,
                        "zip" => $client_to_delete->zip,
                    ]
                ]
            ]);

        $this->get(route('clients.restore', ['clients' => $client_to_delete->id]));

        $this->get(route('clients.list'))->assertJson(['total' => '1']);

    }


    /** @test */
    public function deleted_client_can_be_restored()
    {
        $client = factory(Client::class)->create();

        $this->actingAs($this->superAdmin)
            ->delete(route('clients.destroy', ['client' => $client->id]));

        $url = route('clients.list') . '?deleted=true';

        $this->get($url)
            ->assertJson([
                "total" => 1,
                "rows" => [
                    [
                        "id" => $client->id,
                        "email" => $client->email,
                        "name" => e($client->fullName),
                        "first_name" => e($client->first_name),
                        "last_name" => e($client->last_name),
                        "phone" => e($client->phone),
                        "address" => e($client->address),
                        "city" => e($client->city),
                        "state" => e($client->state),
                        "country" => e($client->country->name),
                    ]
                ]
            ]);

        $this->get(route('clients.restore', ['client' => $client->id]));

        $this->get(route('clients.list'))->assertJson(['total' => '1']);
    }

    /** @test */
    public function if_the_user_is_not_authenticated_then_he_will_redirect_to_login_page_when_try_to_bulk_save_clients()
    {
        $clients = factory(Client::class, 10)->create();
        $ids = [];

        for ($i = 0; $i < 5; $i++) {
            array_push($ids, $clients[$i]->id);
        }

        $this->post(route('clients.bulkSave'), ['ids' => $ids])
            ->assertRedirect('login');
    }

    /** @test */
    public function if_the_user_is_not_authorized_to_bulk_delete_then_he_will_redirect_to_403_page_when_try_to_bulk_save_clients(
    )
    {
        $clients = factory(Client::class, 10)->create();
        $ids = [];

        $user = factory(User::class)->create(['activated' => 1]);

        for ($i = 0; $i < 5; $i++) {
            array_push($ids, $clients[$i]->id);
        }

        $this->actingAs($user)
            ->post(route('clients.bulkSave'), ['ids' => $ids])
            ->assertStatus(403);
    }

    /** @test */
    public function if_the_user_is_authorized_to_bulk_delete_then_he_will_able_to_bulk_delete_clients()
    {
        $user = $this->create_user_and_assign_role_and_permission('Admin', 'bulk_delete_clients');

        $clients = factory(Client::class, 10)->create();
        $ids = [];


        for ($i = 0; $i < 5; $i++) {
            array_push($ids, $clients[$i]->id);
        }

        $this->actingAs($user)
            ->post(route('clients.bulkSave'), ['ids' => $ids]);

        $role = Role::findByName('Admin');
        $role->givePermissionTo(Permission::findByName('view_client'));

        $this->get(route('clients.list'))
            ->assertJson(['total' => 5]);

        $url = route('clients.list') . '?deleted=true';

        $this->get($url)
            ->assertJson(
                [
                    "total" => 5,
                ]
            );
    }

    /** @test */
    public function it_can_bulk_delete_clients()
    {
        $clients = factory(Client::class, 10)->create();
        $ids = [];

        for ($i = 0; $i < 5; $i++) {
            array_push($ids, $clients[$i]->id);
        }

        $this->actingAs($this->superAdmin)
            ->post(route('clients.bulkSave'), ['ids' => $ids]);

        $this->get(route('clients.list'))
            ->assertJson(['total' => 5]);


        $url = route('clients.list') . '?deleted=true';

        $this->get($url)
            ->assertJson(
                [
                    "total" => 5,
                ]
            );

    }
}