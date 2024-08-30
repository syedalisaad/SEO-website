<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterTableUserHospitalInfoShareImage extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('user_hospital_info', function (Blueprint $table) {
            $table->string( 'share_image', 100 )->nullable()->after('right_image');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('user_hospital_info', function (Blueprint $table) {
            $table->dropColumn( 'share_image' );
        });
    }
}
