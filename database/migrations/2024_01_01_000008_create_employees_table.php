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
        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            $table->string('employee_id')->unique()->comment('Employee identification number');
            $table->string('name')->comment('Full name');
            $table->string('email')->unique()->comment('Email address');
            $table->string('phone')->nullable()->comment('Phone number');
            $table->text('address')->nullable()->comment('Home address');
            $table->enum('role', ['admin', 'manager', 'cashier', 'waiter', 'chef', 'cleaner'])->comment('Employee role');
            $table->decimal('hourly_rate', 8, 2)->default(0)->comment('Hourly pay rate');
            $table->date('hire_date')->comment('Date of hire');
            $table->enum('status', ['active', 'inactive', 'terminated'])->default('active')->comment('Employment status');
            $table->json('permissions')->nullable()->comment('Role-based permissions');
            $table->timestamps();
            
            $table->index('employee_id');
            $table->index('role');
            $table->index(['status', 'role']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employees');
    }
};