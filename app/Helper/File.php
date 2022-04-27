<?php

namespace App\Helper;

use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;

Trait File
{
    public $public_path = "/public/uploadedImages/";
    public $storage_path = "/storage/uploadedImages/";

    public function file( $file, $path, $width, $height )
    {
        if ( $file ) {
            $fileName = time().'.'.$file->getClientOriginalExtension();
            $image_url = $path.$fileName;
            $img = Image::make($file)->resize($width, $height)->save($image_url);
//            $extension       = $file->getClientOriginalExtension();
//            $file_name       = $path.'-'.Str::random(30).'.'.$extension;
//            $url             = $file->storeAs($this->public_path,$file_name);
//            $public_path     = public_path($this->storage_path.$file_name);
//            $img             = Image::make($public_path)->resize($width, $height);
//            $url             = preg_replace( "/public/", "", $url );
            return $img ? $image_url : '';
        }
    }
}
