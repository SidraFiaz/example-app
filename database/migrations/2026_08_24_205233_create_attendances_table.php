<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('attendances', function (Blueprint $table) {

            $table->id();

            $table->foreignId('student_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->foreignId('class_id')
                ->constrained('classes')
                ->cascadeOnDelete();

            $table->foreignId('section_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->foreignId('session_id')
                ->nullable()
                ->constrained('academic_sessions')
                ->nullOnDelete();

            $table->date('attendance_date');

            $table->enum('status', [
                'present',
                'absent',
                'half_day',
                'leave',
                'late'
            ]);

            $table->timestamps();

        });
    }


    public function down(): void
    {
        Schema::dropIfExists('attendances');
    }
};