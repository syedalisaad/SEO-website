<?php namespace App\Modules\Category\Respository;

use \App\Models\Category;

use App\Support\Traits\{
    UploadableTrait,
    StorageableTrait
};

class CategoryRespository
{
    use UploadableTrait, StorageableTrait;

    private $model = null;

    public function __construct( Category $category ) {
        $this->model = $category;
    }

    /*
    * Categories - Create Or Update
    *
    * @param Request $request
    * @param Category $category
    */
   public function createOrUpdate( $request, Category $category )
   {
       $category->parent_id    = $request->parent_id ?: null;
       $category->name         = $request->name;
       $category->short_desc   = $request->short_desc ?: null;
       $category->is_active    = (int) $request->is_active;
       $category->extras       = $request->extras ?: null;
       $category->seo_metadata = $request->seo_metadata ?: null;

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
           $this->findOrCreateDirectory( Category::$storage_disk );

           // Delete a file path where image will be stored [ file name + Media + Storage = public + Disk = local]
           if ( $category->source_image ) {
               $this->fileDeleteFromDisk( $category->source_image, Category::$storage_disk );
           }

           // Make a file path where file will be stored [ file name + file extension]
           $category->source_image = \Str::slug( $file_name ) . '_'. time(). "." . $file->getClientOriginalExtension();

           // Store a file path where image will be stored [ File Closure + file name + Media + Storage = public + Disk = local]
           $this->uploadOne($file, Category::$storage_disk, $category->source_image );
       }

       $category->save();

       return $category;
   }
}
