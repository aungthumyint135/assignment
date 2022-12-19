<?php

namespace Database\Seeders;

use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\PermissionRegistrar;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class AdminPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        $permissions = [
            ['guard_name' => 'admins', 'name' => 'UserListing', 'uuid' => Str::uuid()->toString()],
            ['guard_name' => 'admins', 'name' => 'UserCreate', 'uuid' => Str::uuid()->toString()],
            ['guard_name' => 'admins', 'name' => 'UserUpdate', 'uuid' => Str::uuid()->toString()],
            ['guard_name' => 'admins', 'name' => 'UserDelete', 'uuid' => Str::uuid()->toString()],

            ['guard_name' => 'admins', 'name' => 'RoleListing', 'uuid' => Str::uuid()->toString()],
            ['guard_name' => 'admins', 'name' => 'RoleCreate', 'uuid' => Str::uuid()->toString()],
            ['guard_name' => 'admins', 'name' => 'RoleUpdate', 'uuid' => Str::uuid()->toString()],
            ['guard_name' => 'admins', 'name' => 'RoleDelete', 'uuid' => Str::uuid()->toString()],

            ['guard_name' => 'admins', 'name' => 'CategoryListing', 'uuid' => Str::uuid()->toString()],
            ['guard_name' => 'admins', 'name' => 'CategoryCreate', 'uuid' => Str::uuid()->toString()],
            ['guard_name' => 'admins', 'name' => 'CategoryUpdate', 'uuid' => Str::uuid()->toString()],
            ['guard_name' => 'admins', 'name' => 'CategoryDelete', 'uuid' => Str::uuid()->toString()],

            ['guard_name' => 'admins', 'name' => 'SubCategoryListing', 'uuid' => Str::uuid()->toString()],
            ['guard_name' => 'admins', 'name' => 'SubCategoryCreate', 'uuid' => Str::uuid()->toString()],
            ['guard_name' => 'admins', 'name' => 'SubCategoryUpdate', 'uuid' => Str::uuid()->toString()],
            ['guard_name' => 'admins', 'name' => 'SubCategoryDelete', 'uuid' => Str::uuid()->toString()],

            ['guard_name' => 'admins', 'name' => 'ItemListing', 'uuid' => Str::uuid()->toString()],
            ['guard_name' => 'admins', 'name' => 'ItemCreate', 'uuid' => Str::uuid()->toString()],
            ['guard_name' => 'admins', 'name' => 'ItemUpdate', 'uuid' => Str::uuid()->toString()],
            ['guard_name' => 'admins', 'name' => 'ItemDelete', 'uuid' => Str::uuid()->toString()],

            ['guard_name' => 'admins', 'name' => 'AdminListing', 'uuid' => Str::uuid()->toString()],
            ['guard_name' => 'admins', 'name' => 'AdminCreate', 'uuid' => Str::uuid()->toString()],
            ['guard_name' => 'admins', 'name' => 'AdminUpdate', 'uuid' => Str::uuid()->toString()],
            ['guard_name' => 'admins', 'name' => 'AdminDelete', 'uuid' => Str::uuid()->toString()],
            ['guard_name' => 'admins', 'name' => 'ChangePassword', 'uuid' => Str::uuid()->toString()],
        ];
        foreach ($permissions as $permission) {
            Permission::query()->insert($permission);
        }
    }
}
