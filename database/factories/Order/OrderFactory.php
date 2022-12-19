<?php

namespace Database\Factories\Order;

use App\Models\User;
use App\Models\Item\Item;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Order>
 */
class OrderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $items = Item::pluck('id')->toArray();
        $users = User::pluck('id')->toArray();
        return [
            'name' => $this->faker->name(),
            'user_id' => $this->faker->randomElement($users),
            'item_id' => $this->faker->randomElement($items),
        ];
    }
}
