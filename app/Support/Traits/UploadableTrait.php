<?php namespace App\Support\Traits;

use Illuminate\Http\UploadedFile;

use StorageableTrait as traitConfigureOptions;

trait UploadableTrait  {

	/**
	 * Upload a single file in the server
	 *
	 * @param UploadedFile $file
	 * @param null $folder
	 * @param string $disk
	 * @param null $filename
	 * @return false|string
	 */
	public function uploadOne(UploadedFile $file, $folder, $file_name, $storage = 'public',  $disk = 'local')
	{
        // Make a Media where file will be stored [ Media + Storage = public + Disk = local]
        $this->findOrCreateDirectory( $folder, $storage, $disk );

        $storage = public_path('storage/'. ltrim($folder, '/'));

        return $file->move($storage, $file_name);

        /*return $file->storeAs(
			$folder,
            $file_name,
            $storage
		);*/
	}

	/**
 	 * @param UploadedFile $file
	 *
	 * @param string $folder
	 * @param string $disk
	 *
	 * @return false|string
	 */
	public function storeFile(UploadedFile $file, $folder = 'gallery', $storage = 'public',  $disk = 'local')
	{
		return $file->store($folder, ['disk' => $storage]);
	}
}
