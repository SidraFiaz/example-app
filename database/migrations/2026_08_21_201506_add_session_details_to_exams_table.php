<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('exams', function (Blueprint $table) {

            $table->foreignId('session_id')
                ->nullable()
                ->after('id')
                ->constrained('academic_sessions')
                ->nullOnDelete();

            $table->integer('total_marks')
                ->nullable()
                ->after('exam_name');

            $table->date('start_date')
                ->nullable()
                ->after('total_marks');

            $table->date('end_date')
                ->nullable()
                ->after('start_date');

            $table->text('remarks')
                ->nullable()
                ->after('end_date');
        });
    }

    public function down(): void
    {
        Schema::table('exams', function (Blueprint $table) {

            $table->dropForeign(['session_id']);

            $table->dropColumn([
                'session_id',
                'total_marks',
                'start_date',
                'end_date',
                'remarks',
            ]);
        });
    }
};