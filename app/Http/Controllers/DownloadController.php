<?php

namespace App\Http\Controllers;

use App\Http\Models\Download;
use App\Http\Models\DownloadKategorie;
use App\Http\Models\Layout;
use App\Http\Traits\DownloadTrait;
use App\Http\Traits\FxToolsTrait;
use Illuminate\Http\Request;
use const Grpc\STATUS_NOT_FOUND;

/**
 * Class DownloadController
 * @package App\Http\Controllers
 */
class DownloadController extends GroundController
{
    /**
     * @param string $slug
     * @return void
     */
    public function getDownload(string $slug='')
    {
        $getDownload = Download::where('download_key', '=', $slug)->get();
        if (count($getDownload)===0) {
            $data = [];
            $data['error'] = 404;
            $data['message'] = 'Not Found!';
            $data['code'] = 404;
            return response()->json($data, 404);
        }
        $file=[];
        $getDownload->each(function ($d) use (&$file) {
            $file = [
                'filename'=>$d->download_title,
                'file'=>$d->download_file,
            ];
        });
        return $this->getDownloadFile($file);
    }

    /**
     * @param $file
     * @param false $area
     */
    public function getfile($file, $area = false)
    {
        if ($area === false) {
            $download = [];
            $DOWNLOADS = Download::where('download_key', '=', $file)->get();
            $DOWNLOADS->each(function ($d) use (&$download) {
                return DownloadTrait::getDownload($d->download_title, $d->download_file);
            });
        }
    }

    /**
     * @return string
     */
    public function adminShow()
    {
        $data = [];
        $Downloads = \App\Http\Models\Download::all();
        $downloads = [];
        $Downloads->each(function ($m) use (&$downloads) {
            $downloads[$m->id] = [
                'id' => $m->id,
                'titel' => $m->download_title,
                'beschreibung' => $m->download_text,
            ];
        });
        $data['downloads'] = $downloads;
        $content =  view('download.overview')->with('data', $data)->render();
        $l = new Layout();
        return $l->layout_admin_content($content, '', false, false);
    }

    /**
     * @return string
     */
    public function adminAdd()
    {
        $data = [];
        $data['id'] = '';
        $data['titel'] = '';
        $data['beschreibung'] = '';
        $content =  view('download.add_edit')->with('data', $data)->render();
        $l = new Layout();
        return $l->layout_admin_content($content, '', false, false);
    }

    /**
     * @param $id
     * @return string
     */
    public function adminEdit($id)
    {
        $data = [];
        $Downloads = \App\Http\Models\Download::where('id', '=', $id)->get();
        $Downloads->each(function ($d) use (&$data) {
            $data['id'] = $d->id;
            $data['titel'] = $d->download_title;
            $data['beschreibung'] = $d->download_text;
        });
        $content =  view('download.add_edit')->with('data', $data)->render();
        $l = new Layout();
        return $l->layout_admin_content($content, '', false, false);
    }

    /**
     *
     */
    public function adminDelete()
    {
    }

    /**
     *
     */
    public function adminDeletePost()
    {
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function adminSave(Request $request)
    {
        $inputs = $request->all();
        if ($inputs['id'] !== 0) {
            $update = Download::find($inputs['id']);
            $update->download_title = FxToolsTrait::checkChar($inputs['titel']);
            $update->download_text = FxToolsTrait::checkChar($inputs['beschreibung']);
            $update->save();
        } else {
            $add = new Download();
            $add->download_title = FxToolsTrait::checkChar($inputs['titel']);
            $add->download_text = FxToolsTrait::checkChar($inputs['beschreibung']);
            $add->save();
        }
        $this->clearPageCache();
        return redirect()->route('admin.downloads');
    }

    /**
     * @return string
     */
    public function admin_kategorie_show()
    {
        $data = [];
        $Kategorien = DownloadKategorie::all();
        $kategorien = [];
        $Kategorien->each(function ($m) use (&$kategorien) {
            $kategorien[$m->id] = [
                'id' => $m->id,
                'kategorie' => $m->download_kategorie
            ];
        });
        $data['kategorien'] = $kategorien;
        $content =  view('download.download_kategorien_admin_overview')->with('data', $data)->render();
        $l = new Layout();
        return $l->layout_admin_content($content, '', false, false);
    }

    /**
     * @return string
     */
    public function admin_kategorie_add()
    {
        $data = [];
        $data['id'] = '';
        $data['kategorie'] = '';
        $content =  view('download.download_kategorien_adminAdd_edit')->with('data', $data)->render();
        $l = new Layout();
        return $l->layout_admin_content($content, '', false, false);
    }

    /**
     * @param $id
     * @return string
     */
    public function admin_kategorie_edit($id)
    {
        $data = [];
        $Downloads = DownloadKategorie::where('id', '=', $id)->get();
        $Downloads->each(function ($d) use (&$data) {
            $data['id'] = $d->id;
            $data['kategorie'] = $d->download_kategorie;
        });
        $content =  view('download.download_kategorien_adminAdd_edit')->with('data', $data)->render();
        $l = new Layout();
        return $l->layout_admin_content($content, '', false, false);
    }

    /**
     *
     */
    public function admin_kategorie_delete()
    {
    }

    /**
     *
     */
    public function admin_kategorie_delete_post()
    {
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function admin_kategorie_save(Request $request)
    {
        $inputs = $request->all();
        if ($inputs['id'] !== 0) {
            $update = DownloadKategorie::find($inputs['id']);
            $update->download_kategorie = FxToolsTrait::checkChar($inputs['kategorie']);
            $update->save();
        } else {
            $add = new DownloadKategorie();
            $add->download_kategorie = FxToolsTrait::checkChar($inputs['kategorie']);
            $add->save();
        }
        return redirect()->route('admin.downloads.kategorien');
    }
}
