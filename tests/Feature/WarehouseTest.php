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

    private $super_admin;
    private $super_admin_role;
    private $faker;

    public function setUp()
    {
        parent::setUp();
        $this->super_admin = factory(User::class)->create(['activated' => 1]);

        // Only super admin can access all the features
        // so for the time being we will assign Super Admin
        // Role to the user. To test other role and their
        // permissions we have separate test.
        $this->super_admin->assignRole(Role::findByName('Super Admin'));
        $this->faker = FakerFactory::create();
    }

    /** @test */
    public function it_has_an_index_page()
    {
        $this->actingAs($this->super_admin)->get(route('warehouses.index'))
            ->assertViewIs('warehouses.index');
    }

    /** @test */
    public function unauthorize_user_cannot_see_warehouse_index_page()
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
        $permission = Permission::findByName('view_warehouse');
        $permission->assignRole($role);
        $role->givePermissionTo($permission);

        $this->actingAs($authorized_user)->get(route('warehouses.index'))
            ->assertViewIs('warehouses.index');
    }


    /** @test */
    public function authenticated_user_with_view_warehouse_permission_can_see_warehouse_list()
    {
        // create an unauthorized_user
        $authorized_user = factory(User::class)->create(['activated' => true]);
        $role = Role::findByName('Admin');
        $authorized_user->assignRole($role);

        // create permission for viewing warehouse
        $permission = Permission::findByName('view_warehouse');
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
}