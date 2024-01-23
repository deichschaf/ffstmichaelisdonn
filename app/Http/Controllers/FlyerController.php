<?php

namespace App\Http\Controllers;

use App\Http\Models\Flyer;
use App\Http\Models\Layout;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Http\Traits\FxToolsTrait;

/***
 * Class WidgetController
 * @package App\Http\Controllers
 * @todo ImageUploadeer als eigenständiger Controller hinzufügen, damit Global verfügbar
 */

class FlyerController extends GroundController
{
    /**
     * @return string
     */
    public function admin_overview()
    {
        $data = [];
        $Flyer = Flyer::all()->sortBy('start')->sortBy('name');
        $FlyerData = [];
        $Flyer->each(function ($f) use (&$FlyerData) {
            $FlyerData[] = [
                'id' => $f->id,
                'flyer' => $f->flyer,
                'image' => $f->image,
                'link' => $f->link,
                'datum_von' => $f->datum_von,
                'datum_bis' => $f->datum_bis,
                'active' => $f->active,
            ];
        });
        $data['flyer'] = $FlyerData;
        $content =  view('flyer.admin_overview')->with('data', $data)->render();
        $l = new Layout();
        return $l->layout_admin_content($content, '', false, false);
    }

    /**
     * @return string
     */
    public function adminAdd()
    {
        $data = [];
        $data['title'] = '';
        $data['flyer'] = [
            'flyer' => '',
            'link' => '',
            'image' => '',
            'datum_von' => '',
            'datum_bis' => '',
            'special_text' => '',
            'active' => '1',
            'id' => '',
        ];
        $content =  view('flyer.adminAdd_edit')->with('data', $data)->render();
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
        $data['title'] = '';
        $data['flyer'] = [
            'flyer' => '',
            'image' => '',
            'link' => '',
            'datum_von' => '',
            'datum_bis' => '',
            'special_text' => '',
            'active' => '1',
            'id' => '',
        ];

        $flyer = [];
        $Flyer = Flyer::where('id', '=', $id)->get();
        $Flyer->each(function ($f) use (&$flyer) {
            $flyer['id'] = $f->id;
            $flyer['flyer'] = $f->flyer;
            $flyer['link'] = $f->link;
            $flyer['image'] = $f->image;
            $flyer['special_text'] = $f->special_text;
            $flyer['datum_von'] = FxToolsTrait::datum_de_static($f->datum_von);
            $flyer['datum_bis'] = FxToolsTrait::datum_de_static($f->datum_bis);
            $flyer['active'] = $f->active;
        });
        $data['flyer'] = $flyer;

        $content =  view('flyer.adminAdd_edit')->with('data', $data)->render();
        $l = new Layout();
        return $l->layout_admin_content($content, '', false, false);
    }

    /**
     * @param $id
     * @return string
     */
    public function admin_delete($id)
    {
        $data = [];
        $data['title'] = '';
        $data['flyer'] = [
            'flyer' => '',
            'image' => '',
            'link' => '',
            'datum_von' => '',
            'datum_bis' => '',
            'special_text' => '',
            'active' => '1',
            'id' => '',
        ];

        $flyer = [];
        $Flyer = Flyer::where('id', '=', $id)->get();
        $Flyer->each(function ($f) use (&$flyer) {
            $flyer['id'] = $f->id;
            $flyer['flyer'] = $f->flyer;
            $flyer['link'] = $f->link;
            $flyer['image'] = $f->image;
            $flyer['special_text'] = $f->special_text;
            $flyer['datum_von'] = FxToolsTrait::datum_de_static($f->datum_von);
            $flyer['datum_bis'] = FxToolsTrait::datum_de_static($f->datum_bis);
            $flyer['active'] = $f->active;
        });
        $data['flyer'] = $flyer;

        $content =  view('flyer.admin_delete')->with('data', $data)->render();
        $l = new Layout();
        return $l->layout_admin_content($content, '', false, false);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function admin_delete_post(Request $request)
    {
        $inputs = $request->all();
        $delete = Flyer::find($inputs['id']);
        $delete->delete();
        $this->clearPageCache();
        return redirect()->route('admin.flyer');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function admin_save(Request $request)
    {
        $inputs = $request->all();

        if (!array_key_exists('active', $inputs)) {
            $inputs['active'] = '0';
        }

        if ($inputs['id'] !== 0) {
            $update = Flyer::find($inputs['id']);
            $update->flyer = FxToolsTrait::checkChar($inputs['flyer']);
            $update->link = FxToolsTrait::checkChar($inputs['link']);
            $update->special_text = FxToolsTrait::checkChar($inputs['special_text']);
            $update->datum_von = FxToolsTrait::datum_en_static(FxToolsTrait::checkChar($inputs['datum_von']));
            $update->datum_bis = FxToolsTrait::datum_en_static(FxToolsTrait::checkChar($inputs['datum_bis']));
            $update->active = $inputs['active' ];
            $update->save();
            $id = $inputs['id'];
        } else {
            $add = new Flyer();
            $add->flyer = FxToolsTrait::checkChar($inputs['flyer']);
            $add->link = FxToolsTrait::checkChar($inputs['link']);
            $add->special_text = FxToolsTrait::checkChar($inputs['special_text']);
            $add->datum_von = FxToolsTrait::datum_en_static(FxToolsTrait::checkChar($inputs['datum_von']));
            $add->datum_bis = FxToolsTrait::datum_en_static(FxToolsTrait::checkChar($inputs['datum_bis']));
            $add->active = $inputs['active'];
            $add->save();
            $id = $add->id;
        }

        if (count($request->file('image')) > 0) {
            $data = ImageTrait::UploaderImage('flyer', 'image', [], $request);
            if (count($data['error'])) {
                $update = Flyer::find($id);
            }
            $update->image = $data['image'];
            $update->save();
        }

        $this->clearPageCache();
        return redirect()->route('admin.flyer');
    }
}
