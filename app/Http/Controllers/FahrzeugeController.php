<?php

namespace App\Http\Controllers;

use App\Http\Models\FahrzeugAusstattung;
use App\Http\Models\FahrzeugBilder;
use App\Http\Models\Fahrzeuge;
use App\Http\Models\FahrzeugKennung;
use App\Http\Models\FahrzeugStandorteVerlauf;
use App\Http\Models\FahrzeugStandorteVerlaufKarte;
use App\Http\Models\Layout;
use App\Http\Models\Wachen;
use App\Http\Traits\FxToolsFilesTrait;
use App\Http\Traits\ImageTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\JsonResponse;

class FahrzeugeController extends GroundController
{
    private $filepath = '/fileadmin/fahrzeuge/';

    public function getOverview():JsonResponse
    {
        try {
            $data = Cache::remember(
                __CLASS__ . '_' . __FUNCTION__,
                Config::get(42000),
                function () {
                    $data = [];
                    $data['links'] = '';
                    $data['title'] = 'Fahrzeuge';
                    $data['fahrzeuge'] = $this->getEinsatzfahrzeugeController('0');
                    $data['ehemalige_fahrzeuge'] = $this->getEinsatzfahrzeugeController('1');
                    $data['code'] = 200;
                    return $data;
                }
            );
            return response()->json($data, 200);
        } catch (\Exception $exception) {
            return response()->json([
                'code' => $exception->getCode(),
                'message' => $exception->getMessage()
            ], 400);
        }
    }

    public function fahrzeuge_show()
    {
        $data = [];
        $data['links'] = '';
        $data['title'] = 'Fahrzeuge';
        $data['fahrzeuge'] = $this->getEinsatzfahrzeugeController('0');
        $data['ehemalige_fahrzeuge'] = $this->getEinsatzfahrzeugeController('1');

        $content = view('fahrzeuge.fahrzeuge_overview')->with('data', $data)->render();

        $l = new Layout();
        return $l->layout_content($content, $data['title'], false, false);
    }

    private function car_title()
    {
        $kennung = [];
        $FahrzeugKennung = FahrzeugKennung::where('aktiv', '=', '1')->get();
        $FahrzeugKennung->each(function ($fzk) use (&$kennung) {
            if (!array_key_exists($fzk->fahrzeug_id, $kennung)) {
                $kennung[$fzk->fahrzeug_id] = [];
            }
            if ($fzk->florian === '1') {
                $kennung[$fzk->fahrzeug_id]['florian'] = $fzk->fahrzeugkennung;
            }
            if ($fzk->kater === '1') {
                $kennung[$fzk->fahrzeug_id]['kater'] = $fzk->fahrzeugkennung;
            }
            if ($fzk->rotkreuz === '1') {
                $kennung[$fzk->fahrzeug_id]['rotkreuz'] = $fzk->fahrzeugkennung;
            }
            if ($fzk->heros === '1') {
                $kennung[$fzk->fahrzeug_id]['heros'] = $fzk->fahrzeugkennung;
            }
            if ($fzk->kreis === '1') {
                $kennung[$fzk->fahrzeug_id]['kreis'] = $fzk->fahrzeugkennung;
            }
        });
        return $kennung;
    }

    private function car_title_Full($id)
    {
        $kennung = $this->car_title();
        $rufnamen = '';
        if (array_key_exists($id, $kennung)) {
            if (count($kennung[$id]) > 0) {
                $funk = [];
                if (array_key_exists('florian', $kennung[$id])) {
                    $funk[] = $kennung[$id]['florian'];
                }
                if (array_key_exists('kater', $kennung[$id])) {
                    $funk[] = $kennung[$id]['kater'];
                }
                if (array_key_exists('heros', $kennung[$id])) {
                    $funk[] = $kennung[$id]['heros'];
                }
                if (array_key_exists('rotkreuz', $kennung[$id])) {
                    $funk[] = $kennung[$id]['rotkreuz'];
                }
                if (array_key_exists('kreis', $kennung[$id])) {
                    $funk[] = $kennung[$id]['kreis'];
                }

                $rufnamen = '<li>' . $funk['0'] . '</li>';
                unset($funk['0']);
                if (count($funk) > 0) {
                    $rufnamen .= '<li>(' . join(')</li><li>(', $funk) . ')</li>';
                }
                $rufnamen = '<ul class="funkrufnamen">' . $rufnamen . '</ul>';
            }
        }
        return $rufnamen;
    }

