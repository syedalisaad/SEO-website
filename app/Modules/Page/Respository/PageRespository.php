<?php namespace App\Modules\Page\Respository;

use \App\Models\Page;

use App\Support\Traits\{
    UploadableTrait,
    StorageableTrait
};

class PageRespository
{
    use UploadableTrait, StorageableTrait;

    protected $model = null;

    public function __construct(Page $page)
    {
        $this->model = $page;
    }

    /*
     * Create Or Update
     *
     * @param Request $request
     * @param Publisher $publisher
     */
    public function createOrUpdate( $request, Page $page )
    {
        $extras = $this->_source_upload($request->extras);

        $page->name         = $request->name;
        $page->description  = $request->description?:'';
        $page->extras       = $extras ?: null;
        $page->seo_metadata = $request->seo_metadata ?: null;
        $page->save();

        return $page;
    }

    private function _source_upload( $extras )
    {
        // Make a folder path where file will be stored [ Folder + Storage = public + Disk = local]
        $this->findOrCreateDirectory( Page::$storage_disk );

        /**
         * Create upload logo or Update
         * @array \Illuminate\Http\Request  $request
         */
        if ( isset( $extras['source_header'] ) && $extras['source_header'] )
        {
            // Delete a file path where image will be stored [ file name + Media + Storage = public + Disk = local]
            if ( isset( $extras['h_source_header'] ) && $extras['h_source_header'] ) {
                $this->fileDeleteFromDisk( basename( $extras['h_source_header'] ), Page::$storage_disk );
                unset($extras['h_source_header']);
            }

            $file      = $extras['source_header'];
            $file_name = pathinfo( $file->getClientOriginalName(), PATHINFO_FILENAME );
            $extras['source_header'] = \Str::slug( $file_name ) . '_' . time() . "." . $file->getClientOriginalExtension();
            // Store a file path where image will be stored [ File Closure + file name + Media + Storage = public + Disk = local]
            $this->uploadOne( $file, Page::$storage_disk, $extras['source_header'] );
        }
        else
        {
            $extras['source_header'] = $extras['h_source_header'] ?? '';
            unset($extras['h_source_header']);
        }

        return $extras;
    }

    public function removeExistsResource(Page $page)
    {
        $extras = $page->extras;

        if ( isset($extras['source_header']) && $extras['source_header'] ) {
            $this->fileDeleteFromDisk( basename( $extras['source_header'] ), Page::$storage_disk );
            $extras['source_header'] = null;
        }

        $page->extras = $extras;

        return $page;
    }
}
