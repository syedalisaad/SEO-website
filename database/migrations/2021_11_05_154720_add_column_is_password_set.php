<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnIsPasswordSet extends Migration {
    /**
     * Run the migrations.
     * @return void
     */
    public function up() {
        Schema::table( 'users', function( Blueprint $table ) {
            $table->tinyInteger( 'is_password_set' )->default(0)->after( 'password' )->comment('is_password_set=0 first time password change');
        } );
    }

    /**
     * Reverse the migrations.
     * @return void
     */
    public function down() {
        Schema::table( 'users', function( Blueprint $table ) {
            $table->dropColumn( 'is_password_set' );
        } );
    }
}
