<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('transports', function (Blueprint $table) {
            $table->id();

            $table->foreignId('student_id')
                ->constrained('students')
                ->cascadeOnDelete();

            $table->date('date')->nullable();
            $table->decimal('transport_fee', 10, 2)->nullable();
            $table->string('vehicle_no')->nullable();
            $table->string('registration_no')->nullable();
            $table->string('driver_name')->nullable();
            $table->string('stop_name')->nullable();
            $table->string('status');
            $table->text('remarks')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('transports');
    }
};
