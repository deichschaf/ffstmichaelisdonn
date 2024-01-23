<?php

namespace App\Http\Controllers;

use Illuminate\Html;
use App\Http\Models\Einsaetze;
use App\Http\Models\EinsatzFahrzeug;
use App\Http\Models\Feuerwehren;
use App\Http\Models\Fahrzeuge;
use App\Http\Models\Layout;
use App\Http\Traits\EinsaetzeTrait;

class StatistikController extends GroundController
{
    public function statistik_show()
    {
        $data = array();
        $data['content'] = '';
        $data['title'] = 'Einsatzstatistik';
        $l = new Layout();
        return $l->layout_content($data['content'], $data['title'], false, false);
    }
}
