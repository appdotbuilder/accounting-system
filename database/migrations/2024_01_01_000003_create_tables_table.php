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
        Schema::create('tables', function (Blueprint $table) {
            $table->id();
            $table->string('number')->unique()->comment('Table number or identifier');
            $table->integer('capacity')->comment('Number of seats');
            $table->enum('status', ['available', 'occupied', 'reserved', 'cleaning'])->default('available')->comment('Current table status');
            $table->decimal('position_x', 8, 2)->nullable()->comment('X coordinate for layout');
            $table->decimal('position_y', 8, 2)->nullable()->comment('Y coordinate for layout');
            $table->text('notes')->nullable()->comment('Special notes about the table');
            $table->boolean('is_active')->default(true)->comment('Whether the table is active');
            $table->timestamps();
            
            $table->index('number');
            $table->index('status');
            $table->index(['status', 'is_active']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tables');
    }
};