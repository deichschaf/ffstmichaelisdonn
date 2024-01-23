<?php

namespace App\Http\Traits;

use App\Http\Models\FeuerAnmelden;
use App\Http\Models\FeuerwehrDienstgrade;
use App\Http\Models\FeuerwehrDienstgradeKombi;
use App\Http\Models\FeuerwehrDienstgradeVorraussetzungen;
use App\Http\Models\TelephoneNumbers;
use App\Http\Models\TelephoneNumberType;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Config;

trait FeuerwehrTrait
{
    public function getTelephoneNumbers(): array
    {
        $data = Cache::remember(
            __CLASS__ . '_' . __FUNCTION__,
            Config::get('CacheConfig.cache_content_timeout'),
            function () {
                $data = [];
                $getTelephoneNumberTypes = TelephoneNumberType::orderBy('pos', 'ASC')->get();
                $getTelephoneNumberTypes->each(function ($tt) use (&$data) {
                    if (!array_key_exists('types', $data)) {
                        $data['types'] = (array)[];
                    }
                    $data['types'][$tt->id] = $tt->telephone_number_type;
                });
                foreach($data['types'] as $k => $row) {
                    $datas = [];
                    $getTelephoneNumber = TelephoneNumbers::where('telephone_number_type', '=', $k)
                        ->orderBy('organisation', 'ASC')
                        ->get();
                    $getTelephoneNumber->each(function ($t) use (&$datas) {
                        $datas[] = [
                            'organisation' => $t->organisation,
                            'organisation_description' => $t->organisation_description,
                            'telephone_number' => $t->telephone_number,
                            'website' => $t->website,
                            'website_title' => $t->website_title,
                            'website_description' => $t->website_description,
                            'telephone_number_type' => $t->telephone_number_type
                        ];
                    });
                    $data['telephonenumbers'][$k] = $datas;
                }
                return $data;
            }
        );
        return $data;
    }

    /**
     * @return mixed
     * @todo Statistik Daten in der Datenbank pflegen
     */
    public function getFireDepartmentStatistic(): array
    {
        $data = Cache::remember(
            __CLASS__ . '_' . __FUNCTION__,
            Config::get('CacheConfig.cache_content_timeout'),
            function () {
                $data = [];
                $data['active_user'] = 32;
                $data['user_person'] = 31;
                $data['user_personwoman'] = 1;
                $data['trucks'] = 1;
                $data['trailer'] = 2;
                $data['alarm_last_date'] = $this->getLastAlarmTime();
                $data['alarms_this_year'] = $this->getEmergencyStatisticCount(date('Y'));
                $data['alarms_this_year_date'] = date('Y');
                $data['alarms_last_year'] = $this->getEmergencyStatisticCount((date('Y')-1));
                $data['alarms_last_year_date'] = (date('Y')-1);
                return $data;
            }
        );
        return $data;
    }

    public static function show_job($param)
    {
        $data = [];
        $data['title'] = '';
        return view('widget.job')->with('data', $data)->render();
    }

    public static function DienstgradeKombinationen($dienstgrad = 0, $vorraussetzung = '')
    {
        $data = [];
        if ($dienstgrad !== 0 && $vorraussetzung !== '') {
            $Kombinationen = FeuerwehrDienstgradeKombi::where('dienstgrad_id', '=', $dienstgrad)->where($vorraussetzung, '=', '1')->orderBy('pos', 'ASC')->get();
        } elseif ($dienstgrad !== 0 && $vorraussetzung === '') {
            $Kombinationen = FeuerwehrDienstgradeKombi::where('dienstgrad_id', '=', $dienstgrad)->orderBy('pos', 'ASC')->get();
        } elseif ($dienstgrad === 0 && $vorraussetzung !== '') {
            $Kombinationen = FeuerwehrDienstgradeKombi::where($vorraussetzung, '=', '1')->orderBy('pos', 'ASC')->get();
        } else {
            $Kombinationen = FeuerwehrDienstgradeKombi::orderBy('pos', 'ASC')->get();
        }
        $Kombinationen->each(function ($k) use (&$data) {
            $data[] = (array)$k;
        });
        return $data;
    }

