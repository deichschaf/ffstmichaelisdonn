<?php

namespace App\Http\Controllers;

use App\Http\Models\FahrzeugWachenWappen;
use App\Http\Models\Video;
use App\Http\Models\Wachen;
use App\Http\Models\WachenBild;
use Illuminate\Html;
use Illuminate\Http\Request;
use App\Http\Traits\FlorianDithmarschenTrait;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Config;

class FlorianDithmarschenController extends GroundController
{
    use FlorianDithmarschenTrait;

    public function einleitung()
    {
        $l = new Layout();
        return $l->layout_content('', '', false, false, '3');
    }

    public function leitstelle()
    {
        $l = new Layout();
        return $l->layout_content('', '', false, false, '3');
    }

    public function historischer_rueckblick()
    {
        $l = new Layout();
        return $l->layout_content('', '', false, false, '3');
    }

    public function einsatzdisposition()
    {
        $l = new Layout();
        return $l->layout_content('', '', false, false, '3');
    }

    public function stichworte_irls_west()
    {
        $l = new Layout();
        return $l->layout_content('', '', false, false, '3');
    }

    public function stichworte_krls_west()
    {
        $l = new Layout();
        return $l->layout_content('', '', false, false, '3');
    }

    public function krls_west()
    {
        $l = new Layout();
        return $l->layout_content('', '', false, false, '3');
    }

    public function fahrzeugdatenbank(Request $request)
    {
        $data = [];
        $title = 'Fahrzeugdatenbank';
        $sort = 'orga';
        $organisation = '';
        $inputs = $request->all();
        if (array_key_exists('sort', $inputs)) {
            $sort = $inputs['sort'];
        }
        if (array_key_exists('organisation', $inputs)) {
            $organisation = $inputs['organisation'];
        }

        $data = $this->getFahrzeugDatenbank($sort, $organisation);
        $content = view('fahrzeugdatenbank.overview')->with('data', $data)->render();

        $l = new Layout();
        return $l->layout_content($content, $title, false, false, '3');
    }

    public function fahrzeugdatenbank_hiorg($hiorg)
    {
        $title = 'Fahrzeugdatenbank';
        $sort = 'orga';

        $data = $this->getFahrzeugDatenbank($sort, $hiorg);
        $content = view('fahrzeugdatenbank.overview')->with('data', $data)->render();

        $l = new Layout();
        return $l->layout_content($content, $title, false, false, '3');
    }

    public function getWache($id)
    {
        $data = [];
        $data['title'] = 'Fahrzeugdatenbank';
        if (!is_numeric($id)) {
            return redirect()->route('404');
        }
        if ($id <= 0) {
            return redirect()->route('404');
        }
        $count = $this->ifWacheExists($id);
        if ($count === 0) {
            return redirect()->route('404');
        }
        $wachendaten = $this->getWachenData($id);
        $data['title'] = $wachendaten->hiorg . ' ' . $wachendaten->hiort_name;
        $build_ort = $this->build_dithmarschen_karte($id, $wachendaten->hiorg, $wachendaten->xkoordinate, $wachendaten->ykoordinate);
        $wappen = $this->getWachenWappen($id);
        $wachenimpressionen = $this->getWachenImpressionen($id);
        $count_impressionen = count($wachenimpressionen);
        $wachenbilder = $this->getWachenBilder($id);
        $count_wachenbilder = count($wachenbilder);

        $aktuelle_fahrzeuge = [];
        $aktuell_funk = $this->getWachenFahrzeuge($id, '1', '0');
        $aktuell_ohne_funk = $this->getWachenFahrzeuge($id, '0', '0');
        foreach ($aktuell_funk as $k => $v) {
            $aktuelle_fahrzeuge[] = $v;
        }
        foreach ($aktuell_ohne_funk as $k => $v) {
            $aktuelle_fahrzeuge[] = $v;
        }

        $ehemalige_fahrzeuge = [];
        $ehemalig_funk = $this->getWachenFahrzeuge($id, '1', '1');
        $ehemalig__ohne_funk = $this->getWachenFahrzeuge($id, '0', '1');
        foreach ($ehemalig_funk as $k => $v) {
            $ehemalige_fahrzeuge[] = $v;
        }
        foreach ($ehemalig__ohne_funk as $k => $v) {
            $ehemalige_fahrzeuge[] = $v;
        }


        $content = view('fahrzeugdatenbank.wache')
            ->with('data', $data)
            ->with('wachendaten', $wachendaten)
            ->with('wappen', $wappen)
            ->with('count_impressionen', $count_impressionen)
            ->with('wachenbilder', $wachenbilder)
            ->with('count_wachenbilder', $count_wachenbilder)
            ->with('aktuelle_fahrzeuge', $aktuelle_fahrzeuge)
            ->with('ehemalige_fahrzeuge', $ehemalige_fahrzeuge)
            ->render();
        $l = new Layout();
        return $l->layout_content($content, $data['title'], false, false, '3');
    }

