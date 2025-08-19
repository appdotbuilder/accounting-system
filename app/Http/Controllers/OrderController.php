<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Table;
use App\Models\MenuItem;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    /**
     * Display a listing of the orders.
     */
    public function index()
    {
        $orders = Order::with(['table', 'user', 'orderItems.menuItem'])
            ->latest()
            ->paginate(20);
        
        return Inertia::render('orders/index', [
            'orders' => $orders
        ]);
    }

    /**
     * Show the form for creating a new order.
     */
    public function create()
    {
        $tables = Table::where('is_active', true)->orderBy('number')->get();
        $menuItems = MenuItem::with('category')
            ->where('is_available', true)
            ->orderBy('sort_order')
            ->get()
            ->groupBy('category.name');
        
        return Inertia::render('orders/create', [
            'tables' => $tables,
            'menuItems' => $menuItems
        ]);
    }

    /**
     * Store a newly created order in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'table_id' => 'nullable|exists:tables,id',
            'type' => 'required|in:dine_in,takeaway,delivery',
            'customer_name' => 'nullable|string|max:255',
            'customer_phone' => 'nullable|string|max:20',
            'delivery_address' => 'nullable|string',
            'notes' => 'nullable|string',
            'items' => 'required|array|min:1',
            'items.*.menu_item_id' => 'required|exists:menu_items,id',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.special_instructions' => 'nullable|string',
        ]);

        DB::beginTransaction();
        
        try {
            $order = Order::create([
                'order_number' => Order::generateOrderNumber(),
                'table_id' => $validated['table_id'],
                'user_id' => auth()->id(),
                'type' => $validated['type'],
                'status' => 'pending',
                'customer_name' => $validated['customer_name'],
                'customer_phone' => $validated['customer_phone'],
                'delivery_address' => $validated['delivery_address'],
                'notes' => $validated['notes'],
                'subtotal' => 0,
                'tax_amount' => 0,
                'service_charge' => 0,
                'discount_amount' => 0,
                'total_amount' => 0,
            ]);

            foreach ($validated['items'] as $item) {
                $menuItem = MenuItem::find($item['menu_item_id']);
                $quantity = $item['quantity'];
                $unitPrice = $menuItem->price;
                $totalPrice = $unitPrice * $quantity;

                OrderItem::create([
                    'order_id' => $order->id,
                    'menu_item_id' => $menuItem->id,
                    'quantity' => $quantity,
                    'unit_price' => $unitPrice,
                    'total_price' => $totalPrice,
                    'special_instructions' => $item['special_instructions'],
                    'status' => 'pending',
                ]);
            }

            $order->calculateTotals();
            
            // Update table status if it's a dine-in order
            if ($validated['table_id'] && $validated['type'] === 'dine_in') {
                Table::where('id', $validated['table_id'])->update(['status' => 'occupied']);
            }

            DB::commit();

            return redirect()->route('orders.show', $order)
                ->with('success', 'Order created successfully.');
        } catch (\Exception $e) {
            DB::rollback();
            return back()->withErrors(['error' => 'Failed to create order.']);
        }
    }

    /**
     * Display the specified order.
     */
    public function show(Order $order)
    {
        $order->load(['table', 'user', 'orderItems.menuItem', 'payments']);
        
        return Inertia::render('orders/show', [
            'order' => $order
        ]);
    }

    /**
     * Update the specified order status.
     */
    public function update(Request $request, Order $order)
    {
        $validated = $request->validate([
            'status' => 'required|in:pending,confirmed,preparing,ready,served,completed,cancelled',
        ]);

        $order->update(['status' => $validated['status']]);

        // If order is completed and it's a dine-in order, free up the table
        if ($validated['status'] === 'completed' && $order->table_id && $order->type === 'dine_in') {
            Table::where('id', $order->table_id)->update(['status' => 'cleaning']);
        }

        return redirect()->route('orders.show', $order)
            ->with('success', 'Order status updated successfully.');
    }
}