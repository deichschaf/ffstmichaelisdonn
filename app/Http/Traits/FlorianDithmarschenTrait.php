<?php

namespace App\Http\Traits;

use App\Http\Models\FahrzeugAusstattung;
use App\Http\Models\FahrzeugBilder;
use App\Http\Models\Fahrzeuge;
use App\Http\Models\FahrzeugStandorteVerlauf;
use App\Http\Models\FahrzeugTypen;
use App\Http\Models\FahrzeugWachenWappen;
use App\Http\Models\FahrzeugWeitereBilder;
use App\Http\Models\Wachen;
use App\Http\Models\WachenBild;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;

trait FlorianDithmarschenTrait
{
    use FxToolsTrait;

    private $fahrzeug_bilder_path = '/fileadmin/fahrzeuge/';

    public function getWappen()
    {
        $logos = array();
        $logos[] = array('logo' => 'logo_feuerwehr.png', 'orglink' => 'Feuerwehr');
        $logos[] = array('logo' => 'logo_rkish.png', 'orglink' => 'RKiSH');
        $logos[] = array('logo' => 'logo_drk.png', 'orglink' => 'DRK');
        $logos[] = array('logo' => 'logo_thw.png', 'orglink' => 'THW');
        $logos[] = array('logo' => 'logo_dgzrs.png', 'orglink' => 'DGzRS');
        $logos[] = array('logo' => 'logo_sar.png', 'orglink' => 'SAR');
        return view('startpage.partials.wappen')
            ->with('logos', $logos)
            ->render();
    }

    /***
     * @return mixed
     * @todo Fahrzeugcounter Updaten
     */
    public function getFahrzeugCount()
    {
        $count = Cache::remember(
            __CLASS__ . '_' . __FUNCTION__,
            Config::get('CacheConfig.cache_content_timeout'),
            function () {
                return Fahrzeuge::count();
            }
        );
        return $count;
    }

    public function getWachenCount()
    {
        $count = Cache::remember(
            __CLASS__ . '_' . __FUNCTION__,
            Config::get('CacheConfig.cache_content_timeout'),
            function () {
                return Wachen::where('hiort_name', '!=', '')
                    ->count();
            }
        );
        return $count;
    }

    public function ifFahrzeugExists($id)
    {
        return Fahrzeuge::where('id', '=', $id)
            ->count();
    }

    public function ifWacheExists($id)
    {
        return Wachen::where('id', '=', $id)
            ->count();
    }

    public function getFahrzeugData($id)
    {
        $data = Cache::remember(
            __CLASS__ . '_' . __FUNCTION__ . '_' . $id,
            Config::get('CacheConfig.cache_content_timeout'),
            function () use ($id) {
                $data = [];
                $Fahrzeug = Fahrzeuge::where('id', '=', $id)
                    ->get();
                $Fahrzeug->each(function ($f) use (&$data) {
                    $data = $f;
                });
                return $data;
            }
        );
        return $data;
    }

    public function getFahrzeugBilder($id)
    {
        $bilder = Cache::remember(
            __CLASS__ . '_' . __FUNCTION__ . '_' . $id,
            Config::get('CacheConfig.cache_content_timeout'),
            function () use ($id) {
                $bilder = [];
                $Bilder = FahrzeugBilder::where('fahrzeug_id', '=', $id)
                    ->orderBy('pos', 'ASC')
                    ->get();
                $Bilder->each(function ($b) use (&$bilder) {
                    if (is_file(public_path('/fileadmin/fahrzeuge/') . $b->fahrzeug_bild)) {
                        $bilder[] = [
                            'id' => $b->id,
                            'bild' => $b->fahrzeug_bild,
                            'bild_thumb' => self::make_thumb_flodith($b->fahrzeug_bild, '228x150'),
                            'titel' => $b->fahrzeug_bild_titel,
                            'beschreibung' => $b->fahrzeug_bild_beschreibung,
                            'fotograf' => $b->fahrzeug_bild_fotograf
                        ];
                    }
                });
                return $bilder;
            }
        );
        return $bilder;
    }