    public static function Dienstgrade()
    {
        $data = [];
        $Dienstgrade = FeuerwehrDienstgrade::orderBy('pos', 'ASC')->get();
        $Dienstgrade->each(function ($d) use (&$data) {
            $data[$d->id] = $d->dienstgrad;
        });
        return $data;
    }

    public static function DienstgradeAbzeichen()
    {
        $data = [];
        $Diestgrade = FeuerwehrDienstgrade::orderBy('pos', 'ASC')->get();
        $Diestgrade->each(function ($d) use (&$data) {
            $data[$d->id] = [
                'id' => $d->id,
                'dienstgrad' => $d->dienstgrad,
                'schulterstueck' => $d->schulterstueck
            ];
        });
        return $data;
    }

    public static function DiestgradVorraussetzungen()
    {
        $data = [];
        $Vorraussetzungen = FeuerwehrDienstgradeVorraussetzungen::orderBy('pos', 'ASC')->get();
        $Vorraussetzungen->each(function ($v) use (&$data) {
            $data[$v->id] = [
               'id' => $v->id,
               'kuerzel' => $v->kuerzel,
               'vorraussetzung' => $v->vorraussetzung,
            ];
        });
        return $data;
    }

    public static function DiestgradVorraussetzungenKuerzel()
    {
        $data = [];
        $Vorraussetzungen = FeuerwehrDienstgradeVorraussetzungen::orderBy('pos', 'ASC')->get();
        $Vorraussetzungen->each(function ($v) use (&$data) {
            $data[$v->id] = $v->kuerzel;
        });
        return $data;
    }

    public static function show_flyer($param)
    {
        $data = [];
        $data['title'] = '';
        return view('widget.flyer')->with('data', $data)->render();
    }

    public static function send_fire_contactform($inputs)
    {
        $add = new FeuerAnmelden();
        $add->datum = $inputs['datum'];
        $add->uhrzeit  = $inputs['uhrzeit'] . ':00';
        $add->nachname = $inputs['nachname'];
        $add->vorname = $inputs['vorname'];
        $add->strasse = $inputs['strasse'];
        $add->plz = $inputs['plz'];
        $add->wohnort = $inputs['wohnort'];
        $add->telefon = $inputs['telefon'];
        $add->feuer_strasse = $inputs['feuer_plz'];
        $add->feuer_ort = $inputs['feuer_ort'];
        $add->bemerkung = $inputs['bemerkung'];
        $add->emailadresse = $inputs['email'];
        $add->save();
        FeuerwehrTrait::send_fire_email($inputs);
    }

    private static function send_fire_email($data)
    {
        $subjekt = "Feueranmeldung " . env('HOMEPAGETITEL', '');
        $mailtext = "Folgende Feueranmeldung ist am " . date("d.m.Y") . " um " . date("H:i") . " Uhr eingegangen.\n\n";
        $mailtext .= "Name      : " . $data['vorname'] . " " . $data['nachname'] . "\n";
        $mailtext .= "Strasse   : " . $data['strasse'] . "\n";
        $mailtext .= "PLZ Ort   : " . $data['plz'] . " " . $data['wohnort'] . "\n";
        $mailtext .= "Telefon   : " . $data['telefon'] . "\n";
        $mailtext .= "E-Mail    : " . $data['email'] . "\n";
        $mailtext .= "\n";
        $mailtext .= "Angaben zum geplanten Feuer:\n";
        $mailtext .= "Datum     : " . $data['datum'] . "\n";
        $mailtext .= "Uhrzeit   : " . $data['uhrzeit'] . "\n";
        $mailtext .= "\nBei abweichender Adresse\n";
        $mailtext .= "Strasse   : " . $data['feuer_strasse'] . "\n";
        $mailtext .= "PLZ       : " . $data['feuer_plz'] . "\n";
        $mailtext .= "Ort       : " . $data['feuer_ort'] . "\n";
        $mailtext .= "Bemerkung: \n" . $data['bemerkung'] . "\n";

        $adressen = array('info@ff-hennstedt.de', 'info@ff-hennstedt.de', 'j-u-andersson@t-online.de');

        foreach ($adressen as $key => $val) {
            mail($val, $subjekt, $mailtext, "from:Feuer Anmeldung <info@ff-hennstedt.de>");
        }
    }
}
