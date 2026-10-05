<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('fee_processes', function (Blueprint $table) {

            $table->id();

            $table->foreignId('student_id')
                  ->constrained()
                  ->onDelete('cascade');

            $table->foreignId('class_id')
                  ->constrained('classes')
                  ->onDelete('cascade');

            $table->foreignId('fee_type_id')
                  ->nullable()
                  ->constrained('fee_types')
                  ->nullOnDelete();

            $table->integer('amount');

            $table->string('month');

            $table->integer('year');

            $table->enum('status', ['Pending', 'Processed'])
                  ->default('Processed');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('fee_processes');
    }
};