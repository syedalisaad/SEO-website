<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnInvoiceIdSubscriptionId extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->string('invoice_id')->nullable()->after('user_id');
            $table->string('subscription_id')->nullable()->after('invoice_id');
            $table->timestamp('current_period_start')->nullable()->after('subscription_id');
            $table->timestamp('current_period_end')->nullable()->after('current_period_start');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn('invoice_id');
            $table->dropColumn('subscription_id');
            $table->dropColumn('current_period_start');
            $table->dropColumn('current_period_end');
        });
    }
}
