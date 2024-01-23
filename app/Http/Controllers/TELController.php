<?php

namespace App\Http\Controllers;

use App\Http\Models\Kontakt;
use App\Http\Models\Layout;
use App\Http\Models\Mitglieder;
use App\Http\Models\MitgliederTELFunktionen;
use App\Http\Traits\ContactTrait;
use App\Http\Traits\MitgliederTrait;
use App\Http\Traits\TelLexikonTrait;
use Illuminate\Support\Facades\Session;
use App\Http\Traits\FxToolsTrait;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Config;
use Illuminate\Http\Request;
//use Illuminate\Validation\Validator;
use App\Http\Requests;

class TELController extends GroundController
{
    public function special_phonenumbers()
    {
        $data = [];
        $data['titel'] = 'Wichtige Telefonnummern';
        $l = new Layout();
        return $l->layout_content('', '', false, false);
    }

    public function tel_mitglieder()
    {
        $data = [];
        $data['titel'] = 'Mitglieder';
        $l = new Layout();
        return $l->layout_content('', '', false, false);
    }

    public function fuehrungsstufen()
    {
        $data = [];
        $data['titel'] = 'Mitglieder';
        $l = new Layout();
        return $l->layout_content('', '', false, false);
    }

    public function fuehrungseinheiten()
    {
        $data = [];
        $data['titel'] = 'Mitglieder';
        $l = new Layout();
        return $l->layout_content('', '', false, false);
    }

    public function tel_leiter()
    {
        $data = array();
        $data['wehrfuehrer'] = MitgliederTrait::getWehrfuehrer();
        $data['stvwehrfuehrer'] = MitgliederTrait::getStvWehrfuehrer();
        $content = view('tel.tel_leiter')->with('data', $data)->render();
        $l = new Layout();
        return $l->layout_content($content, '', false, false);
    }

    public function tel_leiter_kontakt($id, Request $request)
    {
        $leiter = MitgliederTrait::check_kontakt_exists($id, 'leiter');
        $stv_leiter = MitgliederTrait::check_kontakt_exists($id, 'stv_leiter');
        if ($leiter !== false) {
            $empfaenger = $leiter['vorname'] . ' ' . $leiter['nachname'];
        } elseif ($stv_leiter !== false) {
            $empfaenger = $stv_leiter['vorname'] . ' ' . $stv_leiter['nachname'];
        } else {
            return redirect('tel_leiter', '404');
        }

        $data = [];
        $data['empfaenger'] = $empfaenger;
        $data['empfaenger_id'] = $id;
        $data['spam'] = 0;
        $data['vorname'] = '';
        $data['nachname'] = '';
        $data['strasse'] = '';
        $data['hausno'] = '';
        $data['plz'] = '';
        $data['ort'] = '';
        $data['telefon'] = '';
        $data['email'] = '';
        $data['nachricht'] = '';

        $old = $request->flash();
        if (count($old) > 0) {
            foreach ($old as $k => $v) {
                if (array_key_exists($k, $data)) {
                    $data[$k] = $v;
                }
            }
        }

        $content = view('tel.tel_leiter_eintrag')->with('data', $data)->render();
        $l = new Layout();
        return $l->layout_content($content, '', false, false);
    }