    public function getWachenDaten($id)
    {
    }

    public function getFahrzeugAusstattung($id)
    {
        $ausstattung = Cache::remember(
            __CLASS__ . '_' . __FUNCTION__ . '_' . $id,
            Config::get('CacheConfig.cache_content_timeout'),
            function () use ($id) {
                $ausstattung = [];
                $Ausstattung = FahrzeugAusstattung::where('fahrzeug_id', '=', $id)->get();
                $Ausstattung->each(function ($a) use (&$ausstattung) {
                    $ausstattung[] = $a->fahrzeug_ausstattung;
                });
                return $ausstattung;
            }
        );
        return $ausstattung;
    }

    public function getWachenData($id)
    {
        $data = Cache::remember(
            __CLASS__ . '_' . __FUNCTION__ . '_' . $id,
            Config::get('CacheConfig.cache_content_timeout'),
            function () use ($id) {
                $data = [];
                $Wachen = Wachen::where('id', '=', $id)
                    ->get();
                $Wachen->each(function ($w) use (&$data) {
                    $data = $w;
                });
                return $data;
            }
        );
        return $data;
    }

    public function getFahrzeugStationen($id)
    {
        $data = Cache::remember(
            __CLASS__ . '_' . __FUNCTION__ . '_' . $id,
            Config::get('CacheConfig.cache_content_timeout'),
            function () use ($id) {
                $data = [];
                $count = FahrzeugStandorteVerlauf::where('fahrzeug_id', '=', $id)->count();
                if ($count === 0) {
                    return $data;
                }
                $karten_id = 0;
                $Standorte = FahrzeugStandorteVerlauf::where('fahrzeug_id', '=', $id)->get();
                $Standorte->each(function ($s) use (&$karten_id) {
                    $karten_id = $s->cms_fahrzeug_standorte_verlaufkarte_id;
                });
                $query = DB::table('cms_fahrzeug_standorte_verlauf')
                    ->leftJoin('cms_fahrzeug', 'cms_fahrzeug.id', '=', 'cms_fahrzeug_standorte_verlauf.fahrzeug_id')
                    ->leftJoin('cms_fahrzeug_wachen', 'cms_fahrzeug_wachen.id', '=', 'cms_fahrzeug.cms_fahrzeug_ort_id')
                    ->where('cms_fahrzeug_standorte_verlaufkarte_id', '=', $karten_id)
                    ->get();

                if (count($query) <= 1) {
                    return $data;
                }
                foreach ($query as $k => $row) {
                    $data[] = [
                        'verlaufkarte_id' => $row->cms_fahrzeug_standorte_verlaufkarte_id,
                        'verlauf_id' => $row->cms_fahrzeug_standorte_verlauf_id,
                        'von' => $row->von,
                        'bis' => $row->bis,
                        'standort_id' => $row->cms_fahrzeug_ort_id,
                        'standort_name' => $row->hiort_name . ' ' . $row->hiorg,
                        'fahrzeug_funkverlauf' => $row->funkrufnamen,
                        'fahrzeug_id' => $row->fahrzeug_id,
                        'fahrzeug' => $row->fahrzeug . ', ' . $row->bos_kennung,
                        //'fahrzeug_id' => $row->fahrzeug_id,
                        //'funkrufnamen' => $row->funkrufnamen,
                        //'kennzeichen' => $row->kennzeichen,
                    ];
                }
                return $data;
            }
        );
        return $data;
    }

    public function getWachenImpressionen($id)
    {
        $bilder = Cache::remember(
            __CLASS__ . '_' . __FUNCTION__ . '_' . $id,
            Config::get('CacheConfig.cache_content_timeout'),
            function () use ($id) {
                $bilder = [];
                $Bilder = FahrzeugWeitereBilder::where('cms_fahrzeug_ort_id', '=', $id)
                    ->get();
                $Bilder->each(function ($b) use (&$bilder) {
                    if (is_file(public_path('/fileadmin/fahrzeuge/') . $b->bild)) {
                        $bilder[] = array(
                            'id' => $b->cms_fahrzeug_weitere_id,
                            'bild' => $b->bild,
                            'bild_thumb' => self::make_thumb_flodith($b->bild, '228x150'),
                            'titel' => $b->weitere_bild_titel,
                            'beschreibung' => $b->weitere_bild_beschreibung
                        );
                    }
                });
                return $bilder;
            }
        );
        return $bilder;
    }

