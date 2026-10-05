<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('result_grades', function (Blueprint $table) {
            $table->id();

            $table->decimal('starting_percentage', 5, 2);
            $table->decimal('ending_percentage', 5, 2);

            $table->string('grade');

            $table->date('date');

            $table->string('term');

            $table->string('class_group')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('result_grades');
    }
};