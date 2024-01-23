<?php

namespace App\Http\Controllers;

use App\Http\Models\Blackday;
use App\Http\Models\Layout;
use App\Http\Traits\FxToolsTrait;
use Illuminate\Http\Request;

class BlackdayController extends GroundController
{
    public function adminShow()
    {
        $data = [];
        $Blackday = Blackday::all();
        $blackday = [];
        $Blackday->each(function ($l) use (&$blackday) {
            $blackday[$l->id] = [
                'id' => $l->id,
                'blackday' => $l->blackday,
                'datum_von' => $l->datum_von,
                'datum_bis' => $l->datum_bis,
                'title' => $l->title,
                'text' => $l->text,
                'text2' => $l->text2,
            ];
        });
        $data['blackdays'] = $blackday;
        $content =  view('blackday.overview')->with('data', $data)->render();
        $l = new Layout();
        return $l->layout_admin_content($content, '', false, false);
    }

    public function adminAdd()
    {
        $data = [];
        $data['id'] = '';
        $data['blackday'] = '';
        $data['datum_von'] = '';
        $data['datum_bis'] = '';
        $data['title'] = '';
        $data['text'] = '';
        $data['text2'] = '';
        $content =  view('blackday.add_edit')->with('data', $data)->render();
        $l = new Layout();
        return $l->layout_admin_content($content, '', false, false);
    }

    public function adminEdit($id)
    {
        $data = [];
        $Blackday = Blackday::where('id', '=', $id)->get();
        $Blackday->each(function ($l) use (&$data) {
            $data['id'] = $l->id;
            $data['blackday'] = $l->blackday;
            $data['datum_von'] = $l->datum_von;
            $data['datum_bis'] = $l->datum_bis;
            $data['title'] = $l->title;
            $data['text'] = $l->text;
            $data['text2'] = $l->text2;
        });
        $content =  view('blackday.add_edit')->with('data', $data)->render();
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
            $update = Blackday::find($inputs['id']);
            $update->blackday = FxToolsTrait::checkChar($inputs['blackday']);
            $update->datum_von = FxToolsTrait::checkChar($inputs['datum_von']);
            $update->datum_bis = FxToolsTrait::checkChar($inputs['datum_bis']);
            $update->title = FxToolsTrait::checkChar($inputs['title']);
            $update->text = FxToolsTrait::checkChar($inputs['text']);
            $update->text2 = FxToolsTrait::checkChar($inputs['text2']);
            $update->save();
        } else {
            $add = new Blackday();
            $add->blackday = FxToolsTrait::checkChar($inputs['blackday']);
            $add->datum_von = FxToolsTrait::checkChar($inputs['datum_von']);
            $add->datum_bis = FxToolsTrait::checkChar($inputs['datum_bis']);
            $add->title = FxToolsTrait::checkChar($inputs['title']);
            $add->text = FxToolsTrait::checkChar($inputs['text']);
            $add->text2 = FxToolsTrait::checkChar($inputs['text2']);
            $add->save();
        }
        return redirect()->route('admin.blackday');
    }
}
