<?php

namespace Database\Factories;

use App\Models\MenuItem;
use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\MenuItem>
 */
class MenuItemFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     */
    protected $model = MenuItem::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $price = fake()->randomFloat(2, 5, 50);
        $cost = $price * 0.4; // 40% cost ratio

        $menuItems = [
            'Caesar Salad', 'Grilled Chicken', 'Beef Burger', 'Margherita Pizza', 
            'Spaghetti Carbonara', 'Fish and Chips', 'Vegetable Stir Fry', 
            'Chocolate Cake', 'Ice Cream Sundae', 'Coffee', 'Fresh Orange Juice',
            'Club Sandwich', 'Mushroom Soup', 'Garlic Bread', 'Chicken Wings'
        ];

        return [
            'category_id' => Category::factory(),
            'name' => fake()->randomElement($menuItems),
            'description' => fake()->sentence(8),
            'price' => $price,
            'cost' => $cost,
            'image_url' => 'https://via.placeholder.com/300x200?text=' . urlencode(fake()->word()),
            'is_available' => fake()->boolean(90), // 90% available
            'preparation_time' => fake()->numberBetween(10, 45),
            'allergens' => fake()->randomElements(['gluten', 'dairy', 'nuts', 'eggs', 'soy'], fake()->numberBetween(0, 3)),
            'sort_order' => fake()->numberBetween(1, 100),
        ];
    }
}