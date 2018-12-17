<?php

use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class UsersTableSeeder extends Seeder
{
    private $superAdminUser;
    private $adminUser;
    private $adminRole;
    private $superAdminRole;
    private $readUser;
    private $createUser;
    private $updateUser;
    private $deleteUser;


    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->delete();
        DB::table('roles')->delete();
        DB::table('permissions')->delete();
        DB::table('model_has_permissions')->delete();
        DB::table('model_has_roles')->delete();
        DB::table('role_has_permissions')->delete();


        $this->createUsers();
        $this->createRoles();
        $this->createPermissions();

        // Assign Roles
        $this->superAdminUser->assignRole($this->superAdminRole);
        $this->adminUser->assignRole($this->adminRole);

        // Create permission
        $this->adminRole->syncPermissions([
            $this->createUser,
            $this->readUser,
            $this->updateUser,
            $this->deleteUser,
        ]);
//        factory(App\Models\User::class, 200)->create();
    }

    private function createUsers() {
        $this->superAdminUser = User::create([
            'first_name' => 'Iftekhar',
            'last_name' => 'Hossain',
            'email' => 'ifte510@gmail.com',
            'password' => bcrypt('freshmilk'),
            'activated' => '1',
        ]);


        $this->adminUser = User::create([
            'first_name' => 'Shishir',
            'last_name' => 'Hossain',
            'email' => 'ifte.hsn@gmail.com',
            'password' => bcrypt('freshmilk'),
            'activated' => '1',
        ]);
    }

    /**
     * Create Roles
     */
    private function createRoles() {
        $this->superAdminRole = Role::create(['name' => 'Super Admin']);
        $this->adminRole = Role::create(['name' => 'Admin']);
    }

    private function createPermissions() {
        $this->createUser = Permission::create(['name'=>'Create User']);
        $this->readUser = Permission::create(['name'=>'Read User']);
        $this->updateUser = Permission::create(['name'=>'Update User']);
        $this->deleteUser = Permission::create(['name' => 'Delete User']);
    }
}
