<?php

namespace Tests\Feature;

use App\Models\User;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Faker\Factory as FakerFactory;
use Tests\TestCase;

class UsersTest extends TestCase
{

    private $user;
    private $faker;

    public function setUp()
    {
        parent::setUp();


        $this->user = factory(User::class)->create(['activated'=>1]);

        // Only super admin can access all the features
        // so for the time being we will assign Super Admin
        // Role to the user. To test other role and their
        // permissions we have separate test.
        $this->user->assignRole(Role::findByName('Super Admin'));
        $this->faker = FakerFactory::create();
    }

    /** @test */
    public function site_header_shows_authenticated_users_fullname() {
        $this->actingAs($this->user)
            ->get('/')
            ->assertSee($this->user->fullName);
    }

    /** @test */
    public function unauthenticated_user_redirect_to_login_page_when_try_to_see_user_index_page() {
        $this->get(route('users.index'))
            ->assertRedirect('login');
    }

    /** @test */
    public function user_can_not_see_user_index_page_if_he_is_not_authorized_to_view_user() {
        $unauthorized_user = factory(User::class)->create(['activated' => 1]);
        $role = Role::findByName('Admin');
        $unauthorized_user->assignRole($role);

        $this->actingAs($unauthorized_user)
            ->get(route('users.index'))
            ->assertStatus(403);
    }

    /** @test */
    public function user_can_see_user_index_page_if_he_is_authorized_to_view_user() {
        $unauthorized_user = factory(User::class)->create(['activated' => 1]);
        $role = Role::findByName('Admin');

        $permission = Permission::findByName('view_user');
        $permission->assignRole($role);

        $unauthorized_user->assignRole($role);

        $this->actingAs($unauthorized_user)
            ->get(route('users.index'))->assertViewIs('users.index');
    }

    /** @test */
    public function unauthenticated_user_redirect_to_login_page_when_try_to_see_user_list(){
        $this->get(route('users.list'))
            ->assertRedirect('login');
    }

    /** @test */
    public function if_the_user_is_unauthorized_to_view_user_will_get_403_status_when_trying_to_view_user_list() {
        $user = factory(User::class)->create(['activated' => 1]);
        $role = Role::findByName('Admin');
        $user->assignRole($role);

        $permission = Permission::findByName('view_client');
        $role->givePermissionTo($permission);

        $this->actingAs($user)
            ->get(route('users.list'))
            ->assertStatus(403);
    }

    public function if_the_user_is_authorized_to_view_user_will_able_to_view_user_list_then_trying_to_view_user_list() {
        $user = factory(User::class)->create(['activated' => 1]);
        $role = Role::findByName('Admin');
        $user->assignRole($role);

        $permission = Permission::findByName('view_user');
        $role->givePermissionTo($permission);

        $this->actingAs($user)
            ->get(route('users.list'))
            ->assertJson([
                "total" => 1,
                "rows" => [
                    [
                        "id" => $user->id,
                        "email" => $user->email,
                        "name" => $user->fullName,
                        "first_name" => $user->first_name,
                        "last_name" => $user->last_name,
                        "phone" => $user->phone,
                        "address" => $user->address,
                        "city" => $user->city,
                        "state" => $user->state,
                        "country" => $user->country->name,
                        "zip" => $user->zip,
                        "activated" => $user->activated,
                        "website" => $user->website,
                    ]
                ]
            ]);

    }

    /** @test */
    public function super_admin_can_see_user_list() {
        $this->actingAs($this->user)
            ->get(route('users.list'))
            ->assertJson([
                "total" => 1,
                "rows" => [
                    [
                        "id" => $this->user->id,
                        "email" => $this->user->email,
                        "name" => $this->user->fullName,
                        "first_name" => $this->user->first_name,
                        "last_name" => $this->user->last_name,
                        "phone" => $this->user->phone,
                        "address" => $this->user->address,
                        "city" => $this->user->city,
                        "state" => $this->user->state,
                        "country" => $this->user->country->name,
                        "zip" => $this->user->zip,
                        "activated" => $this->user->activated,
                        "website" => $this->user->website,
                    ]
                ]
            ]);
    }


    /** @test */
    public function unauthenticated_user_will_redirect_to_login_page_if_he_tries_to_go_user_create_page() {
        $this->get(route('users.create'))
            ->assertRedirect('login');
    }

    /** @test */
    public function if_user_is_unauthorized_to_create_new_user_then_he_will_get_403_status_when_he_tries_to_visit_user_create_page() {
        $user = factory(User::class)->create(['activated' => 1]);
        $role = Role::findByName('Admin');

        $permissin = Permission::findByName('view_user');
        $role->givePermissionTo($permissin);

        $user->assignRole($role);

        $this->actingAs($user)
            ->get(route('users.create'))
            ->assertStatus(403);
    }

