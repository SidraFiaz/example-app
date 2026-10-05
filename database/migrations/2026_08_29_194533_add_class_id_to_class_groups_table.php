<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasColumn('class_groups', 'class_id')) {
            Schema::table('class_groups', function (Blueprint $table) {
                $table->unsignedBigInteger('class_id')->after('name');

                $table->foreign('class_id')
                    ->references('id')
                    ->on('classes')
                    ->onDelete('cascade');
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasColumn('class_groups', 'class_id')) {
            Schema::table('class_groups', function (Blueprint $table) {
                $table->dropForeign(['class_id']);
                $table->dropColumn('class_id');
            });
        }
    }
};