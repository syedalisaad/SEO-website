<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('posts', function (Blueprint $table)
        {
            $table->increments('id')->index();
            $table->string('name');
            $table->string('slug')->index('slug');
            $table->mediumText('short_desc')->nullable();
            $table->longText('description');
            $table->string( 'source_image', 100 )->nullable();
            $table->json('extras')->nullable();
            $table->tinyInteger('is_active')->default(1)->index('is_active')->comment('1=Active, 0=In-Active'); //[1=Active, 0=In-Active]
            $table->string( 'type_of', 20 )->default('post')->comment('Posts=post, Blogs=blog etc');
            $table->json('seo_metadata');
            $table->timestamps();
            $table->softDeletes();

            $table->index(['created_at', 'updated_at', 'deleted_at']);
        });

        Schema::create('post_tags', function (Blueprint $table)
        {
            $table->increments('id')->index();
            $table->unsignedInteger('post_id')->index('post_id');
            $table->string('tag_name', 50);
            $table->string('tag_slug', 70)->index('tag_slug');

            //Constraint
            $table->foreign('post_id')->references('id')->on('posts')->onDelete('cascade');
       });

        //Relationship has many "Post - Blog Categories"
        /*Schema::create( 'post_blog_categories', function( Blueprint $table )
        {
            $table->increments('id')->index();
            $table->unsignedInteger( 'post_id' )->index( 'post_id' );
            $table->unsignedBigInteger( 'category_id' )->index( 'category_id' );

            //Constraint
            $table->foreign( 'post_id' )->references( 'id' )->on( 'posts' )->onDelete( 'cascade' );
            $table->foreign( 'category_id' )->references( 'id' )->on( 'blog_categories' )->onDelete( 'cascade' );
        });*/
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        /*Schema::table( 'post_blog_categories', function( $table ) {
            $table->dropForeign( 'post_blog_categories_post_id_foreign' );
            $table->dropForeign( 'post_blog_categories_category_id_foreign' );
        });*/

        Schema::table( 'post_tags', function( $table ) {
            $table->dropForeign( 'post_tags_post_id_foreign' );
        });

        //Schema::dropIfExists('post_blog_categories');
        Schema::dropIfExists('post_tags');
        Schema::dropIfExists('posts');
    }
}
