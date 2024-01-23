<?php

/**
 * Created by PhpStorm.
 * User: Jörg-Marten Hoffmann
 * Date: 16.04.2015
 * Time: 06:55
 */

namespace App\Http\Controllers;

use App\Http\Traits\LayoutTrait;
use App\Http\Models\Layout;

class SchiffstrafficController extends GroundController
{
    public function schiffe_show()
    {
        $data = array();
        $data['links'] = '';
        $data['title'] = 'Schiffstraffic';
        $content =  view('schiffstraffic')->with('data', $data)->render();
        $l = new Layout();
        return $l->layout_content($content, $data['title'], false, false);
    }
}
