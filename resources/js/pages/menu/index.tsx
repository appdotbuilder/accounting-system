import React from 'react';
import { Head, Link } from '@inertiajs/react';
import { AppShell } from '@/components/app-shell';

interface MenuItem {
    id: number;
    name: string;
    description: string;
    price: number;
    is_available: boolean;
    preparation_time: number;
    category: {
        name: string;
    };
}

interface Category {
    id: number;
    name: string;
    is_active: boolean;
}

interface MenuIndexProps {
    menuItems: {
        data: MenuItem[];
        links: Array<{
            url: string | null;
            label: string;
            active: boolean;
        }>;
    };
    categories: Category[];
    [key: string]: unknown;
}

export default function MenuIndex({ menuItems, categories }: MenuIndexProps) {
    const formatCurrency = (amount: number) => {
        return new Intl.NumberFormat('en-US', {
            style: 'currency',
            currency: 'USD'
        }).format(amount);
    };

    return (
        <AppShell>
            <Head title="Menu Management" />
            
            <div className="p-6">
                {/* Header */}
                <div className="flex items-center justify-between mb-6">
                    <div>
                        <h1 className="text-3xl font-bold text-gray-900 dark:text-white">
                            🍕 Menu Management
                        </h1>
                        <p className="text-gray-600 dark:text-gray-400 mt-1">
                            Manage your restaurant menu items and categories
                        </p>
                    </div>
                    <div className="flex space-x-3">
                        <Link
                            href="/categories/create"
                            className="bg-green-500 hover:bg-green-600 text-white px-6 py-2 rounded-lg font-medium transition-colors"
                        >
                            ➕ New Category
                        </Link>
                        <Link
                            href={route('menu.create')}
                            className="bg-blue-500 hover:bg-blue-600 text-white px-6 py-2 rounded-lg font-medium transition-colors"
                        >
                            ➕ New Menu Item
                        </Link>
                    </div>
                </div>

                {/* Categories Overview */}
                {categories.length > 0 && (
                    <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
                        {categories.map((category) => (
                            <div key={category.id} className="bg-white dark:bg-gray-800 p-4 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700">
                                <h3 className="font-semibold text-gray-900 dark:text-white">
                                    {category.name}
                                </h3>
                                <div className={`inline-flex px-2 py-1 text-xs rounded-full mt-2 ${
                                    category.is_active 
                                        ? 'bg-green-100 text-green-800' 
                                        : 'bg-red-100 text-red-800'
                                }`}>
                                    {category.is_active ? 'Active' : 'Inactive'}
                                </div>
                            </div>
                        ))}
                    </div>
                )}

                {/* Menu Items */}
                <div className="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700">
                    <div className="p-6 border-b border-gray-200 dark:border-gray-700">
                        <h2 className="text-xl font-semibold text-gray-900 dark:text-white">
                            Menu Items
                        </h2>
                    </div>
                    
                    <div className="p-6">
                        {menuItems.data.length > 0 ? (
                            <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                                {menuItems.data.map((item) => (
                                    <div key={item.id} className="border border-gray-200 dark:border-gray-600 rounded-lg p-4 hover:shadow-md transition-shadow">
                                        <div className="flex justify-between items-start mb-2">
                                            <h3 className="font-semibold text-gray-900 dark:text-white">
                                                {item.name}
                                            </h3>
                                            <span className={`inline-flex px-2 py-1 text-xs rounded-full ${
                                                item.is_available 
                                                    ? 'bg-green-100 text-green-800' 
                                                    : 'bg-red-100 text-red-800'
                                            }`}>
                                                {item.is_available ? 'Available' : 'Unavailable'}
                                            </span>
                                        </div>
                                        
                                        <p className="text-sm text-gray-600 dark:text-gray-400 mb-3">
                                            {item.description}
                                        </p>
                                        
                                        <div className="flex justify-between items-center mb-3">
                                            <span className="text-lg font-bold text-green-600 dark:text-green-400">
                                                {formatCurrency(item.price)}
                                            </span>
                                            <span className="text-sm text-gray-500 dark:text-gray-400">
                                                {item.preparation_time} min
                                            </span>
                                        </div>
                                        
                                        <div className="flex justify-between items-center">
                                            <span className="inline-flex px-2 py-1 text-xs bg-blue-100 text-blue-800 rounded-full">
                                                {item.category.name}
                                            </span>
                                            <div className="flex space-x-2">
                                                <Link
                                                    href={route('menu.show', item.id)}
                                                    className="text-blue-600 hover:text-blue-800 text-sm font-medium"
                                                >
                                                    View
                                                </Link>
                                                <Link
                                                    href={route('menu.edit', item.id)}
                                                    className="text-green-600 hover:text-green-800 text-sm font-medium"
                                                >
                                                    Edit
                                                </Link>
                                            </div>
                                        </div>
                                    </div>
                                ))}
                            </div>
                        ) : (
                            <div className="text-center py-12">
                                <div className="text-gray-400 text-6xl mb-4">🍽️</div>
                                <h3 className="text-lg font-medium text-gray-900 dark:text-white mb-2">
                                    No menu items yet
                                </h3>
                                <p className="text-gray-500 dark:text-gray-400 mb-6">
                                    Start building your menu by adding your first item.
                                </p>
                                <Link
                                    href={route('menu.create')}
                                    className="bg-blue-500 hover:bg-blue-600 text-white px-6 py-2 rounded-lg font-medium transition-colors"
                                >
                                    Add Menu Item
                                </Link>
                            </div>
                        )}
                    </div>
                    
                    {/* Pagination */}
                    {menuItems.links.length > 3 && (
                        <div className="bg-white dark:bg-gray-800 px-4 py-3 border-t border-gray-200 dark:border-gray-700">
                            <div className="flex items-center justify-between">
                                <div className="flex space-x-1">
                                    {menuItems.links.map((link, index) => (
                                        link.url ? (
                                            <Link
                                                key={index}
                                                href={link.url}
                                                className={`px-3 py-2 text-sm font-medium rounded-md ${
                                                    link.active
                                                        ? 'bg-blue-500 text-white'
                                                        : 'text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200'
                                                }`}
                                                dangerouslySetInnerHTML={{ __html: link.label }}
                                            />
                                        ) : (
                                            <span
                                                key={index}
                                                className="px-3 py-2 text-sm font-medium text-gray-300 dark:text-gray-600"
                                                dangerouslySetInnerHTML={{ __html: link.label }}
                                            />
                                        )
                                    ))}
                                </div>
                            </div>
                        </div>
                    )}
                </div>
            </div>
        </AppShell>
    );
}