    /** @test */
    public function if_a_user_is_authorized_to_create_new_user_then_he_is_able_to_create_new_user() {
        $user = factory(User::class)->create(['activated' => 1]);
        $role = Role::findByName('Admin');

        $permissin = Permission::findByName('add_user');
        $role->givePermissionTo($permissin);

        $user->assignRole($role);

        $new_user = factory(User::class)->make(['activated' => 1]);

        $this->actingAs($user)
            ->from(route('users.create'))
            ->post(route('users.store'),[
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
                'state' =>  $new_user->state,
                'zip' => $new_user->zip,
                'activated' => $new_user->activated,
                'sex' => $new_user->sex
            ])->assertStatus(302);

        $this->assertDatabaseHas('users',[
            'email' => $new_user->email,
            'first_name' => $new_user->first_name,
            'last_name' => $new_user->last_name,
            'phone' => $new_user->phone,
            'fax' => $new_user->fax,
            'website' => $new_user->website,
            'address' => $new_user->address,
            'city' => $new_user->city,
            'state' =>  $new_user->state,
            'zip' => $new_user->zip,
            'activated' => $new_user->activated,
            'sex' => $new_user->sex
        ]);
    }


    /** @test */
    public function super_user_can_create_new_user() {
        $user = factory(User::class)->create(['activated' => 1]);
        $role = Role::findByName('Super Admin');

        $user->assignRole($role);

        $new_user = factory(User::class)->make(['activated' => 1]);

        $this->actingAs($user)
            ->from(route('users.create'))
            ->post(route('users.store'),[
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
                'state' =>  $new_user->state,
                'zip' => $new_user->zip,
                'activated' => $new_user->activated,
                'sex' => $new_user->sex
            ])->assertStatus(302);

        $this->assertDatabaseHas('users',[
            'email' => $new_user->email,
            'first_name' => $new_user->first_name,
            'last_name' => $new_user->last_name,
            'phone' => $new_user->phone,
            'fax' => $new_user->fax,
            'website' => $new_user->website,
            'address' => $new_user->address,
            'city' => $new_user->city,
            'state' =>  $new_user->state,
            'zip' => $new_user->zip,
            'activated' => $new_user->activated,
            'sex' => $new_user->sex
        ]);
    }

    /** @test */
    public function unauthorized_user_redirect_to_login_page_if_user_tries_to_go_user_edit_page() {
        $user = factory(User::class)->create();
        $this->get(route('users.edit', ['user' => $user->id]))
            ->assertRedirect('login');
    }

    /** @test */
    public function if_user_is_unauthorized_to_update_user_will_get_403_status_when_try_to_view_user_edit_page () {
        $user = factory(User::class)->create(['activated' => 1]);
        $role = Role::findByName('Admin');
        $permission = Permission::findByName('view_user');
        $role->givePermissionTo($permission);

        $user->assignRole($role);

        $another_user = factory(User::class)->create();

        $this->actingAs($user)
            ->get(route('users.edit', ['user' => $another_user->id]))
            ->assertStatus(403);
    }

    /** @test */
    public function if_user_is_authorized_to_update_user_will_be_able_to_see_user_edit_page () {
        $user = factory(User::class)->create(['activated' => 1]);
        $role = Role::findByName('Admin');
        $permission = Permission::findByName('edit_user');
        $role->givePermissionTo($permission);

        $user->assignRole($role);

        $another_user = factory(User::class)->create();
        $this->actingAs($user)
            ->get(route('users.edit', ['user'=>$another_user->id]))
            ->assertViewIs('users.edit');
    }

    /** @test */
    public function if_user_is_authorized_to_update_user_then_he_is_able_to_update_the_user() {

        $user = factory(User::class)->create(['activated' => 1]);
        $role = Role::findByName('Admin');
        $permission = Permission::findByName('edit_user');
        $role->givePermissionTo($permission);

        $new_user = factory(User::class)->make();

        $this->actingAs($user)
            ->from(route('users.edit', ['users'=>$user->id]))
            ->put(route('users.update', ['user'=>$user->id]), $new_user->toArray());

        $updated_user = User::findOrFail($user->id);

        $this->assertEquals($new_user->first_name, $updated_user->first_name);
    }


    /** @test */
    public function super_admin_can_update_user() {
        $users = factory(User::class, 10)->create();

        $id = $users[3]->id;
        $user = User::findOrFail($id);

        $user->first_name = $this->faker->firstName;

        $this->actingAs($this->user)
            ->put(route('users.update', ['user'=> $user->id]), $user->toArray());

        $updated_user = User::findOrFail($id);

        $this->assertEquals($user->first_name, $updated_user->first_name);
    }

    /** @test */
    public function unauthenticated_user_redirect_to_login_page_when_they_try_to_delete_an_user_entry() {
        $users = factory(User::class, 10)->create();

        $this->delete(route('users.destroy', ['user'=> $users[3]]))
            ->assertRedirect('login');
    }

