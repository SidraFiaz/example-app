<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::table('fees', function (Blueprint $table) {

        $table->string('description')->nullable();

        $table->string('fee_type')
              ->default('Normal');

        $table->string('discount_type')
              ->nullable();

        $table->integer('discount_value')
              ->nullable();

    });
}

    /**
     * Reverse the migrations.
     */
   public function down()
{
    Schema::table('fees', function (Blueprint $table) {

        $table->dropColumn([
            'description',
            'fee_type',
            'discount_type',
            'discount_value'
        ]);

    });
}
};
