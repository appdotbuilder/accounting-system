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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('order_number')->unique()->comment('Unique order identifier');
            $table->foreignId('table_id')->nullable()->constrained()->onDelete('set null');
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('set null');
            $table->enum('type', ['dine_in', 'takeaway', 'delivery'])->default('dine_in')->comment('Order type');
            $table->enum('status', ['pending', 'confirmed', 'preparing', 'ready', 'served', 'completed', 'cancelled'])->default('pending')->comment('Order status');
            $table->decimal('subtotal', 10, 2)->default(0)->comment('Subtotal before tax and service');
            $table->decimal('tax_amount', 10, 2)->default(0)->comment('Tax amount');
            $table->decimal('service_charge', 10, 2)->default(0)->comment('Service charge');
            $table->decimal('discount_amount', 10, 2)->default(0)->comment('Discount amount');
            $table->decimal('total_amount', 10, 2)->default(0)->comment('Final total amount');
            $table->string('customer_name')->nullable()->comment('Customer name');
            $table->string('customer_phone')->nullable()->comment('Customer phone');
            $table->text('delivery_address')->nullable()->comment('Delivery address for delivery orders');
            $table->text('notes')->nullable()->comment('Special instructions');
            $table->timestamp('estimated_completion')->nullable()->comment('Estimated completion time');
            $table->timestamp('completed_at')->nullable()->comment('Actual completion time');
            $table->timestamps();
            
            $table->index('order_number');
            $table->index('status');
            $table->index(['status', 'type']);
            $table->index(['table_id', 'status']);
            $table->index('created_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};