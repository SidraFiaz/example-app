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
       Schema::table('fee_processes', function (Blueprint $table) {
    $table->string('session')->nullable();
    $table->unsignedBigInteger('section_id')->nullable();
    $table->date('issue_date')->nullable();
    $table->date('due_date')->nullable();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
       Schema::table('fee_processes', function (Blueprint $table) {
    $table->dropColumn([
        'session',
        'section_id',
        'issue_date',
        'due_date',
    ]);
});
    }
};
