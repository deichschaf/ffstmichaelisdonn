<?php

/**
 * Created by PhpStorm.
 * User: Jörg-Marten Hoffmann
 * Date: 15.04.2015
 * Time: 06:55
 */

namespace App\Http\Controllers;

use App\Http\Models\Download;
use App\Http\Traits\LayoutTrait;
use App\Http\Models\Layout;

class FunktionsvorraussetzungController extends GroundController
{
    public function function_show()
    {
        $data = array();
        $data['links'] = '';
        $data['title'] = 'Download';
        $data['downloads'] = array();
        $content =  view('download.download')->with('data', $data)->render();
        $l = new Layout();
        return $l->layout_content($content, $data['title'], false, false);
    }
    private function getFunctionen($parent_id)
    {
        $funktionen = array();
        $Funktionen = Funktionsvorraussetzung::where('parent_id', '=', $parent_id)->orderBy('funktion', 'ASC')->get();
        $Funktionen->each(function ($f) use (&$funktionen) {
        });
        if (count($funktionen) == 0) {
            return '';
        }
    }
}
