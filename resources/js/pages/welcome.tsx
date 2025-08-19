import { type SharedData } from '@/types';
import { Head, Link, usePage } from '@inertiajs/react';

export default function Welcome() {
    const { auth } = usePage<SharedData>().props;

    return (
        <>
            <Head title="RestaurantPOS - Complete Restaurant Management System">
                <link rel="preconnect" href="https://fonts.bunny.net" />
                <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />
            </Head>
            <div className="min-h-screen bg-gradient-to-br from-orange-50 to-red-50 dark:from-gray-900 dark:to-gray-800">
                {/* Header */}
                <header className="w-full bg-white/80 dark:bg-gray-900/80 backdrop-blur-md border-b border-orange-100 dark:border-gray-700">
                    <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                        <div className="flex justify-between items-center py-4">
                            <div className="flex items-center space-x-3">
                                <div className="w-10 h-10 bg-gradient-to-r from-orange-500 to-red-500 rounded-lg flex items-center justify-center">
                                    <span className="text-white font-bold text-xl">🍽️</span>
                                </div>
                                <h1 className="text-2xl font-bold bg-gradient-to-r from-orange-600 to-red-600 bg-clip-text text-transparent">
                                    RestaurantPOS
                                </h1>
                            </div>
                            <nav className="flex items-center space-x-4">
                                {auth.user ? (
                                    <Link
                                        href={route('dashboard')}
                                        className="bg-orange-500 text-white px-6 py-2 rounded-lg font-medium hover:bg-orange-600 transition-colors shadow-lg"
                                    >
                                        Dashboard
                                    </Link>
                                ) : (
                                    <div className="flex space-x-3">
                                        <Link
                                            href={route('login')}
                                            className="text-gray-700 dark:text-gray-300 hover:text-orange-600 dark:hover:text-orange-400 font-medium transition-colors"
                                        >
                                            Login
                                        </Link>
                                        <Link
                                            href={route('register')}
                                            className="bg-orange-500 text-white px-6 py-2 rounded-lg font-medium hover:bg-orange-600 transition-colors shadow-lg"
                                        >
                                            Get Started
                                        </Link>
                                    </div>
                                )}
                            </nav>
                        </div>
                    </div>
                </header>

                {/* Hero Section */}
                <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
                    <div className="text-center mb-16">
                        <h2 className="text-5xl font-bold text-gray-900 dark:text-white mb-6">
                            Complete Restaurant Management System
                        </h2>
                        <p className="text-xl text-gray-600 dark:text-gray-300 mb-8 max-w-3xl mx-auto">
                            Streamline your cafe and restaurant operations with our comprehensive POS system. 
                            Manage orders, tables, inventory, staff, and finances all in one place.
                        </p>
                        {!auth.user && (
                            <Link
                                href={route('register')}
                                className="bg-gradient-to-r from-orange-500 to-red-500 text-white px-8 py-4 rounded-xl font-bold text-lg hover:from-orange-600 hover:to-red-600 transition-all shadow-xl transform hover:scale-105"
                            >
                                Start Free Trial 🚀
                            </Link>
                        )}
                    </div>

                    {/* Feature Grid */}
                    <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 mb-16">
                        {/* Order Management */}
                        <div className="bg-white dark:bg-gray-800 rounded-2xl p-6 shadow-xl border border-orange-100 dark:border-gray-700">
                            <div className="w-12 h-12 bg-blue-100 dark:bg-blue-900 rounded-xl flex items-center justify-center mb-4">
                                <span className="text-2xl">📋</span>
                            </div>
                            <h3 className="text-xl font-bold text-gray-900 dark:text-white mb-3">Order Management</h3>
                            <ul className="text-gray-600 dark:text-gray-300 space-y-2">
                                <li>✓ Table & takeaway orders</li>
                                <li>✓ Real-time order tracking</li>
                                <li>✓ Multiple payment methods</li>
                                <li>✓ Order status updates</li>
                            </ul>
                        </div>

                        {/* Menu Management */}
                        <div className="bg-white dark:bg-gray-800 rounded-2xl p-6 shadow-xl border border-orange-100 dark:border-gray-700">
                            <div className="w-12 h-12 bg-green-100 dark:bg-green-900 rounded-xl flex items-center justify-center mb-4">
                                <span className="text-2xl">🍕</span>
                            </div>
                            <h3 className="text-xl font-bold text-gray-900 dark:text-white mb-3">Menu Management</h3>
                            <ul className="text-gray-600 dark:text-gray-300 space-y-2">
                                <li>✓ Category organization</li>
                                <li>✓ Dynamic pricing</li>
                                <li>✓ Image attachments</li>
                                <li>✓ Availability control</li>
                            </ul>
                        </div>

                        {/* Table & Reservations */}
                        <div className="bg-white dark:bg-gray-800 rounded-2xl p-6 shadow-xl border border-orange-100 dark:border-gray-700">
                            <div className="w-12 h-12 bg-purple-100 dark:bg-purple-900 rounded-xl flex items-center justify-center mb-4">
                                <span className="text-2xl">🪑</span>
                            </div>
                            <h3 className="text-xl font-bold text-gray-900 dark:text-white mb-3">Table Management</h3>
                            <ul className="text-gray-600 dark:text-gray-300 space-y-2">
                                <li>✓ Visual table layout</li>
                                <li>✓ Reservation system</li>
                                <li>✓ Table status tracking</li>
                                <li>✓ Capacity management</li>
                            </ul>
                        </div>

                        {/* Payment System */}
                        <div className="bg-white dark:bg-gray-800 rounded-2xl p-6 shadow-xl border border-orange-100 dark:border-gray-700">
                            <div className="w-12 h-12 bg-yellow-100 dark:bg-yellow-900 rounded-xl flex items-center justify-center mb-4">
                                <span className="text-2xl">💳</span>
                            </div>
                            <h3 className="text-xl font-bold text-gray-900 dark:text-white mb-3">Payment System</h3>
                            <ul className="text-gray-600 dark:text-gray-300 space-y-2">
                                <li>✓ Cash & card payments</li>
                                <li>✓ Digital wallets</li>
                                <li>✓ Auto-receipt generation</li>
                                <li>✓ Discount management</li>
                            </ul>
                        </div>

                        {/* Inventory & Stock */}
                        <div className="bg-white dark:bg-gray-800 rounded-2xl p-6 shadow-xl border border-orange-100 dark:border-gray-700">
                            <div className="w-12 h-12 bg-red-100 dark:bg-red-900 rounded-xl flex items-center justify-center mb-4">
                                <span className="text-2xl">📦</span>
                            </div>
                            <h3 className="text-xl font-bold text-gray-900 dark:text-white mb-3">Inventory Control</h3>
                            <ul className="text-gray-600 dark:text-gray-300 space-y-2">
                                <li>✓ Stock level monitoring</li>
                                <li>✓ Low-stock alerts</li>
                                <li>✓ Automatic calculations</li>
                                <li>✓ Supplier management</li>
                            </ul>
                        </div>

                        {/* Reports & Analytics */}
                        <div className="bg-white dark:bg-gray-800 rounded-2xl p-6 shadow-xl border border-orange-100 dark:border-gray-700">
                            <div className="w-12 h-12 bg-indigo-100 dark:bg-indigo-900 rounded-xl flex items-center justify-center mb-4">
                                <span className="text-2xl">📊</span>
                            </div>
                            <h3 className="text-xl font-bold text-gray-900 dark:text-white mb-3">Reports & Analytics</h3>
                            <ul className="text-gray-600 dark:text-gray-300 space-y-2">
                                <li>✓ Daily/monthly reports</li>
                                <li>✓ Sales analytics</li>
                                <li>✓ Profit & loss statements</li>
                                <li>✓ Employee performance</li>
                            </ul>
                        </div>
                    </div>

                    {/* Additional Features */}
                    <div className="bg-white dark:bg-gray-800 rounded-3xl p-8 shadow-xl border border-orange-100 dark:border-gray-700 mb-16">
                        <h3 className="text-3xl font-bold text-center text-gray-900 dark:text-white mb-8">
                            Everything You Need to Run Your Restaurant
                        </h3>
                        <div className="grid grid-cols-1 md:grid-cols-2 gap-8">
                            <div>
                                <h4 className="text-xl font-semibold text-gray-900 dark:text-white mb-4">👥 Staff Management</h4>
                                <ul className="text-gray-600 dark:text-gray-300 space-y-2">
                                    <li>• Role-based access control</li>
                                    <li>• Work schedules & attendance</li>
                                    <li>• Employee performance tracking</li>
                                    <li>• Payroll integration</li>
                                </ul>
                            </div>
                            <div>
                                <h4 className="text-xl font-semibold text-gray-900 dark:text-white mb-4">💼 Accounting Module</h4>
                                <ul className="text-gray-600 dark:text-gray-300 space-y-2">
                                    <li>• General ledger management</li>
                                    <li>• Tax reporting & compliance</li>
                                    <li>• Financial statements</li>
                                    <li>• Expense tracking</li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    {/* CTA Section */}
                    {!auth.user && (
                        <div className="text-center bg-gradient-to-r from-orange-500 to-red-500 rounded-3xl p-12 text-white">
                            <h3 className="text-3xl font-bold mb-4">Ready to Transform Your Restaurant?</h3>
                            <p className="text-xl mb-8 opacity-90">
                                Join thousands of restaurant owners who have streamlined their operations with RestaurantPOS
                            </p>
                            <div className="flex flex-col sm:flex-row gap-4 justify-center items-center">
                                <Link
                                    href={route('register')}
                                    className="bg-white text-orange-600 px-8 py-4 rounded-xl font-bold text-lg hover:bg-gray-100 transition-all shadow-xl"
                                >
                                    Start Free Trial
                                </Link>
                                <Link
                                    href={route('login')}
                                    className="border-2 border-white text-white px-8 py-4 rounded-xl font-bold text-lg hover:bg-white hover:text-orange-600 transition-all"
                                >
                                    Sign In
                                </Link>
                            </div>
                        </div>
                    )}
                </div>

                {/* Footer */}
                <footer className="bg-white dark:bg-gray-900 border-t border-orange-100 dark:border-gray-700 py-8">
                    <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
                        <p className="text-gray-600 dark:text-gray-400">
                            Built with ❤️ for restaurant owners worldwide
                        </p>
                    </div>
                </footer>
            </div>
        </>
    );
}