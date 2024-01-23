<?php

namespace App\Http\Traits;

use App\Http\Models\SEORouten;

/**
 * Trait SEOTrait
 * @package App\Http\Traits
 */
trait SEOTrait
{
    /**
     * @param $url
     */
    public function SEOUrl($url)
    {
    }

    /**
     * @param $txt
     */
    private function makereadable($txt)
    {
    }

    /**
     * @param $controller
     * @param $id
     * @param $action
     * @param $seourl
     */
    public function saveSEOUrl($controller, $id, $action, $seourl)
    {
    }

    /**
     * @return string
     */
    public function writeAutoRoute()
    {
        $files = array();
        $Routen = SEORouten::where('auto', '=', '1')->orderBy('path', 'ASC')->get();
        $Routen->each(function ($r) use (&$files) {
            $files[] = " Route::get('" . $r->seourl . "', array( 'as' =>'" . $r->alias . "', 'uses' => 'PageController@content')); ";
        });
        /* files in route schreiben */
        return '';
    }
}
