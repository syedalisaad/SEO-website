<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTypeOfModeToStripeProductsNDetails extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table( 'stripe_products', function( Blueprint $table ) {
            $table->string( 'type_of_mode', 20 )->nullable()->default('sandbox')->after( 'is_active' );
        });

        Schema::table( 'stripe_product_details', function( Blueprint $table ) {
            $table->string( 'type_of_mode', 20 )->nullable()->default('sandbox')->after( 'is_active' );
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('stripe_products', function (Blueprint $table) {
            $table->dropColumn('type_of_mode');
        });

        Schema::table('stripe_product_details', function (Blueprint $table) {
            $table->dropColumn('type_of_mode');
        });
    }
}
