<?php

namespace App\Http\Traits;

use App\Http\Models\Mitglieder;
use App\Http\Models\MusikzugMitglied;
use App\Http\Models\Vorstand;
use App\Http\Traits\MitgliederTrait;
use App\Http\Models\Instrumente;

trait MusikzugTrait
{
    private static $instrumente = [];

    public static function getStaticMusikzugFuehrung()
    {
        $getInstrumente = MusikzugTrait::getInstrumente();
        $data = array();
        $mitgliederPos['musikwart'] = 'Musikf&uuml;hrung';
        $mitgliederPos['musikwart_stellvertreter'] = 'Stv. Musikf&uuml;hrung';
        foreach ($mitgliederPos as $key => $val) {
            $Vorstand = Vorstand::where('pos', '=', $key)->get();
            if (count($Vorstand) == 0) {
                $data[$key] = '';
            } else {
                $Vorstand->each(function ($v) use (&$data, $val, $key) {
                    $data[$key] = MitgliederTrait::getVorstandMitgliedData(
                        $key,
                        $val,
                        $v->cms_vorstand_id,
                        $v->cms_mitglieder_id,
                        null,
                        null
                    );
                });
            }
        }
        return view('musikzug.musikzug_vorstand')->with('data', $data)->render();
    }

    public static function getStaticMusizugMitglieder()
    {
        $data = [];
        $mitglieder = MitgliederTrait::getMitglieder(0);
        foreach ($mitglieder as $key => $mitglied) {
            $instrument = MusikzugTrait::getMusikzugMitglied($mitglied['id']);
            if ($instrument !== '') {
                $data[] = [
                            'dienstgrad' => $mitglied['dienstgrad'],
                            'name' => $mitglied['name'],
                            'instrument' => $instrument
                        ];
            }
        }
        return $data;
    }

    public static function getStaticMusizugEhrenMitglieder()
    {
        $data = [];
        $mitglieder = MitgliederTrait::getMitglieder(1);
        foreach ($mitglieder as $key => $mitglied) {
            $instrument = MusikzugTrait::getMusikzugMitglied($mitglied['id']);
            if ($instrument !== '') {
                $data[] = [
                    'dienstgrad' => $mitglied['dienstgrad'],
                    'name' => $mitglied['name'],
                    'instrument' => $instrument
                ];
            }
        }
        return $data;
    }

    private static function getMusikzugMitglied($id)
    {
        $instrument = '';
        $instrumente = MusikzugTrait::$instrumente;
        $Mitglied = MusikzugMitglied::where('cms_mitglieder_id', '=', $id)->get();
        $Mitglied->each(function ($mz) use (&$instrument, $instrumente) {
            $instrument = explode(',', $mz->instrument);
            if (count($instrument) == 1) {
                $instrument = $instrumente[$mz->instrument];
            } else {
                $tmp = '';
                foreach ($instrument as $k2 => $val) {
                    if ($tmp != '') {
                        $tmp .= ' und ';
                    }
                    $tmp .= $instrumente[$val];
                }
                $instrument = $tmp;
            }
        });
        return $instrument;
    }

    private static function getInstrumente()
    {
        $Instrumente = Instrumente::get();
        $instrumente = [];
        $instrumente[''] = '------';
        $Instrumente->each(function ($i) use (&$instrumente) {
            $instrumente[$i->id] = $i->instrument;
        });
        MusikzugTrait::$instrumente = $instrumente;
        return $instrumente;
    }
}
