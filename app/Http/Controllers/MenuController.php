<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreMenuItemRequest;
use App\Http\Requests\UpdateMenuItemRequest;
use App\Models\MenuItem;
use App\Models\Category;
use Inertia\Inertia;

class MenuController extends Controller
{
    /**
     * Display a listing of menu items.
     */
    public function index()
    {
        $menuItems = MenuItem::with('category')
            ->orderBy('category_id')
            ->orderBy('sort_order')
            ->paginate(20);
        
        $categories = Category::active()->orderBy('sort_order')->get();
        
        return Inertia::render('menu/index', [
            'menuItems' => $menuItems,
            'categories' => $categories
        ]);
    }

    /**
     * Show the form for creating a new menu item.
     */
    public function create()
    {
        $categories = Category::active()->orderBy('sort_order')->get();
        
        return Inertia::render('menu/create', [
            'categories' => $categories
        ]);
    }

    /**
     * Store a newly created menu item in storage.
     */
    public function store(StoreMenuItemRequest $request)
    {
        $menuItem = MenuItem::create($request->validated());

        return redirect()->route('menu.show', $menuItem)
            ->with('success', 'Menu item created successfully.');
    }

    /**
     * Display the specified menu item.
     */
    public function show(MenuItem $menuItem)
    {
        $menuItem->load('category');
        
        return Inertia::render('menu/show', [
            'menuItem' => $menuItem
        ]);
    }

    /**
     * Show the form for editing the specified menu item.
     */
    public function edit(MenuItem $menuItem)
    {
        $categories = Category::active()->orderBy('sort_order')->get();
        
        return Inertia::render('menu/edit', [
            'menuItem' => $menuItem,
            'categories' => $categories
        ]);
    }

    /**
     * Update the specified menu item in storage.
     */
    public function update(UpdateMenuItemRequest $request, MenuItem $menuItem)
    {
        $menuItem->update($request->validated());

        return redirect()->route('menu.show', $menuItem)
            ->with('success', 'Menu item updated successfully.');
    }

    /**
     * Remove the specified menu item from storage.
     */
    public function destroy(MenuItem $menuItem)
    {
        $menuItem->delete();

        return redirect()->route('menu.index')
            ->with('success', 'Menu item deleted successfully.');
    }
}