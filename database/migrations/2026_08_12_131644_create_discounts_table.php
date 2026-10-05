<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('discounts', function (Blueprint $table) {
            $table->id();

            // Discount kis class ke liye hai
            $table->foreignId('class_id')
                ->nullable()
                ->constrained('classes')
                ->cascadeOnDelete();

            // Discount kis student ke liye hai
            $table->foreignId('student_id')
                ->nullable()
                ->constrained('students')
                ->cascadeOnDelete();

            // Discount type: Fixed ya Percentage
            $table->enum('discount_type', ['fixed', 'percentage']);

            // Discount amount/value
            $table->decimal('discount_value', 10, 2);

            // Active / Inactive
            $table->enum('status', ['Active', 'Inactive'])
                ->default('Active');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('discounts');
    }
};