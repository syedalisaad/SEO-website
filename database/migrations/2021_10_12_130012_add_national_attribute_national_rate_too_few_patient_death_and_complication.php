<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNationalAttributeNationalRateTooFewPatientDeathAndComplication extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('patient_complication_and_death', function (Blueprint $table) {

            $table->string('number_of_hospitals_too_few')->nullable();
            $table->string('national_rate')->nullable();
            //
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('patient_complication_and_death', function (Blueprint $table) {
            $table->dropColumn('number_of_hospitals_too_few');
            $table->dropColumn('national_rate');
        });
    }
}