    /** @test */
    public function if_a_user_is_not_authorized_to_delete_entry_then_they_will_get_403_status() {
        $user = factory(User::class)->create(['activated' => 1]);
        $role = Role::findByName('Admin');
        $permission = Permission::findByName('view_user');
        $role->givePermissionTo($permission);

        $user->assignRole($role);

        $this->actingAs($user)
            ->delete(route('users.destroy', ['user'=> $user->id]))
            ->assertStatus(403);
    }


    /** @test */
    public function user_cannot_be_created_without_first_name() {
        $this->actingAs($this->user)
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
    public function user_cannot_be_created_without_password() {
        $this->actingAs($this->user)
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
    public function user_cannot_be_created_without_email() {
        $this->actingAs($this->user)
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
    public function create_a_valid_user() {

        $user = factory(User::class)->make();

        $this->actingAs($this->user)
            ->post(route('users.store'),[
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
            'state' =>  $user->state,
            'zip' => $user->zip,
            'activated' => $user->activated,
            'sex' => $user->sex
        ])->assertStatus(302);

        $this->assertDatabaseHas('users',[
            'email' => $user['email'],
            'first_name' => $user['first_name'],
            'last_name' => $user['last_name']
        ]);
    }

    /** @test */
    public function email_address_must_be_unique() {

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

        $this->actingAs($this->user)
            ->from(route('users.create'))
            ->post(route('users.store'),[
                'email' => $user1['email'],
                'password' => $user1['password'],
                'first_name' => $user1['first_name'],
                'activated' => 1
            ]);

        $this->assertDatabaseHas('users',[
            'email' => $email,
            'first_name' => $user1['first_name']
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

        $this->assertDatabaseMissing('users',[
            'email' => $email,
            'first_name' => $user2['first_name']
        ]);
    }

    /** @test */
    public function user_can_be_deleted() {
        $user = factory(User::class)->create();

        $this->actingAs($this->user)
            ->delete(route('users.destroy', ['user'=>$user->id]));

        $this->get(route('users.list'))
            ->assertJson(["total"=>1]);
    }

    /** @test */
    public function it_can_show_deleted_users() {
        $users = factory(User::class, 10)->create();

        $id = $users[3]->id;

        $url = route('users.list').'?deleted=true';

        $this->actingAs($this->user)
            ->delete(route('users.destroy',['user'=>$id]));

        $this->get($url)
            ->assertJson(
                [
                    "total" => 1,
                    "rows" => [
                        [
                            "id" => $users[3]->id,
                            "email" => $users[3]->email,
                            "name" => $users[3]->fullName,
                            "first_name" => $users[3]->first_name,
                            "last_name" => $users[3]->last_name,
                            "phone" => $users[3]->phone,
                            "address" => $users[3]->address,
                            "city" => $users[3]->city,
                            "state" => $users[3]->state,
                            "country" => $users[3]->country->name,
                            "zip" => $users[3]->zip,
                            "activated" => $users[3]->activated,
                            "website" => $users[3]->website,
                        ]
                    ]
                ]
            );
    }

    /** @test */
    public function deleted_user_can_be_restored() {
        $user = factory(User::class)->create();

        $this->actingAs($this->user)
            ->delete(route('users.destroy', ['user'=>$user->id]));

        $url = route('users.list').'?deleted=true';

        $this->get($url)
            ->assertJson([
                "total" => 1,
                "rows" => [
                    [
                        "id" => $user->id,
                        "email" => $user->email,
                        "name" => $user->fullName,
                        "first_name" => $user->first_name,
                        "last_name" => $user->last_name,
                        "phone" => $user->phone,
                        "address" => $user->address,
                        "city" => $user->city,
                        "state" => $user->state,
                        "country" => $user->country->name,
                        "zip" => $user->zip,
                        "activated" => $user->activated,
                        "website" => $user->website,
                    ]
                ]
            ]);

        $this->get(route('users.restore', ['user'=>$user->id]));

        $this->get(route('users.list'))->assertJson(['total' => '2']);
    }

    /** @test */
    public function it_can_bulk_delete_users() {
        $users = factory(User::class, 10)->create();
        $ids=[];

        for($i=0; $i<5; $i++){
            array_push($ids, $users[$i]->id);
        }

        $this->actingAs($this->user)
            ->post(route('users.bulkSave'),['ids'=>$ids]);

        $this->get(route('users.list'))
            ->assertJson(['total'=>6]);


        $url = route('users.list').'?deleted=true';

        $this->get($url)
            ->assertJson(
                [
                    "total" => 5,
                ]
            );

    }

    /** @test */
    public function it_can_bulk_delete_users_but_not_super_admin() {
        $users = factory(User::class, 10)->create();
        $ids=[1];

        for($i=0; $i<5; $i++){
            array_push($ids, $users[$i]->id);
        }

        $this->actingAs($this->user)
            ->post(route('users.bulkSave'),['ids'=>$ids]);

        $this->get(route('users.list'))
            ->assertJson(['total'=>6]);


        $url = route('users.list').'?deleted=true';

        $this->get($url)
            ->assertJson(
                [
                    "total" => 5,
                ]
            );

    }
}
