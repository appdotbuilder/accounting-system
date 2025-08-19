<?php

namespace Database\Factories;

use App\Models\Table;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Table>
 */
class TableFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     */
    protected $model = Table::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'number' => fake()->unique()->numberBetween(1, 50),
            'capacity' => fake()->randomElement([2, 4, 6, 8]),
            'status' => fake()->randomElement(['available', 'occupied', 'reserved', 'cleaning']),
            'position_x' => fake()->randomFloat(2, 0, 100),
            'position_y' => fake()->randomFloat(2, 0, 100),
            'notes' => fake()->optional()->sentence(),
            'is_active' => fake()->boolean(95), // 95% active
        ];
    }
}