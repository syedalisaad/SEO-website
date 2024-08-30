<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLogApiTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        /*cron job api*/
        Schema::create('api_logs', function (Blueprint $table) {

            $table->id();
            $table->string('type_of', 50)->comment('GENERAL_HOSPITAL=Hospital,INFECTION=PatientInfection,SURVEY=PatientSurvey,SURVEY_CANCER=PatientSurvey,COMPLICATION_AND_DEATH=PatientComplicationAndDeath,UNPLANNED_VISITS=PatientUnplannedVisit,TIMELY_AND_EFFECTIVE=PatientTimelyAndEffectiveCare');
            $table->string('patient_category', 50)->nullable();
            $table->integer('offset');
            $table->tinyInteger('is_active')->default(0);
            $table->string('status',50);
            $table->string('error_message')->nullable();
            $table->tinyInteger('count_error')->default(0)->comment('if error is 2 then it shop the this table job');
            $table->timestamps();
            $table->index(['created_at', 'updated_at']);

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {

        Schema::table('api_logs', function ($table) {
        });

        Schema::dropIfExists('api_logs');
    }
}
