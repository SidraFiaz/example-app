<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('student_marks', function (Blueprint $table) {
            // Full combination used by Student Marks duplicate prevention.
            // Keep the older unique index (MySQL may use it for FKs).
            $table->unique(
                ['student_id', 'exam_id', 'session_id', 'class_id', 'section_id', 'subject_id'],
                'student_marks_unique_full_combination'
            );
        });
    }

    public function down(): void
    {
        Schema::table('student_marks', function (Blueprint $table) {
            $table->dropUnique('student_marks_unique_full_combination');
        });
    }
};
