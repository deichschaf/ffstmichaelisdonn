<?php

namespace App\Http\Controllers;

use App\Http\Models\FahrzeugBilder;
use App\Http\Models\Fahrzeuge;
use App\Http\Models\FahrzeugAusstattung;
use App\Http\Traits\FxToolsTrait;
use Illuminate\Support\Facades\Input;

class LinkToFacebookController extends GroundController
{
    public function facebook_show()
    {
        $data = array();
        $data['links'] = '';
        $data['title'] = 'Fahrzeuge';
        $data['content'] = $this->getEinsatzfahrzeuge();

        return view('ajax.ajax_facebookbox')->with('data', $data)->render();
    }
}
