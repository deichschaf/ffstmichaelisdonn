<?php

namespace App\Http\Controllers;

use App\Http\Models\Partner;
use App\Http\Models\Layout;
use App\Http\Traits\FxToolsTrait;
use Illuminate\Http\Request;
use Auth;

class PartnerController extends GroundController
{
    public function adminShow()
    {
        $data = [];
        $Partner = Partner::get();
        $partner = [];
        $Partner->each(function ($m) use (&$partner) {
            $partner[$m->id] = [
                'id' => $m->id,
                'partner' => $m->partner,
                'partner_link' => $m->partner_link,
                'partner_start' => $m->partner_start,
                'partner_ende' => $m->partner_ende,
                'aktiv' => $m->aktiv,
            ];
        });
        $data['partner'] = $partner;
        $content =  view('partner.overview')->with('data', $data)->render();
        $l = new Layout();
        return $l->layout_admin_content($content, '', false, false);
    }

    public function adminAdd()
    {
        $data = [];
        $data['id'] = '';
        $data['metatag'] = '';
        $data['metatag_text'] = '';
        $content =  view('partner.add_edit')->with('data', $data)->render();
        $l = new Layout();
        return $l->layout_admin_content($content, '', false, false);
    }

    public function adminEdit($id)
    {
        $data = [];
        $Partner = Partner::where('id', '=', $id)->get();
        $partner = [];
        $Partner->each(function ($m) use (&$data) {
            $data['id'] = $m->id;
            $data['metatag'] = $m->metatag;
            $data['metatag_text'] = $m->metatag_text;
        });
        $content =  view('partner.add_edit')->with('data', $data)->render();
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
            $update = Partner::find($inputs['id']);
            $update->metatag = FxToolsTrait::checkChar($inputs['metatag']);
            $update->metatag_text = FxToolsTrait::checkChar($inputs['metatag_text']);
            $update->save();
        } else {
            $add = new Partner();
            $add->metatag = FxToolsTrait::checkChar($inputs['metatag']);
            $add->metatag_text = FxToolsTrait::checkChar($inputs['metatag_text']);
            $add->save();
        }
        return redirect()->route('admin.partner');
    }
}
