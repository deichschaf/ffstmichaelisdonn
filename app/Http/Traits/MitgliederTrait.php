<?php

namespace App\Http\Traits;

use App\Http\Models\Mitglieder;
use App\Http\Models\Vorstand;
use App\Http\Models\VorstandPosition;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Config;

trait MitgliederTrait
{
    /**
     * @return array
     */
    public function getManagement():array
    {
        $data = Cache::remember(
            __CLASS__ . '_' . __FUNCTION__,
            Config::get('CacheConfig.cache_content_timeout'),
            function () {
                $data = [];
                $mitgliederPos = $this->MitgliedPositionen();
                foreach ($mitgliederPos as $key => $val) {
                    $Vorstand = Vorstand::where('cms_vorstand_position_id', '=', $key)->get();
                    if (count($Vorstand) !== 0) {
                        $Vorstand->each(function ($v) use (&$data, $val, $key) {
                            $content = [
                                'function_id'=>$key,
                                'data'=>$this->getVorstandMitgliedData($key, $val, $v->cms_vorstand_id, $v->cms_mitglieder_id)
                            ];
                            $data[] = (array)$content;
                        });
                    }
                }
                return (array)$data;
            }
        );
        return (array)$data;
    }
    public function getVorstand()
    {
        $data = [];
        $data = Cache::remember('getVorstand', Config::get('CacheConfig.cache_content_timeout'), function () use (&$data) {
            $mitgliederPos = $this->MitgliedPositionen();
            foreach ($mitgliederPos as $key => $val) {
                $Vorstand = Vorstand::where('cms_vorstand_position_id', '=', $key)->get();
                if (count($Vorstand) === 0) {
                    $data[$key] = '';
                } else {
                    $Vorstand->each(function ($v) use (&$data, $val, $key) {
                        $data[$key] = $this->getVorstandMitgliedData($key, $val, $v->id, $v->cms_mitglieder_id);
                    });
                }
            }
            return $data;
        });
        return $data;
    }

    public function getMitglieder()
    {
        $data = [];
        $data = Cache::remember('mitglieder_liste', Config::get('CacheConfig.cache_content_timeout'), function () use (&$data) {
            $mitglieder = Mitglieder::orderBy('nachname', 'ASC')
                                ->orderBy('vorname', 'ASC')
                                ->get();
            $mitglieder->each(function ($m) use (&$data) {
                $data[] = array(
                    'id' => $m->id,
                    'vorname' => $m->vorname,
                    'nachname' => $m->nachname,
                    'bild' => $m->bild,
                );
            });
            return $data;
        });
        return $data;
    }

    public function getVorstandMitgliedData($key, $val, $vorstand_id, $id)
    {
        $data = [];
        $data['funktion'] = $key;
        $data['funktion_text'] = $val;
        $Mitglied = Mitglieder::where('id', '=', $id)->get();
        $Mitglied->each(function ($m) use (&$data, $vorstand_id) {
            $data['id'] = $m->id;
            $data['vorstand_id'] = $vorstand_id;
            $data['bild'] = $m->bild;
            $data['dienstgrad'] = $m->dienstgrad;
            $data['vorname'] = $m->vorname;
            $data['nachname'] = $m->nachname;
            /*
            $data['strasse'] = $m->strasse;
            $data['plz'] = $m->plz;
            $data['ort'] = $m->ort;
            $data['telefon'] = $m->telefon;
            $data['emailadresse'] = $m->emailadresse;
            */
        });
        #return view('mitglieder.vorstand_details')->with('data', $data)->render();
        return (array)$data;
    }

    public function MitgliedPositionen()
    {
        $postionen = [];
        $Positionen = VorstandPosition::orderBy('pos', 'ASC')->get();
        $Positionen->each(function ($p) use (&$postionen) {
            $postionen[$p->id] = $p->positionname;
        });
        return $postionen;
    }

    public function check_kontakt_exists($id, $pos)
    {
        $daten = Cache::remember('mitglieder_kontakt_' . $id . '_' . $pos, Config::get('CacheConfig.cache_navi_timeout'), function () use ($id, $pos) {
            $daten  = [];
            $Mitglieder = Mitglieder::where($pos, '=', '1')->where('id', '=', $id)->get();
            if (count($Mitglieder) === 0) {
                return false;
            }
            $Mitglieder->each(function ($mitglied) use (&$daten) {
                $daten = $this->getPersonalData($mitglied->id);
            });
            return $daten;
        });
        return $daten;
    }

