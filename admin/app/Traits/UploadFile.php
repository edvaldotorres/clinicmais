<?php

namespace App\Traits;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Exception;

trait UploadFile
{
    /**
     * The function `uploadImage` takes an uploaded file and a directory, stores the
     * file with a unique filename in the specified directory, and returns the
     * filename.
     * 
     * @param UploadedFile file UploadedFile 
     * @param string directory The `` parameter in the `uploadImage` function
     * represents the directory where the uploaded file will be stored. This is the
     * location within the storage disk where the file will be saved. It could be a
     * folder path like 'images/uploads'.
     * 
     * @return string The function `uploadImage` returns the file name of the uploaded
     * image.
     */
    protected function uploadImage(UploadedFile $file, string $directory): string
    {
        $fileName = time() . '.' . $file->extension();
        $isFileMoved = $file->storeAs($directory, $fileName, 'public');

        if (!$isFileMoved) {
            throw new Exception('Failed to upload file.');
        }

        return $fileName;
    }

    /**
     * The function `uploadDeleteImage` deletes an image file from the public storage
     * if it exists at the specified path.
     * 
     * @param path The `uploadDeleteImage` function is a protected method that takes a
     * nullable string parameter ``. It checks if the `` is not null and if a
     * file exists at the specified path within the public disk under the `images`
     * directory. If the file exists, it deletes the file from
     */
    protected function uploadDeleteImage(?string $path): void
    {
        if ($path && Storage::disk('public')->exists('images/' . $path)) {
            Storage::disk('public')->delete('images/' . $path);
        }
    }
}
