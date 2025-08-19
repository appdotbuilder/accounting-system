<?php

namespace Database\Factories;

use App\Models\Order;
use App\Models\Table;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Order>
 */
class OrderFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     */
    protected $model = Order::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $subtotal = fake()->randomFloat(2, 15, 200);
        $taxAmount = $subtotal * 0.10;
        $serviceCharge = $subtotal * 0.05;
        $discountAmount = fake()->boolean(20) ? fake()->randomFloat(2, 0, $subtotal * 0.1) : 0;
        $totalAmount = $subtotal + $taxAmount + $serviceCharge - $discountAmount;

        return [
            'order_number' => 'ORD' . date('Ymd') . str_pad((string) fake()->unique()->numberBetween(1, 9999), 4, '0', STR_PAD_LEFT),
            'table_id' => fake()->boolean(70) ? Table::factory() : null,
            'user_id' => User::factory(),
            'type' => fake()->randomElement(['dine_in', 'takeaway', 'delivery']),
            'status' => fake()->randomElement(['pending', 'confirmed', 'preparing', 'ready', 'served', 'completed']),
            'subtotal' => $subtotal,
            'tax_amount' => $taxAmount,
            'service_charge' => $serviceCharge,
            'discount_amount' => $discountAmount,
            'total_amount' => $totalAmount,
            'customer_name' => fake()->name(),
            'customer_phone' => fake()->phoneNumber(),
            'delivery_address' => fake()->boolean(30) ? fake()->address() : null,
            'notes' => fake()->optional()->sentence(),
            'estimated_completion' => fake()->dateTimeBetween('now', '+2 hours'),
            'completed_at' => fake()->boolean(60) ? fake()->dateTimeBetween('-1 hour', 'now') : null,
        ];
    }
}