    public function show_details($id)
    {
        $data = [];
        if (!is_numeric($id)) {
            return redirect()->route('fahrzeuge');
        }

        $Fahrzeug = Fahrzeuge::where('id', '=', $id)->get();
        if (count($Fahrzeug) === 0) {
            return redirect()->route('fahrzeuge');
        }
        $Fahrzeug->each(function ($fz) use (&$data) {
            $data['id'] = $fz->id;
            $data['title'] = 'Fahrzeuge - ' . $fz->fahrzeug;
            $data['fahrzeug'] = $fz->fahrzeug;
            $data['allgemein'] = $fz->allgemein;
            $data['bild'] = FxToolsFilesTrait::check_file_delete($this->filepath, $fz->bild);
            $daten = [];
            if ($fz->kennzeichen !== '') {
                $daten [] = array('Kennzeichen:', $fz->kennzeichen);
            }
            $kennung = $this->car_title_Full($fz->id);
            if ($kennung !== '') {
                $daten[] = array('Funkrufname:', $kennung);
            }
            if ($fz->zugelassen !== '') {
                $daten [] = array('Zugelassen:', $fz->zugelassen);
            }
            if ($fz->motorleistung !== '') {
                $daten [] = array('Motorleistung:', $fz->motorleistung);
            }
            if ($fz->fahrgestell !== '') {
                $daten [] = array('Fahrgestell:', $fz->fahrgestell);
            }
            if ($fz->aufbau !== '') {
                $daten [] = array('Aufbau:', $fz->aufbau);
            }
            if ($fz->zulaessiges_gesamtgewicht !== '') {
                $daten [] = array('zulässiges Gesamtgewicht:', $fz->zulaessiges_gesamtgewicht);
            }
            if ($fz->ausfahrhoehe !== '' && $fz->ausfahrhoehe !== 0) {
                $daten [] = array('Ausfahrhöhe:', $fz->ausfahrhoehe);
            }
            if ($fz->sitzplaetze !== '' && $fz->sitzplaetze !== 0) {
                $daten [] = array('Sitzplätze:', $fz->sitzplaetze);
            }
            if ($fz->beladung_ueber_normal !== '') {
                $daten [] = array('Beladung über Normal:', $fz->beladung_ueber_normal);
            }
            if ($fz->tank !== '') {
                $daten [] = array('Tank:', $fz->tank);
            }
            if ($fz->besonderheiten !== '') {
                $daten [] = array('Besonderheiten:', $fz->besonderheiten);
            }
            if ($fz->ausrangiert === '1') {
                $daten [] = array('&nbsp;', 'Fahrzeug ausrangiert');
            }

            $FahrzeugAusstattung = FahrzeugAusstattung::where('fahrzeug_id', '=', $fz->id)->orderBy('fahrzeug_ausstattung', 'ASC')->get();
            if (count($FahrzeugAusstattung) > 0) {
                $fahrzeug_data = [];
                $FahrzeugAusstattung->each(function ($fza) use (&$fahrzeug_data) {
                    $fahrzeug_data[] = $fza->fahrzeug_ausstattung;
                });
                if (count($fahrzeug_data) > 0) {
                    $daten [] = array('Ausstattung:', '<ul><li>' . join('</li><li>', $fahrzeug_data) . '</li></ul>');
                }
            }
            //$data['daten'] = $this->build_rows($daten, 1);
            $data['daten'] = view('fahrzeuge.partials.fahrzeug_daten')->with('daten', $daten)->render();

            $bilder = [];
            $FahrzeugBilder = FahrzeugBilder::where('fahrzeug_id', '=', $fz->id)->orderBy('pos', 'ASC')->get();
            if (count($FahrzeugBilder) > 0) {
                $FahrzeugBilder->each(function ($fzb) use (&$bilder) {
                    $bild = FxToolsFilesTrait::check_file_delete($this->filepath, $fzb->fahrzeug_bild);
                    if ($bild !== '') {
                        $bilder[] = array(
                            'bild' => $bild,
                            'titel' => $fzb->fahrzeug_bild_titel,
                            'beschreibung' => $fzb->fahrzeug_bild_beschreibung,
                        );
                    }
                });
            }
            $data['bilder'] = $bilder;
        });

        $content = view('fahrzeuge.fahrzeuge_details')->with('data', $data)->render();
        Session::put('social_sharing.type', 'article');

        $l = new Layout();
        return $l->layout_content($content, $data['title'], false, false);
    }

    private function getEinsatzfahrzeugeController($ehemalige = 0)
    {
        $fahrzeuge = [];
        $f = $this->getFahrzeugeController('!=', $ehemalige);
        if (count($f) > 0) {
            $fahrzeuge = array_merge($fahrzeuge, $f);
        }
        $f = $this->getFahrzeugeController('=', $ehemalige);
        if (count($f) > 0) {
            $fahrzeuge = array_merge($fahrzeuge, $f);
        }
        return $fahrzeuge;
    }

