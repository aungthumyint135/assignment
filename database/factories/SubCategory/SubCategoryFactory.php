<?php

namespace Database\Factories\SubCategory;

use App\Models\Category\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\SubCategory>
 */
class SubCategoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $categories = Category::pluck('id')->toArray();
        return [
            'name' => $this->faker->name(),
            'desc' => $this->faker->text(),
                'category_id' => $this->faker->randomElement($categories),
        ];
    }
}
