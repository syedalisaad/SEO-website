<?php namespace App\Modules\Blog\Respository;

use \App\Models\Post;
use \App\Models\PostTag;

use App\Support\Traits\{
    UploadableTrait,
    StorageableTrait
};

class BlogRespository
{
    use UploadableTrait, StorageableTrait;

    private $model = null;

    public function __construct( Post $post ) {
        $this->model = $post;
    }

    /*
    * Posts - Create Or Update
    *
    * @param Request $request
    * @param Post $post
    */
   public function createOrUpdate( $request, Post $post )
   {
       $post->name         = $request->name;
       $post->slug         = \Str::slug( $request->name, '-' );
       $post->short_desc   = $request->short_desc;
       $post->description  = $request->description;
       $post->is_active    = (int) $request->is_active;
       $post->type_of      = Post::$TYPE_OF_BLOG;
       $post->seo_metadata = $request->seo_metadata ?: null;
       $post->extras       = $request->extras ?: null;

       /**
        * Creating Gallery
        *
        * @array \Illuminate\Http\Request  $request
        */
       if ($request->hasFile('source_image'))
       {
           $file       = $request->file('source_image');
           $file_name  = $request->name;

           // Make a folder path where file will be stored [ Folder + Storage = public + Disk = local]
           $this->findOrCreateDirectory( Post::$storage_disk );

           // Delete a file path where image will be stored [ file name + Media + Storage = public + Disk = local]
           $this->fileDeleteFromDisk($post->source_image, Post::$storage_disk);

           // Make a file path where file will be stored [ file name + file extension]
           $post->source_image = \Str::slug( $file_name ) . '_'. time(). "." . $file->getClientOriginalExtension();

           // Store a file path where image will be stored [ File Closure + file name + Media + Storage = public + Disk = local]
           $this->uploadOne($file, Post::$storage_disk, $post->source_image );
       }
       $post->save();

       //Sync Post - Tags
       if ( $request->post_tags && count( $request->post_tags ) ) {
           $this->_createOrUpdateTags( $request->post_tags, $post );
       }

       return $post;
   }

    private function _createOrUpdateTags( $tags, Post $post )
    {
        if ( $post->tags->count() )
        {
            $exists_tags = $post->tags->pluck( 'tag_name' )->toArray();
            $remove_tags = array_diff( $exists_tags, $tags );
            $tags        = array_diff( $tags, $exists_tags );

            if ( count( $remove_tags ) ) {
                PostTag::wherePostId( $post->id )->whereIn( 'tag_name', $remove_tags )->delete();
            }
        }

        $tags = array_map( function( $v ) use ( $post ) {
            return [ 'post_id' => $post->id, 'tag_name' => $v, 'tag_slug' => \Str::slug( $v, '-' ) ];
        }, $tags );

        $post->tags()->createMany( $tags );

        return true;
    }
}