    public function tel_leiter_kontakt_post(Request $request)
    {
        $inputs = $request->all();
        $data = [];
        $data['empfaenger_id'] = trim($inputs['empfaenger_id']);
        if (!is_numeric($data['empfaenger_id'])) {
            return redirect('tel_leiter', '404');
        }


        $pos = 'leiter';
        $id = $data['empfaenger_id'];
        $leiter = Cache::remember(
            __CLASS__ . '_' . __FUNCTION__ . '.leiter_' . $id . '_' . $pos,
            Config::get('CacheConfig.cache_content_timeout'),
            function () use ($id, $pos) {
                return MitgliederTrait::check_kontakt_exists($id, $pos);
            }
        );
        $pos = 'stv_leiter';
        $stv_leiter = Cache::remember(
            __CLASS__ . '_' . __FUNCTION__ . 'leiter_' . $id . '_' . $pos,
            Config::get('CacheConfig.cache_navi_timeout'),
            function () use ($id, $pos) {
                return MitgliederTrait::check_kontakt_exists($id, $pos);
            }
        );
        if ($leiter !== false) {
            $data['empfaenger'] = $leiter['vorname'] . ' ' . $leiter['nachname'];
            $data['email_empfaenger'] = $leiter['emailadresse'];
        } elseif ($stv_leiter !== false) {
            $data['empfaenger'] = $stv_leiter['vorname'] . ' ' . $stv_leiter['nachname'];
            $data['email_empfaenger'] = $stv_leiter['emailadresse'];
        } else {
            return redirect('tel_leiter', '404');
        }
        $data['vorname'] = trim($inputs['vorname']);
        $data['nachname'] = trim($inputs['nachname']);
        $data['strasse'] = trim($inputs['strasse']);
        $data['hausno'] = trim($inputs['hausno']);
        $data['plz'] = trim($inputs['plz']);
        $data['ort'] = trim($inputs['ort']);
        $data['telefon'] = trim($inputs['telefon']);
        $data['email'] = trim($inputs['email']);
        $data['nachricht'] = trim($inputs['nachricht']);
        $zeit = time();
        $data['datum'] = date('d.m.Y', $zeit);
        $data['zeit'] = date('H:i:s', $zeit);
        $data['datum_zeit'] = date('Y-m-d H:i:s', $zeit);

        $validator = \Validator::make($data, [
            'vorname' => 'required|name',
            'nachname' => 'required|name',
            'strasse' => 'required|street',
            'hausno' => 'required|street',
            'nachricht' => 'required|alphaNum',
            'telefon' => 'required|numeric',
            'plz' => 'required|plz',
            'ort' => 'required|city',
            'email' => 'required|email',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withInput($request->all())
                ->withErrors($validator->errors());
        }

        $save = ContactTrait::SaveContactForm($data);

        Mail::queue(['email.tel_leiter_html', 'email.tel_leiter_text'], $data, function ($m) use ($data) {
            $m->from(env('MAILER_SENDER', env('MAILER_SENDER_OWNER')));
            $m->to($data['email_empfaenger'], $data['empfaenger']);
            $m->bcc('j-mh@j-mh.de', $data['empfaenger']);
            $m->subject('Kontaktanfrage ' . HOMEPAGETITEL);
        });

        $content = view('tel.tel_leiter_kontakt_danke')->render();
        $l = new Layout();
        return $l->layout_content($content, '', false, false);
    }

    public function getTELFunktionen()
    {
        $mitglieder = [];
        $mitglieder_ids = [];
        $Mitglieder = Mitglieder::where('deaktiv', '=', '0')
            ->orderBy('nachname', 'ASC')
            ->orderBy('vorname', 'ASC')
            ->get();
        $Mitglieder->each(function ($m) use (&$mitglieder, &$mitglieder_ids) {
            $mitglieder[$m->id] = $m->vorname . ' ' . $m->nachname;
            $mitglieder_ids[] = $m->id;
        });

        $mitglied_funktion = '';
        $mitglieder_funktionen = [];
        $mitglieder_funktionen['S1'] = [];
        $mitglieder_funktionen['S2'] = [];
        $mitglieder_funktionen['S21'] = [];
        $mitglieder_funktionen['S22'] = [];
        $mitglieder_funktionen['S3'] = [];
        $mitglieder_funktionen['S31'] = [];
        $mitglieder_funktionen['S32'] = [];
        $mitglieder_funktionen['S33'] = [];
        $mitglieder_funktionen['S34'] = [];
        $mitglieder_funktionen['S4'] = [];
        $mitglieder_funktionen['S5'] = [];
        $mitglieder_funktionen['S6'] = [];
        $mitglieder_funktionen['IUK'] = [];

        $MitgliedTELFunktionen = MitgliederTELFunktionen::whereIn('mitglied_id', $mitglieder_ids)
            ->orderBy('name', 'ASC')
            ->get();
        $MitgliedTELFunktionen->each(function ($f) use (&$mitglied_funktion, &$mitglieder_funktionen, $mitglieder) {
            if (session('mitglieder_id') === $f->mitglied_id) {
                $mitglied_funktion = $f->primaer;
            }

            if ($f->primaer !== '') {
                $id = strtoupper($f->primaer);
                $uid = $mitglieder[$f->mitglied_id];
                $mitglieder_funktionen[$id][] = $uid;
            }
            if ($f->sekundaer !== '') {
                $id = strtoupper($f->sekundaer);
                $uid = $mitglieder[$f->mitglied_id];
                $mitglieder_funktionen[$id][] = '(' . $uid . ')';
            }
            if ($f->tertiaer !== '') {
                $id = strtoupper($f->tertiaer);
                $uid = $mitglieder[$f->mitglied_id];
                $mitglieder_funktionen[$id][] = '(' . $uid . ')';
            }
        });

        /***
         * Check wer eine S-Funktion hat
         * IuK darf nur IuK und S6 sehen
         * Sx darf alles sehen, wer wo für Standartmäßig ist
         * primär ist die normale Funktion, sekundär und terziär gehört in Klammeern
         */
        $content = view('intern.mitglieder_tel_funktionen')
            ->with(['mitglieder_funktionen' => $mitglieder_funktionen])
            ->with(['mitglied_funktion' => $mitglied_funktion])
            ->render();
        $l = new Layout();
        return $l->layout_content($content, '', false, false);
    }

    public function tel_lexikon($char = 'a')
    {
        $content = TelLexikonTrait::show($char);
        $l = new Layout();
        return $l->layout_content($content, '', false, false);
    }

    public function leitung()
    {
        $l = new Layout();
        return $l->layout_content('', '', false, false);
    }

    public function funktionstraeger()
    {
        $data = array();
        $content = view('tel.funktionstraeger')->with('data', $data)->render();
        $l = new Layout();
        return $l->layout_content($content, '', false, false);
    }

    public function s1()
    {
        $l = new Layout();
        return $l->layout_content('', '', false, false);
    }

    public function s2()
    {
        $l = new Layout();
        return $l->layout_content('', '', false, false);
    }

    public function s3()
    {
        $l = new Layout();
        return $l->layout_content('', '', false, false);
    }

    public function s4()
    {
        $l = new Layout();
        return $l->layout_content('', '', false, false);
    }

    public function s5()
    {
        $l = new Layout();
        return $l->layout_content('', '', false, false);
    }

    public function s6()
    {
        $l = new Layout();
        return $l->layout_content('', '', false, false);
    }

    public function iuk()
    {
        $l = new Layout();
        return $l->layout_content('', '', false, false);
    }

    public function was_ist_die_tel()
    {
        $l = new Layout();
        return $l->layout_content('', '', false, false);
    }

    public function hochwasser_sachsen_anhalt()
    {
        $l = new Layout();
        return $l->layout_content('', '', false, false);
    }

    public function unwetter_brunsbuettel()
    {
        $l = new Layout();
        return $l->layout_content('', '', false, false);
    }

    public function fd_katastrophenschutz()
    {
        $l = new Layout();
        return $l->layout_content('', '', false, false);
    }

    public function kfv_dithmarschen()
    {
        $l = new Layout();
        return $l->layout_content('', '', false, false);
    }

    public function lzg_dithmarschen()
    {
        $l = new Layout();
        return $l->layout_content('', '', false, false);
    }

    public function vorsorge_fuer_den_notfall()
    {
        $l = new Layout();
        return $l->layout_content('', '', false, false);
    }

    public function fuehrungsorganisationen()
    {
        $data = array();
        $content = view('tel.fuehrungsorganisationen')->with('data', $data)->render();
        $l = new Layout();
        return $l->layout_content($content, '', false, false);
    }
}
