<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Item\Item;
use App\Models\Order\Order;
use App\Models\User;
use Illuminate\Database\Seeder;
use App\Models\Category\Category;
use App\Models\SubCategory\SubCategory;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {

        $this->call(AdminPermissionSeeder::class);
        $this->call(AdminRoleSeeder::class);
        $this->call(AdminTableSeeder::class);
        Category::factory()->count(5)->create();
        SubCategory::factory()->count(5)->create();
        Item::factory()->count(5)->create();
        User::factory()->count(5)->create();
        Order::factory()->count(5)->create();
    }
}
