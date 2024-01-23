<?php

namespace App\Http\Controllers;

namespace App\Http\Controllers;

use App\Http\Models\Wachen;
use App\Http\Models\UserLogin;
use Illuminate\Html;
use App\Http\Models\Admin;
use App\Http\Traits\AdminTrait;
use App\Http\Models\Layout;
use App\Http\Models\User;
use Illuminate\Support\Facades\Session;
use App\Http\Traits\FxToolsTrait;
use Illuminate\Contracts\Mail;
use Illuminate\Http\Request;
use Auth;

class WachenController extends GroundController
{
    public function adminShow()
    {
        $data = [];
        $wachen = [];
        $Wachen = \App\Http\Models\Wachen::where('is_feuerwehr', '=', '1')->get();
        $Wachen->each(function ($w) use (&$wachen) {
            $wachen[$w->id] = [
                'id' => $w->id,
                'feuerwehr' => $w->feuerwehr,
                'ort' => $w->ort,
            ];
        });
        $Wachen = \App\Http\Models\Wachen::where('is_rkish', '=', '1')->get();
        $Wachen->each(function ($w) use (&$wachen) {
            $wachen[$w->id] = [
                'id' => $w->id,
                'feuerwehr' => $w->feuerwehr,
                'ort' => $w->ort,
            ];
        });
        $Wachen = \App\Http\Models\Wachen::where('is_drk', '=', '1')->get();
        $Wachen->each(function ($w) use (&$wachen) {
            $wachen[$w->id] = [
                'id' => $w->id,
                'feuerwehr' => $w->feuerwehr,
                'ort' => $w->ort,
            ];
        });
        $Wachen = \App\Http\Models\Wachen::where('is_thw', '=', '1')->get();
        $Wachen->each(function ($w) use (&$wachen) {
            $wachen[$w->id] = [
                'id' => $w->id,
                'feuerwehr' => $w->feuerwehr,
                'ort' => $w->ort,
            ];
        });
        $Wachen = \App\Http\Models\Wachen::where('is_dgzrs', '=', '1')->get();
        $Wachen->each(function ($w) use (&$wachen) {
            $wachen[$w->id] = [
                'id' => $w->id,
                'feuerwehr' => $w->feuerwehr,
                'ort' => $w->ort,
            ];
        });
        $data['wachen'] = $wachen;
        $content =  view('metatags.overview')->with('data', $data)->render();
        $l = new Layout();
        return $l->layout_admin_content($content, '', false, false);
    }

    public function adminAdd()
    {
        $data = [];
        $data['id'] = '';
        $data['metatag'] = '';
        $data['metatag_text'] = '';
        $content =  view('metatags.add_edit')->with('data', $data)->render();
        $l = new Layout();
        return $l->layout_admin_content($content, '', false, false);
    }

    public function adminEdit($id)
    {
        $data = [];
        $Wachen = \App\Http\Models\Wachen::where('id', '=', $id)->get();
        $metatags = [];
        $Wachen->each(function ($m) use (&$data) {
            $data['id'] = $m->id;
            $data['metatag'] = $m->metatag;
            $data['metatag_text'] = $m->metatag_text;
        });
        $content =  view('metatags.add_edit')->with('data', $data)->render();
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
        $inputs = $request->all();
        if ($inputs['id'] !== 0) {
            $update = Wachen::find($inputs['id']);
            $update->metatag = FxToolsTrait::checkChar($inputs['metatag']);
            $update->metatag_text = FxToolsTrait::checkChar($inputs['metatag_text']);
            $update->save();
        } else {
            $add = new Wachen();
            $add->metatag = FxToolsTrait::checkChar($inputs['metatag']);
            $add->metatag_text = FxToolsTrait::checkChar($inputs['metatag_text']);
            $add->save();
        }
        return redirect()->route('admin.metatags');
    }
}
