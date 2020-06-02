<?php


namespace App\helpers;

use Illuminate\Http\File;
use Illuminate\Support\Facades\Storage;

class FileUploadHelper
{
    public static function upload($data, array $allowedfileExtension, string $folder)
    {
        $images = [];
        foreach ($data as $image) {
            if (in_array("*", $allowedfileExtension) || in_array($image->getClientOriginalExtension(), $allowedfileExtension)) {
                $image = Storage::disk('public')->putFile($folder, new File($image));
                $images[]["image"] = $image;
            }
        }
        return $images;
    }
}