    public function getWacheBilder($id, $weitere = 0)
    {
    }

    public function getWacheImpressionen($id, $weitere = 0)
    {
        $data = [];
        $data['title'] = 'Fahrzeugdatenbank';
        if (!is_numeric($id)) {
            return redirect()->route('404');
        }
        if ($id <= 0) {
            return redirect()->route('404');
        }
        $count = $this->ifWacheExists($id);
        if ($count === 0) {
            return redirect()->route('404');
        }

        if (!is_numeric($id) || $id <= 0) {
            $weitere = 0;
        }
        $wachendaten = $this->getWachenData($id);
        $wachenimpressionen = $this->getWachenBilder($id);
        $c = count($wachenimpressionen);
        if ($weitere < 0 || $weitere > ($count - 1)) {
            $weitere = 0;
        }

        $data['title'] = $wachendaten->hiorg . ' ' . $wachendaten->hiort_name;
        $content = view('fahrzeugdatenbank.wache_impressionen')->with('data', $data)
            ->with('wachendaten', $wachendaten)
            ->with('impressionen', $wachenimpressionen)
            ->with('impression', $weitere)
            ->render();
        $l = new Layout();
        return $l->layout_content($content, $data['title'], false, false, '3');
    }

    public function getFahrzeug($id)
    {
        $data = [];
        $data['title'] = 'Fahrzeugdatenbank';
        if (!is_numeric($id)) {
            return redirect()->route('404');
        }
        if ($id <= 0) {
            return redirect()->route('404');
        }
        $count = $this->ifFahrzeugExists($id);
        if ($count === 0) {
            return redirect()->route('404');
        }
        $fahrzeugdaten = $this->getFahrzeugData($id);
        $fahrzeugbilder = $this->getFahrzeugBilder($id);
        $ausstattung = $this->getFahrzeugAusstattung($id);
        $wache = $this->getWachenData($fahrzeugdaten['cms_fahrzeug_ort_id']);
        $stationiert = $this->getFahrzeugStationen($id);

        $content = view('fahrzeugdatenbank.fahrzeug')
            ->with('data', $data)
            ->with('fahrzeugdaten', $fahrzeugdaten)
            ->with('fahrzeugbilder', $fahrzeugbilder)
            ->with('ausstattung', $ausstattung)
            ->with('wache', $wache)
            ->with('stationiert', $stationiert)
            ->render();
        $l = new Layout();
        return $l->layout_content($content, $data['title'], false, false, '3');
    }

    public function getFahrzeugBild($id, $bild_id)
    {
        $data = [];
        $data['title'] = 'Fahrzeugdatenbank';
        if (!is_numeric($id)) {
            return redirect()->route('404');
        }
        if ($id <= 0) {
            return redirect()->route('404');
        }
        $count = $this->ifFahrzeugExists($id);
        if ($count === 0) {
            return redirect()->route('404');
        }
        $fahrzeugdaten = $this->getFahrzeugData($id);
        $fahrzeugbilder = $this->getFahrzeugBilder($id);
        $content = view('fahrzeugdatenbank.fahrzeug_impressionen')
            ->with('data', $data)
            ->with('fahrzeugdaten', $fahrzeugdaten)
            ->with('fahrzeugbilder', $fahrzeugbilder)
            ->with('bild', $bild_id)
            ->render();
        $l = new Layout();
        return $l->layout_content($content, $data['title'], false, false, '3');
    }

    public function fahrzeugsuche()
    {
        $l = new Layout();
        return $l->layout_content('', '', false, false, '3');
    }

    public function videos()
    {
        $data = [];
        $data['title'] = 'Videos';
        $videos = Cache::remember(
            __CLASS__ . '_' . __FUNCTION__,
            Config::get('CacheConfig.cache_content_timeout'),
            function () {
                $videos = [];
                $Videos = Video::orderBy('video_titel', 'ASC')->get();
                $Videos->each(function ($v) use (&$videos) {
                    $videos[] = [
                        'id' => $v->id,
                        'title' => $v->video_titel,
                        'link' => $v->video_link,
                        'beschreibung' => $v->video_beschreibung,
                    ];
                });
                return $videos;
            }
        );
        $content = view('videos.videos')->with('data', $videos)->render();
        $l = new Layout();
        return $l->layout_content($content, $data['title'], false, false, '3');
    }

