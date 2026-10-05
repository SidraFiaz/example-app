<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Rebuild student_marks for the new Student Marks module.
        Schema::dropIfExists('student_marks');

        Schema::create('student_marks', function (Blueprint $table) {
            $table->id();

            $table->foreignId('exam_id')->constrained('exams')->cascadeOnDelete();
            $table->foreignId('student_id')->constrained('students')->cascadeOnDelete();
            $table->foreignId('class_id')->constrained('classes')->cascadeOnDelete();
            $table->foreignId('section_id')->constrained('sections')->cascadeOnDelete();
            $table->foreignId('subject_id')->constrained('subjects')->cascadeOnDelete();
            $table->foreignId('session_id')->nullable()->constrained('academic_sessions')->nullOnDelete();

            $table->decimal('total_marks', 10, 2);
            $table->decimal('obtained_marks', 10, 2);
            $table->date('date')->nullable();

            $table->timestamps();

            $table->unique(
                ['session_id', 'exam_id', 'student_id', 'subject_id'],
                'student_marks_unique_session_exam_student_subject'
            );
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('student_marks');

        Schema::create('student_marks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained()->cascadeOnDelete();
            $table->foreignId('exam_id')->nullable()->constrained('exams')->nullOnDelete();
            $table->foreignId('subject_id')->constrained()->cascadeOnDelete();
            $table->integer('marks');
            $table->integer('total_marks')->nullable();
            $table->timestamps();
        });
    }
};
