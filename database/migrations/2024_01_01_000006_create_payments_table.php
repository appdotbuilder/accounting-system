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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained()->onDelete('cascade');
            $table->enum('method', ['cash', 'card', 'digital_wallet', 'bank_transfer'])->comment('Payment method');
            $table->decimal('amount', 10, 2)->comment('Payment amount');
            $table->enum('status', ['pending', 'completed', 'failed', 'refunded'])->default('pending')->comment('Payment status');
            $table->string('transaction_id')->nullable()->comment('External transaction ID');
            $table->text('notes')->nullable()->comment('Payment notes');
            $table->timestamp('processed_at')->nullable()->comment('When payment was processed');
            $table->timestamps();
            
            $table->index(['order_id', 'status']);
            $table->index('method');
            $table->index('transaction_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};