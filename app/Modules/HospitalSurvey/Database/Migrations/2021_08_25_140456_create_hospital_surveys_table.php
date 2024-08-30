<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHospitalSurveysTable extends Migration
{

    /*
     *
ALTER TABLE `patient_survey` ADD INDEX(`patient_survey_star_rating`);
ALTER TABLE `hospitals` ADD INDEX(`lat`);
ALTER TABLE `hospitals` ADD INDEX(`lng`);
ALTER TABLE `hospitals` ADD INDEX(`facility_id`);

ALTER TABLE `patient_survey` ADD INDEX(`facility_id`);
ALTER TABLE `patient_complication_and_death` ADD INDEX(`facility_id`);
ALTER TABLE `patient_infections` ADD INDEX(`facility_id`);
ALTER TABLE `patient_timely_and_effective_care` ADD INDEX(`facility_id`);
ALTER TABLE `patient_unplanned_visit` ADD INDEX(`facility_id`);

ALTER TABLE `patient_survey` ADD INDEX(`measure_id`);
ALTER TABLE `patient_complication_and_death` ADD INDEX(`measure_id`);
ALTER TABLE `patient_infections` ADD INDEX(`measure_id`);
ALTER TABLE `patient_timely_and_effective_care` ADD INDEX(`measure_id`);
ALTER TABLE `patient_unplanned_visit` ADD INDEX(`measure_id`);

     * */
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //Hospital General Information - Hospital [ Table - "b2dda626-82d6-5be9-8fb6-cae92dd21248" ]
        //Timely and Effective Care - Hospital [ Table - "cce912ad-182c-593c-882c-1d6395a09617" ]
        //Patient survey (HCAHPS) - Hospital [ Table - "cb0e589e-e78b-541c-baa9-a8a4857cfa17" ]
        Schema::create('hospitals', function (Blueprint $table) {
            $table->increments('id')->index();
            $table->string('facility_id', 50)->index();
            $table->string('facility_name');
            $table->string('slug')->index('slug')->nullable();
            $table->mediumText('short_desc')->nullable();
            $table->longText('description')->nullable();
            $table->string('phone_number', 30)->nullable();
            $table->mediumText('address')->nullable();
            $table->string('county_name', 100)->comment('Serving Patients')->nullable();
            $table->string('state', 100)->nullable();
            $table->string('city', 100)->nullable();
            $table->string('zip_code', 20)->nullable();
            $table->string('hospital_type')->nullable();
            $table->string('hospital_ownership')->nullable();
            $table->string('emergency_services')->nullable();
            $table->string('hospital_overall_rating', 50)->nullable();
            $table->string('ref_url')->nullable();
            $table->json('extras')->nullable();
            $table->tinyInteger('is_active')->default(1)->index('is_active')->comment('1=Active, 0=In-Active');
            $table->tinyInteger('is_api')->default(0)->index('is_api')->comment('1=Api, 0=Custom');
            $table->string('source_image', 100)->nullable();
            $table->json('seo_metadata')->nullable();
            $table->unsignedBigInteger('created_by')->index('created_by');
            $table->timestamps();
            $table->softDeletes();

            $table->index(['created_at', 'updated_at', 'deleted_at']);

            //TODO::cascade issue
            //Constraint
//            $table->foreign('created_by')->references('id')->on('users')->onDelete('cascade');
        });

        /*
         * Healthcare Associated Infections - Hospital
         * - - - - - - - - - - - - - - - - - - - - - -
         *  Measure Case #1: [HAI_1_SIR, HAI_2_SIR, HAI_3_SIR, HAI_4_SIR, HAI_5_SIR, HAI_6_SIR]
         *
         * */
        Schema::create('patient_infections', function (Blueprint $table) {
            $table->increments('id')->index();
            $table->string('facility_id', 50)->index()->nullable();
            $table->string('facility_name')->nullable();;
            $table->string('measure_id', 50)->index();
            $table->string('measure_name');
            $table->string('compared_to_national')->nullable();
            $table->string('score', 50)->nullable();
            $table->string('footnote', 155)->nullable();
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->string('type_of', 20)->default(null)->comment('Hospital=hospital, National=national, State=state etc');
            $table->timestamps();
            //TODO::cascade issue

            //Constraint
//            $table->foreign('hospital_id')->references('id')->on('hospitals')->onDelete('cascade');
        });
        /*
         * Patient survey (HCAHPS) (Patient Satisfaction/Experience) - Hospital
         * - - - - - - - - - - - - - - - - - - - - - -
         *  Measure Case #1: [H_COMP_1_STAR_RATING,H_COMP_2_STAR_RATING,H_COMP_3_STAR_RATING,H_COMP_3_STAR_RATING,H_COMP_5_STAR_RATING,H_COMP_6_STAR_RATING,H_CLEAN_STAR_RATING,H_QUIET_STAR_RATING,H_HSP_STAR_RATING,H_RECMND_STAR_RATING]
         *
         * */
        Schema::create('patient_survey', function (Blueprint $table) {
            $table->increments('id')->index();
            $table->string('facility_id', 50)->index()->nullable();
            $table->string('facility_name')->nullable();;
            $table->string('measure_id', 50)->index();
            $table->string('measure_name');
            $table->string('patient_survey_star_rating')->nullable();
            $table->string('patient_survey_star_rating_footnote')->nullable();
            $table->string('score', 50)->nullable();
            $table->string('question')->nullable();
            $table->string('answer_description')->nullable();
            $table->string('answer_percent')->nullable();
            $table->string('answer_percent_footnote', 155)->nullable();
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->string('type_of', 20)->default(null)->comment('Hospital=hospital, National=national, State=state etc');

            $table->timestamps();
            //TODO::cascade issue

            //Constraint
//            $table->foreign('hospital_id')->references('id')->on('hospitals')->onDelete('cascade');
        });

        /*
         * Complication and death - Hospital
         * - - - - - - - - - - - - - - - - - - - - - -
         *  Measure Case #1: [COMP_HIP_KNEE, MORT_30_AMI, MORT_30_COPD, MORT_30_HF, MORT_30_PN, MORT_30_STK, PSI_03-to-PSI_15,PSI_90]
         *
         * */
        Schema::create('patient_complication_and_death', function (Blueprint $table) {
            $table->increments('id')->index();
            $table->string('facility_id', 50)->index()->nullable();
            $table->string('facility_name')->nullable();;
            $table->string('measure_id', 50)->index();
            $table->string('measure_name');
            $table->string('compared_to_national')->nullable();
            $table->string('score', 50)->nullable();
            $table->float('national_number', 50)->nullable();
            $table->float('number_of_hospitals_worse', 50)->nullable();
            $table->float('number_of_hospitals_same', 50)->nullable();
            $table->float('number_of_hospitals_better', 50)->nullable();
            $table->float('number_of_hospitals_few', 50)->nullable();
            $table->string('footnote', 155)->nullable();
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->string('type_of', 20)->default(null)->comment('Hospital=hospital, National=national, State=state etc');

            $table->timestamps();
            //TODO::cascade issue

            //Constraint
//            $table->foreign('hospital_id')->references('id')->on('hospitals')->onDelete('cascade');
        });


        /*
        * Patient Unplanned Hospital Visits (Patient Readmission) - Hospital
        * - - - - - - - - - - - - - - - - - - - - - -
        *  Measure Case #1: [EDAC_30_AMI,EDAC_30_HF,EDAC_30_PN,OP_32,OP_35_ADM,OP_35_ED,OP_36,READM_30_AMI,READM_30_AMI,READM_30_CABG,READM_30_COPD,READM_30_HF,READM_30_HIP_KNEE,READM_30_HIP_KNEE,READM_30_PN]
        *
        * */
        Schema::create('patient_unplanned_visit', function (Blueprint $table) {
            $table->increments('id')->index();
            $table->string('facility_id', 50)->index()->nullable();
            $table->string('facility_name')->nullable();;
            $table->string('measure_id', 50)->index();
            $table->string('measure_name');
            $table->string('score', 50)->nullable();
            $table->string('compared_to_national')->nullable();
            $table->float('number_of_patients',50)->nullable();
            $table->float('number_of_patients_returned')->nullable();
            $table->float('number_of_hospitals_fewer', 50)->nullable();
            $table->float('number_of_hospitals_average', 50)->nullable();
            $table->float('number_of_hospitals_more', 50)->nullable();
            $table->float('number_of_hospitals_to_small', 50)->nullable();
            $table->string('footnote', 155)->nullable();
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->string('type_of', 20)->default(null)->comment('Hospital=hospital, National=national, State=state etc');

            $table->timestamps();
            //TODO::cascade issue

            //Constraint
//            $table->foreign('hospital_id')->references('id')->on('hospitals')->onDelete('cascade');
        });

        /*
         * Healthcare timely and effective care (speed of care) - Hospital
         * - - - - - - - - - - - - - - - - - - - - - -
         *  Measure Case #1: []
         *
         * */
        Schema::create('patient_timely_and_effective_care', function (Blueprint $table) {
            $table->increments('id')->index();
            $table->string('facility_id', 50)->index()->nullable();
            $table->string('facility_name')->nullable();
            $table->string('measure_id', 50)->index();
            $table->string('measure_name');
            $table->string('score', 50)->nullable();
            $table->string('footnote', 155)->nullable();
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->string('type_of', 20)->default(null)->comment('Hospital=hospital, National=national, State=state etc');

            $table->timestamps();
    //TODO::cascade issue
            //Constraint
//            $table->foreign('hospital_id')->references('id')->on('hospitals')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {

        Schema::table('patient_timely_and_effective_care', function ($table) {
//            $table->dropForeign('patient_timely_and_effective_care_hospital_id_foreign');
        });
        Schema::table('patient_unplanned_visit', function ($table) {
//            $table->dropForeign('patient_unplanned_visit_hospital_id_foreign');
        });
        Schema::table('patient_complication_and_death', function ($table) {
//            $table->dropForeign('patient_complication_and_death_hospital_id_foreign');
        });

        Schema::table('patient_survey', function ($table) {
//            $table->dropForeign('patient_survey_hospital_id_foreign');
        });

        Schema::table('patient_infections', function ($table) {
//            $table->dropForeign('patient_infections_hospital_id_foreign');
        });

        Schema::dropIfExists('patient_timely_and_effective_care');
        Schema::dropIfExists('patient_unplanned_visit');
        Schema::dropIfExists('patient_complication_and_death');
        Schema::dropIfExists('patient_survey');
        Schema::dropIfExists('patient_infections');
        Schema::dropIfExists('hospitals');
    }
}
