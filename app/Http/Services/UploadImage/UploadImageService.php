<?php

namespace App\Http\Services\UploadImage;

class UploadImageService {

    public function uploadImage($file, $path)
    : bool|string {
        $name = $file->getClientOriginalName();
        return $file->storeAs($path, $name);
    }
}