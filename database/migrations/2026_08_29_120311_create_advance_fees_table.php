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
        Schema::create('advance_fees', function (Blueprint $table) {

            $table->id();

            // Student
            $table->foreignId('student_id')
                ->constrained('students')
                ->cascadeOnDelete();

            // Advance month
            $table->date('advance_month');

            // Advance fee receive date
            $table->date('payment_date');

            // Total advance amount
            $table->decimal('amount', 10, 2);

            // Amount already adjusted
            $table->decimal('adjusted_amount', 10, 2)
                ->default(0);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('advance_fees');
    }
};