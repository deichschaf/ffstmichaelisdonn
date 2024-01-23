<?php

/**
 * Created by PhpStorm.
 * User: Jörg
 * Date: 13.04.2015
 * Time: 16:46
 */

namespace App\Http\Controllers;

use App\Http\Models\Bilder;
use App\Http\Models\Bilderverzeichnis;
use App\Http\Models\Layout;
use App\Http\Traits\FxToolsTrait;
use App\Http\Traits\ImageTrait;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use function redirect;

/**
 * Class BilderController
 * @package App\Http\Controllers
 */
class BilderController extends GroundController
{
    /**
     * @var string
     */
    private $path = DIRECTORY_SEPARATOR . 'fileadmin' . DIRECTORY_SEPARATOR . 'fotos' . DIRECTORY_SEPARATOR;

    /**
     * @return string
     */
    public function bilder_show()
    {
        $data = array();
        $data['title'] = 'Bilder';
        $content = Cache::remember(
            __CLASS__ . '_' . __FUNCTION__,
            Config::get('CacheConfig.cache_content_timeout'),
            function () use ($data) {
                $gallery = array();
                $Bilder = Bilderverzeichnis::orderBy('cms_bilder_jahr', 'DESC')
                    ->orderBy('cms_bilder_datum', 'DESC')
                    ->orderBy('cms_bilder_veranstaltung')
                    ->get();
                $Bilder->each(function ($gallerie) use (&$gallery) {
                    if (!array_key_exists($gallerie->cms_bilder_jahr, $gallery)) {
                        $gallery[$gallerie->cms_bilder_jahr] = array();
                    }

                    $bild = '';
                    $Bild = Bilder::where('cms_bilderverzeichnis_id', '=', $gallerie->id)
                        ->where('cms_pos', '=', '1')
                        ->get();
                    $Bild->each(function ($b) use (&$bild) {
                        $bild = $b->cms_bild;
                    });
                    if ($bild !== '' && $bild !== null) {
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
                return view('gallery.gallery')->with('data', $data)->render();
            }
        );
        $l = new Layout();
        return $l->layout_content($content, $data['title'], false, false);
    }

    /**
     * @param $gallery
     * @return RedirectResponse|string
     */
    public function show_gallery($gallery)
    {
        $data = array();
        $data['id'] = $gallery;
        #$content = Cache::remember('bilder.show.'.$gallery, Config::get('CacheConfig.cache_content_timeout'),
        #function() use (&$data, $gallery) {
        $G = Bilderverzeichnis::where('id', '=', $gallery)->get();
        if (count($G) === 0) {
            return redirect()->route('bilder');
        }

        $cms_bilder_verzeichnis = '';
        $G->each(function ($g) use (&$data, &$cms_bilder_verzeichnis) {
            $data['gal_name'] = $g->cms_bilder_veranstaltung;
            $data['datum'] = FxToolsTrait::datum_de_static($g->cms_bilder_datum);
            $cms_bilder_verzeichnis = $g->cms_bilder_verzeichnis;
        });
        $view = $this->getImagesArray($gallery, $cms_bilder_verzeichnis, 0);

        $data['gallery'] = $view;
        $content = view('gallery.gallery_overview')->with('data', $data)->render();
        #return view('gallery.gallery_overview')->with('data', $data)->render();
        #});
        $l = new Layout();
        return $l->layout_content($content, $data['gal_name'], false, false);
    }

    /**
     * @param $gallery
     * @param $cms_bilder_verzeichnis
     * @param int $cache
     * @return array
     */
    private function getImagesArray($gallery, $cms_bilder_verzeichnis, $cache = 0)
    {
        $view = array();
        if ($cache === 1) {
            $cache = 'cache/';
        } else {
            $cache = '';
        }
        $GAL = Bilder::where('cms_bilderverzeichnis_id', '=', $gallery)->orderBy('pos', 'ASC')->get();
        $GAL->each(function ($g) use (&$view, $cms_bilder_verzeichnis, &$cache) {
            $view[] = [
                'id' => $g->cms_bilder_id,
                'bild' => $cms_bilder_verzeichnis . '/' . $cache . $g->cms_bild,
            ];
        });
        return $view;
    }

    /**
     * @param $gallery
     * @param $pos
     * @return string
     */
    public function show_image($gallery, $pos)
    {
        $data = array();
        $data['gal_name'] = '';
        $data['id'] = $gallery;
        $content = Cache::remember(
            __CLASS__ . '_' . __FUNCTION__ . 'image.' . $gallery . '.' . $pos,
            Config::get('CacheConfig.cache_content_timeout'),
            function () use (&$data, $gallery, $pos) {
                $G = Bilderverzeichnis::where('cms_bilderverzeichnis_id', '=', $gallery)->get();
                if (count($G) === 0) {
                    return redirect()->route('bilder');
                }

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
                #$content = view('gallery.gallery_details')->with('data', $data)->render();
                return view('gallery.gallery_details')->with('data', $data)->render();
            }
        );
        $l = new Layout();
        return $l->layout_content($content, $data['gal_name'], false, false);
    }

    /**
     * @param $pos
     * @param $array
     * @return int|string|void
     */
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

    /**
     * @return string
     */
    public function adminShow()
    {
        $data = [];
        $data['title'] = 'Bildergalerie';
        $gallery = array();
        $Bilder = Bilderverzeichnis::orderBy('cms_bilder_jahr', 'DESC')
            ->orderBy('cms_bilder_datum', 'DESC')
            ->orderBy('cms_bilder_veranstaltung')
            ->get();
        $Bilder->each(function ($gallerie) use (&$gallery) {
            if (!array_key_exists($gallerie->cms_bilder_jahr, $gallery)) {
                $gallery[$gallerie->cms_bilder_jahr] = array();
            }

            $bild = '';
            $Bild = Bilder::where('cms_bilderverzeichnis_id', '=', $gallerie->id)->where('cms_pos', '=', '1')->get();
            $Bild->each(function ($b) use (&$bild) {
                $bild = $b->cms_bild;
            });
            if ($bild !== '' && $bild !== null) {
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
        $content = view('gallery.gallery_admin_overview')->with('data', $data)->render();
        $l = new Layout();
        return $l->layout_admin_content($content, $data['title'], false, false);
    }

    /**
     * @return string
     */
    public function adminAdd_gallery()
    {
        $data = [];
        $data['title'] = 'Bildergalerie';
        $data['veranstaltung'] = '';
        $data['datum'] = date('d.m.Y');
        $data['id'] = '0';
        $data['wasserzeichen'] = '1';
        $data['fotograf'] = env('HOMEPAGE_OWNER', '');
        $data['bilder'] = [];
        $content = view('gallery.gallery_add_edit')->with('data', $data)->render();
        $l = new Layout();
        return $l->layout_admin_content($content, $data['title'], false, false);
    }

    /**
     * @param $id
     * @return string
     */
    public function adminEdit_gallery($id)
    {
        $data = [];
        $data['title'] = 'Bildergalerie';
        $content = view('gallery.gallery_add_edit')->with('data', $data)->render();
        $l = new Layout();
        return $l->layout_admin_content($content, $data['title'], false, false);
    }

    /**
     * @param $id
     */
    public function adminDelete_gallery($id)
    {
    }

    /**
     * @param $id
     */
    public function adminDelete_gallery_post($id)
    {
    }

    /**
     * @param Request $request
     * @param $id
     * @return Application|RedirectResponse|Redirector
     */
    public function adminSave_gallery(Request $request, $id)
    {
        $inputs = $request->all();
        if (!array_key_exists('wasserzeichen', $inputs)) {
            $inputs['wasserzeichen'] = 0;
        }

        $date = FxToolsTrait::datum_en_static($inputs['datum']);
        $ex = explode('-', $date);
        $year = $ex['0'];
        $currentdate = date('Y-m-d H:i:s');

        if ($inputs['id'] === 0) {
            $folder = FxToolsTrait::makeFolderName($inputs['veranstaltung']);
            $makefolder = $this->makeFolder($year, $folder);
            if ($makefolder === false) {
                return redirect('intern/bilder')->withErrors('FolderNotExists');
            }

            $add = new Bilderverzeichnis();
            $add->cms_bilderverzeichnis_id = 0;
            $add->cms_bilder_jahr = $year;
            $add->cms_bilder_datum = $date;
            $add->bilder_datum = $date;
            $add->cms_bilder_veranstaltung = FxToolsTrait::checkChar($inputs['veranstaltung']);
            $add->bilder_veranstaltung = FxToolsTrait::checkChar($inputs['veranstaltung']);
            $add->cms_bilder_verzeichnis = $folder;
            $add->bilder_verzeichnis = $folder;
            $add->cms_erstellt_am = $currentdate;
            $add->cms_geaendert_am = $currentdate;
            $add->cms_erstellt_von = Session::get('user');
            $add->cms_geaendert_von = Session::get('user');
            $add->cms_wasserzeichen = $inputs['wasserzeichen'];
            $add->cms_bilder_extern = $inputs['bilder_exterm'];
            $add->fotograf = $inputs['fotograf'];
            $add->erwachsende = '1';
            $add->jugendliche = '0';
            $add->cms_bilder_verzeichnis_beschreibung = FxToolsTrait::checkChar($inputs['cms_bilder_verzeichnis_beschreibung']);
            $add->save();
            $this->clearPageCache();
            return redirect(route('admin.images.edit') . '/' . $add->id)->with('successful', '1');
        } else {
            $update = Bilderverzeichnis::find($inputs['id']);
            $update->cms_bilderverzeichnis_id = $inputs['id'];
            #$update->cms_bilder_jahr = $year;
            #$update->cms_bilder_datum = $date;
            #$update->bilder_datum = $date;
            $update->cms_bilder_veranstaltung = FxToolsTrait::checkChar($inputs['veranstaltung']);
            $update->bilder_veranstaltung = FxToolsTrait::checkChar($inputs['veranstaltung']);
            #$update->cms_bilder_verzeichnis = $folder;
            #$update->bilder_verzeichnis = $folder;
            $update->cms_geaendert_am = $currentdate;
            $update->cms_geaendert_von = Session::get('user');
            $update->cms_wasserzeichen = $inputs['wasserzeichen'];
            $update->cms_bilder_extern = $inputs['bilder_exterm'];
            $update->fotograf = $inputs['fotograf'];
            #$update->erwachsende= '1';
            #$update->jugendliche= '0';
            $update->cms_bilder_verzeichnis_beschreibung = FxToolsTrait::checkChar($inputs['cms_bilder_verzeichnis_beschreibung']);
            $update->save();
            $this->clearPageCache();
            return redirect()->route('admin.images');
        }
    }

    /**
     * @param $year
     * @param $folder
     * @return bool
     */
    private function makeFolder($year, $folder)
    {
        if (!is_dir(public_path($year, $folder))) {
            @mkdir(0777, public_path($year, $folder));
        }
        if (!is_dir(public_path($year, $folder))) {
            Log::error('Folder dont can be created: ' . public_path($year, $folder));
            return false;
        }
        return true;
    }

    /**
     * @param Request $request
     */
    public function admin_uploader(Request $request)
    {
        $inputs = $request->all();

        if (count($inputs['image']) > 0) {
            $folder = $this->path;
            $data = ImageTrait::UploaderImage($folder, 'image', [], $request);
            $inputs['bild'] = $data['image'];
            $add = new Bilder();
            $add->cms_bilder_id = '0';
            $add->cms_pos = '0';
            $add->pos = '0';
            $add->cms_bilderverzeichnis_id = $inputs['bilderverzeichnis_id'];
            $add->bilderverzeichnis_id = $inputs['bilderverzeichnis_id'];
            $add->cms_bild = $inputs['bild'];
            $add->cms_bild_titel = '';
            $add->cms_bild_text = '';
            $add->bild = $inputs['bild'];
            $add->save();

            $update = Bilder::find($add->id);
            $update->cms_pos = $add->id;
            $update->pos = $add->id;
            $update->save();
            echo 'success';
        }
        echo 'fail';
    }

    /**
     * @return string
     */
    public function adminAdd_image()
    {
        $data = [];
        $data['title'] = 'Bildergalerie';
        $content = view('gallery.gallery_add_edit')->with('data', $data)->render();
        $l = new Layout();
        return $l->layout_admin_content($content, $data['title'], false, false);
    }

    /**
     * @param $gallery
     * @param $id
     * @return string
     */
    public function adminEdit_image($gallery, $id)
    {
        $data = [];
        $data['title'] = 'Bildergalerie';
        $content = view('gallery.gallery_add_edit')->with('data', $data)->render();
        $l = new Layout();
        return $l->layout_admin_content($content, $data['title'], false, false);
    }

    /**
     * @param $gallery
     * @param $id
     */
    public function adminDelete_image($gallery, $id)
    {
    }

    /**
     * @param $gallery
     * @param $id
     */
    public function adminDelete_image_post($gallery, $id)
    {
    }

    /**
     * @param $gallery
     * @param $id
     */
    public function adminSave_image($gallery, $id)
    {
        $this->clearPageCache();
    }
}
