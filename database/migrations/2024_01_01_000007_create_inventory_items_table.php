<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('inventory_items', function (Blueprint $table) {
            $table->id();
            $table->string('name')->comment('Inventory item name');
            $table->text('description')->nullable()->comment('Item description');
            $table->string('unit')->default('pcs')->comment('Unit of measurement');
            $table->decimal('current_stock', 10, 2)->default(0)->comment('Current stock level');
            $table->decimal('minimum_stock', 10, 2)->default(0)->comment('Minimum stock alert level');
            $table->decimal('unit_cost', 10, 2)->default(0)->comment('Cost per unit');
            $table->string('supplier')->nullable()->comment('Primary supplier');
            $table->string('category')->nullable()->comment('Inventory category');
            $table->boolean('is_active')->default(true)->comment('Whether item is active');
            $table->timestamps();
            
            $table->index('name');
            $table->index('category');
            $table->index(['is_active', 'current_stock']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inventory_items');
    }
};