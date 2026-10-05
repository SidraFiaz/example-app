<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('academic_sessions')) {
            return;
        }

        if (! Schema::hasColumn('academic_sessions', 'session_from')) {
            Schema::table('academic_sessions', function (Blueprint $table) {
                $table->date('session_from')->nullable()->after('name');
            });
        }

        if (! Schema::hasColumn('academic_sessions', 'session_to')) {
            Schema::table('academic_sessions', function (Blueprint $table) {
                $table->date('session_to')->nullable()->after('session_from');
            });
        }
    }

    public function down(): void
    {
        if (! Schema::hasTable('academic_sessions')) {
            return;
        }

        $columns = [];

        if (Schema::hasColumn('academic_sessions', 'session_from')) {
            $columns[] = 'session_from';
        }

        if (Schema::hasColumn('academic_sessions', 'session_to')) {
            $columns[] = 'session_to';
        }

        if ($columns !== []) {
            Schema::table('academic_sessions', function (Blueprint $table) use ($columns) {
                $table->dropColumn($columns);
            });
        }
    }
};