    public function getPersonalDataByPosition($pos)
    {
        $daten  = [];
        $Mitglieder = Mitglieder::where($pos, '=', '1')->get();
        $Mitglieder->each(function ($mitglied) use (&$daten) {
            $daten = $this->getPersonalData($mitglied->id);
        });
        return $daten;
    }

    public function getMitgliederShort()
    {
        $data = [];
        $mitglied = [];
        $Mitglieder = Mitglieder::orderBy('vorname', 'ASC')->orderBy('nachname', 'ASC')->orderBy('ort', 'ASC')->get();
        $Mitglieder->each(function ($m) use (&$mitglied) {
            $mitglied[] = array(
                'id' => $m->id,
                'vorname' => $m->vorname,
                'nachname' => $m->nachname
            );
        });
        return $data;
    }

    private function getPersonalData($id)
    {
        $daten  = [];
        $Mitglieder = Mitglieder::where('id', '=', $id)->where('deaktiv', '=', '0')->get();
        $Mitglieder->each(function ($mitglied) use (&$daten) {
            $daten = array(
                'id' => $mitglied->id,
                'vorname' => $mitglied->vorname,
                'nachname' => $mitglied->nachname,
                'dienstgrad' => $mitglied->dienstgrad,
                'strasse' => $mitglied->strasse,
                'plz' => $mitglied->plz,
                'ort' => $mitglied->ort,
                'telefon' => $mitglied->telefon,
                'telefon2' => $mitglied->telefon2,
                'dienstlich' => $mitglied->dienstlich,
                'mobil' => $mitglied->mobil,
                'telefax' => $mitglied->telefax,
                'emailadresse' => $mitglied->emailadresse,
                'emailadresse2' => $mitglied->emailadresse2,
                'bild' => $mitglied->bild,
                'sichtbar' => $mitglied->sichtbar,
                'sichtbar_strasse' => $mitglied->sichtbar_strasse,
                'sichtbar_plz' => $mitglied->sichtbar_plz,
                'sichtbar_ort' => $mitglied->sichtbar_ort,
                'sichtbar_telefon' => $mitglied->sichtbar_telefon,
                'sichtbar_telefon2' => $mitglied->sichtbar_telefon2,
                'sichtbar_dienstlich' => $mitglied->sichtbar_dienstlich,
                'sichtbar_telefax' => $mitglied->sichtbar_telefax,
                'sichtbar_mobil' => $mitglied->sichtbar_mobil,
                'sichtbar_email' => $mitglied->sichtbar_email,
                'sichtbar_email2' => $mitglied->sichtbar_email2,
                'deaktiv' => $mitglied->deaktiv
            );
        });
        return $daten;
    }

    public function ExportMitglieder($type = 'csv')
    {
        $mirglieder = [];
        $Mitglieder = Mitglieder::where('deaktiv', '=', '0')->orderBy('vorname', 'ASC')->orderBy('nachname', 'ASC')->get();
        $Mitglieder->each(function ($m) use (&$mitglieder) {
            $mitglieder[] = array(
                'id' => $m->id,
                'vorname' => $m->vorname,
                'nachname' => $m->nachname,
                'strasse' => $m->strasse,
                'plz' => $m->plz,
                'ort' => $m->ort,
                'telefon' => $m->telefon,
                'telefon2' => $m->telefon2,
                'dienstlich' => $m->dienstlich,
                'mobil' => $m->mobil,
                'telefax' => $m->telefax,
                'emailadresse' => $m->emailadresse,
                'emailadresse2' => $m->emailadresse2,
                'bild' => $m->bild,
                'sichtbar' => $m->sichtbar,
                'sichtbar_strasse' => $m->sichtbar_strasse,
                'sichtbar_plz' => $m->sichtbar_plz,
                'sichtbar_ort' => $m->sichtbar_ort,
                'sichtbar_telefon' => $m->sichtbar_telefon,
                'sichtbar_telefon2' => $m->sichtbar_telefon2,
                'sichtbar_dienstlich' => $m->sichtbar_dienstlich,
                'sichtbar_telefax' => $m->sichtbar_telefax,
                'sichtbar_mobil' => $m->sichtbar_mobil,
                'sichtbar_email' => $m->sichtbar_email,
                'sichtbar_email2' => $m->sichtbar_email2,
                'deaktiv' => $m->deaktiv
            );
        });

        $export = '';
        $headline = $mitglieder['0'];
        foreach ($headline as $key => $val) {
            $export .= "'" . $key . "';";
        }
        $export = substr($export, 0, -1);
        $export .= "\n";
        foreach ($mitglieder as $key => $row) {
            $export .= "'" . join("';'", $row) . "'" . "\n";
        }
        echo $export;
        exit();
    }
}
