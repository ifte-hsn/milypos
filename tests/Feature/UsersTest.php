<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class UsersTest extends TestCase
{
    /** @test */
    public function site_header_shows_authenticated_users_fullname()
    {
        $this->actingAs($this->superAdmin)
            ->get('/')
            ->assertSee($this->superAdmin->fullName);
    }

    /** @test */
    public function unauthenticated_user_redirect_to_login_page_when_try_to_see_user_index_page()
    {
        $this->get(route('users.index'))
            ->assertRedirect('login');
    }

    /** @test */
    public function user_can_not_see_user_index_page_if_he_is_not_authorized_to_view_user()
    {
        $unauthorized_user = factory(User::class)->create(['activated' => 1]);
        $role = Role::findByName('Admin');
        $unauthorized_user->assignRole($role);

        $this->actingAs($unauthorized_user)
            ->get(route('users.index'))
            ->assertStatus(403);
    }

    /** @test */
    public function user_can_see_user_index_page_if_he_is_authorized_to_view_user()
    {
        $unauthorized_user = $this->create_user_and_assign_role_and_permission('Admin', 'view_user');

        $this->actingAs($unauthorized_user)
            ->get(route('users.index'))->assertViewIs('users.index');
    }

    /** @test */
    public function unauthenticated_user_redirect_to_login_page_when_try_to_see_user_list()
    {
        $this->get(route('users.list'))
            ->assertRedirect('login');
    }

    /** @test */
    public function if_the_user_is_unauthorized_to_view_user_will_get_403_status_when_trying_to_view_user_list()
    {
        $user = $this->create_user_and_assign_role_and_permission('Admin', 'view_client');

        $this->actingAs($user)
            ->get(route('users.list'))
            ->assertStatus(403);
    }

    /** @test */
    public function if_the_user_is_authorized_to_view_user_will_able_to_view_user_list_when_trying_to_view_user_list()
    {
        $user = $this->create_user_and_assign_role_and_permission('Admin', 'view_user');

        $this->actingAs($user)
            ->get(route('users.list'))
            ->assertJson([
                "total" => 2,
            ]);

    }

    /** @test */
    public function super_admin_can_see_user_list()
    {
        $this->actingAs($this->superAdmin)
            ->get(route('users.list'))
            ->assertJson([
                "total" => 1,
                "rows" => [
                    [
                        "id" => e($this->superAdmin->id),
                        "email" => e($this->superAdmin->email),
                        "name" => e($this->superAdmin->fullName),
                        "first_name" => e($this->superAdmin->first_name),
                        "last_name" => e($this->superAdmin->last_name),
                        "phone" => e($this->superAdmin->phone),
                        "address" => e($this->superAdmin->address),
                        "city" => e($this->superAdmin->city),
                        "state" => e($this->superAdmin->state),
                        "country" => e($this->superAdmin->country->name),
                        "zip" => e($this->superAdmin->zip),
                        "activated" => e($this->superAdmin->activated),
                        "website" => e($this->superAdmin->website),
                    ]
                ]
            ]);
    }


    /** @test */
    public function unauthenticated_user_will_redirect_to_login_page_if_he_tries_to_go_user_create_page()
    {
        $this->get(route('users.create'))
            ->assertRedirect('login');
    }

    /** @test */
    public function if_user_is_unauthorized_to_create_new_user_then_he_will_get_403_status_when_he_tries_to_visit_user_create_page()
    {

        $user = $this->create_user_and_assign_role_and_permission('Admin', 'view_user');

        $this->actingAs($user)
            ->get(route('users.create'))
            ->assertStatus(403);
    }

    /** @test */
    public function if_a_user_is_authorized_to_create_new_user_then_he_is_able_to_create_new_user()
    {
        $user = $this->create_user_and_assign_role_and_permission('Admin', 'add_user');

        $new_user = factory(User::class)->make(['activated' => 1]);

        $this->actingAs($user)
            ->from(route('users.create'))
            ->post(route('users.store'), [
                'email' => $new_user->email,
                'email_verified_at' => $new_user->email_verified_at,
                'password' => 'secret',
                'remember_token' => $new_user->remember_token,
                'last_login' => $new_user->last_login,
                'first_name' => $new_user->first_name,
                'last_name' => $new_user->last_name,
                'employee_num' => $new_user->employee_num,
                'phone' => $new_user->phone,
                'fax' => $new_user->fax,
                'website' => $new_user->website,
                'address' => $new_user->address,
                'city' => $new_user->city,
                'state' => $new_user->state,
                'zip' => $new_user->zip,
                'activated' => $new_user->activated,
                'sex' => $new_user->sex
            ])->assertStatus(302);

        $this->assertDatabaseHas('users', [
            'email' => $new_user->email,
            'first_name' => e($new_user->first_name),
            'last_name' => e($new_user->last_name),
            'phone' => e($new_user->phone),
            'fax' => e($new_user->fax),
            'website' => e($new_user->website),
            'address' => e($new_user->address),
            'city' => e($new_user->city),
            'state' => e($new_user->state),
            'zip' => e($new_user->zip),
            'activated' => e($new_user->activated),
            'sex' => e($new_user->sex)
        ]);
    }


    /** @test */
    public function super_admin_can_create_new_user()
    {
        $new_user = factory(User::class)->make(['activated' => 1]);

        $this->actingAs($this->superAdmin)
            ->from(route('users.create'))
            ->post(route('users.store'), [
                'email' => $new_user->email,
                'email_verified_at' => $new_user->email_verified_at,
                'password' => 'secret',
                'remember_token' => $new_user->remember_token,
                'last_login' => $new_user->last_login,
                'first_name' => $new_user->first_name,
                'last_name' => $new_user->last_name,
                'employee_num' => $new_user->employee_num,
                'phone' => $new_user->phone,
                'fax' => $new_user->fax,
                'website' => $new_user->website,
                'address' => $new_user->address,
                'city' => $new_user->city,
                'state' => $new_user->state,
                'zip' => $new_user->zip,
                'activated' => $new_user->activated,
                'sex' => $new_user->sex
            ])->assertStatus(302);

        $this->assertDatabaseHas('users', [
            'email' => e($new_user->email),
            'first_name' => e($new_user->first_name),
            'last_name' => e($new_user->last_name),
            'phone' => e($new_user->phone),
            'fax' => e($new_user->fax),
            'website' => e($new_user->website),
            'address' => e($new_user->address),
            'city' => e($new_user->city),
            'state' => e($new_user->state),
            'zip' => e($new_user->zip),
            'activated' => e($new_user->activated),
            'sex' => e($new_user->sex)
        ]);
    }

    /** @test */
    public function unauthorized_user_redirect_to_login_page_if_user_tries_to_go_user_edit_page()
    {
        $user = factory(User::class)->create();
        $this->get(route('users.edit', ['user' => $user->id]))
            ->assertRedirect('login');
    }

    /** @test */
    public function if_user_is_unauthorized_to_update_user_will_get_403_status_when_try_to_view_user_edit_page()
    {
        $user = $this->create_user_and_assign_role_and_permission('Admin', 'view_user');

        $another_user = factory(User::class)->create();

        $this->actingAs($user)
            ->get(route('users.edit', ['user' => $another_user->id]))
            ->assertStatus(403);
    }

    /** @test */
    public function if_user_is_authorized_to_update_user_will_be_able_to_see_user_edit_page()
    {
        $user = $this->create_user_and_assign_role_and_permission('Admin', 'edit_user');

        $another_user = factory(User::class)->create();
        $this->actingAs($user)
            ->get(route('users.edit', ['user' => $another_user->id]))
            ->assertViewIs('users.edit');
    }

    /** @test */
    public function if_user_is_authorized_to_update_user_then_he_is_able_to_update_the_user()
    {
        $user = $this->create_user_and_assign_role_and_permission('Admin', 'edit_user');

        $new_user = factory(User::class)->create(['activated' => 1]);

        $user_to_update = factory(User::class)->make(['activated' => 1]);
        $this->actingAs($user)
            ->from(route('users.edit', ['user' => $new_user->id]))
            ->put(route('users.update', ['user' => $new_user->id]), $user_to_update->toArray());

        $updated_user = User::findOrFail($new_user->id);



        $this->assertEquals($user_to_update->first_name, $updated_user->first_name);
    }


    /** @test */
    public function super_admin_can_update_user()
    {
        $users = factory(User::class, 10)->create();

        $id = $users[3]->id;
        $user = User::findOrFail($id);

        $user->first_name = $this->faker->firstName;

        $this->actingAs($this->superAdmin)
            ->put(route('users.update', ['user' => $user->id]), $user->toArray());

        $updated_user = User::findOrFail($id);

        $this->assertEquals($user->first_name, $updated_user->first_name);
    }

    /** @test */
    public function user_cannot_be_created_without_first_name()
    {
        $this->actingAs($this->superAdmin)
            ->from(route('users.create'))
            ->post(route('users.store'), [
                'email' => 'john@email.com',
                'password' => 'secret',
            ])
            ->assertRedirect(route('users.create'))
            ->assertSessionHasErrors('first_name');

        $this->assertTrue(session()->hasOldInput('email'));
        $this->assertFalse(session()->hasOldInput('password'));
    }

    /** @test */
    public function user_cannot_be_created_without_password()
    {
        $this->actingAs($this->superAdmin)
            ->from(route('users.create'))
            ->post(route('users.store'), [
                'first_name' => 'John Doe',
                'email' => 'john.doe@email.com',
            ])
            ->assertRedirect(route('users.create'))
            ->assertSessionHasErrors('password');

        $this->assertTrue(session()->hasOldInput('first_name'));
        $this->assertTrue(session()->hasOldInput('email'));
        $this->assertFalse(session()->hasOldInput('password'));
    }

    /** @test */
    public function user_cannot_be_created_without_email()
    {
        $this->actingAs($this->superAdmin)
            ->from(route('users.create'))
            ->post(route('users.store'), [
                'first_name' => 'John Doe',
                'password' => 'secret',
            ])
            ->assertRedirect(route('users.create'))
            ->assertSessionHasErrors('email');

        $this->assertTrue(session()->hasOldInput('first_name'));
        $this->assertFalse(session()->hasOldInput('password'));
    }

    /** @test */
    public function create_a_valid_user()
    {

        $user = factory(User::class)->make();

        $this->actingAs($this->superAdmin)
            ->post(route('users.store'), [
                'email' => $user->email,
                'email_verified_at' => $user->email_verified_at,
                'password' => 'secret',
                'remember_token' => $user->remember_token,
                'last_login' => $user->last_login,
                'first_name' => $user->first_name,
                'last_name' => $user->last_name,
                'employee_num' => $user->employee_num,
                'phone' => $user->phone,
                'fax' => $user->fax,
                'website' => $user->website,
                'address' => $user->address,
                'city' => $user->city,
                'state' => $user->state,
                'zip' => $user->zip,
                'activated' => $user->activated,
                'sex' => $user->sex
            ])->assertStatus(302);

        $this->assertDatabaseHas('users', [
            'email' => $user['email'],
            'first_name' => e($user['first_name']),
            'last_name' => e($user['last_name'])
        ]);
    }

    /** @test */
    public function email_address_must_be_unique()
    {

        $email = $this->faker->unique()->safeEmail;
        $user1 = factory(User::class)->make([
            'first_name' => $this->faker->firstName,
            'email' => $email,
            'password' => bcrypt('secret'),
        ]);


        $user2 = factory(User::class)->make([
            'first_name' => $this->faker->firstName,
            'email' => $email,
            'password' => bcrypt('secret'),
        ]);

        $this->actingAs($this->superAdmin)
            ->from(route('users.create'))
            ->post(route('users.store'), [
                'email' => $user1['email'],
                'password' => $user1['password'],
                'first_name' => $user1['first_name'],
                'activated' => 1
            ]);

        $this->assertDatabaseHas('users', [
            'email' => $email,
            'first_name' => e($user1['first_name'])
        ]);
//
        $this->from(route('users.create'))
            ->post(route('users.store'), [
                'email' => $user2['email'],
                'password' => $user2['password'],
                'first_name' => $user2['first_name'],
                'activated' => 1
            ])
            ->assertRedirect(route('users.create'));


        $this->assertTrue(session()->hasOldInput('first_name'));
        $this->assertTrue(session()->hasOldInput('email'));
        $this->assertFalse(session()->hasOldInput('password'));

        $this->assertDatabaseMissing('users', [
            'email' => $email,
            'first_name' => e($user2['first_name'])
        ]);
    }

    /** @test */
    public function user_can_be_deleted()
    {
        $user = factory(User::class)->create();

        $this->actingAs($this->superAdmin)
            ->delete(route('users.destroy', ['user' => $user->id]));

        $this->get(route('users.list'))
            ->assertJson(["total" => 1]);
    }

    /** @test */
    public function unauthenticated_user_redirect_to_login_page_when_they_try_to_delete_an_user_entry()
    {
        $users = factory(User::class, 10)->create();

        $this->delete(route('users.destroy', ['user' => $users[3]]))
            ->assertRedirect('login');
    }

    /** @test */
    public function if_a_user_is_not_authorized_to_delete_entry_then_they_will_get_403_status()
    {
        $user = $this->create_user_and_assign_role_and_permission('Admin', 'view_user');


        $this->actingAs($user)
            ->delete(route('users.destroy', ['user' => $user->id]))
            ->assertStatus(403);
    }

    /** @test */
    public function if_a_user_is_authorized_to_delete_user_enty_then_he_will_able_to_delete_user()
    {
        $users = factory(User::class, 10)->create(['activated' => 1]);

        $user = $this->create_user_and_assign_role_and_permission('Admin', 'delete_user');

        $this->actingAs($user)
            ->delete(route('users.destroy', ['user' => $users[3]->id]));

        $url = route('users.list') . '?deleted=true';

        // Give permission to view user;
        // without view user permission
        // the user will not able to
        // see deleted user
        $role = Role::findByName('Admin');
        $role->givePermissionTo(Permission::findByName('view_user'));

        $this->get($url)
            ->assertJson(
                [
                    "total" => 1,
                    "rows" => [
                        [
                            "id" => $users[3]->id,
                            "email" => $users[3]->email,
                            "name" => e($users[3]->fullName),
                            "first_name" => e($users[3]->first_name),
                            "last_name" => e($users[3]->last_name),
                            "phone" => e($users[3]->phone),
                            "address" => e($users[3]->address),
                            "city" => e($users[3]->city),
                            "state" => e($users[3]->state),
                            "country" => e($users[3]->country->name),
                            "zip" => e($users[3]->zip),
                            "activated" => e($users[3]->activated),
                            "website" => e($users[3]->website),
                        ]
                    ]
                ]
            );
    }

    /** @test */
    public function it_can_show_deleted_users()
    {
        $users = factory(User::class, 10)->create();

        $id = $users[3]->id;

        $url = route('users.list') . '?deleted=true';

        $this->actingAs($this->superAdmin)
            ->delete(route('users.destroy', ['user' => $id]));

        $this->get($url)
            ->assertJson(
                [
                    "total" => 1,
                    "rows" => [
                        [
                            "id" => $users[3]->id,
                            "email" => $users[3]->email,
                            "name" => e($users[3]->fullName),
                            "first_name" => e($users[3]->first_name),
                            "last_name" => e($users[3]->last_name),
                            "phone" => e($users[3]->phone),
                            "address" => e($users[3]->address),
                            "city" => e($users[3]->city),
                            "state" => e($users[3]->state),
                            "country" => e($users[3]->country->name),
                            "zip" => e($users[3]->zip),
                            "activated" => e($users[3]->activated),
                            "website" => e($users[3]->website),
                        ]
                    ]
                ]
            );
    }

    /** @test */
    public function if_a_user_is_not_authenticated_then_he_will_redirect_to_login_page_when_he_try_to_restore_user()
    {
        $user = factory(User::class)->create(['activated' => 1]);

        $this->get(route('users.restore', ['user' => $user->id]))
            ->assertRedirect('login');
    }

    /** @test */
    public function if_the_user_is_unauthorized_to_restore_he_will_get_403_status_when_he_try_to_restore_deleted_user()
    {
        $user = $this->create_user_and_assign_role_and_permission('Admin', 'view_user');

        $users = factory(User::class, 10)->create();

        $users[4]->delete();

        $this->actingAs($user)
            ->get(route('users.restore', ['user' => $users[4]->id]))->assertStatus(403);
    }

    /** @test */
    public function if_a_user_is_authorized_then_he_will_be_able_to_restore_user()
    {
        $user = $this->create_user_and_assign_role_and_permission('Admin', 'restore_user');

        $user_to_delete = factory(User::class)->create(['activated' => 1]);

        $user_to_delete->delete();

        $url = route('users.list') . '?deleted=true';

        $role = Role::findByName('Admin');
        $role->givePermissionTo(Permission::findByName('view_user'));

        $this->actingAs($user)
            ->get($url)
            ->assertJson([
                "total" => 1,
                "rows" => [
                    [
                        "id" => $user_to_delete->id,
                        "email" => $user_to_delete->email,
                        "name" => e($user_to_delete->fullName),
                        "first_name" => e($user_to_delete->first_name),
                        "last_name" => e($user_to_delete->last_name),
                        "phone" => e($user_to_delete->phone),
                        "address" => e($user_to_delete->address),
                        "city" => e($user_to_delete->city),
                        "state" => e($user_to_delete->state),
                        "country" => e($user_to_delete->country->name),
                        "zip" => e($user_to_delete->zip),
                        "activated" => e($user_to_delete->activated),
                        "website" => e($user_to_delete->website),
                    ]
                ]
            ]);

        $this->get(route('users.restore', ['user' => $user_to_delete->id]));

        $this->get(route('users.list'))->assertJson(['total' => '3']);

    }

    /** @test */
    public function deleted_user_can_be_restored()
    {
        $user = factory(User::class)->create();

        $this->actingAs($this->superAdmin)
            ->delete(route('users.destroy', ['user' => $user->id]));

        $url = route('users.list') . '?deleted=true';

        $this->get($url)
            ->assertJson([
                "total" => 1,
                "rows" => [
                    [
                        "id" => $user->id,
                        "email" => $user->email,
                        "name" => e($user->fullName),
                        "first_name" => e($user->first_name),
                        "last_name" => e($user->last_name),
                        "phone" => e($user->phone),
                        "address" => e($user->address),
                        "city" => e($user->city),
                        "state" => e($user->state),
                        "country" => e($user->country->name),
                        "zip" => e($user->zip),
                        "activated" => e($user->activated),
                        "website" => e($user->website),
                    ]
                ]
            ]);

        $this->get(route('users.restore', ['user' => $user->id]));

        $this->get(route('users.list'))->assertJson(['total' => '2']);
    }

    /** @test */
    public function it_can_bulk_delete_users()
    {
        $users = factory(User::class, 10)->create();
        $ids = [];

        for ($i = 0; $i < 5; $i++) {
            array_push($ids, $users[$i]->id);
        }

        $this->actingAs($this->superAdmin)
            ->post(route('users.bulkSave'), ['ids' => $ids]);

        $this->get(route('users.list'))
            ->assertJson(['total' => 6]);


        $url = route('users.list') . '?deleted=true';

        $this->get($url)
            ->assertJson(
                [
                    "total" => 5,
                ]
            );

    }

    /** @test */
    public function it_can_bulk_delete_users_but_not_super_admin()
    {
        $users = factory(User::class, 10)->create();
        $ids = [1];

        for ($i = 0; $i < 5; $i++) {
            array_push($ids, $users[$i]->id);
        }

        $this->actingAs($this->superAdmin)
            ->post(route('users.bulkSave'), ['ids' => $ids]);

        $this->get(route('users.list'))
            ->assertJson(['total' => 6]);


        $url = route('users.list') . '?deleted=true';

        $this->get($url)
            ->assertJson(
                [
                    "total" => 5,
                ]
            );

    }
}