    public function adminShow()
    {
        $wachen = Cache::remember(
            __CLASS__ . '_' . __FUNCTION__,
            Config::get('CacheConfig.cache_content_timeout'),
            function () {
                $wachen = [];
                $Wachen = Wachen::where('hiort_name', '!=', '')
                    ->where('hiorg', '!=', '')
                    ->orderBy('hiorg', 'ASC')
                    ->orderBy('hiort_name', 'ASC')
                    ->get();
                $Wachen->each(function ($w) use (&$wachen) {
                    $wachen[] = [
                        'title' => $w->gemeinde,
                        'einheit' => $w->einheit,
                        'amt' => $w->amt,
                        'hiorg' => $w->hiorg,
                        'label' => $w->hiorg . ' ' . $w->hiort_name,
                        'id' => $w->id
                    ];
                });
                return $wachen;
            }
        );
        $content = view('fahrzeugdatenbank.admin_wachen_overview')
            ->with('data', $wachen)
            ->render();
        $l = new Layout();
        return $l->layout_admin_content($content, 'Admin Wachen', false, false);
    }

    public function adminAdd()
    {
        $data = [];
        $data['id'] = '0';
        $data['einheit'] = '';
        $data['hiorg'] = '';
        $data['hiort_name'] = '';
        $data['strasse'] = '';
        $data['plz'] = '';
        $data['ort'] = '';
        $data['gemeinde'] = '';
        $data['gemeinde_abc'] = '';
        $data['amt'] = '';
        $data['telefon'] = '';
        $data['telefax'] = '';
        $data['emailadresse'] = '';
        $data['homepage'] = '';
        $data['wehrfuehrer'] = '';
        $data['geo_l'] = '0';
        $data['geo_b'] = '0';
        $data['xkoordinate'] = '0';
        $data['ykoordinate'] = '0';
        $data['beschreibung'] = '';
        $data['bezeichnung'] = '';
        $data['wappen_id'] = '0';
        $data['wachentyp'] = '';
        $data['funkrufnamen'] = '';
        $data['wachen_token'] = $this->generateWachenToken();
        $wappen = $this->getWappenList();
        $content = view('fahrzeugdatenbank.admin_wachen_add_edit')
            ->with('data', $data)
            ->with('wappen', $wappen)
            ->render();
        $l = new Layout();
        return $l->layout_admin_content($content, 'Admin Wachen', false, false);
    }

    public function adminEdit($id)
    {
        $data = [];
        $Wachen = Wachen::where('id', '=', $id)->get();
        $Wachen->each(function ($w) use (&$data) {
            $data['id'] = $w->id;
            $data['einheit'] = $w->einheit;
            $data['hiorg'] = $w->hiorg;
            $data['hiort_name'] = $w->hiort_name;
            $data['strasse'] = $w->strasse;
            $data['plz'] = $w->plz;
            $data['ort'] = $w->ort;
            $data['gemeinde'] = $w->gemeinde;
            $data['gemeinde_abc'] = $w->gemeinde_abc;
            $data['amt'] = $w->amt;
            $data['telefon'] = $w->telefon;
            $data['telefax'] = $w->telefax;
            $data['emailadresse'] = $w->emailadresse;
            $data['homepage'] = $w->homepage;
            $data['wehrfuehrer'] = $w->wehrfuehrer;
            $data['geo_l'] = $w->geo_l;
            $data['geo_b'] = $w->geo_b;
            $data['xkoordinate'] = $w->xkoordinate;
            $data['ykoordinate'] = $w->ykoordinate;
            $data['beschreibung'] = $this->text_rep_input($w->beschreibung);
            $data['bezeichnung'] = $w->bezeichnung;
            $data['wappen_id'] = $w->wappen_id;
            $data['wachentyp'] = $w->wachentyp;
            $data['funkrufnamen'] = $w->funkrufnamen;
        });
        $data['wachen_token'] = $this->generateWachenToken();
        $wappen = $this->getWappenList();
        $content = view('fahrzeugdatenbank.admin_wachen_add_edit')
            ->with('data', $data)
            ->with('wappen', $wappen)
            ->render();
        $l = new Layout();
        return $l->layout_admin_content($content, 'Admin Wachen', false, false);
    }

