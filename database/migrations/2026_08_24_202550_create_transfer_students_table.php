<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('transfer_students', function (Blueprint $table) {

            $table->id();

            // Student
            $table->foreignId('admission_id')
                ->constrained()
                ->cascadeOnDelete();

            // Old class & section
            $table->foreignId('old_class_id')
                ->nullable()
                ->constrained('classes')
                ->nullOnDelete();

            $table->foreignId('old_section_id')
                ->nullable()
                ->constrained('sections')
                ->nullOnDelete();


            // New branch, class & section
            $table->foreignId('branch_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->foreignId('new_class_id')
                ->constrained('classes')
                ->cascadeOnDelete();

            $table->foreignId('new_section_id')
                ->constrained('sections')
                ->cascadeOnDelete();


            $table->date('transfer_date')
                ->nullable();

            $table->text('reason')
                ->nullable();

            $table->timestamps();

        });
    }


    public function down(): void
    {
        Schema::dropIfExists('transfer_students');
    }
};