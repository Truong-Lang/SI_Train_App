<?php

namespace App\Http\Services\UploadImage;

use Illuminate\Support\Facades\Storage;

class UploadImageService implements UploadImage {

    /**
     * @param $file
     * @param $path
     * @param $old_file
     *
     * @return bool|string
     */
    public function uploadImage($file, $path, $old_file = null)
    : bool|string {

        if ($old_file && Storage::exists($old_file)) {
            Storage::delete($old_file);
        }
        $name = $file->getClientOriginalName();

        return $file->storeAs($path, $name);
    }
}