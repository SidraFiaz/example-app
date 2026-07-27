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
        Schema::create('class_fees', function (Blueprint $table) {

            $table->id();

            $table->foreignId('class_id')
                  ->constrained('classes')
                  ->cascadeOnDelete();

            $table->foreignId('fee_type_id')
                  ->constrained('fee_types')
                  ->cascadeOnDelete();

            $table->decimal('amount', 10, 2);

            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('class_fees');
    }
};