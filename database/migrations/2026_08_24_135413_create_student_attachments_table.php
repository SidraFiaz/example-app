<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('student_attachments', function (Blueprint $table) {

            $table->id();

            // Student / Admission
            $table->foreignId('admission_id')
                ->constrained('admissions')
                ->cascadeOnDelete();

            // Attachment information
            $table->string('attachment_name');

            $table->text('remarks')->nullable();

            // Uploaded file path
            $table->string('file_path')->nullable();

            // Certificate given or not
            $table->boolean('certificate_given')
                ->default(false);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('student_attachments');
    }
};