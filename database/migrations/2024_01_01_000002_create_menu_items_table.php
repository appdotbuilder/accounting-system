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
        Schema::create('menu_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->constrained()->onDelete('cascade');
            $table->string('name')->comment('Menu item name');
            $table->text('description')->nullable()->comment('Menu item description');
            $table->decimal('price', 10, 2)->comment('Base price');
            $table->decimal('cost', 10, 2)->default(0)->comment('Cost to prepare');
            $table->string('image_url')->nullable()->comment('Menu item image URL');
            $table->boolean('is_available')->default(true)->comment('Whether the item is available');
            $table->integer('preparation_time')->default(15)->comment('Preparation time in minutes');
            $table->json('allergens')->nullable()->comment('List of allergens');
            $table->integer('sort_order')->default(0)->comment('Display order within category');
            $table->timestamps();
            
            $table->index('name');
            $table->index(['category_id', 'is_available']);
            $table->index(['is_available', 'sort_order']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('menu_items');
    }
};