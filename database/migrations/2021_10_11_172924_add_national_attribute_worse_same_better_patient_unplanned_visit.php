<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNationalAttributeWorseSameBetterPatientUnplannedVisit extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('patient_unplanned_visit', function (Blueprint $table) {

            $table->string('number_of_hospitals_worse')->nullable();
            $table->string('number_of_hospitals_same')->nullable();
            $table->string('number_of_hospitals_better')->nullable();
            $table->string('number_of_hospitals_too_few')->nullable();
            $table->string('national_rate')->nullable();
            $table->string('number_of_hospitals_too_small')->nullable();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('patient_unplanned_visit', function (Blueprint $table) {
             $table->dropColumn('number_of_hospitals_worse');
             $table->dropColumn('number_of_hospitals_same');
             $table->dropColumn('number_of_hospitals_better');
             $table->dropColumn('number_of_hospitals_too_few');
             $table->dropColumn('national_rate');
             $table->dropColumn('number_of_hospitals_too_small');

        });
    }
}