    public function getStationen()
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
                    $wachen[$w->id] = $w->hiorg . ' ' . $w->hiort_name;
                });
                return $wachen;
            }
        );
        return $wachen;
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
                        'label' => $w->hiorg . ' ' . $w->hiort_name,
                        'id' => $w->id
                    ];
                });
                return $wachen;
            }
        );

        foreach ($wachen as $k_wachen => $v_wachen) {
            $fahrzeuge = [];
            $aktuell_funk = $this->getWachenFahrzeuge($v_wachen['id'], '1', '0');
            $aktuell_ohne_funk = $this->getWachenFahrzeuge($v_wachen['id'], '0', '0');
            foreach ($aktuell_funk as $k => $v) {
                $fahrzeuge[] = $v;
            }
            foreach ($aktuell_ohne_funk as $k => $v) {
                $fahrzeuge[] = $v;
            }

            $ehemalig_funk = $this->getWachenFahrzeuge($v_wachen['id'], '1', '1');
            $ehemalig__ohne_funk = $this->getWachenFahrzeuge($v_wachen['id'], '0', '1');
            foreach ($ehemalig_funk as $k => $v) {
                $fahrzeuge[] = $v;
            }
            foreach ($ehemalig__ohne_funk as $k => $v) {
                $fahrzeuge[] = $v;
            }
            $wachen[$k_wachen]['fahrzeuge'] = $fahrzeuge;
        }
        $content = view('fahrzeuge.admin_fahrzeuge_overview')->with('data', $wachen)->render();
        $l = new Layout();
        return $l->layout_admin_content($content, 'Admin Fahrzeuge', false, false);
    }

    private function generateCarToken()
    {
        return md5(uniqid(rand(), true));
    }

    public function adminAdd()
    {
        $data = [];
        $data['id'] = '0';
        $data['fahrzeug'] = '';
        $data['kennzeichen'] = '';
        $data['bos_kennung'] = '';
        $data['zugelassen'] = '';
        $data['motorleistung'] = '';
        $data['fahrgestell'] = '';
        $data['zulaessiges_gesamtgewicht'] = '';
        $data['aufbau'] = '';
        $data['ausfahrhoehe'] = '';
        $data['sitzplaetze'] = '';
        $data['beladung_ueber_normal'] = '';
        $data['besonderheiten'] = '';
        $data['ausrangiert'] = '0';
        $data['tank'] = '';
        $data['allgemein'] = '';
        $data['cms_fahrzeug_ort_id'] = '0';
        $data['funkorganisation'] = '';
        $data['verwendung'] = '';
        $data['verwendung_id'] = '0';
        $data['wasserzeichen'] = '0';
        $data['baujahr'] = '';
        $data['beschreibungstext'] = '';
        $data['fahrzeug_token'] = $this->generateCarToken();
        $stationen = $this->getStationen();
        $content = view('fahrzeuge.admin_fahrzeug_add_edit')
            ->with('data', $data)
            ->with('stationen', $stationen)
            ->render();
        $l = new Layout();
        return $l->layout_admin_content($content, 'Admin Fahrzeuge', false, false);
    }

    public function adminEdit($id)
    {
        $data = [];
        $Fahrzeug = Fahrzeuge::where('id', '=', $id)->get();
        $Fahrzeug->each(function ($f) use (&$data) {
            $data['id'] = $f->id;
            $data['fahrzeug'] = $f->fahrzeug;
            $data['kennzeichen'] = $f->kennzeichen;
            $data['bos_kennung'] = $f->bos_kennung;
            $data['zugelassen'] = $f->zugelassen;
            $data['motorleistung'] = $f->motorleistung;
            $data['fahrgestell'] = $f->fahrgestell;
            $data['zulaessiges_gesamtgewicht'] = $f->zulaessiges_gesamtgewicht;
            $data['aufbau'] = $f->aufbau;
            $data['ausfahrhoehe'] = $f->ausfahrhoehe;
            $data['sitzplaetze'] = $f->sitzplaetze;
            $data['beladung_ueber_normal'] = $f->beladung_ueber_normal;
            $data['besonderheiten'] = $f->besonderheiten;
            $data['ausrangiert'] = $f->ausrangiert;
            $data['tank'] = $f->tank;
            $data['allgemein'] = $f->allgemein;
            $data['cms_fahrzeug_ort_id'] = $f->cms_fahrzeug_ort_id;
            $data['funkorganisation'] = $f->funkorganisation;
            $data['verwendung'] = $f->verwendung;
            $data['verwendung_id'] = '0';
            $data['baujahr'] = $f->baujahr;
            $data['beschreibungstext'] = $this->text_rep_input($f->beschreibungstext);
        });
        $data['fahrzeug_token'] = $this->generateCarToken();
        $stationen = $this->getStationen();
        $content = view('fahrzeuge.admin_fahrzeug_add_edit')
            ->with('data', $data)
            ->with('stationen', $stationen)
            ->render();
        $l = new Layout();
        return $l->layout_admin_content($content, 'Admin Fahrzeuge', false, false);
    }

    public function admin_copy($id)
    {
        $data = [];
        $Fahrzeug = Fahrzeuge::where('id', '=', $id)->get();
        $Fahrzeug->each(function ($f) use (&$data) {
            $data['id'] = $f->id;
            $data['fahrzeug'] = $f->fahrzeug;
            $data['kennzeichen'] = $f->kennzeichen;
            $data['bos_kennung'] = $f->bos_kennung;
            $data['zugelassen'] = $f->zugelassen;
            $data['motorleistung'] = $f->motorleistung;
            $data['fahrgestell'] = $f->fahrgestell;
            $data['zulaessiges_gesamtgewicht'] = $f->zulaessiges_gesamtgewicht;
            $data['aufbau'] = $f->aufbau;
            $data['ausfahrhoehe'] = $f->ausfahrhoehe;
            $data['sitzplaetze'] = $f->sitzplaetze;
            $data['beladung_ueber_normal'] = $f->beladung_ueber_normal;
            $data['besonderheiten'] = $f->besonderheiten;
            $data['ausrangiert'] = $f->ausrangiert;
            $data['tank'] = $f->tank;
            $data['allgemein'] = $f->allgemein;
            $data['cms_fahrzeug_ort_id'] = $f->cms_fahrzeug_ort_id;
            $data['funkorganisation'] = $f->funkorganisation;
            $data['verwendung'] = $f->verwendung;
            $data['verwendung_id'] = '0';
            $data['baujahr'] = $f->baujahr;
            $data['beschreibungstext'] = $f->beschreibungstext;
        });

        /***
         * Add now new entry
         */
        $copy = new Fahrzeuge();
        $copy->fahrzeug = $data['fahrzeug'];
        $copy->kennzeichen = $data['kennzeichen'];
        $copy->bos_kennung = $data['bos_kennung'];
        $copy->zugelassen = $data['zugelassen'];
        $copy->motorleistung = $data['motorleistung'];
        $copy->fahrgestell = $data['fahrgestell'];
        $copy->zulaessiges_gesamtgewicht = $data['zulaessiges_gesamtgewicht'];
        $copy->aufbau = $data['aufbau'];
        $copy->ausfahrhoehe = $data['ausfahrhoehe'];
        $copy->sitzplaetze = $data['sitzplaetze'];
        $copy->beladung_ueber_normal = $data['beladung_ueber_normal'];
        $copy->besonderheiten = $data['besonderheiten'];
        $copy->ausrangiert = $data['ausrangiert'];
        $copy->tank = $data['tank'];
        $copy->allgemein = $data['allgemein'];
        $copy->cms_fahrzeug_ort_id = $data['cms_fahrzeug_ort_id'];
        $copy->funkorganisation = $data['funkorganisation'];
        $copy->verwendung = $data['verwendung'];
        $copy->verwendung_id = $data['verwendung_id'];
        $copy->baujahr = $data['baujahr'];
        $copy->beschreibungstext = $data['beschreibungstext'];
        $copy->erstellt_am = date('Y-m-d H:i:s');
        $copy->geaendert_am = date('Y-m-d H:i:s');
        $copy->last_upload = date('Y-m-d H:i:s');
        $copy->last_update = date('Y-m-d H:i:s');
        $copy->status_dienst = '';
        $copy->save();
        $id = $copy->id;

        $wachen = $this->getStationen();
        $sharecard = new FahrzeugStandorteVerlaufKarte();
        $sharecard->karte = $data['fahrzeug'] . ' ' . $wachen[$data['cms_fahrzeug_ort_id']];
        $sharecard->save();
        $share_id = $sharecard->id;
        $sharecardDetail = new FahrzeugStandorteVerlauf();
        $sharecardDetail->cms_fahrzeug_standorte_verlaufkarte_id = $share_id;
        $sharecardDetail->von = '';
        $sharecardDetail->bis = '';
        $sharecardDetail->fahrzeug_id = $id;
        $sharecardDetail->funkrufnamen = $data['bos_kennung'];
        $sharecardDetail->kennzeichen = $data['kennzeichen'];
        $sharecardDetail->save();
        $this->clearPageCache();
        return redirect()->route('admin.fahrzeuge.edit', ['id' => $id]);
    }

    public function adminDelete($id)
    {
        $data = [];
        $Fahrzeug = Fahrzeuge::where('id', '=', $id)->get();
        $Fahrzeug->each(function ($f) use (&$data) {
            $data['id'] = $f->id;
            $data['fahrzeug'] = $f->fahrzeug;
            $data['kennzeichen'] = $f->kennzeichen;
            $data['bos_kennung'] = $f->bos_kennung;
            $data['zugelassen'] = $f->zugelassen;
            $data['motorleistung'] = $f->motorleistung;
            $data['fahrgestell'] = $f->fahrgestell;
            $data['zulaessiges_gesamtgewicht'] = $f->zulaessiges_gesamtgewicht;
            $data['aufbau'] = $f->aufbau;
            $data['ausfahrhoehe'] = $f->ausfahrhoehe;
            $data['sitzplaetze'] = $f->sitzplaetze;
            $data['beladung_ueber_normal'] = $f->beladung_ueber_normal;
            $data['besonderheiten'] = $f->besonderheiten;
            $data['ausrangiert'] = $f->ausrangiert;
            $data['tank'] = $f->tank;
            $data['allgemein'] = $f->allgemein;
            $data['cms_fahrzeug_ort_id'] = $f->cms_fahrzeug_ort_id;
            $data['funkorganisation'] = $f->funkorganisation;
            $data['verwendung'] = $f->verwendung;
            $data['verwendung_id'] = '0';
            $data['baujahr'] = $f->baujahr;
            $data['beschreibungstext'] = $this->text_rep_input($f->beschreibungstext);
        });
        $data['fahrzeug_token'] = $this->generateCarToken();
        $stationen = $this->getStationen();
        $content = view('fahrzeuge.admin_fahrzeug_delete')
            ->with('data', $data)
            ->with('stationen', $stationen)
            ->render();
        $l = new Layout();
        return $l->layout_admin_content($content, 'Admin Fahrzeuge', false, false);
    }

    public function adminDeletePost(Request $request)
    {
        $inputs = $request->all();
        $update = Fahrzeuge::where('id', '=', $inputs['id'])->delete();
        $this->clearPageCache();
        return redirect()->route('admin.fahrzeuge');
    }

    public function adminSave(Request $request)
    {
        $inputs = $request->all();
        if (!array_key_exists('wasserzeichen', $inputs)) {
            $inputs['wasserzeichen'] = '0';
        }
        if (!array_key_exists('ausrangiert', $inputs)) {
            $inputs['ausrangiert'] = '0';
        }

        if ($inputs['id'] !== 0) {
            $save = Fahrzeuge::find($inputs['id']);
            $save->fahrzeug = $this->checktext($inputs['fahrzeug']);
            $save->kennzeichen = $this->checktext($inputs['kennzeichen']);
            $save->bos_kennung = $this->checktext($inputs['bos_kennung']);
            $save->zugelassen = $this->checktext($inputs['zugelassen']);
            $save->motorleistung = $this->checktext($inputs['motorleistung']);
            $save->fahrgestell = $this->checktext($inputs['fahrgestell']);
            $save->zulaessiges_gesamtgewicht = $this->checktext($inputs['zulaessiges_gesamtgewicht']);
            $save->aufbau = $this->checktext($inputs['aufbau']);
            $save->ausfahrhoehe = $this->checktext($inputs['ausfahrhoehe']);
            $save->sitzplaetze = $this->checktext($inputs['sitzplaetze']);
            $save->beladung_ueber_normal = $this->checktext($inputs['beladung_ueber_normal']);
            $save->besonderheiten = $this->checktext($inputs['besonderheiten']);
            $save->ausrangiert = $this->checktext($inputs['ausrangiert']);
            $save->tank = $this->checktext($inputs['tank']);
            $save->allgemein = $this->checktext($inputs['allgemein']);
            $save->cms_fahrzeug_ort_id = $this->checktext($inputs['cms_fahrzeug_ort_id']);
            $save->funkorganisation = $this->checktext($inputs['funkorganisation']);
            $save->verwendung = $this->checktext($inputs['verwendung']);
            $save->verwendung_id = '0';
            $save->baujahr = $this->checktext($inputs['baujahr']);
            $save->beschreibungstext = $this->text_rep_html($this->checktext($inputs['beschreibungstext']));
            $save->erstellt_am = date('Y-m-d H:i:s');
            $save->geaendert_am = date('Y-m-d H:i:s');
            $save->last_upload = date('Y-m-d H:i:s');
            $save->last_update = date('Y-m-d H:i:s');
            $save->status_dienst = '';
            $save->save();
            $id = $inputs['id'];

            $wachen = $this->getStationen();
            $sharecard = new FahrzeugStandorteVerlaufKarte();
            $sharecard->karte = $this->checktext($inputs['fahrzeug']) . ' ' . $wachen[$inputs['cms_fahrzeug_ort_id']];
            $sharecard->save();
            $share_id = $sharecard->id;
            $sharecardDetail = new FahrzeugStandorteVerlauf();
            $sharecardDetail->cms_fahrzeug_standorte_verlaufkarte_id = $share_id;
            $sharecardDetail->von = '';
            $sharecardDetail->bis = '';
            $sharecardDetail->fahrzeug_id = $id;
            $sharecardDetail->funkrufnamen = $this->checktext($inputs['bos_kennung']);
            $sharecardDetail->kennzeichen = $this->checktext($inputs['kennzeichen']);
            $sharecardDetail->save();
        } else {
            $save = new Fahrzeuge();
            $save->fahrzeug = $this->checktext($inputs['fahrzeug']);
            $save->kennzeichen = $this->checktext($inputs['kennzeichen']);
            $save->bos_kennung = $this->checktext($inputs['bos_kennung']);
            $save->zugelassen = $this->checktext($inputs['zugelassen']);
            $save->motorleistung = $this->checktext($inputs['motorleistung']);
            $save->fahrgestell = $this->checktext($inputs['fahrgestell']);
            $save->zulaessiges_gesamtgewicht = $this->checktext($inputs['zulaessiges_gesamtgewicht']);
            $save->aufbau = $this->checktext($inputs['aufbau']);
            $save->ausfahrhoehe = $this->checktext($inputs['ausfahrhoehe']);
            $save->sitzplaetze = $this->checktext($inputs['sitzplaetze']);
            $save->beladung_ueber_normal = $this->checktext($inputs['beladung_ueber_normal']);
            $save->besonderheiten = $this->checktext($inputs['besonderheiten']);
            $save->ausrangiert = $this->checktext($inputs['ausrangiert']);
            $save->tank = $this->checktext($inputs['tank']);
            $save->allgemein = $this->checktext($inputs['allgemein']);
            $save->cms_fahrzeug_ort_id = $this->checktext($inputs['cms_fahrzeug_ort_id']);
            $save->funkorganisation = $this->checktext($inputs['funkorganisation']);
            $save->verwendung = $this->checktext($inputs['verwendung']);
            $save->verwendung_id = '0';
            $save->baujahr = $this->checktext($inputs['baujahr']);
            $save->beschreibungstext = $this->text_rep_html($this->checktext($inputs['beschreibungstext']));
            $save->erstellt_am = date('Y-m-d H:i:s');
            $save->geaendert_am = date('Y-m-d H:i:s');
            $save->last_upload = date('Y-m-d H:i:s');
            $save->last_update = date('Y-m-d H:i:s');
            $save->status_dienst = '';
            $save->save();
            $id = $save->id;
        }

        /***
         * Set now the correction ID for the car images
         */
        $save = FahrzeugBilder::where('fahrzeug_token', '=', $inputs['fahrzeug_token'])
            ->update(['fahrzeug_id' => $id, 'fahrzeug_token' => '']);

        $this->clearPageCache();

        return redirect()->route('admin.fahrzeuge');
    }

    public function getCarImages(Request $request)
    {
        $request = $request->all();
        $images = [];
        if ($request['fahrzeug_id'] !== '0') {
            $FahrzeugBilder = FahrzeugBilder::where('fahrzeug_id', '=', $request['fahrzeug_id'])
                ->OrWhere('fahrzeug_token', '=', $request['fahrzeug_token'])
                ->orderBy('pos')->get();
        } else {
            $FahrzeugBilder = FahrzeugBilder::where('fahrzeug_token', '=', $request['fahrzeug_token'])
                ->orderBy('pos')
                ->get();
        }

        $FahrzeugBilder->each(function ($imgs) use (&$images) {
            $images[] = [
                'image' => $imgs->fahrzeug_bild,
                'small' => $this->admin_thumbnails('/fileadmin/fahrzeuge/', $imgs->fahrzeug_bild),
                'text' => $imgs->fahrzeug_bild_titel,
                'beschreibung' => $imgs->fahrzeug_bild_beschreibung,
                'picture_id' => $imgs->id,
            ];
        });
        return response()->json(['images' => $images]);
    }

    public function uploadCarImages(Request $request)
    {
        $file = $request->file('file');
        $fahrzeug_id = $request->input('fahrzeug_id');
        $fahrzeug_token = $request->input('fahrzeug_token');
        $upload_path = storage_path('/grfx/');
        $public = public_path('/fileadmin/fahrzeuge/');
        $name = time() . rand(0, 9999) . '.' . $request->file->extension();
        $file->move($upload_path, $name);
        $data = [];
        $data['error'] = [];
        $data['success'] = [];
        $data = $this->ImageMagick($upload_path . $name, '1024x768', $public . $name, $data);
        if (count($data['error']) === 0) {
            $last_pos = 0;
            if ($fahrzeug_id !== 0) {
                $Last = FahrzeugBilder::where('fahrzeug_id', '=', $fahrzeug_id)
                    ->orderBy('pos', 'DESC')->get();
            } else {
                $Last = FahrzeugBilder::where('fahrzeug_token', '=', $fahrzeug_token)
                    ->orderBy('pos', 'DESC')->get();
            }
            $Last->each(function ($p) use (&$last_pos) {
                $last_pos = $p->pos;
            });
            $last_pos = $last_pos + 1;
            $save = new FahrzeugBilder();
            $save->fahrzeug_bild_titel = '';
            $save->fahrzeug_bild_beschreibung = '';
            $save->fahrzeug_bild = $name;
            $save->fahrzeug_id = $fahrzeug_id;
            $save->fahrzeug_token = $fahrzeug_token;
            $save->pos = $last_pos;
            $save->save();
            @unlink($upload_path . $name);
            $data['success'] = $file->getFilename();
        }
        $this->clearPageCache();
        return response()->json($data);
    }

    public function deleteCarImages(Request $request)
    {
        $request = $request->all();
        /*
        $path = public_path('/fahrzeuge/');
        $Data = FahrzeugBilder::where('id', '=', $request['picture_id'])->get();
        $Data->each(function ($f) use ($path) {
            @unlink($path.$f->fahrzeug_bild);
            @unlink($path.'thumb_'.$f->fahrzeug_bild);
            @unlink($path.'thumb_admin_'.$f->fahrzeug_bild);
        });
        $delete = FahrzeugBilder::where('id', '=', $request['picture_id'])->delete();
        $this->clearPageCache();
        */
        return response()->json(['success' => 'OK']);
    }

    public function editCarImages(Request $request)
    {
        $request = $request->all();
        /*
        $Data = FahrzeugBilder::where('id', '=', $request['picture_id'])
            ->update(
                [
                    'fahrzeug_bild_titel'=>$request['text'],
                    'fahrzeug_bild_beschreibung'=>$request['beschreibung'],
                    'fahrzeug_bild_fotograf'=>$request['fotograf'],
                ]
            );
        $this->clearPageCache();
        */
        return response()->json(['success' => 'OK']);
    }

    /***
     * Save Method on another function for global
     */
    private function saveFahrzeugBild(Request $request)
    {
        if ($request->hasFile('bild')) {
            if ($request->file('bild')->isValid()) {
                $file = $request->file('bild');
                $id = $request->get('id');
                $extension = $request->file('bild')->getClientOriginalExtension();
                $name = date('YmdHis') . '_' . rand(11111, 99999) . '.' . $extension;
                $upload_path = storage_path('/fahrzeug/');
                $public = public_path('/fileadmin/fahrzeuge/');
                $file->move($upload_path, $name);
                $data = [];
                $data['error'] = [];
                $data['success'] = [];
                $data = ImageTrait::ImageMagick($upload_path . $name, '530x347', $public . $name, $data);
                if (count($data['error']) === 0) {
                    $save = Fahrzeuge::find($id);
                    $save->bild = $name;
                    $save->save();
                }
            }
        }
    }


    public function admin_bilder($id)
    {
    }

    public function admin_bilder_add()
    {
    }

    public function admin_bilder_edit($id)
    {
    }

    public function admin_bilder_save()
    {
    }

    public function admin_bilder_pos(Request $request)
    {
        $inputs = $request->all();
        $id = $inputs['id'];
        $fahrzeug_id = $inputs['fahrzeug_id'];
        $pos = $inputs['pos'];
        if ($pos === '' || !is_numeric($pos) || !is_numeric($id)) {
            echo "FEHLER!";
            exit();
        } else {
            $POS = FahrzeugBilder::where('id', '=', $id)->get();
            $posalt = 0;
            $POS->each(function ($b) use (&$posalt) {
                $posalt = $b->pos;
            });

            /**
             * @todo Update Routine programmieren!
             */

            /*
            $sql="UPDATE ".CMS_TABLE_SUFIX."cms_fahrzeug_bilder SET pos='".$posalt."' WHERE fahrzeug_id=".$fahrzeug_id."
            AND pos=".$pos;
            $query=$mysql->Query($sql) or die(mysql_error());
            $sql="UPDATE ".CMS_TABLE_SUFIX."cms_fahrzeug_bilder SET pos='".$pos."' WHERE fahrzeug_bild_id=".$id;
            $query=$mysql->Query($sql) or die(mysql_error());
            */
        }
        echo 'gespeichert!';
    }

    private function getFahrzeugeController($bos = '=', $ausrangiert = '0')
    {
        $einsatzfahrzeuge = [];
        $Fahrzeuge = Fahrzeuge::where('ausrangiert', '=', $ausrangiert)
            ->where('bos_kennung', $bos, '')
            ->orderBy('bos_kennung', 'ASC')
            ->get();
        $Fahrzeuge->each(function ($fz) use (&$einsatzfahrzeuge) {
            $bild = FxToolsFilesTrait::check_file_delete($this->filepath, $fz->bild);
            $kennung = $this->car_title_Full($fz->id);
            if ($kennung === '') {
                $kennung = $fz->bos_kennung;
            }
            $einsatzfahrzeuge[$fz->id] = array(
                'id' => $fz->id,
                'path' => $bild,
                'fahrzeug' => $fz->fahrzeug,
                'fahrgestell' => $fz->fahrgestell,
                'zugelassen' => $fz->zugelassen,
                'bos_kennung' => $kennung,
                'kennzeichen' => $fz->kennzeichen,
            );
        });
        return $einsatzfahrzeuge;
    }

    private function getAdminFahrzeuge($wachen_id, $bos = '=', $ausrangiert = '0')
    {
        $einsatzfahrzeuge = [];
        $Fahrzeuge = Fahrzeuge::where('ausrangiert', '=', $ausrangiert)
            ->where('bos_kennung', $bos, '')
            ->orderBy('bos_kennung', 'ASC')
            ->get();
        $Fahrzeuge->each(function ($fz) use (&$einsatzfahrzeuge) {
            $bild = FxToolsFilesTrait::check_file_delete($this->filepath, $fz->bild);
            $kennung = $this->car_title_Full($fz->id);
            if ($kennung === '') {
                $kennung = $fz->bos_kennung;
            }
            $einsatzfahrzeuge[$fz->id] = array(
                'id' => $fz->id,
                'path' => $bild,
                'fahrzeug' => $fz->fahrzeug,
                'fahrgestell' => $fz->fahrgestell,
                'zugelassen' => $fz->zugelassen,
                'bos_kennung' => $kennung,
                'kennzeichen' => $fz->kennzeichen,
            );
        });
        return $einsatzfahrzeuge;
    }

    public function fulldata($id)
    {
        $Fahrzeug = Fahrzeuge::where('id', '=', $id)->get();
    }

    private function boshistory($id)
    {
    }

    public function bilder($id)
    {
        $fahrzeug_bild = [];
        $Bilder = FahrzeugBilder::where('fahrzeug_id', '=', $id)->get();
        $Bilder->each(function ($b) use (&$fahrzeug_bild) {
            $bild = FxToolsFilesTrait::check_file_delete($this->filepath, $b->fahrzeug_bild);
            if ($bild !== '') {
                $fahrzeug_bild[] = array(
                    'fahrzeug_bild' => $bild,
                    'fahrzeug_bild_titel' => $b->fahrzeug_bild_titel,
                    'fahrzeug_bild_beschreibung' => $b->fahrzeug_bild_beschreibung
                );
            }
        });
        return $fahrzeug_bild;
    }

    private function admin_thumbnails($folder, $image)
    {
        $size = 150;
        $small = 'thumb_admin_' . $image;
        $folder = public_path($folder);
        if (file_exists($folder . $small)) {
            return $small;
        } else {
            $data = [];
            $data['error'] = [];
            $data['success'] = [];
            $data = $this->admin_IM($folder . $image, $size . 'x' . $size, $folder . $small, $data);
        }
        return $small;
    }

    private function admin_IM($upload_file, $size = '1024x768', $endfile, $data)
    {
        $im_config = [];
        $im_config[] = '-resize ' . $size;
        #$im_config[] = '-sampling-factor 4:2:0';
        $im_config[] = '-strip';
        #$im_config[] = '-quality 85';
        #$im_config[] = '-interlace';
        #$im_config[] = '-colorspace RGB';

        $cmd = "convert " . $upload_file . " " . implode(" ", $im_config) . " " . $endfile;
        exec($cmd, $output, $return_var);

        if (isset($output)) {
            if (count($output) > 0) {
                $data['error'][] = $output;
            }
        }
        return $data;
    }
}
