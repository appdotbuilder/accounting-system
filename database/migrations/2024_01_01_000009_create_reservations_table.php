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
        Schema::create('reservations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('table_id')->constrained()->onDelete('cascade');
            $table->string('customer_name')->comment('Customer name');
            $table->string('customer_phone')->comment('Customer phone');
            $table->string('customer_email')->nullable()->comment('Customer email');
            $table->integer('party_size')->comment('Number of guests');
            $table->datetime('reservation_date')->comment('Date and time of reservation');
            $table->integer('duration_minutes')->default(120)->comment('Expected duration in minutes');
            $table->enum('status', ['confirmed', 'seated', 'completed', 'cancelled', 'no_show'])->default('confirmed')->comment('Reservation status');
            $table->text('special_requests')->nullable()->comment('Special requests');
            $table->text('notes')->nullable()->comment('Internal notes');
            $table->timestamps();
            
            $table->index(['table_id', 'reservation_date']);
            $table->index('status');
            $table->index('customer_phone');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reservations');
    }
};