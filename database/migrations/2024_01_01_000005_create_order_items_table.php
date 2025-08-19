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
        Schema::create('order_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained()->onDelete('cascade');
            $table->foreignId('menu_item_id')->constrained()->onDelete('cascade');
            $table->integer('quantity')->comment('Quantity ordered');
            $table->decimal('unit_price', 10, 2)->comment('Price per unit at time of order');
            $table->decimal('total_price', 10, 2)->comment('Total price for this line item');
            $table->text('special_instructions')->nullable()->comment('Special instructions for this item');
            $table->enum('status', ['pending', 'confirmed', 'preparing', 'ready', 'served'])->default('pending')->comment('Status of this line item');
            $table->timestamps();
            
            $table->index(['order_id', 'status']);
            $table->index('menu_item_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_items');
    }
};