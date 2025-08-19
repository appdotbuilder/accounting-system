<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Table;
use App\Models\MenuItem;
use App\Models\Employee;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Carbon\Carbon;

class DashboardController extends Controller
{
    /**
     * Display the dashboard with key metrics and overview.
     */
    public function index()
    {
        // Get today's metrics
        $today = Carbon::today();
        
        $todayOrders = Order::whereDate('created_at', $today)->count();
        $todayRevenue = Order::whereDate('created_at', $today)
            ->where('status', 'completed')
            ->sum('total_amount');
        
        $activeOrders = Order::whereIn('status', ['pending', 'confirmed', 'preparing', 'ready'])->count();
        $availableTables = Table::where('status', 'available')->where('is_active', true)->count();
        
        // Recent orders
        $recentOrders = Order::with(['table', 'user'])
            ->latest()
            ->take(10)
            ->get();
        
        // Popular menu items today
        $popularItems = MenuItem::select('menu_items.*')
            ->join('order_items', 'menu_items.id', '=', 'order_items.menu_item_id')
            ->join('orders', 'order_items.order_id', '=', 'orders.id')
            ->whereDate('orders.created_at', $today)
            ->groupBy('menu_items.id')
            ->selectRaw('menu_items.*, SUM(order_items.quantity) as total_sold')
            ->orderByDesc('total_sold')
            ->take(5)
            ->get();
        
        // Table status overview
        $tableStats = [
            'available' => Table::where('status', 'available')->where('is_active', true)->count(),
            'occupied' => Table::where('status', 'occupied')->count(),
            'reserved' => Table::where('status', 'reserved')->count(),
            'cleaning' => Table::where('status', 'cleaning')->count(),
        ];
        
        return Inertia::render('dashboard', [
            'metrics' => [
                'todayOrders' => $todayOrders,
                'todayRevenue' => $todayRevenue,
                'activeOrders' => $activeOrders,
                'availableTables' => $availableTables,
            ],
            'recentOrders' => $recentOrders,
            'popularItems' => $popularItems,
            'tableStats' => $tableStats,
        ]);
    }
}