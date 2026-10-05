<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('register_students', function (Blueprint $table) {
            $table->id();

            $table->foreignId('class_id')
                ->constrained('classes')
                ->cascadeOnDelete();

            $table->foreignId('student_id')
                ->nullable()
                ->constrained('students')
                ->nullOnDelete();

            // Two "Admission #" fields from the register form UI
            $table->string('admission_no')->nullable();
            $table->string('admission_no_2')->nullable();

            $table->string('form_no')->nullable();
            $table->string('registration_no')->nullable();
            $table->string('roll_no')->nullable();
            $table->decimal('obtain_marks', 10, 2)->nullable();
            $table->date('admission_date')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('register_students');
    }
};
