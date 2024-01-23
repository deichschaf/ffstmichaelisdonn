<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Models\Layout;
use App\Http\Traits\FeuerwehrTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class FeuerwehrController extends GroundController
{
    public function dienstgrade(Request $request)
    {
        $data = [];
        $data['title'] = 'Dienstgrade';
        $inputs = $request->all();

        $kombi = [];
        $kombi['dienstgad'] = 0;
        $kombi['vorraussetzung'] = '';
        if (count($inputs) > 0) {
            $kurzel = FeuerwehrTrait::DiestgradVorraussetzungenKuerzel();

            if (array_key_exists('dienstgrad', $inputs)) {
                if (is_numeric($inputs['dienstgrad'])) {
                    $kombi['dienstgad'] = $inputs['dienstgrad'];
                }
            }
            if (in_array($inputs['vorraussetzung'], $kurzel)) {
                $kombi['vorraussetzung'] = $inputs['vorraussetzung'];
            }
        }
        $kombinationen = FeuerwehrTrait::DienstgradeKombinationen($kombi['dienstgad'], $kombi['vorraussetzung']);

        $dienstgrade = FeuerwehrTrait::Dienstgrade();
        $Vorraussetzungen = FeuerwehrTrait::DiestgradVorraussetzungen();
        $Schulterstuecke = FeuerwehrTrait::DienstgradeAbzeichen();

        $data['dienstgrade'] = $dienstgrade;
        $data['vorraussetzungen'] = $Vorraussetzungen;
        $data['schulterstuecke'] = $Schulterstuecke;
        $data['kombinationen'] = $kombinationen;

        $content =  view('feuerwehr.dienstgrade')->with('data', $data)->render();
        $l = new Layout();
        return $l->layout_content($content, $data['title'], false, false);
    }

    public function add_fire_contactform(Request $request)
    {
        $data = array();
        $data['title'] = 'Feuer anmelden';
        $inputs = $request->all();

        $data['datum'] = '';
        $data['uhrzeit'] = '';
        $data['nachname'] = '';
        $data['vorname'] = '';
        $data['strasse'] = '';
        $data['plz'] = '';
        $data['wohnort'] = '';
        $data['telefon'] = '';
        $data['feuer_strasse'] = '';
        $data['feuer_ort'] = '';
        $data['bemerkung'] = '';
        $data['email'] = '';

        if (array_key_exists('datum', $inputs)) {
            $data['datum'] = $inputs['datum'];
            $data['uhrzeit']  = $inputs['uhrzeit'] . ':00';
            $data['nachname'] = $inputs['nachname'];
            $data['vorname'] = $inputs['vorname'];
            $data['strasse'] = $inputs['strasse'];
            $data['plz'] = $inputs['plz'];
            $data['wohnort'] = $inputs['wohnort'];
            $data['telefon'] = $inputs['telefon'];
            $data['feuer_strasse'] = $inputs['feuer_plz'];
            $data['feuer_ort'] = $inputs['feuer_ort'];
            $data['bemerkung'] = $inputs['bemerkung'];
            $data['email'] = $inputs['email'];
        }

        $content =  view('feuerwehr.feuer_anmelden')->with('data', $data)->render();
        $l = new Layout();
        return $l->layout_content($content, $data['title'], false, false);
    }

    public function send_fire_contactform(Request $request)
    {
        $inputs = $request->all();
        $error = 0;
        // Speichere erstmal die Daten, evtl wird es nicht neu abgesendet!
        $data = FeuerwehrTrait::send_fire_contactform($inputs);

        if (trim($inputs['datum']) == '') {
            $error = 1;
        }
        if (trim($inputs['uhrzeit']) == '') {
            $error = 1;
        }
        if (trim($inputs['nachname']) == '') {
            $error = 1;
        }
        if (trim($inputs['vorname']) == '') {
            $error = 1;
        }
        if (trim($inputs['strasse']) == '') {
            $error = 1;
        }
        if (trim($inputs['plz']) == '') {
            $error = 1;
        }
        if (trim($inputs['wohnort']) == '') {
            $error = 1;
        }
        if (trim($inputs['email']) == '') {
            $error = 1;
        }

        foreach ($inputs as $key => $value) {
            $inputs[$key] = trim($value);
        }

        if ($error === 1) {
            return redirect()->route('feuer_anmelden')->with(['error' => 'empty', 'inputs' => $inputs]);
        }

        $data['title'] = 'Feuer anmelden';
        $content =  view('feuerwehr.kontakt_send')->with('data', $data)->render();
        $l = new Layout();
        return $l->layout_content($content, $data['title'], false, false);
    }
}
