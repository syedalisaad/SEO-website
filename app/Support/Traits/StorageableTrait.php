<?php namespace App\Support\Traits;

trait StorageableTrait  {

	public function findOrCreateDirectory($folder, $storage = 'public', $disk = 'local')
	{
        $storage = public_path( 'storage/'. $folder );

        \File::isDirectory($storage) or \File::makeDirectory($storage, 0777, true, true);

        return TRUE;
	}

	public function fileDeleteFromDisk($file_name, $folder, $storage = 'public', $disk = 'local')
    {
        $file_name = ltrim( $file_name, '/' );

        if ( $folder ) {
            $folder = (ltrim( $folder, '/' ) . '/');
        }

        \File::delete( public_path( 'storage/'. $folder .  $file_name ) );

        return TRUE;
    }

    public function fileCopyFromDisk($file_name, $copy_name, $folder, $storage = 'public', $disk = 'local')
    {
        $file_name = ltrim( $file_name, '/' );
        $copy_name = ltrim( $copy_name, '/' );

        if ( $folder ) {
            $folder = (ltrim( $folder, '/' ) . '/');
        }

        \File::copy( public_path( 'storage/'. $folder .  $file_name), public_path( 'storage/'. $folder .  $copy_name) );

        return $copy_name;
    }
}