    public function getWachenBilder($id)
    {
        $bilder = Cache::remember(
            __CLASS__ . '_' . __FUNCTION__ . '_' . $id,
            Config::get('CacheConfig.cache_content_timeout'),
            function () use ($id) {
                $bilder = [];
                $Bilder = WachenBild::where('cms_fahrzeug_ort_id', '=', $id)
                    ->get();
                $Bilder->each(function ($b) use (&$bilder) {
                    if (is_file(public_path('/fileadmin/fahrzeuge/') . $b->bild)) {
                        $bilder[] = array(
                            'id' => $b->id,
                            'bild' => $b->bild,
                            'bild_thumb' => self::make_thumb_flodith($b->bild, '228x150'),
                            'titel' => $b->wachen_bild_titel,
                            'beschreibung' => $b->wachen_bild_beschreibung
                        );
                    }
                });
                return $bilder;
            }
        );
        return $bilder;
    }

    /**
     * Holt alle Fahrzeuge nach dem bestimmten Status von der aktuellen Wache
     * @param integer $id
     * @param boolean $funk
     * @param boolean $archive
     */
    public function getWachenFahrzeuge($id, $funk = 1, $archive = 0)
    {
        $data = Cache::remember(
            __CLASS__ . '_' . __FUNCTION__ . '_' . $id . '_funk_' . $funk . '_archive_' . $archive,
            Config::get('CacheConfig.cache_content_timeout'),
            function () use ($id, $funk, $archive) {
                $data = [];
                $where = [];

                $where[] = "cms_fahrzeug_ort_id=" . $id;
                $where[] = "ausrangiert='" . $archive . "'";
                if ($funk === '0') {
                    $funkgeraet = '=';
                } else {
                    $funkgeraet = '!=';
                }

                $Fahrzeuge = Fahrzeuge::where('cms_fahrzeug_ort_id', '=', $id)
                    ->where('ausrangiert', '=', $archive)
                    ->where('bos_kennung', $funkgeraet, '')
                    ->orderBy('ausrangiert', 'ASC')
                    ->orderBy('bos_kennung', 'ASC')
                    ->orderBy('fahrzeug', 'ASC')
                    ->orderBy('baujahr', 'DESC')
                    ->get();
                $Fahrzeuge->each(function ($f) use (&$data) {
                    $funkkennung = '&nbsp;';
                    if ($f->bos_kennung !== '') {
                        $funkkennung = $f->bos_kennung;
                    }
                    $typ = '&nbsp;';
                    $typ_url = '';
                    if ($f->fahrzeug !== '') {
                        $typ = $f->fahrzeug;
                        $typ_url = $this->dateizeichen($typ);
                    }
                    $fahrgestell = '&nbsp;';
                    if ($f->fahrgestell !== '') {
                        $fahrgestell = $f->fahrgestell;
                    }
                    $baujahr = '&nbsp;';
                    if ($f->baujahr !== '') {
                        $baujahr = $f->baujahr;
                    }
                    $kennzeichen = '&nbsp;';
                    if ($f->kennzeichen !== '') {
                        $kennzeichen = $f->kennzeichen;
                    }
                    $data[] = [
                        'id' => $f->id,
                        'funkkennung' => $funkkennung,
                        'typ' => $typ,
                        'typ_url' => $typ_url,
                        'fahrgestell' => $fahrgestell,
                        'baujahr' => $baujahr,
                        'kennzeichen' => $kennzeichen,
                        'ausrangiert' => $f->ausrangiert,
                    ];
                });
                return $data;
            }
        );
        return $data;
    }

