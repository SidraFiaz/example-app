<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('fees', function (Blueprint $table) {
            if (! Schema::hasColumn('fees', 'is_adjustment')) {
                $table->boolean('is_adjustment')->default(false)->after('discount_value');
            }
        });
    }

    public function down(): void
    {
        Schema::table('fees', function (Blueprint $table) {
            if (Schema::hasColumn('fees', 'is_adjustment')) {
                $table->dropColumn('is_adjustment');
            }
        });
    }
};
