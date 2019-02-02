<?php

namespace Tests\Unit;


use App\Models\Client;
use App\Models\Country;
use Tests\TestCase;

class ClientTest extends TestCase
{
    /** @test */
    public function client_has_has_full_name(){
        $client = factory(Client::class)->create();
        $this->assertEquals($client->fullName, $client->first_name." ".$client->last_name);
    }

    /** @test */
    public function client_not_be_saved_without_first_name() {
        $clients = Client::create([
            'email' => 'ifte510@gmail.com',
            'password' => bcrypt('secret')
        ]);
        $this->assertDatabaseMissing('clients', $clients->toArray());
    }

    /** @test */
    public function client_could_not_be_saved_without_email() {
        $clients = Client::create([
            'first_name' => 'Iftekhar',
            'password' => bcrypt('secret')
        ]);
        $this->assertDatabaseMissing('clients', $clients->toArray());
    }

    /** @test */
    public function client_could_not_be_saved_if_number_of_character_in_first_name_is_below_three() {
        $client = Client::create([
            'first_name' => 'If',
            'email' => 'ifte.hsn@gmail.com',
            'password' => bcrypt('secret')
        ]);
        $this->assertDatabaseMissing('clients', $client->toArray());
    }


    /** @test */
    public function client_can_be_soft_deleted() {
        $clients = factory(Client::class, 5)->create();
        $clients[3]->delete();
        $this->assertSoftDeleted('clients', $clients[3]->toArray());
    }


    /** @test */
    public function client_is_belongs_to_a_country()
    {
        $client = factory(Client::class)->create();
        $country = Country::create(['name'=> 'Bangladesh']);
        $client->country = $country;
        $this->assertInstanceOf('App\Models\Country', $client->country);
    }
}