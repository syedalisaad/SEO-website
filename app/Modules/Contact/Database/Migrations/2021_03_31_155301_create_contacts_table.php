<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContactsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contacts', function (Blueprint $table) {
            $table->increments('id')->index();
            $table->string('name', 40);
            $table->string('email', 50);
            $table->string('phone', 20)->nullable();
            $table->string('subject', 50)->nullable();
            $table->mediumText('message')->nullable();
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
        Schema::dropIfExists('contacts');
    }
}
