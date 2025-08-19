<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\OrderController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/health-check', function () {
    return response()->json([
        'status' => 'ok',
        'timestamp' => now()->toISOString(),
    ]);
})->name('health-check');

Route::get('/', function () {
    return Inertia::render('welcome');
})->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
    // Main dashboard
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Order management
    Route::resource('orders', OrderController::class);
    
    // Menu management
    Route::resource('menu', MenuController::class);
    
    // Additional restaurant routes can be added here
    // Route::resource('tables', TableController::class);
    // Route::resource('inventory', InventoryController::class);
    // Route::resource('employees', EmployeeController::class);
    // Route::resource('reports', ReportController::class);
});

require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