    public function getFahrzeugTypen()
    {
        $typen = Cache::remember(
            __CLASS__ . '_' . __FUNCTION__,
            Config::get('CacheConfig.cache_content_timeout'),
            function () {
                $typen = array();
                $FahrzeugTypen = FahrzeugTypen::OrderBy('typ', 'ASC')->get();
                $FahrzeugTypen->each(function ($f) use (&$typen) {
                    $typen[$f->typen_id] = $f->typ;
                });
                return $typen;
            }
        );
        return $typen;
    }

    /**
     * Holt die Daten von den X letzten Bildern die Eingetragen wurden
     * @param integer $limit
     * @return array
     */
    public function getNeueFahrzeuge($limit = 5)
    {
        $fahrzeuge = Cache::remember(
            __CLASS__ . '_' . __FUNCTION__ . '_LIMIT_' . $limit,
            Config::get('CacheConfig.cache_content_timeout'),
            function () use ($limit) {
                $fahrzeuge = array();
                $fahrzeugbilder = array();
                $Fahrzeugbilder = FahrzeugBilder::orderBy('fahrzeug_id', 'DESC')
                    ->orderBy('pos', 'DESC')
                    ->get();
                $Fahrzeugbilder->each(function ($fb) use (&$fahrzeugbilder) {
                    if (is_file(public_path($this->fahrzeug_bilder_path) . $fb->fahrzeug_bild)) {
                        $fahrzeugbilder[$fb->fahrzeug_id] = $fb->fahrzeug_bild;
                    }
                });

                $wachendb = array();
                $Wachen = Wachen::get();
                $Wachen->each(function ($w) use (&$wachendb) {
                    $wachendb[$w->cms_fahrzeug_wachen_id] = $w->einheit;
                });

                $fahrzeuge = [];
                $Fahrzeug = Fahrzeuge::where('ausrangiert', '=', '0')
                    ->orderBy('last_upload', 'DESC')
                    ->take($limit)
                    ->get();
                $Fahrzeug->each(function ($f) use (&$fahrzeuge, $wachendb, $fahrzeugbilder) {
                    $bild = '';
                    if (array_key_exists($f->id, $fahrzeugbilder)) {
                        $bild = $fahrzeugbilder[$f->id];
                    }
                    if ($bild === '' || $bild === 'NULL') {
                        $bild = 'foto_folgt.gif';
                    }
                    $fti = array(); // Feuerwehr Heide<br>ELW 1<br>Florian Dithmarschen 10/11/1

                    if (array_key_exists($f->cms_fahrzeug_ort_id, $wachendb)) {
                        $fti[] = $wachendb[$f->cms_fahrzeug_ort_id];
                    }

                    $funk = array();
                    if ($f->funkorganisation !== '') {
                        $funk[] = $f->funkorganisation;
                    }
                    if ($f->bos_kennung !== '') {
                        $funk[] = $f->bos_kennung;
                    }
                    if (count($funk) > 0) {
                        $fti[] = join(' ', $funk);
                    }
                    $fti[] = $f->fahrzeug;
                    $fahrzeuge[] = [
                        'id' => $f->id,
                        'bild' => $bild,
                        'bild_thumb' => self::make_thumb_flodith($bild, '237x155'),
                        'data' => $fti,
                        'url' => $this->dateizeichen(join('/', $fti))
                    ];
                });
                return $fahrzeuge;
            }
        );
        return view('fahrzeugdatenbank.partials.new_car')
            ->with('fahrzeuge', $fahrzeuge)
            ->render();
    }

    private static function make_thumb_flodith($image, $size)
    {
        $file = 'thumb/thb_' . $image;
        if (is_file(public_path('/fileadmin/fahrzeuge/') . $file)) {
            return $file;
        }
        if (!is_dir(public_path('/fileadmin/fahrzeuge/thumb/'))) {
            mkdir(public_path('/fileadmin/fahrzeuge/thumb'), 0777);
        }
        $data = [];
        $data['error'] = [];
        $data['success'] = [];
        $data = ImageTrait::ImageMagick(
            public_path('/fileadmin/fahrzeuge/') . $image,
            $size,
            public_path('/fileadmin/fahrzeuge/thumb/') . 'thb_' . $image,
            $data
        );
        if (count($data['error']) > 0) {
            return false;
        }
        return $file;
    }

