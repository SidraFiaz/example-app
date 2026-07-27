<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('fees', function (Blueprint $table) {

            if (!Schema::hasColumn('fees', 'fee_type_id')) {

                $table->foreignId('fee_type_id')
                    ->after('class_id')
                    ->constrained('fee_types')
                    ->cascadeOnDelete();

            }

        });
    }

    public function down(): void
    {
        Schema::table('fees', function (Blueprint $table) {

            if (Schema::hasColumn('fees', 'fee_type_id')) {
                $table->dropForeign(['fee_type_id']);
                $table->dropColumn('fee_type_id');
            }

        });
    }
};