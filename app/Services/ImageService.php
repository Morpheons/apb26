<?php
namespace App\Services;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Session;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;

class ImageService
{
    public function __construct()
    {
        $this->manager = new ImageManager(Driver::class);
    }
    public function saveImage($file, $pathToSave, $size): \Intervention\Image\Image
    {
        $this->createDirectoryIfNotExists($pathToSave);
        $filename = $file->getClientOriginalname();
        $pathWithFilename = $pathToSave .'/'. $filename;
        $image = $this->manager->read($file);
        if (!is_null($size)){
            $image->scaleDown(width: $size);
        }
        $image->save(storage_path($pathWithFilename ) );
        return $image;
    }

    public function createDirectoryIfNotExists($directory) {
        if(!File::exists($directory)) {
           if(File::makeDirectory(storage_path($directory), 493, true, true)){
               $message = array('type' => 'success', 'message' => 'le repertoire est créé!');
               Session::flash('notifications', $message);
           }
           else {
               $message = array('type' => 'danger', 'message' => 'le repertoire n\'est pas créé!');
               Session::flash('notifications', $message);
           };

        }
    }

}
