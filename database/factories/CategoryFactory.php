<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Category>
 */
class CategoryFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     */
    protected $model = Category::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $categories = [
            'Appetizers', 'Main Course', 'Desserts', 'Beverages', 
            'Salads', 'Soups', 'Pasta', 'Pizza', 'Sandwiches', 'Breakfast'
        ];

        return [
            'name' => fake()->unique()->randomElement($categories),
            'description' => fake()->sentence(10),
            'image_url' => 'https://via.placeholder.com/300x200?text=' . urlencode(fake()->word()),
            'is_active' => true,
            'sort_order' => fake()->numberBetween(1, 100),
        ];
    }
}