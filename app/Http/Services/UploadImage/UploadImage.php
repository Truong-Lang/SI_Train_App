<?php

namespace App\Http\Services\UploadImage;

/**
 * Interface UploadImage
 *
 * @package App\Http\Services\UploadImage
 */
interface UploadImage
{
    /**
     * @param $file
     * @param $path
     * @param $old_file
     *
     * @return mixed
     */
    public function uploadImage($file, $path, $old_file);
}