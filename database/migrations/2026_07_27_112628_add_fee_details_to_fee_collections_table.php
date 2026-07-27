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
    Schema::table('fee_collections', function (Blueprint $table) {

     $table->foreignId('fee_type_id')
    ->nullable()
    ->after('student_id')
    ->constrained('fee_types')
    ->nullOnDelete();

$table->string('month')->after('payment_date');

$table->integer('year')->after('month');

    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
{
    Schema::table('fee_collections', function (Blueprint $table) {

        $table->dropForeign(['fee_type_id']);
        $table->dropColumn([
            'fee_type_id',
            'month',
            'year'
        ]);

    });
}
};
