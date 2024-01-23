<?php

namespace App\Http\Controllers;

use App\Http\Models\Blackday;
use App\Http\Models\Layout;
use App\Http\Models\MitgliedCardEhrenamtskarte;
use App\Http\Models\MitgliedCardPublisher;
use App\Http\Models\MitgliedCardUrlChecker;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Http\Traits\FxToolsTrait;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Cache;

class FirecardController extends GroundController
{
    public function overview()
    {
        $data = [];
        $publisher = $this->getPublisher();
        $content = Cache::remember(
            __CLASS__ . '_' . __FUNCTION__,
            Config::get('CacheConfig.cache_content_timeout'),
            function () use ($data, $publisher) {
                $MitgliedCardEhrenamtskarte = MitgliedCardEhrenamtskarte::orderBy('firma_name', 'ASC')
                ->orderBy('firma_city')
                ->get();

                return view('firecard.overview')->with('data', $data)->render();
            }
        );
        $l = new Layout();
        return $l->layout_content($content, $data['title'], false, false);
    }

    private function getPublisher()
    {
        $data = Cache::remember(
            __CLASS__ . '_' . __FUNCTION__,
            Config::get('CacheConfig.cache_content_timeout'),
            function () {
                $data = [];
                $Publisher = MitgliedCardPublisher::orderBy('herausgeber', 'ASC')->get();
                $Publisher->each(function ($p) use (&$data) {
                    $data[$p->id] = $p->herausgeber;
                });
                return $data;
            }
        );
        return $data;
    }

    public function admin_overview()
    {
        $data = [];
        $MigliedCardEhrenamtskarte = MitgliedCardEhrenamtskarte::orderBy('mitgliedcard_url_id', 'ASC')->orderBy('firma_name', 'ASC')->orderBy('firma_city', 'ASC')->get();
        $MigliedCardEhrenamtskarte->each(function ($e) use (&$data) {
            $data[] = [
                'id' => $e->id,
                'herausgeber_id' => $e->herausgeber_id,
                'bonus_region' => $e->bonus_region,
                'firma_name' => $e->firma_name,
                'firma_city' => $e->firma_city,
            ];
        });
        $publisher = $this->getPublisher();
        $content = view('firecard.admin_overview')
                    ->with('data', $data)
                    ->with('publisher', $publisher)
                    ->render();

        $data['title'] = 'Firecard Admin';
        $l = new Layout();
        return $l->layout_admin_content($content, $data['title'], false, false);
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
        $content = view('fahrzeuge.admin_fahrzeug_add_edit')->with('data', $data)->with('stationen', $stationen)->render();
        $l = new Layout();
        return $l->layout_admin_content($content, 'Admin Fahrzeuge', false, false);
    }

    public function adminEdit($id)
    {
        $data = [];
        $Fahrzeug = MitgliedCardEhrenamtskarte::where('id', '=', $id)->get();
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
        $content = view('fahrzeuge.admin_fahrzeug_add_edit')->with('data', $data)->with('stationen', $stationen)->render();
        $l = new Layout();
        return $l->layout_admin_content($content, 'Admin Fahrzeuge', false, false);
    }

    public function adminDelete($id)
    {
    }

    public function adminDeletePost(Request $request)
    {
    }

