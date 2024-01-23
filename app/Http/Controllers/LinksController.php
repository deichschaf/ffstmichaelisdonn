<?php

namespace App\Http\Controllers;

use App\Http\Models\Layout;
use App\Http\Models\Links;
use App\Http\Models\LinkToFacebook;
use App\Http\Traits\FxToolsTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Config;

/**
 * Class LinksController
 * @package App\Http\Controllers
 */
class LinksController extends GroundController
{
    /**
     * @return JsonResponse
     */
    public function getLinksOverview(): JsonResponse
    {
        $data = [];
        $data['links'] = $this->getAdminOverviewLinks();
        $data['form_add_url'] = $this->getAdminPath().'/links/add';
        $data['form_edit_url'] = $this->getAdminPath().'/links/edit';
        $data['form_save_url'] = '/api'.$this->getAdminPath().'/links/save/';
        return response()->json($data, 200);
    }

    /**
     * @param $id
     * @return JsonResponse
     */
    public function getAdminLinks($id=0): JsonResponse
    {
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function setAdminLinks(Request $request): JsonResponse
    {
    }

    /**
     * @return string
     */
    public function links_show()
    {
        $content = Cache::remember(
            __CLASS__ . '_' . __FUNCTION__,
            Config::get('CacheConfig.cache_navi_timeout'),
            function () {
                return $this->getLinks();
            }
        );

        $data = array();
        $data['links'] = '';
        $data['title'] = 'Download';
        $data['downloads'] = array();
        $l = new Layout();
        return $l->layout_content($content, $data['title'], false, false);
    }

    /**
     * Zeigt ein PopUp das man nun auf Facebook kommt und dadurch die Datenschutz Richtlinien beachten soll (heise.de)
     * @param $id
     */
    public function LinktoFacebook($id)
    {
        $Facebook = LinkToFacebook::where('id', '=', $id)
            ->where('aktiv', '=', '1')
            ->get();
        if (count($Facebook) == 0) {
            return '404';
        }
        $data = array();
        $Facebook->each(function ($f) use (&$data) {
            $data['url'] = $f->link;
            $data['title'] = $f->titel;
        });
        return json_encode($data);
    }


    /**
     * @return string
     */
    private function getLinksBlade()
    {
        $links = $this->getLinks();
        return view('links.links')->with('links', $links)->render();
    }


    /**
     * @return string
     */
    public function adminShow()
    {
        $kategorien = $this->getLinksKategorien();
        $data = [];
        $Links = Links::all();
        $links = [];
        $Links->each(function ($l) use (&$links, $kategorien) {
            $links[$l->id] = [
                'id' => $l->id,
                'link_kategorie_id' => $l->link_kategorie_id,
                'link_kategorie' => $kategorien[$l->link_kategorie_id],
                'link_titel' => $l->link_titel,
                'link' => $l->link,
                'link_text' => $l->link_text,
            ];
        });
        $data['links'] = $links;
        $content = view('links.overview')->with('data', $data)->render();
        $l = new Layout();
        return $l->layout_admin_content($content, '', false, false);
    }

    public function checkLinkExists($id)
    {
        $link = '';
        $getLink = Links::where('id', '=', $id)->get();
        $getLink->each(function ($l) use (&$link) {
            $link = $l->link;
        });
        $check = $this->linksHelperCheckIsValidUrl($link);
        if ($check) {
            $update = Links::find($id);
            $update->is_brocken = '0';
            $update->save();
            return $this->makeLinkColorActive('green');
        }
        try {
            $update = Links::find($id);
            $update->is_brocken = '1';
            $update->save();
            Links::where('id', '=', $id)->delete();
            return $this->makeLinkColorActive('red');
        } catch (\Exception $exception) {
            $error = $this->makeJsonLogging(
                __CLASS__,
                __FUNCTION__,
                __LINE__,
                $exception->getCode(),
                $exception->getMessage(),
                0
            );
            return $this->makeLinkColorActive('violet');
        }
    }

    /**
     * @param $color
     * @return void
     */
    private function makeLinkColorActive($color = 'green')
    {
        $im = imagecreate(10, 10);
        if ($color === 'green') {
            $bg = imagecolorat($im, 0, 0);
            imagecolorset($im, $bg, 0, 255, 0);
            imagecolorallocate($im, 0, 255, 0);
        } elseif($color ==='violet') {
            $bg = imagecolorat($im, 0, 0);
            imagecolorset($im, $bg, 238, 130, 238);
            imagecolorallocate($im, 238, 130, 238);
        } else {
            $bg = imagecolorat($im, 0, 0);
            imagecolorset($im, $bg, 255, 0, 0);
            imagecolorallocate($im, 255, 0, 0);
        }
        header('Content-Type: image/png');
        imagepng($im);
        imagedestroy($im);
        exit();
    }

    /**
     * @return string
     */
    public function adminAdd()
    {
        $data = [];
        $data['id'] = '';
        $data['link'] = '';
        $data['link_text'] = '';
        $data['link_titel'] = '';
        $data['link_kategorie_id'] = '';
        $content = view('links.add_edit')->with('data', $data)->with('kategorien', $this->getKategorien())->render();
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
        $Links = Links::where('id', '=', $id)->get();
        $Links->each(function ($l) use (&$data) {
            $data['id'] = $l->id;
            $data['link_titel'] = $l->link_titel;
            $data['link_text'] = $l->link_text;
            $data['link'] = $l->link;
            $data['link_kategorie_id'] = $l->link_kategorie_id;
        });
        $content = view('links.add_edit')->with('data', $data)->with('kategorien', $this->getKategorien())->render();
        $l = new Layout();
        return $l->layout_admin_content($content, '', false, false);
    }

    /**
     * @param $id
     */
    public function adminDelete($id)
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
            $update = Links::find($inputs['id']);
            $update->link_titel = FxToolsTrait::checkChar($inputs['link_titel']);
            $update->link_text = FxToolsTrait::checkChar($inputs['link_text']);
            $update->link = FxToolsTrait::checkChar($inputs['link']);
            $update->link_kategorie_id = FxToolsTrait::checkChar($inputs['link_kategorie_id']);
            $update->save();
        } else {
            $add = new Links();
            $add->link_titel = FxToolsTrait::checkChar($inputs['link_titel']);
            $add->link_text = FxToolsTrait::checkChar($inputs['link_text']);
            $add->link = FxToolsTrait::checkChar($inputs['link']);
            $add->link_kategorie_id = FxToolsTrait::checkChar($inputs['link_kategorie_id']);
            $add->save();
        }
        $this->clearPageCache();
        return redirect()->route('admin.links');
    }

    /**
     * @return string
     */
    public function admin_kategorien_show()
    {
        $kategorien = $this->getLinksKategorien();
        $data = [];
        $Links = Links::all();
        $links = [];
        $Links->each(function ($l) use (&$links, $kategorien) {
            $links[$l->id] = [
                'id' => $l->id,
                'link_kategorie_id' => $l->link_kategorie_id,
                'link_kategorie' => $kategorien[$l->link_kategorie_id],
                'link_titel' => $l->link_titel,
                'link' => $l->link,
                'link_text' => $l->link_text,
            ];
        });
        $data['links'] = $links;
        $content = view('links.overview')->with('data', $data)->render();
        $l = new Layout();
        return $l->layout_admin_content($content, '', false, false);
    }

    /**
     * @return string
     */
    public function admin_kategorien_add()
    {
        $data = [];
        $data['id'] = '';
        $data['link'] = '';
        $data['link_text'] = '';
        $data['link_titel'] = '';
        $data['link_kategorie_id'] = '';
        $content = view('links.add_edit')->with('data', $data)->with('kategorien', $this->getKategorien())->render();
        $l = new Layout();
        return $l->layout_admin_content($content, '', false, false);
    }

    /**
     * @param $id
     * @return string
     */
    public function admin_kategorien_edit($id)
    {
        $data = [];
        $Links = Links::where('id', '=', $id)->get();
        $Links->each(function ($l) use (&$data) {
            $data['id'] = $l->id;
            $data['link_titel'] = $l->link_titel;
            $data['link_text'] = $l->link_text;
            $data['link'] = $l->link;
            $data['link_kategorie_id'] = $l->link_kategorie_id;
        });
        $content = view('links.add_edit')->with('data', $data)->with('kategorien', $this->getKategorien())->render();
        $l = new Layout();
        return $l->layout_admin_content($content, '', false, false);
    }

    /**
     * @param $id
     */
    public function admin_kategorien_delete($id)
    {
    }

    /**
     *
     */
    public function admin_kategorien_delete_post()
    {
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function admin_kategorien_save(Request $request)
    {
        $inputs = $request->all();
        if ($inputs['id'] !== 0) {
            $update = Links::find($inputs['id']);
            $update->link_titel = FxToolsTrait::checkChar($inputs['link_titel']);
            $update->link_text = FxToolsTrait::checkChar($inputs['link_text']);
            $update->link = FxToolsTrait::checkChar($inputs['link']);
            $update->link_kategorie_id = FxToolsTrait::checkChar($inputs['link_kategorie_id']);
            $update->save();
        } else {
            $add = new Links();
            $add->link_titel = FxToolsTrait::checkChar($inputs['link_titel']);
            $add->link_text = FxToolsTrait::checkChar($inputs['link_text']);
            $add->link = FxToolsTrait::checkChar($inputs['link']);
            $add->link_kategorie_id = FxToolsTrait::checkChar($inputs['link_kategorie_id']);
            $add->save();
        }
        $this->clearPageCache();
        return redirect()->route('admin.links');
    }

    /**
     * @param int $id
     * @return JsonResponse
     */
    public function checkUrlExists($id = 0): JsonResponse
    {
        $url = '';
        $Links = Links::where('id', '=', $id)->get();
        $Links->each(function ($l) use (&$url) {
            $url = $l->link;
        });
        $bool = $this->linksHelperCheckIsValidUrl($url);
        return response()->json(['success' => $bool], 200);
    }
}
