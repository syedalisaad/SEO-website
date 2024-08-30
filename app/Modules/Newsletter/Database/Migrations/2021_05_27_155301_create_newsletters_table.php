<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNewslettersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('newsletters', function (Blueprint $table) {
            $table->increments('id')->index();
            $table->string('name', 40)->nullable();
            $table->string('email', 50);
            $table->string('phone', 20)->nullable();
            $table->string('ip_address', 100)->nullable();
            $table->json('extras')->nullable();
            $table->timestamps();

            $table->index(['created_at', 'updated_at']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('newsletters');
    }
}
