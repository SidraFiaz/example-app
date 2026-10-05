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
        Schema::table('admissions', function (Blueprint $table) {

            $table->string('b_form_no')->nullable()->after('family_no');

            $table->date('date_of_birth')->nullable()->after('b_form_no');

            $table->string('father_email')->nullable()->after('father_contact');

            $table->string('father_cnic')->nullable()->after('father_email');

            $table->string('mother_name')->nullable()->after('father_name');

            $table->string('mother_email')->nullable()->after('mother_name');

            $table->string('mother_mobile')->nullable()->after('mother_email');

            $table->string('mother_cnic')->nullable()->after('mother_mobile');

            $table->text('permanent_address')->nullable()->after('mother_cnic');

            $table->string('identification_mark')->nullable()->after('permanent_address');

            $table->string('blood_group')->nullable()->after('identification_mark');

            $table->string('gender')->nullable()->after('blood_group');

            $table->string('student_city')->nullable()->after('gender');

            $table->string('student_country')->nullable()->after('student_city');

            $table->date('status_date')->nullable()->after('student_country');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('admissions', function (Blueprint $table) {

            $table->dropColumn([
                'b_form_no',
                'date_of_birth',
                'father_email',
                'father_cnic',
                'mother_name',
                'mother_email',
                'mother_mobile',
                'mother_cnic',
                'permanent_address',
                'identification_mark',
                'blood_group',
                'gender',
                'student_city',
                'student_country',
                'status_date',
            ]);
        });
    }
};