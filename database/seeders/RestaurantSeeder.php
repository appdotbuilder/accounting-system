<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\MenuItem;
use App\Models\Table;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\InventoryItem;
use App\Models\Employee;

class RestaurantSeeder extends Seeder
{
    /**
     * Seed the restaurant data.
     */
    public function run(): void
    {
        // Create categories
        $categories = [
            ['name' => 'Appetizers', 'sort_order' => 1],
            ['name' => 'Main Course', 'sort_order' => 2],
            ['name' => 'Desserts', 'sort_order' => 3],
            ['name' => 'Beverages', 'sort_order' => 4],
            ['name' => 'Salads', 'sort_order' => 5],
        ];

        foreach ($categories as $categoryData) {
            $category = Category::create([
                'name' => $categoryData['name'],
                'description' => "Delicious {$categoryData['name']} prepared with fresh ingredients",
                'is_active' => true,
                'sort_order' => $categoryData['sort_order'],
            ]);

            // Create menu items for each category
            $this->createMenuItemsForCategory($category);
        }

        // Create tables
        for ($i = 1; $i <= 20; $i++) {
            Table::create([
                'number' => str_pad((string) $i, 2, '0', STR_PAD_LEFT),
                'capacity' => [2, 4, 6, 8][array_rand([2, 4, 6, 8])],
                'status' => ['available', 'occupied', 'reserved'][array_rand(['available', 'occupied', 'reserved'])],
                'position_x' => random_int(10, 90),
                'position_y' => random_int(10, 90),
                'is_active' => true,
            ]);
        }

        // Create sample orders
        Order::factory(30)->create();

        // Create inventory items
        $inventoryItems = [
            ['name' => 'Chicken Breast', 'unit' => 'kg', 'category' => 'Meat'],
            ['name' => 'Tomatoes', 'unit' => 'kg', 'category' => 'Vegetables'],
            ['name' => 'Lettuce', 'unit' => 'heads', 'category' => 'Vegetables'],
            ['name' => 'Cheese', 'unit' => 'kg', 'category' => 'Dairy'],
            ['name' => 'Pasta', 'unit' => 'kg', 'category' => 'Dry Goods'],
            ['name' => 'Rice', 'unit' => 'kg', 'category' => 'Dry Goods'],
            ['name' => 'Cooking Oil', 'unit' => 'liters', 'category' => 'Oils'],
            ['name' => 'Salt', 'unit' => 'kg', 'category' => 'Seasonings'],
        ];

        foreach ($inventoryItems as $item) {
            InventoryItem::create([
                'name' => $item['name'],
                'unit' => $item['unit'],
                'category' => $item['category'],
                'current_stock' => random_int(10, 100),
                'minimum_stock' => random_int(5, 20),
                'unit_cost' => random_int(200, 2000) / 100,
                'supplier' => 'Local Supplier',
                'is_active' => true,
            ]);
        }

        // Create employees
        $employees = [
            ['name' => 'John Manager', 'role' => 'manager', 'hourly_rate' => 25.00],
            ['name' => 'Alice Cashier', 'role' => 'cashier', 'hourly_rate' => 15.00],
            ['name' => 'Bob Waiter', 'role' => 'waiter', 'hourly_rate' => 12.00],
            ['name' => 'Carol Chef', 'role' => 'chef', 'hourly_rate' => 20.00],
            ['name' => 'Dave Cleaner', 'role' => 'cleaner', 'hourly_rate' => 10.00],
        ];

        foreach ($employees as $index => $emp) {
            Employee::create([
                'employee_id' => 'EMP' . str_pad((string) ($index + 1), 3, '0', STR_PAD_LEFT),
                'name' => $emp['name'],
                'email' => strtolower(str_replace(' ', '.', $emp['name'])) . '@restaurant.com',
                'role' => $emp['role'],
                'hourly_rate' => $emp['hourly_rate'],
                'hire_date' => now()->subDays(random_int(30, 365)),
                'status' => 'active',
            ]);
        }
    }

    public function createMenuItemsForCategory(Category $category): void
    {
        $menuItems = [
            'Appetizers' => [
                ['name' => 'Caesar Salad', 'price' => 8.99, 'prep_time' => 10],
                ['name' => 'Garlic Bread', 'price' => 5.99, 'prep_time' => 5],
                ['name' => 'Chicken Wings', 'price' => 12.99, 'prep_time' => 15],
                ['name' => 'Mozzarella Sticks', 'price' => 9.99, 'prep_time' => 8],
            ],
            'Main Course' => [
                ['name' => 'Grilled Chicken', 'price' => 18.99, 'prep_time' => 25],
                ['name' => 'Beef Burger', 'price' => 15.99, 'prep_time' => 15],
                ['name' => 'Spaghetti Carbonara', 'price' => 16.99, 'prep_time' => 20],
                ['name' => 'Fish and Chips', 'price' => 19.99, 'prep_time' => 18],
            ],
            'Desserts' => [
                ['name' => 'Chocolate Cake', 'price' => 7.99, 'prep_time' => 5],
                ['name' => 'Ice Cream Sundae', 'price' => 6.99, 'prep_time' => 3],
                ['name' => 'Tiramisu', 'price' => 8.99, 'prep_time' => 5],
                ['name' => 'Apple Pie', 'price' => 7.49, 'prep_time' => 8],
            ],
            'Beverages' => [
                ['name' => 'Coffee', 'price' => 2.99, 'prep_time' => 3],
                ['name' => 'Fresh Orange Juice', 'price' => 4.99, 'prep_time' => 2],
                ['name' => 'Soft Drink', 'price' => 2.49, 'prep_time' => 1],
                ['name' => 'House Wine', 'price' => 8.99, 'prep_time' => 2],
            ],
            'Salads' => [
                ['name' => 'Garden Salad', 'price' => 9.99, 'prep_time' => 8],
                ['name' => 'Greek Salad', 'price' => 11.99, 'prep_time' => 10],
                ['name' => 'Chicken Salad', 'price' => 13.99, 'prep_time' => 12],
                ['name' => 'Quinoa Bowl', 'price' => 12.99, 'prep_time' => 15],
            ],
        ];

        $items = $menuItems[$category->name] ?? [];

        foreach ($items as $index => $item) {
            MenuItem::create([
                'category_id' => $category->id,
                'name' => $item['name'],
                'description' => "Delicious {$item['name']} made with fresh ingredients",
                'price' => $item['price'],
                'cost' => $item['price'] * 0.4, // 40% cost ratio
                'is_available' => true,
                'preparation_time' => $item['prep_time'],
                'sort_order' => $index + 1,
            ]);
        }
    }
}