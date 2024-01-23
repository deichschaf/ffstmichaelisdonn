<?php

namespace App\Http\Traits;

trait MakeImageTrait
{
    public static function makeImage($file, $width = 200, $height = 200, $delete = 0)
    {
        $new_file = basename($file);
        $new_path = dirname($file) . DIRECTORY_SEPARATOR . 'cache' . DIRECTORY_SEPARATOR;
        $new_path_file = DIRECTORY_SEPARATOR . $new_path . $width . 'x' . $height . '_' . $new_file;
        $newrealpath = public_path() . $new_path_file;
        $realpath = public_path() . $file;
        $cache_dir = public_path() . $new_path;
        if (!is_dir($cache_dir)) {
            @mkdir($cache_dir, 0777);
        }
        $new_path_file = str_replace('\\', '/', $new_path_file);
        $realpath = self::CorrectPath($realpath);
        $newrealpath = self::CorrectPath($newrealpath);
        $new_path_file = self::CorrectPath($new_path_file);
        if ($delete === 1) {
            @unlink($newrealpath);
        }
        if (is_file($newrealpath)) {
            return $new_path_file;
        }
        FxToolsSystemToolsTrait::make_thumb_static($realpath, $newrealpath, $width, $height);
        return $new_path_file;
    }

    public static function CorrectPath($link)
    {
        return str_replace(DIRECTORY_SEPARATOR . DIRECTORY_SEPARATOR, DIRECTORY_SEPARATOR, $link);
    }
}
