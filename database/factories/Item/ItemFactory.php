<?php

namespace Database\Factories\Item;

use App\Models\SubCategory\SubCategory;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Item>
 */
class ItemFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $subCategories = SubCategory::pluck('id')->toArray();
        return [
            'name' => $this->faker->name(),
            'desc' => $this->faker->text(),
            'sub_category_id' => $this->faker->randomElement($subCategories),
        ];
    }
}
