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
    Schema::table('class_fees', function (Blueprint $table) {

        $table->string('fee_type')->after('fee_type_id');

        $table->enum('status', ['Active', 'Inactive'])
              ->default('Active')
              ->after('amount');

    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
{
    Schema::table('class_fees', function (Blueprint $table) {

        $table->dropColumn(['fee_type', 'status']);

    });
}
};
