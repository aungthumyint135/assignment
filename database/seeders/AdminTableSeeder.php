<?php

namespace Database\Seeders;

use App\Models\Admin\Admin;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AdminTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Admin::query()->create([
            'name' => 'System Admin',
            'email' => 'admin@mail.com',
            'role_id' => 1,
            'is_super' => 1,
            'password' => '$2y$10$23L5z9XQwSCCAk5u/8XjAOGBfrwjsX3R9Qjb0ci.ZSNk.z86CRpBi', // >h.[8'YFZ)
        ])->assignRole('administrator');
    }
}
