<?php

namespace Tests\Feature;

use App\Models\Role;
use App\Models\User;
use App\Models\Warehouse;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Spatie\Permission\Models\Permission;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Faker\Factory as FakerFactory;

class WarehouseTest extends TestCase
{
    use DatabaseMigrations;


    /** @test */
    public function it_has_an_index_page()
    {
        $this->actingAs($this->superAdmin)->get(route('warehouses.index'))
            ->assertViewIs('warehouses.index');
    }

    /** @test */
    public function unauthorized_user_cannot_see_warehouse_index_page()
    {

        // create an unauthorized_user
        $unauthorized_user = factory(User::class)->create(['activated' => true]);
        $role = Role::findByName('Admin');
        $unauthorized_user->assignRole($role);

        // create permission other than view_warehouse
        $permission = Permission::findByName('view_user');
        $permission->assignRole($role);
        $role->givePermissionTo($permission);


        $this->actingAs($unauthorized_user)->get(route('warehouses.index'))
            ->assertStatus(403);
    }

    /** @test */
    public function user_with_view_warehouse_permission_can_see_index_page()
    {
        // create an unauthorized_user
        $authorized_user = factory(User::class)->create(['activated' => true]);
        $role = Role::findByName('Admin');
        $authorized_user->assignRole($role);

        // create permission for viewing warehouse
        $permission = Permission::findByName('warehouse.view');
        $permission->assignRole($role);
        $role->givePermissionTo($permission);

        $this->actingAs($authorized_user)->get(route('warehouses.index'))
            ->assertViewIs('warehouses.index');
    }


    /** @test */
    public function authorized_user_with_view_warehouse_permission_can_see_warehouse_list()
    {
        // create an unauthorized_user
        $authorized_user = factory(User::class)->create(['activated' => true]);
        $role = Role::findByName('Admin');
        $authorized_user->assignRole($role);

        // create permission for viewing warehouse
        $permission = Permission::findByName('warehouse.view');
        $permission->assignRole($role);
        $role->givePermissionTo($permission);


        $warehouse = factory(Warehouse::class)->create();
        $warehouse->contactPersons()->saveMany([$authorized_user]);

        $this->actingAs($authorized_user)->get(route('warehouses.list'))
            ->assertJson([
                'total' => 1,
                "rows" => [
                    [
                        'id' => $warehouse->id,
                        'code' => $warehouse->code,
                        'name' => $warehouse->name,
                        'phone' => $warehouse->phone,
                        'email' => $warehouse->email,
                        'address' => $warehouse->address,
                    ]
                ]
            ]);
    }

    /** @test */
    public function unauthorized_user_without_view_warehouse_permission_can_not_see_warehouse_list()
    {
        // create an unauthorized_user
        $authorized_user = factory(User::class)->create(['activated' => true]);
        $role = Role::findByName('Admin');
        $authorized_user->assignRole($role);

        // create permission for viewing warehouse
        $permission = Permission::findByName('add_product');
        $permission->assignRole($role);
        $role->givePermissionTo($permission);


        $warehouse = factory(Warehouse::class)->create();
        $warehouse->contactPersons()->saveMany([$authorized_user]);

        $this->actingAs($authorized_user)
            ->get(route('warehouses.list'))
            ->assertStatus(403);
    }


    /** @test */
    public function unauthorized_user_cannot_see_ware_house_create_page () {
        $unauthorized_user = factory(User::class)->create(['activated' => true]);
        $role = Role::findByName('Admin');
        $unauthorized_user->assignRole($role);

        // create permission other than view_warehouse
        $permission = Permission::findByName('view_user');
        $permission->assignRole($role);
        $role->givePermissionTo($permission);

        $this->actingAs($unauthorized_user)
            ->get(route('warehouses.create'))
            ->assertStatus(403);
    }


    /** @test */
    public function authorized_user_can_see_warehouse_create_page () {
        $authorized_user = factory(User::class)->create(['activated' => true]);
        $role = Role::findByName('Admin');
        $authorized_user->assignRole($role);

        // create permission other than view_warehouse
        $permission = Permission::findByName('warehouse.add');
        $permission->assignRole($role);
        $role->givePermissionTo($permission);

        $this->actingAs($authorized_user)
            ->get(route('warehouses.create'))
            ->assertViewIs('warehouses.edit');
    }
}