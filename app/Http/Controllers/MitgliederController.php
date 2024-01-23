<?php

namespace App\Http\Controllers;

use App\Http\Models\Layout;
use App\Http\Models\Mitglieder;
use App\Http\Models\MitgliederAlarm;
use App\Http\Traits\FxToolsTrait;
use App\Http\Traits\MitgliederTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class MitgliederController extends GroundController
{
    /***
     * Show the Overview for the Alarm
     */
    public function admin_overview_alarm()
    {
        $Alarm = MitgliederAlarm::all();
        $alarme = [];
        $Alarm->each(function ($a) use (&$alarme) {
            $alarme[$a->cms_mitglieder_id] = [
                'boss_925' => $a->boss_925,
                'handy' => $a->handy,
                'vollalarm' => $a->vollalarm,
                'loeschhilfe' => $a->loeschhilfe,
                'fuehrung' => $a->fuehrung,
                'sirene' => $a->sirene,
                'melder_pw' => $a->melder_pw,
                'tel_a' => $a->tel_a,
                'tel_b' => $a->tel_b,
                'tel_c' => $a->tel_c,
                'tel_d' => $a->tel_d,
                'pressewart' => $a->pressewart,
            ];
        });

        $data = [];
        $data['mitglieder'] = Mitglieder::where('deaktiv', '=', '0')->orderBy('vorname', 'ASC')->orderBy('nachname', 'ASC')
            ->get();
        $data['alarm'] = $alarme;
        $data['title'] = 'Schleifen';
        $content = view('mitglieder.schleifen')->with('data', $data)->render();
        $l = new Layout();
        return $l->layout_admin_content($content, $data['title'], false, false);
    }

    public function vorstand()
    {
        $data = [];
        $data['title'] = 'Vorstand';
        $content = Cache::remember(
            __CLASS__ . '_' . __FUNCTION__,
            Config::get('CacheConfig.cache_content_timeout'),
            function () use ($data) {
                $data = MitgliederTrait::getVorstand();
                return view('mitglieder.vorstand')->with('data', $data)->render();
            }
        );
        $l = new Layout();
        return $l->layout_content($content, $data['title'], false, false);
    }

    /**
     * @todo: Write vorstand_contact or it gives a blank site
     */
    public function vorstand_contact()
    {
        $data = [];
        $data['title'] = 'Vorstand';
        /*$content = Cache::remember('mitglieder', Config::get('CacheConfig.cache_content_timeout'), function () use (&$data) {
            $data['mitglieder'] = MitgliederTrait::getMitglieder();
            return view('mitglieder.mitglieder')->with('data', $data)->render();
        });*/
        $content = '';
        $l = new Layout();
        return $l->layout_content($content, $data['title'], false, false);
    }

    public function vorstand_conctact_post()
    {
    }

    public function mitglieder()
    {
        $data = [];
        $data['title'] = 'Mitglieder';
        $content = Cache::remember(
            __CLASS__ . '_' . __FUNCTION__,
            Config::get('CacheConfig.cache_content_timeout'),
            function () use (&$data) {
                $data['mitglieder'] = MitgliederTrait::getMitglieder();
                return view('mitglieder.mitglieder')->with('data', $data)->render();
            }
        );
        $l = new Layout();
        return $l->layout_content($content, $data['title'], false, false);
    }

    public function adminShow()
    {
        $data = [];
        $Mitglieder = Mitglieder::all()->sortBy('nachname')->sortBy('vorname');
        $mitglieder = [];
        $Mitglieder->each(function ($l) use (&$mitglieder) {
            $mitglieder[$l->id] = [
                'id' => $l->id,
                'nachname' => $l->nachname,
                'vorname' => $l->vorname,
                'dienstgrad' => $l->dienstgrad,
                'strasse' => $l->strasse,
            ];
        });
        $data['mitglieder'] = $mitglieder;
        $content = view('mitglieder.overview')->with('data', $data)->render();
        $l = new Layout();
        return $l->layout_admin_content($content, '', false, false);
    }

    public function adminAdd()
    {
        $data = [];
        $data['id'] = '';
        $data['dienstgrad'] = '';
        $data['strasse'] = '';
        $content = view('mitglieder.add_edit')->with('data', $data)->render();
        $l = new Layout();
        return $l->layout_admin_content($content, '', false, false);
    }

    public function adminEdit($id)
    {
        $data = [];
        $Mitglieder = Mitglieder::where('id', '=', $id)->get();
        $Mitglieder->each(function ($l) use (&$data) {
            $data['id'] = $l->id;
            $data['vorname'] = $l->vorname;
            $data['strasse'] = $l->strasse;
            $data['dienstgrad'] = $l->dienstgrad;
            $data['nachname'] = $l->nachname;
        });
        $content = view('mitglieder.add_edit')->with('data', $data)->render();
        $l = new Layout();
        return $l->layout_admin_content($content, '', false, false);
    }

    public function adminDelete($id)
    {
    }

    public function adminDeletePost()
    {
    }

    public function adminSave(Request $request)
    {
        $inputs = $requestall();
        if ($inputs['id'] !== 0) {
            $update = Mitglieder::find($inputs['id']);
            $update->vorname = FxToolsTrait::checkChar($inputs['vorname']);
            $update->strasse = FxToolsTrait::checkChar($inputs['strasse']);
            $update->dienstgrad = FxToolsTrait::checkChar($inputs['dienstgrad']);
            $update->nachname = FxToolsTrait::checkChar($inputs['nachname']);
            $update->save();
        } else {
            $add = new Mitglieder();
            $add->vorname = FxToolsTrait::checkChar($inputs['vorname']);
            $add->strasse = FxToolsTrait::checkChar($inputs['strasse']);
            $add->dienstgrad = FxToolsTrait::checkChar($inputs['dienstgrad']);
            $add->nachname = FxToolsTrait::checkChar($inputs['nachname']);
            $add->save();
        }
        return redirect()->route('admin.mitglieder');
    }

    public function admin_musikzug_show()
    {
        $data = [];
        $Mitglieder = Mitglieder::all()->sortBy('nachname')->sortBy('vorname');
        $musikzug = [];
        $Mitglieder->each(function ($l) use (&$musikzug) {
            $musikzug[$l->id] = [
                'id' => $l->id,
                'nachname' => $l->nachname,
                'vorname' => $l->vorname,
                'dienstgrad' => $l->dienstgrad,
                'strasse' => $l->strasse,
            ];
        });
        $data['musikzug'] = $musikzug;
        $content = view('musikzug.overview')->with('data', $data)->render();
        $l = new Layout();
        return $l->layout_admin_content($content, '', false, false);
    }

    public function admin_musikzug_add()
    {
        $data = [];
        $data['id'] = '';
        $data['dienstgrad'] = '';
        $data['strasse'] = '';
        $content = view('musikzug.add_edit')->with('data', $data)->render();
        $l = new Layout();
        return $l->layout_admin_content($content, '', false, false);
    }

    public function admin_musikzug_edit($id)
    {
        $data = [];
        $Mitglieder = Mitglieder::where('id', '=', $id)->get();
        $Mitglieder->each(function ($l) use (&$data) {
            $data['id'] = $l->id;
            $data['vorname'] = $l->vorname;
            $data['strasse'] = $l->strasse;
            $data['dienstgrad'] = $l->dienstgrad;
            $data['nachname'] = $l->nachname;
        });
        $content = view('musikzug.add_edit')->with('data', $data)->render();
        $l = new Layout();
        return $l->layout_admin_content($content, '', false, false);
    }

    public function admin_musikzug_delete($id)
    {
    }

    public function admin_musikzug_delete_post()
    {
    }

    public function admin_musikzug_save(Request $request)
    {
        $inputs = $request->all();
        if ($inputs['id'] !== 0) {
            $update = Mitglieder::find($inputs['id']);
            $update->vorname = FxToolsTrait::checkChar($inputs['vorname']);
            $update->strasse = FxToolsTrait::checkChar($inputs['strasse']);
            $update->dienstgrad = FxToolsTrait::checkChar($inputs['dienstgrad']);
            $update->nachname = FxToolsTrait::checkChar($inputs['nachname']);
            $update->save();
        } else {
            $add = new Mitglieder();
            $add->vorname = FxToolsTrait::checkChar($inputs['vorname']);
            $add->strasse = FxToolsTrait::checkChar($inputs['strasse']);
            $add->dienstgrad = FxToolsTrait::checkChar($inputs['dienstgrad']);
            $add->nachname = FxToolsTrait::checkChar($inputs['nachname']);
            $add->save();
        }
        return redirect()->route('admin.mitglieder');
    }


    public function getLeiter()
    {
    }

    public function LeiterEmail()
    {
    }

    public function LeiterEmailSend()
    {
    }

    public function getMitglieder()
    {
    }

    public function getMitgliedData()
    {
    }

    public function getMitgliederShort()
    {
        $data = array();
        $mitglied = array();
        $Mitglieder = Mitglieder::orderBy('vorname', 'ASC')->orderBy('nachname', 'ASC')->orderBy('ort', 'ASC')->get();
        $Mitglieder->each(function ($m) use (&$mitglied) {
            $mitglied[] = array(
                'id' => $m->id,
                'vorname' => $m->vorname,
                'nachname' => $m->nachname,
                'geburtstag' => $this->getGeburtstag($m->geburtstag, $m->sichtbar_geburtstag),
                'skype' => $this->getSkype($m->skype)
            );
        });

        return view('intern.mitglieder')->with('data', $data)->render();
    }

    /**
     * Schau nach wie ein Mitglied verfügbar ist
     * @todo Baue eine Tabelle mit Urlaub info
     */
    public function getVerfuegbarkeit()
    {
    }

    public function PWLost()
    {
        $data = array();
        return view('intern.lostpw')->with('data', $data)->render();
    }

    public function PWLostSend(Request $request)
    {
        $data = array();
        $email = $request->get('email');
        $Mitglied = Mitglieder::where('email', '=', $email)->get();
        if (count($Mitglied) === 0) {
            return redirect()->route('intern');
        }
        $Mitglied->each(function ($m) {
        });

        return view('intern.lostpw_success')->with('data', $data)->render();
    }

    public function Save()
    {
    }

    public static function Geburtstagsgruss()
    {
        /**
         * @todo Persönliche Gruskarte bauen
         * @todo Abfrage ob man eine Blindkopie erhalten möchte als Admin
         */

        $raw = 'DATE_FORMAT(CURDATE(), "%d.%c.") = DATE_FORMAT(`geburtstag`, "%d.%c.")';
        $db = Mitglieder::where('emailadresse', '!=', '')
            ->whereRaw(DB::raw($raw))
            ->get();
        $c = count($db);

        if ($c > 0) {
            $db->each(function ($mitglied) {
                $data = [];
                Mail::send(['email.birthday_html', 'email.birthday_text'], $data, function ($m) use ($mitglied) {
                    $m->from(env('MAILER_SENDER', env('MAILER_SENDER_OWNER')));
                    $m->to($mitglied->emailadresse, $mitglied->vorname . ' ' . $mitglied->nachname);
                    $m->bcc('j-mh@j-mh.de');
                    $m->subject('Herzlichen Glueckwunsch!');
                    //$m->attach($pathToFile, ['as' => $display, 'mime' => $mime]);
                });
                if ($mitglied->emailadresse2 !== '') {
                    Mail::send(['email.birthday_html', 'email.birthday_text'], $data, function ($m) use ($mitglied) {
                        $m->from(env('MAILER_SENDER', env('MAILER_SENDER_OWNER')));
                        $m->to($mitglied->emailadresse2, $mitglied->vorname . ' ' . $mitglied->nachname);
                        $m->bcc('j-mh@j-mh.de');
                        $m->subject('Herzlichen Glueckwunsch!');
                        //$m->attach($pathToFile, ['as' => $display, 'mime' => $mime]);
                    });
                }
            });
        }
        return $c;
    }

    public function admin_vorstand_show()
    {
        $data = [];
        $Partner = \App\Http\Models\Partner::all();
        $partner = [];
        $Partner->each(function ($m) use (&$partner) {
            $partner[$m->id] = [
                'id' => $m->id,
                'metatag' => $m->metatag,
                'metatag_text' => $m->metatag_text,
            ];
        });
        $data['partner'] = $partner;
        $content = view('partner.overview')->with('data', $data)->render();
        $l = new Layout();
        return $l->layout_admin_content($content, '', false, false);
    }

    public function admin_vorstand_add()
    {
        $data = [];
        $data['id'] = '';
        $data['metatag'] = '';
        $data['metatag_text'] = '';
        $content = view('partner.add_edit')->with('data', $data)->render();
        $l = new Layout();
        return $l->layout_admin_content($content, '', false, false);
    }

    public function admin_vorstand_edit($id)
    {
        $data = [];
        $Partner = \App\Http\Models\Partner::where('id', '=', $id)->get();
        $partner = [];
        $Partner->each(function ($m) use (&$data) {
            $data['id'] = $m->id;
            $data['metatag'] = $m->metatag;
            $data['metatag_text'] = $m->metatag_text;
        });
        $content = view('partner.add_edit')->with('data', $data)->render();
        $l = new Layout();
        return $l->layout_admin_content($content, '', false, false);
    }

    public function admin_vorstand_delete($id)
    {
    }

    public function admin_vorstand_delete_post()
    {
    }

    public function admin_vorstand_save(Request $request)
    {
        $inputs = $request->all();
        if ($inputs['id'] !== 0) {
            $update = Partner::find($inputs['id']);
            $update->metatag = FxToolsTrait::checkChar($inputs['metatag']);
            $update->metatag_text = FxToolsTrait::checkChar($inputs['metatag_text']);
            $update->save();
        } else {
            $add = new Partner();
            $add->metatag = FxToolsTrait::checkChar($inputs['metatag']);
            $add->metatag_text = FxToolsTrait::checkChar($inputs['metatag_text']);
            $add->save();
        }
        return redirect()->route('admin.partner');
    }
}