    public function getFahrzeugDatenbank($sort, $organisation = '')
    {
        $gemeinde = 'x';
        $sort = strtolower($sort);
        $organisation = trim(strtolower($organisation));

        switch ($organisation) {
            case 'feuerwehr':
                $organisation = 'Feuerwehr';
                break;
            case 'rkish':
                $organisation = 'RKiSH';
                break;
            case 'drk':
                $organisation = 'DRK';
                break;
            case 'thw':
                $organisation = 'THW';
                break;
            case 'dgzrs':
                $organisation = 'DGzRS';
                break;
            case 'sar':
                $organisation = 'SAR';
                break;
            default:
                $organisation = '';
        }

        if ($organisation !== '') {
            $sort = 'orga';
        }
        $data = Cache::remember(
            __CLASS__ . '_' . __FUNCTION__ . '_' . $sort . '_' . $organisation,
            Config::get('CacheConfig.cache_content_timeout'),
            function () use ($sort, $organisation) {
                $fahrzeuge_counter = $this->getFahrzeugeCounter();
                $wachenbilder = $this->getWachenImages();

                $data = [];

                if ($sort === 'ort') {
                    $ort = '';
                    $FahrzeugWache = Wachen::where('hiort_name', '!=', '')
                        ->OrderBy('gemeinde_abc', 'ASC')
                        ->orderBy('hiort_name', 'ASC')
                        ->orderBy('hiorg', 'ASC')
                        ->get();
                    $FahrzeugWache->each(function ($fw) use ($fahrzeuge_counter, $wachenbilder, &$data) {
                        $c = $this->getWachenFahrzeugCount($fw->id, $fahrzeuge_counter);
                        $wachenbild = $this->getWachenBild($fw->id, $wachenbilder);
                        $data[] = [
                            'title' => $fw->gemeinde,
                            'id' => $fw->id,
                            'hi_org' => $fw->hiorg,
                            'hiort_name' => $fw->hiort_name,
                            'funkrufnamen' => $fw->funkrufnamen,
                            'wachenbild' => $wachenbild,
                            'wachenbild_thumb' => self::make_thumb_flodith($wachenbild, '150x87'),
                            'fahrzeug_count' => $c,
                            'clean_url' => $this->dateizeichen($fw->hiorg . ' ' . $fw->hiort_name)
                        ];
                    });
                } elseif ($sort === 'orga') {
                    $hiorg = '';

                    if ($organisation !== '') {
                        $where = [];
                        if ($organisation === 'Feuerwehr') {
                            $where[] = 'Betriebsfeuerwehr';
                            $where[] = 'Flugplatzfeuerwehr';
                            $where[] = 'Freiwillige Feuerwehr';
                            $where[] = 'Kreisfeuerwehrverband';
                            $where[] = 'Pflichtfeuerwehr';
                            $where[] = 'Werkfeuerwehr';
                        }
                        if ($organisation === 'DRK') {
                            $where[] = 'Deutsches Rotes Kreuz';
                        }
                        if ($organisation === 'BMI') {
                            $where[] = 'Bundesministerium des Inneren';
                        }
                        if ($organisation === 'DGzRS') {
                            $where[] = 'DGzRS';
                        }
                        if ($organisation === 'DRF') {
                            $where[] = 'DRF';
                        }
                        if ($organisation === 'Bundeswehr') {
                            $where[] = 'Bundeswehr';
                        }
                        if ($organisation === 'Kreis') {
                            $where[] = 'Kreis Dithmarschen';
                        }
                        if ($organisation === 'Kreis_RD') {
                            $where[] = 'Rettungsdienst Dithmarschen';
                        }
                        if ($organisation === 'RKiSH') {
                            $where[] = 'RKiSH gGmbH';
                        }
                        if ($organisation === 'THW') {
                            $where[] = 'Technisches Hilfswerk';
                        }
                        if (count($where) === 0) {
                            $where[] = 'Betriebsfeuerwehr';
                            $where[] = 'Flugplatzfeuerwehr';
                            $where[] = 'Freiwillige Feuerwehr';
                            $where[] = 'Kreisfeuerwehrverband';
                            $where[] = 'Pflichtfeuerwehr';
                            $where[] = 'Werkfeuerwehr';
                        }
                        $Wachen = Wachen::where('hiort_name', '!=', '')
                            ->whereIn('hiorg', $where)
                            ->orderBy('hiorg', 'ASC')
                            ->orderBy('hiort_name', 'ASC')
                            ->get();
                    } else {
                        $Wachen = Wachen::where('hiort_name', '!=', '')
                            ->orderBy('hiorg', 'ASC')
                            ->orderBy('hiort_name', 'ASC')
                            ->get();
                    }
                    $Wachen->each(function ($fw) use ($fahrzeuge_counter, $wachenbilder, &$data) {
                        $c = $this->getWachenFahrzeugCount($fw->id, $fahrzeuge_counter);
                        $wachenbild = $this->getWachenBild($fw->id, $wachenbilder);
                        $data[] = [
                            'title' => $fw->hiorg,
                            'id' => $fw->id,
                            'hi_org' => $fw->hiorg,
                            'hiort_name' => $fw->hiort_name,
                            'funkrufnamen' => $fw->funkrufnamen,
                            'wachenbild' => $wachenbild,
                            'wachenbild_thumb' => self::make_thumb_flodith($wachenbild, '150x87'),
                            'fahrzeug_count' => $c,
                            'clean_url' => $this->dateizeichen($fw->hiorg . ' ' . $fw->hiort_name)
                        ];
                    });
                } else {
                    $Wachen = Wachen::where('hiort_name', '!=', '')
                        ->orderBy('gemeinde_abc', 'ASC')
                        ->orderBy('hiorg', 'ASC')
                        ->orderBy('hiorg_name', 'ASC')
                        ->get();
                    $Wachen->each(function ($fw) use ($fahrzeuge_counter, $wachenbilder, &$data) {
                        $c = $this->getWachenFahrzeugCount($fw->id, $fahrzeuge_counter);
                        $wachenbild = $this->getWachenBild($fw->id, $wachenbilder);
                        $data[] = [
                            'title' => $fw->gemeinde,
                            'id' => $fw->id,
                            'hi_org' => $fw->hiorg,
                            'hiort_name' => $fw->hiort_name,
                            'funkrufnamen' => $fw->funkrufnamen,
                            'wachenbild' => $wachenbild,
                            'wachenbild_thumb' => self::make_thumb_flodith($wachenbild, '150x87'),
                            'fahrzeug_count' => $c,
                            'clean_url' => $this->dateizeichen($fw->hiorg . ' ' . $fw->hiort_name)
                        ];
                    });
                }
                return $data;
            }
        );
        return $data;
    }

