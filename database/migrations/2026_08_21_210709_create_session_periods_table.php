<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('session_periods', function (Blueprint $table) {

            $table->id();

            $table->foreignId('session_id')
                ->constrained('academic_sessions')
                ->cascadeOnDelete();

            $table->date('period_month');

            $table->boolean('is_active')
                ->default(false);

            $table->timestamps();

            $table->unique([
                'session_id',
                'period_month'
            ]);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('session_periods');
    }
};