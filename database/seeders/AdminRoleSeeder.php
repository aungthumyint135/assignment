<?php

namespace Database\Seeders;

use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class AdminRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return bool
     */
    public function run()
    {
        $firstRecord = Role::first();
        if($firstRecord) {
            echo "Aborted with message 'Role table exists data.' : ";
            return false;
        }

        $permissions = Permission::query()
            ->where('guard_name', 'admins')
            ->get();

        Role::create([
            'guard_name' => 'admins',
            'name' => 'administrator',
            'uuid' => Str::uuid()->toString(),
        ])->givePermissionTo($permissions);
    }
}