    public function getWachenWappen($id)
    {
        $wappen = Cache::remember(
            __CLASS__ . '_' . __FUNCTION__ . '_' . $id,
            Config::get('CacheConfig.cache_content_timeout'),
            function () use ($id) {
                $wappen = '';
                $Wappen = FahrzeugWachenWappen::where('id', '=', $id)->get();
                $Wappen->each(function ($w) use (&$wappen) {
                    $wappen = $w->wappen;
                });
                return $wappen;
            }
        );
        return $wappen;
    }

    private function getWachenFahrzeugCount($wachen_id, $fahrzeuge_counter)
    {
        $c = 0;
        if (array_key_exists($wachen_id, $fahrzeuge_counter)) {
            $c = $fahrzeuge_counter[$wachen_id];
        }
        return $c;
    }

    private function getWachenbild($wachen_id, $wachenbilder)
    {
        $bild = '';
        if (array_key_exists($wachen_id, $wachenbilder)) {
            $bild = $wachenbilder[$wachen_id];
        }
        return $bild;
    }

    private function getFahrzeugeCounter()
    {
        $fahrzeuge_counter = Cache::remember(
            __CLASS__ . '_' . __FUNCTION__,
            Config::get('CacheConfig.cache_content_timeout'),
            function () {
                $fahrzeuge_counter = array();
                $Fahrzeug = Fahrzeuge::get();
                $Fahrzeug->each(function ($f) use (&$fahrzeuge_counter) {
                    if (!array_key_exists($f->cms_fahrzeug_ort_id, $fahrzeuge_counter)) {
                        $fahrzeuge_counter[$f->cms_fahrzeug_ort_id] = 1;
                    } else {
                        $fahrzeuge_counter[$f->cms_fahrzeug_ort_id] = $fahrzeuge_counter[$f->cms_fahrzeug_ort_id] + 1;
                    }
                });
                return $fahrzeuge_counter;
            }
        );
        return $fahrzeuge_counter;
    }

