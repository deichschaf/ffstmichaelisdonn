<?php

/**
 * Created by PhpStorm.
 * User: Jörg
 * Date: 13.04.2015
 * Time: 16:46
 */

namespace App\Http\Controllers;

use App\Http\Traits\LayoutTrait;
use App\Http\Models\Layout;
use App\Http\Traits\FxToolsTrait;
use App\Http\Traits\AdminTrait;
use App\Http\Models\InternBilderverzeichnis;
use App\Http\Models\InternBilder;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Redirect;

class InternBilderController extends GroundController
{
    public function intern_bilder_show()
    {
        $data = array();
        $data['title'] = 'Bilder';
        $content = Cache::remember(
            __CLASS__ . '_' . __FUNCTION__,
            Config::get('CacheConfig.cache_content_timeout'),
            function () use ($data) {
                $gallery = array();
                $Bilder = InternBilderverzeichnis::orderBy('cms_bilder_jahr', 'DESC')
                    ->orderBy('cms_bilder_datum', 'DESC')
                    ->orderBy('cms_bilder_veranstaltung')
                    ->get();
                $Bilder->each(function ($gallerie) use (&$gallery) {
                    if (!array_key_exists($gallerie->cms_bilder_jahr, $gallery)) {
                        $gallery[$gallerie->cms_bilder_jahr] = array();
                    }

                    $bild = '';
                    $Bild = InternBilder::where('cms_bilderverzeichnis_id', '=', $gallerie->id)
                        ->where('cms_pos', '=', '1')
                        ->get();
                    $Bild->each(function ($b) use (&$bild) {
                        $bild = $b->cms_bild;
                    });
                    if ($bild !== '' && $bild != null) {
                        $bild = $gallerie->cms_bilder_verzeichnis . '/' . $bild;
                    }

                    $gallery[$gallerie->cms_bilder_jahr][] = array(
                        'datum' => FxToolsTrait::datum_de_static($gallerie->cms_bilder_datum),
                        'titel' => $gallerie->cms_bilder_veranstaltung,
                        'id' => $gallerie->id,
                        'bild' => $bild
                    );
                });

                $data['gallery'] = $gallery;
                $content = view('gallery.gallery_intern')->with('data', $data)->render();
                return $content;
            }
        );

        $l = new Layout();
        return $l->layout_content($content, $data['title'], false, false);
    }

    private function getImagesArray($gallery, $cms_bilder_verzeichnis, $cache = 0)
    {
        $view = array();
        if ($cache === 1) {
            $cache = 'cache/';
        } else {
            $cache = '';
        }
        $GAL = InternBilder::where('cms_bilderverzeichnis_id', '=', $gallery)
            ->orderBy('pos', 'ASC')
            ->get();
        $GAL->each(function ($g) use (&$view, $cms_bilder_verzeichnis, &$cache) {
            $view[] = [
                'id' => $g->cms_bilder_id,
                'bild' => $cms_bilder_verzeichnis . '/' . $cache . $g->cms_bild,
            ];
        });
        return $view;
    }

    public function show_gallery($gallery)
    {
        $G = InternBilderverzeichnis::where('id', '=', $gallery)->get();
        if (count($G) === 0) {
            return redirect()->route('bilder');
        }
        $data = array();
        $data['id'] = $gallery;
        $cms_bilder_verzeichnis = '';
        $G->each(function ($g) use (&$data, &$cms_bilder_verzeichnis) {
            $data['gal_name'] = $g->cms_bilder_veranstaltung;
            $data['datum'] = FxToolsTrait::datum_de_static($g->cms_bilder_datum);
            $cms_bilder_verzeichnis = $g->cms_bilder_verzeichnis;
        });
        $view = $this->getImagesArray($gallery, $cms_bilder_verzeichnis, 0);

        $data['gallery'] = $view;
        $content = view('gallery.gallery_intern_overview')->with('data', $data)->render();
        $l = new Layout();
        return $l->layout_content($content, $data['gal_name'], false, false);
    }

    public function show_image($gallery, $pos)
    {
        $G = InternBilderverzeichnis::where('cms_bilderverzeichnis_id', '=', $gallery)->get();
        if (count($G) === 0) {
            return redirect()->route('bilder');
        }
        $data = array();
        $data['id'] = $gallery;
        $cms_bilder_verzeichnis = '';
        $G->each(function ($g) use (&$data, &$cms_bilder_verzeichnis) {
            $data['gal_name'] = $g->cms_bilder_veranstaltung;
            $data['datum'] = FxToolsTrait::datum_de_static($g->cms_bilder_datum);
            $cms_bilder_verzeichnis = $g->cms_bilder_verzeichnis;
        });
        $view = $this->getImagesArray($gallery, $cms_bilder_verzeichnis, 0);

        $now = $this->IfPosExists($pos, $view);
        $next = $this->IfPosExists(($pos + 1), $view);
        $past = $this->IfPosExists(($pos - 1), $view);

        $data['image'] = $view[$now]['bild'];
        $data['now'] = $now + 1;
        $data['max'] = count($view);
        $data['next'] = $next;
        $data['past'] = $past;
        $content = view('gallery.gallery_intern_details')->with('data', $data)->render();
        $l = new Layout();
        return $l->layout_content($content, $data['gal_name'], false, false);
    }

    private function IfPosExists($pos, $array)
    {
        if (array_key_exists($pos, $array)) {
            return $pos;
        }
        $c = count($array) - 1;
        if ($pos === -1) {
            return $c;
        }
        if ($pos > $c) {
            return '0';
        }
    }

    public function adminShow()
    {
        $this->checkadmin();
    }

    public function adminAdd_gallery()
    {
        $this->checkadmin();
    }

    public function adminAdd_image()
    {
        $this->checkadmin();
    }

    public function adminEdit_gallery($id)
    {
        $this->checkadmin();
    }

    public function adminEdit_image($gallery, $id)
    {
        $this->checkadmin();
    }

    public function adminDelete_gallery($id)
    {
        $this->checkadmin();
    }

    public function adminDelete_image($gallery, $id)
    {
        $this->checkadmin();
    }

    private function checkadmin()
    {
        $return = AdminTrait::checkIsLogin();
        if (is_object($return)) {
            return $return;
        }
    }
}
