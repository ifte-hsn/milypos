<?php

namespace Tests\Feature;

use App\Models\Category;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CategoriesTest extends TestCase
{
    /** @test */
    public function unauthenticated_user_redirects_to_login_page_when_he_tries_to_access_category_index_page()
    {

        $this->get(route('categories.index'))
            ->assertRedirect('login');
    }

    /** @test */
    public function user_can_not_see_category_index_page_if_he_is_not_authorized_to_view_category()
    {
        $unauthorized_user = $this->create_user_and_assign_role_and_permission('Admin');

        $this->actingAs($unauthorized_user)
            ->get(route('categories.index'))
            ->assertStatus(403);
    }


    /** @test */
    public function user_can_see_category_index_page_if_he_is_authorized_to_view_category()
    {
        $authorized_user = $this->create_user_and_assign_role_and_permission('Admin', 'view_category');

        $this->actingAs($authorized_user)
            ->get(route('categories.index'))->assertViewIs('categories.index');
    }

    /** @test */
    public function unauthenticated_user_redirect_to_login_page_when_try_to_see_categories_list()
    {
        $this->get(route('categories.list'))
            ->assertRedirect('login');
    }

    /** @test */
    public function if_the_user_is_unauthorized_to_view_category_will_get_403_status_when_trying_to_view_category_list()
    {
        $user = $this->create_user_and_assign_role_and_permission('Admin', 'view_user');

        $this->actingAs($user)
            ->get(route('categories.list'))
            ->assertStatus(403);
    }


    /** @test */
    public function if_the_user_is_authorized_to_view_category_will_be_able_to_view_category_list()
    {
        $user = $this->create_user_and_assign_role_and_permission('Admin', 'view_category');

        $category = factory(Category::class)->create();

        $category = Category::findOrFail($category->id);

        $this->actingAs($user)
            ->get(route('categories.list'))
            ->assertJson([
                "total" => 1,
                "rows" => [
                    [
                        "id" => $category->id,
                        "name" => html_entity_decode($category->name),
                    ]
                ]
            ]);
    }

    /** @test */
    public function super_admin_can_see_category_list()
    {
        $category = factory(Category::class)->create();

        $category = Category::findOrFail($category->id);

        $this->actingAs($this->superAdmin)
            ->get(route('categories.list'))
            ->assertJson([
                "total" => 1,
                "rows" => [
                    [
                        "id" => $category->id,
                        "name" => html_entity_decode($category->name),
                    ]
                ]
            ]);
    }

    /** @test */
    public function unauthenticated_user_will_redirect_to_login_page_if_he_tries_to_go_category_create_page()
    {
        $this->get(route('categories.create'))
            ->assertRedirect('login');
    }

    /** @test */
    public function if_user_is_unauthorized_to_create_new_category_then_he_will_get_403_status_when_he_tries_to_visit_category_create_page(
    )
    {
        $user = $this->create_user_and_assign_role_and_permission('Admin', 'view_user');

        $this->actingAs($user)
            ->get(route('categories.create'))
            ->assertStatus(403);
    }

    /** @test */
    public function if_a_user_is_authorized_to_create_new_category_then_he_is_able_to_create_new_category()
    {
        $user = $this->create_user_and_assign_role_and_permission('Admin', 'add_category');

        $category = factory(Category::class)->make();

        $this->actingAs($user)
            ->from(route('categories.create'))
            ->post(route('categories.store'), [
                'name' => $category->name
            ])->assertStatus(302);

        $this->assertDatabaseHas('categories', [
            'name' => $category->name
        ]);
    }


    /** @test */
    public function super_user_can_create_new_category()
    {
        $category = factory(Category::class)->make();

        $this->actingAs($this->superAdmin)
            ->from(route('categories.create'))
            ->post(route('categories.store'), [
                'name' => $category->name
            ])->assertStatus(302);

        $this->assertDatabaseHas('categories', [
            'name' => $category->name
        ]);
    }

    /** @test */
    public function unauthorized_user_redirect_to_login_page_if_user_tries_to_go_category_edit_page()
    {
        $category = factory(Category::class)->create();
        $this->get(route('categories.edit', ['category' => $category->id]))
            ->assertRedirect('login');
    }

    /** @test */
    public function if_user_is_unauthorized_to_update_category_will_get_403_status_when_try_to_view_category_edit_page()
    {
        $user = $this->create_user_and_assign_role_and_permission('Admin', 'view_user');


        $category = factory(Category::class)->create();

        $this->actingAs($user)
            ->get(route('categories.edit', ['category' => $category->id]))
            ->assertStatus(403);
    }

    /** @test */
    public function if_user_is_authorized_to_update_category_will_be_able_to_see_category_edit_page()
    {
        $user = $this->create_user_and_assign_role_and_permission('Admin', 'edit_category');

        $category = factory(Category::class)->create();
        $this->actingAs($user)
            ->get(route('categories.edit', ['category' => $category->id]))
            ->assertViewIs('categories.edit');
    }

    /** @test */
    public function if_user_is_authorized_to_update_category_then_he_will_be_able_to_update_categories()
    {
        $user = $this->create_user_and_assign_role_and_permission('Admin', 'edit_category');

        $categories = factory(Category::class, 10)->create();

        // Get the category which we will update
        $category = $categories[5];
        $category->name = "Food";

        $this->actingAs($user)
            ->from(route('categories.edit', ['category' => $category->id]))
            ->put(route('categories.update', ['category' => $category->id]), $category->toArray());

        $updated_category = Category::findOrFail($categories[5]->id);

        $this->assertEquals($updated_category->name, $category->name);
    }

    /** @test */
    public function super_admin_can_update_category()
    {
        $categories = factory(Category::class, 10)->create();

        $category = $categories[3];
        $name = "Food";
        $category->name = $name;

        $this->actingAs($this->superAdmin)
            ->put(route('categories.update', ['category' => $category->id]), $category->toArray());

        $updated_category = Category::findOrFail($category->id);
        $this->assertEquals($name, $updated_category->name);
    }


    /** @test */
    public function category_cannot_be_created_without_name()
    {
        $this->actingAs($this->superAdmin)
            ->from(route('categories.create'))
            ->post(route('categories.store'), [
                'image' => "image"
            ])
            ->assertRedirect(route('categories.create'))
            ->assertSessionHasErrors('name');
    }


    /** @test */
    public function name_must_be_unique()
    {

        $name = $this->faker->word;

        $category1 = factory(Category::class)->make([
            'name' => $name,
        ]);


        $category2 = factory(Category::class)->make([
            'name' => $name,
        ]);

        $this->actingAs($this->superAdmin)
            ->from(route('categories.create'))
            ->post(route('categories.store'), [
                'name' => $category1['name'],
            ]);

        $this->assertDatabaseHas('categories', [
            'name' => $name,
        ]);
//
        $this->from(route('categories.create'))
            ->post(route('categories.store'), [
                'name' => $category2['name'],
            ])
            ->assertRedirect(route('categories.create'));
        $this->assertTrue(session()->hasOldInput('name'));
    }

    /** @test */
    public function category_can_be_deleted()
    {
        $category = factory(Category::class)->create();

        $this->actingAs($this->superAdmin)
            ->delete(route('categories.destroy', ['category' => $category->id]));

        $this->get(route('categories.list'))
            ->assertJson(["total" => 0]);
    }

    /** @test */
    public function unauthenticated_user_redirect_to_login_page_when_they_try_to_delete_a_category_entry()
    {
        $categories = factory(Category::class, 10)->create();

        $this->delete(route('categories.destroy', ['category' => $categories[3]]))
            ->assertRedirect('login');
    }

    /** @test */
    public function if_a_user_is_not_authorized_to_delete_entry_then_they_will_get_403_status()
    {
        $user = $this->create_user_and_assign_role_and_permission('Admin', 'view_user');

        $category = factory(Category::class)->create();

        $this->actingAs($user)
            ->delete(route('categories.destroy', ['category' => $category->id]))
            ->assertStatus(403);
    }


    /** @test */
    public function if_a_user_is_authorized_to_delete_category_entry_then_he_will_able_to_delete()
    {
        $categories = factory(Category::class, 10)->create();

        $user = $this->create_user_and_assign_role_and_permission('Admin', 'delete_category');


        $this->actingAs($user)
            ->delete(route('categories.destroy', ['category' => $categories[3]->id]));

        $url = route('categories.list') . '?deleted=true';

        // Give permission to view user;
        // without view user permission
        // the user will not able to
        // see deleted user
        $role = Role::findByName('Admin');
        $role->givePermissionTo(Permission::findByName('view_category'));

        $this->get($url)
            ->assertJson(
                [
                    "total" => 1,
                    "rows" => [
                        [
                            "name" => html_entity_decode($categories[3]->name),
                        ]
                    ]
                ]
            );
    }


    /** @test */
    public function it_can_show_deleted_categories()
    {
        $categories = factory(Category::class, 10)->create();

        $id = $categories[3]->id;

        $url = route('categories.list') . '?deleted=true';

        $this->actingAs($this->superAdmin)
            ->delete(route('categories.destroy', ['category' => $id]));

        $this->get($url)
            ->assertJson(
                [
                    "total" => 1,
                    "rows" => [
                        [
                            "name" => html_entity_decode($categories[3]->name),
                        ]
                    ]
                ]
            );
    }

    /** @test */
    public function if_a_user_is_not_authenticated_then_he_will_redirect_to_login_page_when_he_try_to_restore_category()
    {
        $category = factory(Category::class)->create();

        $this->get(route('categories.restore', ['category' => $category->id]))
            ->assertRedirect('login');
    }


    /** @test */
    public function if_the_user_is_unauthorized_to_restore_he_will_get_403_status_when_he_try_to_restore_deleted_category(
    )
    {
        $user = $this->create_user_and_assign_role_and_permission('Admin', 'view_user');


        $categories = factory(Category::class, 10)->create();

        $categories[4]->delete();

        $this->actingAs($user)
            ->get(route('categories.restore', ['category' => $categories[4]->id]))->assertStatus(403);
    }

    /** @test */
    public function if_a_user_is_authorized_then_he_will_be_able_to_restore_category()
    {
        $user = $this->create_user_and_assign_role_and_permission('Admin', 'restore_category');

        $category_to_delete = factory(Category::class)->create();

        $category_to_delete->delete();

        $url = route('categories.list') . '?deleted=true';

        $role = Role::findByName('Admin');

        $role->givePermissionTo(Permission::findByName('view_category'));

        $this->actingAs($user)
            ->get($url)
            ->assertJson([
                "total" => 1,
                "rows" => [
                    [
                        "name" => html_entity_decode($category_to_delete->name)
                    ]
                ]
            ]);

        $this->get(route('categories.restore', ['categories' => $category_to_delete->id]));

        $this->get(route('categories.list'))->assertJson(['total' => '1']);

    }


    /** @test */
    public function deleted_category_can_be_restored()
    {
        $category = factory(Category::class)->create();

        $this->actingAs($this->superAdmin)
            ->delete(route('categories.destroy', ['category' => $category->id]));

        $url = route('categories.list') . '?deleted=true';

        $this->get($url)
            ->assertJson([
                "total" => 1,
                "rows" => [
                    [
                        "name" => html_entity_decode($category->name),
                    ]
                ]
            ]);

        $this->get(route('categories.restore', ['category' => $category->id]));

        $this->get(route('categories.list'))->assertJson(['total' => '1']);
    }

    /** @test */
    public function if_the_user_is_not_authenticated_then_he_will_redirect_to_login_page_when_try_to_bulk_save_categories()
    {
        $categories = factory(Category::class, 10)->create();
        $ids = [];

        for ($i = 0; $i < 5; $i++) {
            array_push($ids, $categories[$i]->id);
        }

        $this->post(route('categories.bulkSave'), ['ids' => $ids])
            ->assertRedirect('login');
    }

    /** @test */
    public function if_the_user_is_not_authorized_to_bulk_delete_then_he_will_redirect_to_403_page_when_try_to_bulk_save_categories(
    )
    {
        $categories = factory(Category::class, 10)->create();
        $ids = [];

        $user = $this->create_user_and_assign_role_and_permission('Admin');

        for ($i = 0; $i < 5; $i++) {
            array_push($ids, $categories[$i]->id);
        }

        $this->actingAs($user)
            ->post(route('categories.bulkSave'), ['ids' => $ids])
            ->assertStatus(403);
    }

    /** @test */
    public function if_the_user_is_authorized_to_bulk_delete_then_he_will_able_to_bulk_delete_categories()
    {
        $user = $this->create_user_and_assign_role_and_permission('Admin', 'bulk_delete_categories');

        $categories = factory(Category::class, 10)->create();
        $ids = [];


        for ($i = 0; $i < 5; $i++) {
            array_push($ids, $categories[$i]->id);
        }

        $this->actingAs($user)
            ->post(route('categories.bulkSave'), ['ids' => $ids]);

        $role = Role::findByName('Admin');
        $role->givePermissionTo(Permission::findByName('view_category'));

        $this->get(route('categories.list'))
            ->assertJson(['total' => 5]);

        $url = route('categories.list') . '?deleted=true';

        $this->get($url)
            ->assertJson(
                [
                    "total" => 5,
                ]
            );
    }

    /** @test */
    public function it_can_bulk_delete_categories()
    {
        $categories = factory(Category::class, 10)->create();
        $ids = [];

        for ($i = 0; $i < 5; $i++) {
            array_push($ids, $categories[$i]->id);
        }

        $this->actingAs($this->superAdmin)
            ->post(route('categories.bulkSave'), ['ids' => $ids]);

        $this->get(route('categories.list'))
            ->assertJson(['total' => 5]);


        $url = route('categories.list') . '?deleted=true';

        $this->get($url)
            ->assertJson(
                [
                    "total" => 5,
                ]
            );

    }

}
