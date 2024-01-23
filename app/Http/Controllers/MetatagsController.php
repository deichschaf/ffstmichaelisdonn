<?php

namespace App\Http\Controllers;

use App\Http\Models\Metatags;
use App\Http\Models\UserLogin;
use App\Http\Models\Layout;
use App\Http\Models\User;
use Illuminate\Support\Facades\Session;
use App\Http\Traits\FxToolsTrait;
use Illuminate\Contracts\Mail;
use Illuminate\Http\Request;
use Auth;

/**
 * Class MetatagsController
 * @package App\Http\Controllers
 */
class MetatagsController extends GroundController
{
    /**
     * Hole alle Metatags
     *
     * @param object $mysql
     * @return array
     */
    public function getMetatags($mysql, $admin)
    {
    }

    /**
     * @return string
     */
    public function adminShow()
    {
        $data = [];
        $Metatags = \App\Http\Models\Metatags::all();
        $metatags = [];
        $Metatags->each(function ($m) use (&$metatags) {
            $metatags[$m->id] = [
                'id' => $m->id,
                'metatag' => $m->metatag,
                'metatag_text' => $m->metatag_text,
            ];
        });
        $data['metatags'] = $metatags;
        $content =  view('metatags.overview')->with('data', $data)->render();
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
        $data['metatag'] = '';
        $data['metatag_text'] = '';
        $content =  view('metatags.add_edit')->with('data', $data)->render();
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
        $Metatags = \App\Http\Models\Metatags::where('id', '=', $id)->get();
        $metatags = [];
        $Metatags->each(function ($m) use (&$data) {
            $data['id'] = $m->id;
            $data['metatag'] = $m->metatag;
            $data['metatag_text'] = $m->metatag_text;
        });
        $content =  view('metatags.add_edit')->with('data', $data)->render();
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
            $update = Metatags::find($inputs['id']);
            $update->metatag = FxToolsTrait::checkChar($inputs['metatag']);
            $update->metatag_text = FxToolsTrait::checkChar($inputs['metatag_text']);
            $update->save();
        } else {
            $add = new Metatags();
            $add->metatag = FxToolsTrait::checkChar($inputs['metatag']);
            $add->metatag_text = FxToolsTrait::checkChar($inputs['metatag_text']);
            $add->save();
        }
        return redirect()->route('admin.metatags');
    }
}
