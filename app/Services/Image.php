<?php

namespace App\Services;

use Config;
use File;
use Log;

class Image
{
    /**
    * Instance of the Imagine package.
    *
    * @var Imagine\Gd\Imagine
    */
    protected $imagine;

    /**
    * Type of library used by the service.
    *
    * @var string
    */
    protected $library;

    /**
    * Initialize the image service.
    *
    * @return void
    */
    public function __construct()
    {
        if (! $this->imagine) {
            $this->library = Config::get('image.library', 'gd');

            // Now create the instance
            if ('imagick' === $this->library) {
                $this->imagine = new \Imagine\Imagick\Imagine();
            } elseif ('gmagick' === $this->library) {
                $this->imagine = new \Imagine\Gmagick\Imagine();
            } elseif ('gd' === $this->library) {
                $this->imagine = new \Imagine\Gd\Imagine();
            } else {
                $this->imagine = new \Imagine\Gd\Imagine();
            }
        }
    }

    /**
    * Resize an image.
    *
    * @param string $url
    * @param int    $width
    * @param int    $height
    * @param bool   $crop
    *
    * @return string
    */
    public function resize($url, $width = 100, $height = null, $crop = false, $quality = 90): ?string
    {
        //echo $url;
        //exit();
        if ($url) {
            // URL info
            $info = pathinfo($url);

            // The size
            if (! $height) {
                $height = $width;
            }

            // Quality
            $quality = Config::get('image.quality', $quality);

            // Directories and file names
            $fileName = $info['basename'];
            $sourceDirPath = public_path() . DIRECTORY_SEPARATOR . $info['dirname'];
            $sourceFilePath = $sourceDirPath . DIRECTORY_SEPARATOR . $fileName;
            $targetDirName = $width . 'x' . $height . ($crop ? '_crop' : '');
            $targetDirPath = $sourceDirPath . DIRECTORY_SEPARATOR . $targetDirName . '/';
            $targetFilePath = $targetDirPath . $fileName;
            $targetUrl = asset($info['dirname'] . '/' . $targetDirName . '/' . $fileName);

            // Create directory if missing
            try {
                // Create dir if missing
                if (! File::isDirectory($targetDirPath) and $targetDirPath) {
                    @File::makeDirectory($targetDirPath);
                }

                // Set the size
                $size = new \Imagine\Image\Box($width, $height);

                // Now the mode
                $mode = $crop ?
                    \Imagine\Image\ImageInterface::THUMBNAIL_OUTBOUND : \Imagine\Image\ImageInterface::THUMBNAIL_INSET;

                if (
                    !File::exists($targetFilePath)
                    or (File::lastModified($targetFilePath) < File::lastModified($sourceFilePath))
                ) {
                    $this->imagine->open($sourceFilePath)
                        ->thumbnail($size, $mode)
                        ->save($targetFilePath, ['quality' => $quality]);
                }
            } catch (\Exception $e) {
                Log::error('[IMAGE SERVICE] Failed to resize image "' . $url . '" [' . $e->getMessage() . ']');
            }

            return $targetUrl;
        }
    }

    /**
    * Helper for creating thumbs.
    *
    * @param string $url
    * @param int    $width
    * @param int    $height
    *
    * @return string
    */
    public function thumb($url, $width, $height = null): string
    {
        return $this->resize($url, $width, $height, true);
    }

    /**
    * Upload an image to the public storage.
    *
    * @param File $file
    *
    * @return string
    */
    public function upload($file, $dir = null, $createDimensions = false): ?string
    {
        if ($file) {
            // Generate random dir
            if (! $dir) {
                $dir = str_random(8);
            }

            // Get file info and try to move
            $destination = Config::get('image.upload_path') . $dir;
            $filename = $file->getClientOriginalName();
            $path = Config::get('image.upload_dir') . DIRECTORY_SEPARATOR . $dir . DIRECTORY_SEPARATOR . $filename;
            $uploaded = $file->move($destination, $filename);

            if ($uploaded) {
                if ($createDimensions) {
                    $this->createDimensions($path);
                }

                return $path;
            }
        }
    }

    /**
    * Creates image dimensions based on a configuration.
    *
    * @param string $url
    * @param array  $dimensions
    *
    * @return void
    */
    public function createDimensions($url, $dimensions = [])
    {
        // Get default dimensions
        $defaultDimensions = Config::get('image.dimensions');

        if (is_array($defaultDimensions)) {
            $dimensions = array_merge($defaultDimensions, $dimensions);
        }

        foreach ($dimensions as $dimension) {
            // Get dimmensions and quality
            $width = (int) $dimension[0];
            $height = isset($dimension[1]) ? (int) $dimension[1] : $width;
            $crop = isset($dimension[2]) ? (bool) $dimension[2] : false;
            $quality = isset($dimension[3]) ? (int) $dimension[3] : Config::get('image.quality');

            // Run resizer
            $img = $this->resize($url, $width, $height, $crop, $quality);
        }
    }
}
