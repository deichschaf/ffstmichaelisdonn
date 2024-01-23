<?php

namespace App\Http\Controllers;

use App\Http\Traits\FxToolsSystemToolsTrait;

class SystemToolsController extends GroundController
{
    public function systemtools_show()
    {
        $data = FxToolsSystemToolsTrait::show();

        return $this->getLayoutAdminContent($data['content'], $data['title'], false, false);
    }

    public function makeCacheClear()
    {
        shell_exec('php artisan cache:clear');
        $cachedViewsDirectory = app('path.storage') . DIRECTORY_SEPARATOR . 'framework' . DIRECTORY_SEPARATOR . 'views'
            . DIRECTORY_SEPARATOR;
        //echo 'path: '.$cachedViewsDirectory;
        //exit();
        $files = glob($cachedViewsDirectory . '*');
        foreach ($files as $file) {
            if ('.gitignore' !== $file) {
                if (is_file($file)) {
                    @unlink($file);
                }
            }
        }

        return redirect()->route('home');
    }
}
