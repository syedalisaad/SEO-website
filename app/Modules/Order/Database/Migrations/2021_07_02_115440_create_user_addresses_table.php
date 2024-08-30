<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserAddressesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //For User Details
        Schema::create('user_addresses', function (Blueprint $table)
        {
            $table->id()->unsigned()->index();
            $table->unsignedBigInteger('user_id')->index('user_id');
            $table->string('first_name', 40);
            $table->string('last_name', 40);
            $table->string('email', 100);
            $table->string('phone', 30);
            $table->string('company', 30)->nullable();
            $table->string('country', 20);
            $table->string('state', 20)->nullable();
            $table->string('city', 20)->nullable();
            $table->string('zipcode', 10)->nullable();
            $table->mediumText('address')->nullable();
            $table->string('for_type', 10)->default('billing')->index('for_type')->comment('billing, shipping');
            $table->json('extras')->nullable();
            $table->string('ip_address', 100)->nullable();
            $table->tinyInteger('is_default')->default(1)->index('is_default')->comment('1=Active, 0=In-Active');
            $table->timestamps();
            $table->softDeletes();

            $table->index(['created_at', 'updated_at', 'deleted_at']);

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
        Schema::table( 'user_addresses', function( $table ) {
            $table->dropForeign( 'user_addresses_user_id_foreign' );
        });

        Schema::dropIfExists('user_addresses');
    }
}
