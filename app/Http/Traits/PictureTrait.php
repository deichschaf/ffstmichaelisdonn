<?php

namespace App\Http\Traits;

trait PictureTrait
{
    public function getPictureSrc(string $file='', string $path = ''):array
    {
        $sourceSet=[];
        if ($file === '') {
            return $sourceSet;
        }
        $pathinfo = pathinfo($file);
        if ($path !== '') {
            if (is_file(public_path($path)).$pathinfo['filename'].'.jpg') {
                $sourceSet[] = [
                    'image' => $pathinfo['filename'] . '.jpg',
                    'type' => 'jpg'
                ];
            }
            if (is_file(public_path($path)).$pathinfo['filename'].'.png') {
                $sourceSet[] = [
                    'image' => $pathinfo['filename'] . '.png',
                    'type' => 'png'
                ];
            }
            if (is_file(public_path($path)).$pathinfo['filename'].'.webp') {
                $sourceSet[] = [
                    'image' => $pathinfo['filename'] . '.webp',
                    'type' => 'webp'
                ];
            }
        } else {
            $sourceSet[] = [
                'image'=>$pathinfo['filename'].'.jpg',
                'type'=>'jpg'
            ];
            $sourceSet[] = [
                'image'=>$pathinfo['filename'].'.png',
                'type'=>'png'
            ];
            $sourceSet[] = [
                'image'=>$pathinfo['filename'].'.webp',
                'type'=>'webp'
            ];
        }

        return $sourceSet;
    }
}
