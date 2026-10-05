<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('fee_collections', function (Blueprint $table) {
            $table->decimal('amount_paid', 12, 2)
                ->nullable()
                ->after('amount');
        });

        // Existing Paid rows are treated as fully paid; Unpaid as unpaid.
        DB::table('fee_collections')
            ->whereRaw('LOWER(status) = ?', ['paid'])
            ->update([
                'amount_paid' => DB::raw('amount'),
            ]);

        DB::table('fee_collections')
            ->where(function ($query) {
                $query->whereNull('status')
                    ->orWhereRaw('LOWER(status) != ?', ['paid']);
            })
            ->whereNull('amount_paid')
            ->update([
                'amount_paid' => 0,
            ]);
    }

    public function down(): void
    {
        Schema::table('fee_collections', function (Blueprint $table) {
            $table->dropColumn('amount_paid');
        });
    }
};
