<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePackagePriceTable extends Migration {

    /**
     * Run the migrations.
     * @return void
     */
    public function up() {

        Schema::create( 'stripe_products', function( Blueprint $table )
        {
            $table->increments( 'id' )->index();
            $table->string( 'name', 100 );
            $table->string( 'stripe_product_price_id' )->nullable();
            $table->text( 'description' )->nullable();
            $table->tinyInteger( 'is_active' )->default(1);
            $table->json('extras')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->index(['created_at', 'updated_at', 'deleted_at']);
        });

        Schema::create( 'stripe_product_details', function( Blueprint $table )
        {
            $table->increments('id'   )->index();
            $table->unsignedInteger( 'stripe_product_id');
            $table->string( 'stripe_product_price_id', 50 )->nullable();
            $table->string( 'name', 100 );
            $table->decimal('price', 8, 2)->default('0.00');
            $table->tinyInteger( 'recurring' )->comment('monthly=1,yearly=2');
            $table->tinyInteger( 'is_active' )->default(1);
            $table->json('extras')->nullable();

            //Constraint
            $table->foreign('stripe_product_id')->references('id')->on('stripe_products')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     * @return void
     */
    public function down() {

        Schema::table( 'stripe_product_details', function( $table ) {
            $table->dropForeign( 'stripe_product_details_stripe_product_id_foreign' );
        });

        Schema::dropIfExists( 'stripe_product_details' );
        Schema::dropIfExists( 'stripe_products' );
    }
}
