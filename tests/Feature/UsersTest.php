<?php

namespace Tests\Feature;

use App\Models\User;
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
    public function an_authenticated_user_can_see_user_list() {
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
    public function it_can_update_user_info() {
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
