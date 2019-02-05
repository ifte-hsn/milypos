<?php

namespace Tests\Feature;


use App\Models\Client;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Faker\Factory as FakerFactory;
use Tests\TestCase;

class ClientsTest extends TestCase
{
    private $user;
    private $role;
    private $faker;

    public function setUp()
    {
        parent::setUp();


        $this->user = factory(User::class)->create(['activated' => 1]);

        // Only super admin can access all the features
        // so for the time being we will assign Super Admin
        // Role to the user. To test other role and their
        // permissions we have separate test.
        $this->user->assignRole(Role::findByName('Super Admin'));
        $this->faker = FakerFactory::create();
    }

    /** @test */
    public function an_authenticated_user_can_see_user_list()
    {
        $client = factory(Client::class)->create();

        $this->actingAs($this->user)
            ->get(route('clients.list'))
            ->assertJson([
                'total' => '1',
                "rows" => [
                    [
                        "id" => $client->id,
                        "email" => $client->email,
                        "name" => $client->fullName,
                        "first_name" => $client->first_name,
                        "last_name" => $client->last_name,
                        "sex" => $client->sex,
                        "phone" => $client->phone,
                        "address" => $client->address,
                        "city" => $client->city,
                        "state" => $client->state,
                        "zip" => $client->zip,
                        "shopping" => $client->shopping,
                    ]
                ]
            ]);
    }

    /** @test */
    public function client_cannot_be_created_without_first_name() {
        $this->actingAs($this->user)
            ->from(route('clients.create'))
            ->post(route('clients.store'), [
                'email' => 'john@email.com'
            ])
            ->assertRedirect(route('clients.create'))
            ->assertSessionHasErrors('first_name');

        $this->assertTrue(session()->hasOldInput('email'));
    }

    /** @test */
    public function client_cannot_be_created_without_email() {
        $this->actingAs($this->user)
            ->from(route('clients.create'))
            ->post(route('clients.store'), [
                'first_name' => 'John Doe',
            ])
            ->assertRedirect(route('clients.create'))
            ->assertSessionHasErrors('email');

        $this->assertTrue(session()->hasOldInput('first_name'));
    }


    /** @test */
    public function create_a_valid_client() {

        $client = factory(Client::class)->make();

        $this->actingAs($this->user)
            ->post(route('clients.store'),[
                'email' => $client->email,
                'first_name' => $client->first_name,
                'last_name' => $client->last_name,
                'phone' => $client->phone,
                'address' => $client->address,
                'city' => $client->city,
                'state' =>  $client->state,
                'zip' => $client->zip,
                'sex' => $client->sex,
                'last_purchase' => $client->last_purchase,
                'shopping' => $client->shopping,
                'dob' => $client->dob,
            ])->assertStatus(302);

        $this->assertDatabaseHas('clients',[
            'email' => $client['email'],
            'first_name' => $client['first_name'],
            'last_name' => $client['last_name']
        ]);
    }

    /** @test */
    public function email_address_must_be_unique() {

        $email = $this->faker->unique()->safeEmail;
        $client1 = factory(User::class)->make([
            'first_name' => $this->faker->firstName,
            'email' => $email,
        ]);


        $client2 = factory(User::class)->make([
            'first_name' => $this->faker->firstName,
            'email' => $email,
        ]);

        $this->actingAs($this->user)
            ->from(route('clients.create'))
            ->post(route('clients.store'),[
                'email' => $client1['email'],
                'first_name' => $client1['first_name'],
            ]);

        $this->assertDatabaseHas('clients',[
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

        $this->assertDatabaseMissing('clients',[
            'email' => $email,
            'first_name' => $client2['first_name']
        ]);
    }

    /** @test */
    public function a_client_can_be_deleted() {
        $client = factory(Client::class)->create();

        $this->actingAs($this->user)
            ->delete(route('clients.destroy', ['client'=>$client->id]));

        $this->get(route('clients.list'))
            ->assertJson(["total"=>0]);
    }

    /** @test */
    public function it_can_show_deleted_clients() {
        $clients = factory(Client::class, 10)->create();

        $id = $clients[3]->id;

        $url = route('clients.list').'?deleted=true';

        $this->actingAs($this->user)
            ->delete(route('clients.destroy',['client'=>$id]));

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
                            "country" => $clients[3]->country,
                            "zip" => $clients[3]->zip,
                        ]
                    ]
                ]
            );
    }

    /** @test */
    public function deleted_client_can_be_restored() {
        $clients = factory(Client::class, 4)->create();

        $client = $clients[2];

        $this->actingAs($this->user)
            ->delete(route('clients.destroy', ['client'=>$client->id]));

        $url = route('clients.list').'?deleted=true';

        $this->get($url)
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
                        "country" => $client->country,
                        "zip" => $client->zip,
                    ]
                ]
            ]);

        $this->get(route('clients.list'))->assertJson(['total' => '3']);

        $this->get(route('clients.restore', ['client'=>$client->id]));

        $this->get(route('clients.list'))->assertJson(['total' => '4']);
    }


    /** @test */
    public function it_can_update_client_info() {
        $clients = factory(Client::class, 10)->create();


        $id = $clients[3]->id;
        $client = Client::findOrFail($id);

        $client->first_name = $this->faker->firstName;

        $this->actingAs($this->user)
            ->put(route('clients.update', ['client'=> $client->id]), $client->toArray());

        $updated_user = Client::findOrFail($id);

        $this->assertEquals($client->first_name, $updated_user->first_name);

    }


    /** @test */
    public function it_can_bulk_delete_clients() {
        $clients = factory(Client::class, 10)->create();
        $ids=[];

        for($i=0; $i<6; $i++){
            array_push($ids, $clients[$i]->id);
        }

        $this->actingAs($this->user)
            ->post(route('clients.bulkSave'),['ids'=>$ids]);

        $this->get(route('clients.list'))
            ->assertJson(['total'=>4]);


        $url = route('clients.list').'?deleted=true';

        $this->get($url)
            ->assertJson(
                [
                    "total" => 6,
                ]
            );

    }

}