    private function getWachenImages()
    {
        $wachenbilder = Cache::remember('wachenbilder', Config::get('CacheConfig.cache_content_timeout'), function () {
            $wachenbilder = array();
            $WachenBilder = WachenBild::where('standard', '=', '1')->get();
            $WachenBilder->each(function ($wb) use (&$wachenbilder) {
                $wachenbilder[$wb->cms_fahrzeug_ort_id] = $wb->bild;
            });
            return $wachenbilder;
        });
        return $wachenbilder;
    }

    /**
     * Generiert an den angegebenen Koordinaten das Symbol der HiOrg
     * @param integer $ort
     * @param string $org
     * @param integer $x
     * @param integer $y
     */
    public function build_dithmarschen_karte($ort, $org, $x, $y)
    {
        if (is_file(public_path('/fileadmin/fahrzeuge/') . $ort . '.gif')) {
            return '';
        }
        $background = imagecreatefromgif(public_path('/fileadmin/fahrzeuge/') . "dithkarte.gif");
        switch ($org) {
            case "DGzRS":
                $foreground = imagecreatefromgif(public_path('/fileadmin/fahrzeuge/') . "icon_dgzrs.gif");
                break;
            case "DRF":
                $foreground = imagecreatefromgif(public_path('/fileadmin/fahrzeuge/') . "icon_rettungswache.gif");
                break;
            case "DRK":
                $foreground = imagecreatefromgif(public_path('/fileadmin/fahrzeuge/') . "icon_drk.gif");
                break;
            case "Feuerwehr":
                $foreground = imagecreatefromgif(public_path('/fileadmin/fahrzeuge/') . "icon_feuerwehr.gif");
                break;
            case "Rettungswache":
                $foreground = imagecreatefromgif(public_path('/fileadmin/fahrzeuge/') . "icon_rettungswache.gif");
                break;
            case "THW":
                $foreground = imagecreatefromgif(public_path('/fileadmin/fahrzeuge/') . "icon_thw.gif");
                break;
            case "Werkfeuerwehr":
                $foreground = imagecreatefromgif(public_path('/fileadmin/fahrzeuge/') . "icon_feuerwehr.gif");
                break;
            default:
                $foreground = imagecreatefromgif(public_path('/fileadmin/fahrzeuge/') . "icon_feuerwehr.gif");
                break;
        }

        $insertWidth = imagesx($foreground);
        $insertHeight = imagesy($foreground);

        $imageWidth = imagesx($background);
        $imageHeight = imagesy($background);

        $overlapX = $x - $insertWidth / 2;
        $overlapY = $y - $insertHeight / 2;
        imagecolortransparent($foreground, imagecolorat($foreground, 1, 1));
        imagecopymerge($background, $foreground, $overlapX, $overlapY, 0, 0, $insertWidth, $insertHeight, 100);
        ImageGIF($background, public_path('/fileadmin/fahrzeuge/') . $ort . ".gif");
        return $background;
    }

    private function perpare_images($name)
    {
        return str_replace('.', '-|-', $name);
    }
}
