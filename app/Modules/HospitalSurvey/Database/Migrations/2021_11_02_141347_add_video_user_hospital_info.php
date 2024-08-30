<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddVideoUserHospitalInfo extends Migration {
    /**
     * Run the migrations.
     * @return void
     */
    public function up() {
        Schema::table( 'user_hospital_info', function( Blueprint $table ) {
            $table->string( 'video_one' )->nullable();
            $table->string( 'video_two' )->nullable();
            $table->string( 'video_three' )->nullable();
            //
        } );
    }

    /**
     * Reverse the migrations.
     * @return void
     */
    public function down() {
        Schema::table( 'user_hospital_info', function( Blueprint $table ) {
            $table->dropColumn( 'video_one' );
            $table->dropColumn( 'video_two' );
            $table->dropColumn( 'video_three' );
        } );
    }
}
