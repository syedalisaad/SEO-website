<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //For Users
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('first_name', 40)->nullable();
            $table->string('last_name', 40)->nullable();
            $table->string('email', 100)->index('email');
            $table->string('password');
            $table->string('phone', 30)->index('phone');
            $table->tinyInteger('gender')->default(1)->comment('1=Male, 2=Female, 0=Other');
            $table->string( 'age', 10 )->nullable();
            $table->date( 'date_of_birth' )->nullable();
            $table->string('source_image', 100)->nullable();
            $table->tinyInteger('user_type')->default(1)->index('user_type')->comment('0=Admin, 1=Team, 2=User');
            $table->string('verifytoken', 20)->nullable();
            $table->string('ip_address', 100)->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->tinyInteger('is_active')->default(1)->index('is_active')->comment('1=Active, 0=In-Active');
            $table->json('extras')->nullable();
            $table->rememberToken();
            $table->timestamps();
            $table->softDeletes();

            $table->index(['created_at', 'updated_at', 'deleted_at']);
        });

        //For User Details
        Schema::create('user_details', function (Blueprint $table) {
            $table->increments('id')->index();
            $table->unsignedBigInteger('user_id')->index('user_id');
            $table->integer('hospital_id')->nullable();
            $table->json('extras')->nullable();

           //Constraint
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
       });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table( 'user_details', function( $table ) {
            $table->dropForeign( 'user_details_user_id_foreign' );
        });

        Schema::dropIfExists('user_details');
        Schema::dropIfExists('users');
    }
}
