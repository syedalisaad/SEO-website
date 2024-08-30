<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table)
        {
            $table->id()->index('id');
            $table->string('user_id')->index('user_id');
            $table->decimal('coupon_amount', 8, 2)->default('0.00');
            $table->decimal('shipping_amount', 8, 2)->default('0.00');
            $table->decimal('total_amount', 8, 2)->default('0.00');
            $table->mediumText('order_note')->nullable();
            $table->json('extras')->nullable();
            $table->string('for_order_type', 20)->default('cash_on_delivery')->index('for_order_type')->comment('cash_on_delivery, pay_by_paypal, pay_by_stripe');
            $table->string('for_order_status', 10)->default('pending')->index('for_order_status')->comment('pending, processing, on-hold, completed, cancelled, refunded, shipped, delivered');
            $table->dateTime('expire_package')->index('expire_package')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->index(['created_at', 'updated_at', 'deleted_at']);
        });

        //For User Details
        Schema::create('order_details', function (Blueprint $table)
        {
            $table->id()->unsigned()->index();
            $table->unsignedBigInteger('order_id')->index('user_id');
            $table->unsignedBigInteger('product_id')->index('product_id');
            $table->decimal('cost_price', 8, 2)->default('0.00');
            $table->decimal('sale_price', 8, 2)->default('0.00');
            $table->unsignedInteger('qty')->index('qty')->default(1);
            $table->mediumText('variations')->nullable();
            $table->json('extras')->nullable();

            //Constraint
            $table->foreign('order_id')->references('id')->on('orders')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table( 'order_details', function( $table ) {
            $table->dropForeign( 'order_details_order_id_foreign' );
        });

        Schema::dropIfExists('order_details');
        Schema::dropIfExists('orders');
    }
}
