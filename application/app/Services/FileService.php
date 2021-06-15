<?php

namespace App\Services;

use File;
use Illuminate\Http\UploadedFile;
use Storage;

/**
 * Class FileService
 *
 * @package App\Services
 */
class FileService
{
    /**
     * @param string $file
     * @param string $disk
     *
     * @return bool
     */
    public static function exists(string $file, string $disk = 'public'): bool
    {
        return Storage::disk($disk)->exists($file);
    }

    /**
     * @param UploadedFile $file
     * @param string $disk
     *
     * @return string
     */
    public static function create(UploadedFile $file, string $disk = 'public'): string
    {
        $name = self::generateHashName($file->getClientOriginalName());
        Storage::disk($disk)->put($name, $file->getContent());

        return $name;
    }


    /**
     * @param string $name
     * @return string
     */
    public static function generateHashName(string $name)
    {
        $path = pathinfo($name);

        if ($path['basename']) {
            $name = sha1($path['basename']);

            return "$name.{$path['extension']}";
        } else {
            return false;
        }
    }
}
