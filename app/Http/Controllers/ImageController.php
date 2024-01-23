<?php

namespace App\Http\Controllers;

use App\Http\Traits\ImageTrait;

/**
 * Class ImageController
 * @package App\Http\Controllers
 */
class ImageController extends GroundController
{
    use ImageTrait;

    public function thumb_150($image)
    {
        $checkdir = $this->CheckCacheDir();
        $image = str_replace('-|-', '.', $image);
        $imagepath = public_path('/fileadmin/fahrzeuge/') . $image;
        if (!is_file($imagepath)) {
            return redirect()->route('404');
        }
        $imagepath = public_path('/fileadmin/fahrzeuge/cache/') . '150px_' . $image;
        if (is_file($imagepath)) {
            list($src_width, $src_height, $type) = getimagesize($imagepath);

            readfile($imagepath);
            exit();
        }
        $file = $this->Imagethumbnail($image, 'cache', 150, 1);
        if (is_file($imagepath)) {
            readfile($imagepath);
            exit();
        }
        return '';
    }
    /**
         * @param $first_folder
         * @param $second_folder
         * @param $image
         */
    public function thumbnails($first_folder, $second_folder, $image)
    {
        $size = 250;
        $small = 'thumb_' . $image;
        $folder = public_path($first_folder . DIRECTORY_SEPARATOR . $second_folder);
        if (file_exists($folder . $small)) {
        } else {
            $data = [];
            $data['error'] = [];
            $data['success'] = [];
            $data = ImageTrait::ImageMagick($folder . $image, $size . 'x' . $size, $folder . $small, $data);
        }

        header("Location: " . $first_folder . '/' . $second_folder . '/' . $small);
        exit();
    }

    private function CheckCacheDir()
    {
        if (!is_dir(public_path('/fileadmin/fahrzeuge/cache/'))) {
            if (!mkdir($concurrentDirectory = public_path('/fileadmin/fahrzeuge/cache/'), 0777) && !is_dir($concurrentDirectory)) {
                throw new \RuntimeException(sprintf('Directory "%s" was not created', $concurrentDirectory));
            }
        }
        if (!is_dir(storage_path('/images/'))) {
            if (!mkdir($concurrentDirectory = storage_path('/images/'), 0777) && !is_dir($concurrentDirectory)) {
                throw new \RuntimeException(sprintf('Directory "%s" was not created', $concurrentDirectory));
            }
        }
    }
}