    public function adminSave(Request $request)
    {
        if ($id === 0) {
            $save = new MitgliedCardEhrenamtskarte();
            $save->mitgliedcard_url_id = $this->mitgliedcard_url_id;
            $save->origin_id = $row['ID'];
            $save->post_author = $row['post_author'];
            $save->post_date = $row['post_date'];
            $save->post_date_gmt = $row['post_date_gmt'];
            $save->post_content = $row['post_content'];
            $save->post_title = $row['post_title'];
            $save->post_excerpt = $row['post_excerpt'];
            $save->post_status = $row['post_status'];
            $save->comment_status = $row['comment_status'];
            $save->ping_status = $row['ping_status'];
            $save->post_password = $row['post_password'];
            $save->post_name = $row['post_name'];
            $save->to_ping = $row['to_ping'];
            $save->pinged = $row['pinged'];
            $save->post_modified = $row['post_modified'];
            $save->post_modified_gmt = $row['post_modified_gmt'];
            $save->post_content_filtered = $row['post_content_filtered'];
            $save->post_parent = $row['post_parent'];
            $save->guid = $row['guid'];
            $save->menu_order = $row['menu_order'];
            $save->post_type = $row['post_type'];
            $save->post_mime_type = $row['post_mime_type'];
            $save->comment_count = $row['comment_count'];
            $save->filter = $row['filter'];
            $save->termids = $row['termids'];
            $save->new_post = $row['new_post'];
            $save->position_lat = $row['position']['0'];
            $save->position_lon = $row['position']['1'];
            $save->permalink = $row['permalink'];
            $save->firma_name = $row['firma_name'];
            $save->firma_link = $row['firma_link'];
            $save->firma_link_short = $row['firma_link_short'];
            $save->firma_street = $row['firma_street'];
            $save->firma_zip = $row['firma_zip'];
            $save->firma_city = $row['firma_city'];
            $save->ansprechpartner_anrede = $row['ansprechpartner_anrede'];
            $save->ansprechpartner_vorname = $row['ansprechpartner_vorname'];
            $save->ansprechpartner_nachname = $row['ansprechpartner_nachname'];
            $save->ansprechpartner_telefon = $row['ansprechpartner_telefon'];
            $save->ansprechpartner_email = $row['ansprechpartner_email'];
            $save->bonus_region = $row['bonus_region'];
            $save->bonus_link = $row['bonus_link'];
            $save->bonus_link_short = $row['bonus_link_short'];
            $save->bonus_street = $row['bonus_street'];
            $save->bonus_zip = $row['bonus_zip'];
            $save->bonus_city = $row['bonus_city'];
            $save->bonus_logo = $row['bonus_logo'];
            $save->bonus_logo_map = $row['bonus_logo_map'];
            $save->bonus_bild = $row['bonus_bild'];
            $save->bonus_bild_resized = $row['bonus_bild_resized'];
            $save->bonus_img_on_overview = $row['bonus_img_on_overview'];
            $save->bonus_title = $row['bonus_title'];
            $save->bonus_kurzbeschreibung = $row['bonus_kurzbeschreibung'];
            $save->bonus_kurzbeschreibung_excerpt = $row['bonus_kurzbeschreibung_excerpt'];
            $save->bonus_anmeldemodus = $row['bonus_anmeldemodus'];
            $save->bonus_anzahl = $row['bonus_anzahl'];
            $save->bonus_start = $row['bonus_start'];
            $save->bonus_ende = $row['bonus_ende'];
            $save->bonus_erganzungen = $row['bonus_erganzungen'];
            $save->partner_str_nr = $row['partner_str_nr'];
            $save->partner_plz = $row['partner_plz'];
            $save->partner_ort = $row['partner_ort'];
            $save->npo_categories = json_encode($row['npo_categories']);
            $save->filtered = $row['filtered'];
            $save->save();
        } else {
            $save = MitgliedCardEhrenamtskarte::find($id);
            $save->mitgliedcard_url_id = $this->mitgliedcard_url_id;
            $save->origin_id = $row['ID'];
            $save->post_author = $row['post_author'];
            $save->post_date = $row['post_date'];
            $save->post_date_gmt = $row['post_date_gmt'];
            $save->post_content = $row['post_content'];
            $save->post_title = $row['post_title'];
            $save->post_excerpt = $row['post_excerpt'];
            $save->post_status = $row['post_status'];
            $save->comment_status = $row['comment_status'];
            $save->ping_status = $row['ping_status'];
            $save->post_password = $row['post_password'];
            $save->post_name = $row['post_name'];
            $save->to_ping = $row['to_ping'];
            $save->pinged = $row['pinged'];
            $save->post_modified = $row['post_modified'];
            $save->post_modified_gmt = $row['post_modified_gmt'];
            $save->post_content_filtered = $row['post_content_filtered'];
            $save->post_parent = $row['post_parent'];
            $save->guid = $row['guid'];
            $save->menu_order = $row['menu_order'];
            $save->post_type = $row['post_type'];
            $save->post_mime_type = $row['post_mime_type'];
            $save->comment_count = $row['comment_count'];
            $save->filter = $row['filter'];
            $save->termids = $row['termids'];
            $save->new_post = $row['new_post'];
            $save->position_lat = $row['position']['0'];
            $save->position_lon = $row['position']['1'];
            $save->permalink = $row['permalink'];
            $save->firma_name = $row['firma_name'];
            $save->firma_link = $row['firma_link'];
            $save->firma_link_short = $row['firma_link_short'];
            $save->firma_street = $row['firma_street'];
            $save->firma_zip = $row['firma_zip'];
            $save->firma_city = $row['firma_city'];
            $save->ansprechpartner_anrede = $row['ansprechpartner_anrede'];
            $save->ansprechpartner_vorname = $row['ansprechpartner_vorname'];
            $save->ansprechpartner_nachname = $row['ansprechpartner_nachname'];
            $save->ansprechpartner_telefon = $row['ansprechpartner_telefon'];
            $save->ansprechpartner_email = $row['ansprechpartner_email'];
            $save->bonus_region = $row['bonus_region'];
            $save->bonus_link = $row['bonus_link'];
            $save->bonus_link_short = $row['bonus_link_short'];
            $save->bonus_street = $row['bonus_street'];
            $save->bonus_zip = $row['bonus_zip'];
            $save->bonus_city = $row['bonus_city'];
            $save->bonus_logo = $row['bonus_logo'];
            $save->bonus_logo_map = $row['bonus_logo_map'];
            $save->bonus_bild = $row['bonus_bild'];
            $save->bonus_bild_resized = $row['bonus_bild_resized'];
            $save->bonus_img_on_overview = $row['bonus_img_on_overview'];
            $save->bonus_title = $row['bonus_title'];
            $save->bonus_kurzbeschreibung = $row['bonus_kurzbeschreibung'];
            $save->bonus_kurzbeschreibung_excerpt = $row['bonus_kurzbeschreibung_excerpt'];
            $save->bonus_anmeldemodus = $row['bonus_anmeldemodus'];
            $save->bonus_anzahl = $row['bonus_anzahl'];
            $save->bonus_start = $row['bonus_start'];
            $save->bonus_ende = $row['bonus_ende'];
            $save->bonus_erganzungen = $row['bonus_erganzungen'];
            $save->partner_str_nr = $row['partner_str_nr'];
            $save->partner_plz = $row['partner_plz'];
            $save->partner_ort = $row['partner_ort'];
            $save->npo_categories = json_encode($row['npo_categories']);
            $save->filtered = $row['filtered'];
            $save->save();
        }
    }
}