    public function admin_copy($id)
    {
        $data = [];
        $Wachen = Wachen::where('id', '=', $id)->get();
        $Wachen->each(function ($w) use (&$data) {
            $data['id'] = $w->id;
            $data['einheit'] = $w->einheit;
            $data['hiorg'] = $w->hiorg;
            $data['hiort_name'] = $w->hiort_name;
            $data['strasse'] = $w->strasse;
            $data['plz'] = $w->plz;
            $data['ort'] = $w->ort;
            $data['gemeinde'] = $w->gemeinde;
            $data['gemeinde_abc'] = $w->gemeinde_abc;
            $data['amt'] = $w->amt;
            $data['telefon'] = $w->telefon;
            $data['telefax'] = $w->telefax;
            $data['emailadresse'] = $w->emailadresse;
            $data['homepage'] = $w->homepage;
            $data['wehrfuehrer'] = $w->wehrfuehrer;
            $data['geo_l'] = $w->geo_l;
            $data['geo_b'] = $w->geo_b;
            $data['xkoordinate'] = $w->xkoordinate;
            $data['ykoordinate'] = $w->ykoordinate;
            $data['beschreibung'] = $w->beschreibung;
            $data['bezeichnung'] = $w->bezeichnung;
            $data['wappen_id'] = $w->wappen_id;
            $data['wachentyp'] = $w->wachentyp;
            $data['funkrufnamen'] = $w->funkrufnamen;
        });
        $copy = new Wachen();
        $copy->einheit = $data['einheit'];
        $copy->hiorg = $data['hiorg'];
        $copy->hiort_name = $data['hiort_name'];
        $copy->strasse = $data['strasse'];
        $copy->plz = $data['plz'];
        $copy->ort = $data['ort'];
        $copy->gemeinde = $data['gemeinde'];
        $copy->gemeinde_abc = $data['gemeinde_abc'];
        $copy->amt = $data['amt'];
        $copy->telefon = $data['telefon'];
        $copy->telefax = $data['telefax'];
        $copy->emailadresse = $data['emailadresse'];
        $copy->homepage = $data['homepage'];
        $copy->wehrfuehrer = $data['wehrfuehrer'];
        $copy->geo_l = $data['geo_l'];
        $copy->geo_b = $data['geo_b'];
        $copy->xkoordinate = $data['xkoordinate'];
        $copy->ykoordinate = $data['ykoordinate'];
        $copy->beschreibung = $data['beschreibung'];
        $copy->bezeichnung = $data['bezeichnung'];
        $copy->wappen_id = $data['wappen_id'];
        $copy->wachentyp = $data['wachentyp'];
        $copy->funkrufnamen = $data['funkrufnamen'];
        $copy->save();
        $this->clearPageCache();
        return redirect()->route('admin.wachen.edit', ['id' => $id]);
    }

    public function adminDelete($id)
    {
        $data = [];
        $Wachen = Wachen::where('id', '=', $id)->get();
        $Wachen->each(function ($w) use (&$data) {
            $data['id'] = $w->id;
            $data['einheit'] = $w->einheit;
            $data['hiorg'] = $w->hiorg;
            $data['hiort_name'] = $w->hiort_name;
            $data['strasse'] = $w->strasse;
            $data['plz'] = $w->plz;
            $data['ort'] = $w->ort;
            $data['gemeinde'] = $w->gemeinde;
            $data['gemeinde_abc'] = $w->gemeinde_abc;
            $data['amt'] = $w->amt;
            $data['telefon'] = $w->telefon;
            $data['telefax'] = $w->telefax;
            $data['emailadresse'] = $w->emailadresse;
            $data['homepage'] = $w->homepage;
            $data['wehrfuehrer'] = $w->wehrfuehrer;
            $data['geo_l'] = $w->geo_l;
            $data['geo_b'] = $w->geo_b;
            $data['xkoordinate'] = $w->xkoordinate;
            $data['ykoordinate'] = $w->ykoordinate;
            $data['beschreibung'] = $this->text_rep_input($w->beschreibung);
            $data['bezeichnung'] = $w->bezeichnung;
            $data['wappen_id'] = $w->wappen_id;
            $data['wachentyp'] = $w->wachentyp;
            $data['funkrufnamen'] = $w->funkrufnamen;
        });
        $data['wachen_token'] = $this->generateWachenToken();
        $wappen = $this->getWappenList();
        $content = view('fahrzeugdatenbank.admin_wachen_delete')
            ->with('data', $data)
            ->with('wappen', $wappen)
            ->render();
        $l = new Layout();
        return $l->layout_admin_content($content, 'Admin Wachen', false, false);
    }

    public function adminDeletePost(Request $request)
    {
        $inputs = $request->all();
        $update = Wachen::where('id', '=', $inputs['id'])->delete();
        $this->clearPageCache();
        return redirect()->route('admin.wachen');
    }

