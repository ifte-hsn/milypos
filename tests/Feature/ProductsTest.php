<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProductsTest extends TestCase
{
    /** @test */
    public function unauthenticated_user_redirects_to_login_page_when_he_tries_to_access_product_index_page()
    {

        $this->get(route('products.index'))
            ->assertRedirect('login');
    }

    /** @test */
    public function user_can_not_see_product_index_page_if_he_is_not_authorized_to_view_product()
    {
        $unauthorized_user = $this->create_user_and_assign_role_and_permission('Admin');

        $this->actingAs($unauthorized_user)
            ->get(route('products.index'))
            ->assertStatus(403);
    }


    /** @test */
    public function user_can_see_product_index_page_if_he_is_authorized_to_view_product()
    {
        $authorized_user = $this->create_user_and_assign_role_and_permission('Admin', 'view_product');

        $this->actingAs($authorized_user)
            ->get(route('products.index'))->assertViewIs('products.index');
    }

    /** @test */
    public function unauthenticated_user_redirect_to_login_page_when_try_to_see_products_list()
    {
        $this->get(route('products.list'))
            ->assertRedirect('login');
    }

    /** @test */
    public function if_the_user_is_unauthorized_to_view_product_will_get_403_status_when_trying_to_view_product_list()
    {
        $user = $this->create_user_and_assign_role_and_permission('Admin', 'view_user');

        $this->actingAs($user)
            ->get(route('products.list'))
            ->assertStatus(403);
    }

    /** @test */
    public function if_the_user_is_authorized_to_view_product_will_be_able_to_view_product_list()
    {
        $user = $this->create_user_and_assign_role_and_permission('Admin', 'view_product');

        $product = factory(Product::class)->create();

        $product = Product::findOrFail($product->id);

        $this->actingAs($user)
            ->get(route('products.list'))
            ->assertJson([
                "total" => 1,
                "rows" => [
                    [
                        "id" => $product->id,
                        "name" => e($product->name),
                        "code" => e($product->code),
                        "stock" => e($product->stock),
                        "description" => e($product->description),
                        "purchase_price" => e($product->purchase_price),
                        "selling_price" => e($product->selling_price),
                        "sales" => e($product->sales),
                        "category" => e($product->category->name),
                    ]
                ]
            ]);
    }

    /** @test */
    public function super_admin_can_see_product_list()
    {
        $product = factory(Product::class)->create();

        $product = Product::findOrFail($product->id);

        $this->actingAs($this->superAdmin)
            ->get(route('products.list'))
            ->assertJson([
                "total" => 1,
                "rows" => [
                    [
                        "id" => $product->id,
                        "name" => e($product->name),
                        "code" => e($product->code),
                        "stock" => e($product->stock),
                        "description" => e($product->description),
                        "purchase_price" => e($product->purchase_price),
                        "selling_price" => e($product->selling_price),
                        "sales" => e($product->sales),
                        "category" => e($product->category->name),
                    ]
                ]
            ]);
    }

    /** @test */
    public function unauthenticated_user_will_redirect_to_login_page_if_he_tries_to_go_product_create_page()
    {
        $this->get(route('products.create'))
            ->assertRedirect('login');
    }

    /** @test */
    public function if_user_is_unauthorized_to_create_new_product_then_he_will_get_403_status_when_he_tries_to_visit_product_create_page()
    {
        $user = $this->create_user_and_assign_role_and_permission('Admin', 'view_user');

        $this->actingAs($user)
            ->get(route('products.create'))
            ->assertStatus(403);
    }

    /** @test */
    public function if_a_user_is_authorized_to_create_new_product_then_he_is_able_to_create_new_product()
    {
        $user = $this->create_user_and_assign_role_and_permission('Admin', 'add_product');

        $product = factory(Product::class)->make();

        $category = factory(Category::class)->create();

        $this->actingAs($user)
            ->from(route('products.create'))
            ->post(route('products.store'), [
                "name" => e($product->name),
                "code" => e($product->code),
                "stock" => e($product->stock),
                "description" => e($product->description),
                "purchase_price" => e($product->purchase_price),
                "selling_price" => e($product->selling_price),
                "sales" => e($product->sales),
                "category_id" => e($category->id),
            ])->assertStatus(302);

        $this->assertDatabaseHas('products', [
            "name" => e($product->name),
            "code" => e($product->code),
            "stock" => e($product->stock),
            "description" => e($product->description),
            "purchase_price" => e($product->purchase_price),
            "selling_price" => e($product->selling_price),
            "sales" => e($product->sales),
            "category_id" => e($category->id),
        ]);
    }


    /** @test */
    public function super_user_can_create_new_product()
    {
        $product = factory(Product::class)->make();


        $category = factory(Category::class)->create();

        $this->actingAs($this->superAdmin)
            ->from(route('products.create'))
            ->post(route('products.store'), [
                "name" => e($product->name),
                "code" => e($product->code),
                "stock" => e($product->stock),
                "description" => e($product->description),
                "purchase_price" => e($product->purchase_price),
                "selling_price" => e($product->selling_price),
                "sales" => e($product->sales),
                "category_id" => e($category->id),
            ])->assertStatus(302);

        $this->assertDatabaseHas('products', [
            "name" => e($product->name),
            "code" => e($product->code),
            "stock" => e($product->stock),
            "description" => e($product->description),
            "purchase_price" => e($product->purchase_price),
            "selling_price" => e($product->selling_price),
            "sales" => e($product->sales),
            "category_id" => e($category->id),
        ]);
    }


    /** @test */
    public function unauthorized_user_redirect_to_login_page_if_user_tries_to_go_product_edit_page()
    {
        $product = factory(Product::class)->create();
        $this->get(route('products.edit', ['product' => $product->id]))
            ->assertRedirect('login');
    }


    /** @test */
    public function if_user_is_unauthorized_to_update_product_will_get_403_status_when_try_to_view_product_edit_page()
    {
        $user = $this->create_user_and_assign_role_and_permission('Admin', 'view_user');


        $product = factory(Product::class)->create();

        $this->actingAs($user)
            ->get(route('products.edit', ['product' => $product->id]))
            ->assertStatus(403);
    }

    /** @test */
    public function if_user_is_authorized_to_update_product_will_be_able_to_see_product_edit_page()
    {
        $user = $this->create_user_and_assign_role_and_permission('Admin', 'edit_product');

        $product = factory(Product::class)->create();
        $this->actingAs($user)
            ->get(route('products.edit', ['product' => $product->id]))
            ->assertViewIs('products.edit');
    }

    /** @test */
    public function if_user_is_authorized_to_update_product_then_he_will_be_able_to_update_products()
    {
        $user = $this->create_user_and_assign_role_and_permission('Admin', 'edit_product');

        $products = factory(Product::class, 10)->create();

        // Get the product which we will update
        $product = $products[5];
        $product->name = 'Xiaomi Wireless Mouse';

        $this->actingAs($user)
            ->from(route('products.edit', ['product' => $product->id]))
            ->put(route('products.update', ['product' => $product->id]), $product->toArray());

        $updated_product = Product::findOrFail($products[5]->id);

        $this->assertEquals($updated_product->name, $product->name);
    }

    /** @test */
    public function super_admin_can_update_product()
    {
        $products = factory(Product::class, 10)->create();

        $product = $products[3];
        $name = $this->faker->firstName;
        $product->name = $name;

        $this->actingAs($this->superAdmin)
            ->put(route('products.update', ['product' => $product->id]), $product->toArray());

        $updated_product = Product::findOrFail($product->id);
        $this->assertEquals($name, $updated_product->name);
    }

    /** @test */
    public function product_cannot_be_created_without_name()
    {
        $product = factory(Product::class)->make();
        $this->actingAs($this->superAdmin)
            ->from(route('products.create'))
            ->post(route('products.store'), [
                'code' => $product->code,
                'stock' => $product->stock,
                'description' => $product->description,
                'purchase_price' => $product->purchase_price,
                'selling_price' => $product->selling_price,
                'sales' => $product->sales
            ])
            ->assertRedirect(route('products.create'))
            ->assertSessionHasErrors('name');

        $this->assertFalse(session()->hasOldInput('name'));
        $this->assertTrue(session()->hasOldInput('code'));
        $this->assertTrue(session()->hasOldInput('stock'));
        $this->assertTrue(session()->hasOldInput('description'));
        $this->assertTrue(session()->hasOldInput('purchase_price'));
        $this->assertTrue(session()->hasOldInput('selling_price'));
    }

    /** @test */
    public function product_cannot_be_created_without_code()
    {
        $product = factory(Product::class)->make();

        $this->actingAs($this->superAdmin)
            ->from(route('products.create'))
            ->post(route('products.store'), [
                'name' => $product->name,
                'stock' => $product->stock,
                'description' => $product->description,
                'purchase_price' => $product->purchase_price,
                'selling_price' => $product->selling_price,
                'sales' => $product->sales
            ])
            ->assertRedirect(route('products.create'))
            ->assertSessionHasErrors('code');


        $this->assertFalse(session()->hasOldInput('code'));
        $this->assertTrue(session()->hasOldInput('name'));
        $this->assertTrue(session()->hasOldInput('stock'));
        $this->assertTrue(session()->hasOldInput('description'));
        $this->assertTrue(session()->hasOldInput('purchase_price'));
        $this->assertTrue(session()->hasOldInput('selling_price'));
    }

    /** @test */
    public function product_purchase_price_must_be_numaric()
    {
        $product = factory(Product::class)->make();

        $this->actingAs($this->superAdmin)
            ->from(route('products.create'))
            ->post(route('products.store'), [
                'name' => $product->name,
                'code' => $product->code,
                'stock' => $product->stock,
                'description' => $product->description,
                'purchase_price' => 'loiuyj',
                'selling_price' => $product->selling_price,
                'sales' => $product->sales
            ])
            ->assertRedirect(route('products.create'))
            ->assertSessionHasErrors('purchase_price');


        $this->assertTrue(session()->hasOldInput('code'));
        $this->assertTrue(session()->hasOldInput('name'));
        $this->assertTrue(session()->hasOldInput('stock'));
        $this->assertTrue(session()->hasOldInput('description'));
        $this->assertTrue(session()->hasOldInput('purchase_price'));
        $this->assertTrue(session()->hasOldInput('selling_price'));
    }


    /** @test */
    public function product_selling_price_must_be_numaric()
    {
        $product = factory(Product::class)->make();

        $this->actingAs($this->superAdmin)
            ->from(route('products.create'))
            ->post(route('products.store'), [
                'name' => $product->name,
                'code' => $product->code,
                'stock' => $product->stock,
                'description' => $product->description,
                'purchase_price' => $product->purchase_price,
                'selling_price' => "ddddewerdas",
                'sales' => $product->sales
            ])
            ->assertRedirect(route('products.create'))
            ->assertSessionHasErrors('selling_price');


        $this->assertTrue(session()->hasOldInput('code'));
        $this->assertTrue(session()->hasOldInput('name'));
        $this->assertTrue(session()->hasOldInput('stock'));
        $this->assertTrue(session()->hasOldInput('description'));
        $this->assertTrue(session()->hasOldInput('purchase_price'));
        $this->assertTrue(session()->hasOldInput('selling_price'));
    }


    /** @test */
    public function product_can_be_deleted()
    {
        $product = factory(Product::class)->create();

        $this->actingAs($this->superAdmin)
            ->delete(route('products.destroy', ['product' => $product->id]));

        $this->get(route('products.list'))
            ->assertJson(["total" => 0]);
    }

    /** @test */
    public function unauthenticated_user_redirect_to_login_page_when_they_try_to_delete_a_product_entry()
    {
        $products = factory(Product::class, 10)->create();

        $this->delete(route('products.destroy', ['product' => $products[3]]))
            ->assertRedirect('login');
    }


    /** @test */
    public function if_a_user_is_not_authorized_to_delete_entry_then_they_will_get_403_status()
    {
        $user = $this->create_user_and_assign_role_and_permission('Admin', 'view_user');

        $product = factory(Product::class)->create();

        $this->actingAs($user)
            ->delete(route('products.destroy', ['product' => $product->id]))
            ->assertStatus(403);
    }

    /** @test */
    public function if_a_user_is_authorized_to_delete_product_entry_then_he_will_able_to_delete()
    {
        $products = factory(Product::class, 10)->create();

        $user = $this->create_user_and_assign_role_and_permission('Admin', 'delete_product');


        $this->actingAs($user)
            ->delete(route('products.destroy', ['product' => $products[3]->id]));

        $url = route('products.list') . '?deleted=true';

        $role = Role::findByName('Admin');
        $role->givePermissionTo(Permission::findByName('view_product'));

        $this->get($url)
            ->assertJson(
                [
                    "total" => 1,
                    "rows" => [
                        [
                            "name" => e($products[3]->name),
                            "code" => e($products[3]->code),
                        ]
                    ]
                ]
            );
    }

    /** @test */
    public function it_can_show_deleted_products()
    {
        $products = factory(Product::class, 10)->create();

        $id = $products[3]->id;

        $url = route('products.list') . '?deleted=true';

        $this->actingAs($this->superAdmin)
            ->delete(route('products.destroy', ['product' => $id]));

        $this->get($url)
            ->assertJson(
                [
                    "total" => 1,
                    "rows" => [
                        [
                            "name" => e($products[3]->name),
                            "code" => e($products[3]->code),
                        ]
                    ]
                ]
            );
    }

    /** @test */
    public function if_a_user_is_not_authenticated_then_he_will_redirect_to_login_page_when_he_try_to_restore_product()
    {
        $product = factory(Product::class)->create();

        $this->get(route('products.restore', ['product' => $product->id]))
            ->assertRedirect('login');
    }

    /** @test */
    public function if_the_user_is_unauthorized_to_restore_he_will_get_403_status_when_he_try_to_restore_deleted_product()
    {
        $user = $this->create_user_and_assign_role_and_permission('Admin', 'view_user');


        $products = factory(Product::class, 10)->create();

        $products[4]->delete();

        $this->actingAs($user)
            ->get(route('products.restore', ['product' => $products[4]->id]))->assertStatus(403);
    }

    /** @test */
    public function if_a_user_is_authorized_then_he_will_be_able_to_restore_product()
    {
        $user = $this->create_user_and_assign_role_and_permission('Admin', 'restore_product');

        $product_to_delete = factory(Product::class)->create();

        $product_to_delete->delete();

        $url = route('products.list') . '?deleted=true';

        $role = Role::findByName('Admin');

        $role->givePermissionTo(Permission::findByName('view_product'));

        $this->actingAs($user)
            ->get($url)
            ->assertJson([
                "total" => 1,
                "rows" => [
                    [
                        "name" => e($product_to_delete->name),
                        "code" => e($product_to_delete->code),
                    ]
                ]
            ]);

        $this->get(route('products.restore', ['products' => $product_to_delete->id]));

        $this->get(route('products.list'))->assertJson(['total' => '1']);

    }

    /** @test */
    public function deleted_product_can_be_restored()
    {
        $product = factory(Product::class)->create();

        $this->actingAs($this->superAdmin)
            ->delete(route('products.destroy', ['product' => $product->id]));

        $url = route('products.list') . '?deleted=true';

        $this->get($url)
            ->assertJson([
                "total" => 1,
                "rows" => [
                    [
                        'name' => e($product->name),
                        'code' => e($product->code)
                    ]
                ]
            ]);

        $this->get(route('products.restore', ['product' => $product->id]));

        $this->get(route('products.list'))->assertJson(['total' => '1']);
    }


    /** @test */
    public function if_the_user_is_not_authenticated_then_he_will_redirect_to_login_page_when_try_to_bulk_save_products()
    {
        $products = factory(Product::class, 10)->create();
        $ids = [];

        for ($i = 0; $i < 5; $i++) {
            array_push($ids, $products[$i]->id);
        }

        $this->post(route('products.bulkSave'), ['ids' => $ids])
            ->assertRedirect('login');
    }

    /** @test */
    public function if_the_user_is_not_authorized_to_bulk_delete_then_he_will_redirect_to_403_page_when_try_to_bulk_save_products()
    {
        $products = factory(Product::class, 10)->create();
        $ids = [];

        $user = factory(User::class)->create(['activated' => 1]);

        for ($i = 0; $i < 5; $i++) {
            array_push($ids, $products[$i]->id);
        }

        $this->actingAs($user)
            ->post(route('products.bulkSave'), ['ids' => $ids])
            ->assertStatus(403);
    }

    /** @test */
    public function if_the_user_is_authorized_to_bulk_delete_then_he_will_able_to_bulk_delete_products()
    {
        $user = $this->create_user_and_assign_role_and_permission('Admin', 'bulk_delete_products');

        $products = factory(Product::class, 10)->create();
        $ids = [];


        for ($i = 0; $i < 5; $i++) {
            array_push($ids, $products[$i]->id);
        }

        $this->actingAs($user)
            ->post(route('products.bulkSave'), ['ids' => $ids]);

        $role = Role::findByName('Admin');
        $role->givePermissionTo(Permission::findByName('view_product'));

        $this->get(route('products.list'))
            ->assertJson(['total' => 5]);

        $url = route('products.list') . '?deleted=true';

        $this->get($url)
            ->assertJson(
                [
                    "total" => 5,
                ]
            );
    }


    /** @test */
    public function it_can_bulk_delete_products()
    {
        $products = factory(Product::class, 10)->create();
        $ids = [];

        for ($i = 0; $i < 5; $i++) {
            array_push($ids, $products[$i]->id);
        }

        $this->actingAs($this->superAdmin)
            ->post(route('products.bulkSave'), ['ids' => $ids]);

        $this->get(route('products.list'))
            ->assertJson(['total' => 5]);


        $url = route('products.list') . '?deleted=true';

        $this->get($url)
            ->assertJson(
                [
                    "total" => 5,
                ]
            );
    }
}
