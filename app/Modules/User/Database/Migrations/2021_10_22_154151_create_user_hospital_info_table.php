<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserHospitalInfoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_hospital_info', function (Blueprint $table) {

            $table->increments( 'id' )->index();
            $table->unsignedBigInteger( 'user_id' )->index( 'user_id' );
            $table->integer( 'hospital_id' )->index( 'hospital_id' );
            $table->string( 'name' );
            $table->mediumText( 'short_desc' )->nullable();
            $table->longText( 'description' )->nullable();
            $table->string( 'phone_number', 30 )->nullable();
            $table->string( 'logo_image', 100 )->nullable();
            $table->string( 'right_image', 100 )->nullable();
            $table->mediumText( 'address' )->nullable();
            $table->string( 'ref_url' )->nullable();
            $table->tinyInteger('is_approved')->default(0)->index('is_approved');
            $table->tinyInteger('is_publish')->default(0)->index('is_publish');
            $table->json( 'extras' )->nullable();

            //Constraint
            $table->foreign( 'user_id' )->references( 'id' )->on( 'users' )->onDelete( 'cascade' );
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table( 'user_hospital_info', function( $table ) {
            $table->dropForeign( 'user_hospital_info_user_id_foreign' );
        });

        Schema::dropIfExists('user_hospital_info');
    }
}
