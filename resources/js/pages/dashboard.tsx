import React from 'react';
import { Head } from '@inertiajs/react';
import { AppShell } from '@/components/app-shell';

interface DashboardProps {
    metrics: {
        todayOrders: number;
        todayRevenue: number;
        activeOrders: number;
        availableTables: number;
    };
    recentOrders: Array<{
        id: number;
        order_number: string;
        status: string;
        total_amount: number;
        created_at: string;
        table?: { number: string };
        customer_name?: string;
    }>;
    popularItems: Array<{
        id: number;
        name: string;
        price: number;
        total_sold: number;
    }>;
    tableStats: {
        available: number;
        occupied: number;
        reserved: number;
        cleaning: number;
    };
    [key: string]: unknown;
}

export default function Dashboard({ 
    metrics, 
    recentOrders, 
    popularItems, 
    tableStats 
}: DashboardProps) {
    const formatCurrency = (amount: number) => {
        return new Intl.NumberFormat('en-US', {
            style: 'currency',
            currency: 'USD'
        }).format(amount);
    };

    const getStatusColor = (status: string) => {
        const colors = {
            pending: 'bg-yellow-100 text-yellow-800',
            confirmed: 'bg-blue-100 text-blue-800',
            preparing: 'bg-orange-100 text-orange-800',
            ready: 'bg-green-100 text-green-800',
            completed: 'bg-gray-100 text-gray-800',
            cancelled: 'bg-red-100 text-red-800'
        };
        return colors[status as keyof typeof colors] || 'bg-gray-100 text-gray-800';
    };

    return (
        <AppShell>
            <Head title="Restaurant Dashboard" />
            
            <div className="p-6 space-y-6">
                {/* Header */}
                <div className="flex items-center justify-between">
                    <div>
                        <h1 className="text-3xl font-bold text-gray-900 dark:text-white">
                            🍽️ Restaurant Dashboard
                        </h1>
                        <p className="text-gray-600 dark:text-gray-400 mt-1">
                            Welcome back! Here's what's happening in your restaurant today.
                        </p>
                    </div>
                    <div className="text-sm text-gray-500 dark:text-gray-400">
                        {new Date().toLocaleDateString('en-US', { 
                            weekday: 'long', 
                            year: 'numeric', 
                            month: 'long', 
                            day: 'numeric' 
                        })}
                    </div>
                </div>

                {/* Key Metrics */}
                <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                    <div className="bg-white dark:bg-gray-800 p-6 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700">
                        <div className="flex items-center justify-between">
                            <div>
                                <p className="text-sm text-gray-600 dark:text-gray-400">Today's Orders</p>
                                <p className="text-3xl font-bold text-gray-900 dark:text-white">
                                    {metrics.todayOrders}
                                </p>
                            </div>
                            <div className="w-12 h-12 bg-blue-100 dark:bg-blue-900 rounded-lg flex items-center justify-center">
                                <span className="text-2xl">📋</span>
                            </div>
                        </div>
                    </div>

                    <div className="bg-white dark:bg-gray-800 p-6 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700">
                        <div className="flex items-center justify-between">
                            <div>
                                <p className="text-sm text-gray-600 dark:text-gray-400">Today's Revenue</p>
                                <p className="text-3xl font-bold text-green-600 dark:text-green-400">
                                    {formatCurrency(metrics.todayRevenue)}
                                </p>
                            </div>
                            <div className="w-12 h-12 bg-green-100 dark:bg-green-900 rounded-lg flex items-center justify-center">
                                <span className="text-2xl">💰</span>
                            </div>
                        </div>
                    </div>

                    <div className="bg-white dark:bg-gray-800 p-6 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700">
                        <div className="flex items-center justify-between">
                            <div>
                                <p className="text-sm text-gray-600 dark:text-gray-400">Active Orders</p>
                                <p className="text-3xl font-bold text-orange-600 dark:text-orange-400">
                                    {metrics.activeOrders}
                                </p>
                            </div>
                            <div className="w-12 h-12 bg-orange-100 dark:bg-orange-900 rounded-lg flex items-center justify-center">
                                <span className="text-2xl">🔥</span>
                            </div>
                        </div>
                    </div>

                    <div className="bg-white dark:bg-gray-800 p-6 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700">
                        <div className="flex items-center justify-between">
                            <div>
                                <p className="text-sm text-gray-600 dark:text-gray-400">Available Tables</p>
                                <p className="text-3xl font-bold text-purple-600 dark:text-purple-400">
                                    {metrics.availableTables}
                                </p>
                            </div>
                            <div className="w-12 h-12 bg-purple-100 dark:bg-purple-900 rounded-lg flex items-center justify-center">
                                <span className="text-2xl">🪑</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div className="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    {/* Recent Orders */}
                    <div className="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700">
                        <div className="p-6 border-b border-gray-200 dark:border-gray-700">
                            <h3 className="text-lg font-semibold text-gray-900 dark:text-white">Recent Orders</h3>
                        </div>
                        <div className="p-6 space-y-4">
                            {recentOrders.map((order) => (
                                <div key={order.id} className="flex items-center justify-between p-3 bg-gray-50 dark:bg-gray-700 rounded-lg">
                                    <div>
                                        <p className="font-medium text-gray-900 dark:text-white">
                                            {order.order_number}
                                        </p>
                                        <p className="text-sm text-gray-600 dark:text-gray-400">
                                            {order.table ? `Table ${order.table.number}` : order.customer_name || 'Takeaway'}
                                        </p>
                                    </div>
                                    <div className="text-right">
                                        <p className="font-medium text-gray-900 dark:text-white">
                                            {formatCurrency(order.total_amount)}
                                        </p>
                                        <span className={`inline-block px-2 py-1 text-xs font-medium rounded-full ${getStatusColor(order.status)}`}>
                                            {order.status}
                                        </span>
                                    </div>
                                </div>
                            ))}
                            {recentOrders.length === 0 && (
                                <p className="text-gray-500 dark:text-gray-400 text-center py-8">
                                    No orders yet today
                                </p>
                            )}
                        </div>
                    </div>

                    {/* Table Status Overview */}
                    <div className="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700">
                        <div className="p-6 border-b border-gray-200 dark:border-gray-700">
                            <h3 className="text-lg font-semibold text-gray-900 dark:text-white">Table Status</h3>
                        </div>
                        <div className="p-6">
                            <div className="grid grid-cols-2 gap-4">
                                <div className="text-center p-4 bg-green-50 dark:bg-green-900/20 rounded-lg">
                                    <p className="text-2xl font-bold text-green-600 dark:text-green-400">
                                        {tableStats.available}
                                    </p>
                                    <p className="text-sm text-green-600 dark:text-green-400">Available</p>
                                </div>
                                <div className="text-center p-4 bg-red-50 dark:bg-red-900/20 rounded-lg">
                                    <p className="text-2xl font-bold text-red-600 dark:text-red-400">
                                        {tableStats.occupied}
                                    </p>
                                    <p className="text-sm text-red-600 dark:text-red-400">Occupied</p>
                                </div>
                                <div className="text-center p-4 bg-blue-50 dark:bg-blue-900/20 rounded-lg">
                                    <p className="text-2xl font-bold text-blue-600 dark:text-blue-400">
                                        {tableStats.reserved}
                                    </p>
                                    <p className="text-sm text-blue-600 dark:text-blue-400">Reserved</p>
                                </div>
                                <div className="text-center p-4 bg-yellow-50 dark:bg-yellow-900/20 rounded-lg">
                                    <p className="text-2xl font-bold text-yellow-600 dark:text-yellow-400">
                                        {tableStats.cleaning}
                                    </p>
                                    <p className="text-sm text-yellow-600 dark:text-yellow-400">Cleaning</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {/* Popular Items */}
                {popularItems.length > 0 && (
                    <div className="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700">
                        <div className="p-6 border-b border-gray-200 dark:border-gray-700">
                            <h3 className="text-lg font-semibold text-gray-900 dark:text-white">Popular Items Today</h3>
                        </div>
                        <div className="p-6">
                            <div className="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-5 gap-4">
                                {popularItems.map((item, index) => (
                                    <div key={item.id} className="text-center p-4 bg-gray-50 dark:bg-gray-700 rounded-lg">
                                        <div className="w-8 h-8 bg-orange-500 text-white rounded-full flex items-center justify-center mx-auto mb-2">
                                            {index + 1}
                                        </div>
                                        <p className="font-medium text-gray-900 dark:text-white text-sm mb-1">
                                            {item.name}
                                        </p>
                                        <p className="text-xs text-gray-600 dark:text-gray-400">
                                            {item.total_sold} sold
                                        </p>
                                    </div>
                                ))}
                            </div>
                        </div>
                    </div>
                )}

                {/* Quick Actions */}
                <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                    <button className="p-6 bg-blue-500 hover:bg-blue-600 text-white rounded-xl transition-colors">
                        <div className="text-center">
                            <div className="text-3xl mb-2">➕</div>
                            <p className="font-medium">New Order</p>
                        </div>
                    </button>
                    <button className="p-6 bg-green-500 hover:bg-green-600 text-white rounded-xl transition-colors">
                        <div className="text-center">
                            <div className="text-3xl mb-2">🍕</div>
                            <p className="font-medium">Menu Items</p>
                        </div>
                    </button>
                    <button className="p-6 bg-purple-500 hover:bg-purple-600 text-white rounded-xl transition-colors">
                        <div className="text-center">
                            <div className="text-3xl mb-2">🪑</div>
                            <p className="font-medium">Table Layout</p>
                        </div>
                    </button>
                    <button className="p-6 bg-orange-500 hover:bg-orange-600 text-white rounded-xl transition-colors">
                        <div className="text-center">
                            <div className="text-3xl mb-2">📊</div>
                            <p className="font-medium">Reports</p>
                        </div>
                    </button>
                </div>
            </div>
        </AppShell>
    );
}