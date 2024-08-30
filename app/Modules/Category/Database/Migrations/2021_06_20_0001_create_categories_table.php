<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create( 'categories', function( Blueprint $table ) {
            $table->id()->index( 'id' );
            $table->unsignedBigInteger( 'parent_id' )->index( 'parent_id' )->nullable();
            $table->string( 'name', 100 );
            $table->string( 'slug', 120 )->index( 'slug' );
            $table->mediumText('short_desc')->nullable();
            $table->string( 'source_image', 100 )->nullable();
            $table->tinyInteger( 'is_active' )->default( 1 )->index( 'is_active' )->comment( '1=Active, 0=In-Active' );
            $table->json('extras')->nullable();
            $table->json( 'seo_metadata' )->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->index( [ 'created_at', 'updated_at', 'deleted_at' ] );

            $table->foreign( 'parent_id' )->references( 'id' )->on( 'categories' )->onDelete( 'cascade' );
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table( 'categories', function( $table ) {
            $table->dropForeign( 'categories_parent_id_foreign' );
        });

        Schema::dropIfExists('categories');
    }
}
