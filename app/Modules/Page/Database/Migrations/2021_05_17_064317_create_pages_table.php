<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pages', function (Blueprint $table)
        {
            $table->increments('id')->index();
            $table->string('name', 100);
            $table->string('slug', 120)->index('slug');
            $table->longText('description')->nullable();
            $table->json('extras')->nullable();
            $table->json('seo_metadata')->nullable();
            $table->tinyInteger('is_active')->default(1)->index('is_active')->comment('1=Active, 0=In-Active');
            $table->tinyInteger('is_lock')->default(0)->index('is_lock')->comment('1=Lock, 0=Unlock');
            $table->timestamps();
            $table->softDeletes();

            $table->index(['created_at', 'updated_at', 'deleted_at']);

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pages');
    }
}