    public function adminSave(Request $request)
    {
        $inputs = $request->all();
        if ($inputs['id'] != 0) {
            $save = Wachen::find($inputs['id']);
            $save->einheit = $this->checktext($inputs['einheit']);
            $save->hiorg = $this->checktext($inputs['hiorg']);
            $save->hiort_name = $this->checktext($inputs['hiort_name']);
            $save->strasse = $this->checktext($inputs['strasse']);
            $save->plz = $this->checktext($inputs['plz']);
            $save->ort = $this->checktext($inputs['ort']);
            $save->gemeinde = $this->checktext($inputs['gemeinde']);
            $save->gemeinde_abc = $this->checktext($inputs['gemeinde_abc']);
            $save->amt = $this->checktext($inputs['amt']);
            $save->telefon = $this->checktext($inputs['telefon']);
            $save->telefax = $this->checktext($inputs['telefax']);
            $save->emailadresse = $this->checktext($inputs['emailadresse']);
            $save->homepage = $this->checktext($inputs['homepage']);
            $save->wehrfuehrer = $this->checktext($inputs['wehrfuehrer']);
            $save->geo_l = $this->checktext($inputs['geo_l']);
            $save->geo_b = $this->checktext($inputs['geo_b']);
            $save->xkoordinate = $this->checktext($inputs['xkoordinate']);
            $save->ykoordinate = $this->checktext($inputs['ykoordinate']);
            $save->beschreibung = $this->checktext($inputs['beschreibung']);
            $save->bezeichnung = $this->checktext($inputs['bezeichnung']);
            $save->wappen_id = $this->checktext($inputs['wappen_id']);
            $save->wachentyp = $this->checktext($inputs['wachentyp']);
            $save->funkrufnamen = $this->checktext($inputs['funkrufnamen']);
            $save->save();
            $id = $inputs['id'];
        } else {
            $save = new Wachen();
            $save->einheit = $this->checktext($inputs['einheit']);
            $save->hiorg = $this->checktext($inputs['hiorg']);
            $save->hiort_name = $this->checktext($inputs['hiort_name']);
            $save->strasse = $this->checktext($inputs['strasse']);
            $save->plz = $this->checktext($inputs['plz']);
            $save->ort = $this->checktext($inputs['ort']);
            $save->gemeinde = $this->checktext($inputs['gemeinde']);
            $save->gemeinde_abc = $this->checktext($inputs['gemeinde_abc']);
            $save->amt = $this->checktext($inputs['amt']);
            $save->telefon = $this->checktext($inputs['telefon']);
            $save->telefax = $this->checktext($inputs['telefax']);
            $save->emailadresse = $this->checktext($inputs['emailadresse']);
            $save->homepage = $this->checktext($inputs['homepage']);
            $save->wehrfuehrer = $this->checktext($inputs['wehrfuehrer']);
            $save->geo_l = $this->checktext($inputs['geo_l']);
            $save->geo_b = $this->checktext($inputs['geo_b']);
            $save->xkoordinate = $this->checktext($inputs['xkoordinate']);
            $save->ykoordinate = $this->checktext($inputs['ykoordinate']);
            $save->beschreibung = $this->checktext($inputs['beschreibung']);
            $save->bezeichnung = $this->checktext($inputs['bezeichnung']);
            $save->wappen_id = $this->checktext($inputs['wappen_id']);
            $save->wachentyp = $this->checktext($inputs['wachentyp']);
            $save->funkrufnamen = $this->checktext($inputs['funkrufnamen']);
            $save->save();
            $id = $save->id;
        }
        /***
         * Set now the correction ID for the car images
         */
        $save = WachenBild::where('wachen_token', '=', $inputs['wachen_token'])
            ->update(['cms_fahrzeug_ort_id' => $id, 'wachen_token' => '']);

        $this->clearPageCache();

        return redirect()->route('admin.wachen');
    }

    private function generateWachenToken()
    {
        return md5(uniqid(rand(), true));
    }

    private function getWappenList()
    {
        $data = Cache::remember(
            __CLASS__ . '_' . __FUNCTION__,
            Config::get('CacheConfig.cache_content_timeout'),
            function () {
                $data = [];
                $data['0'] = 'Kein Wappen';
                $Wappen = FahrzeugWachenWappen::orderBy('wache', 'ASC')->get();
                $Wappen->each(function ($w) use (&$data) {
                    $data[$w->id] = $w->wache;
                });
                return $data;
            }
        );
        return $data;
    }
}
