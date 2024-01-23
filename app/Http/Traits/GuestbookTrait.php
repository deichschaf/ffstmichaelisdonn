<?php

namespace App\Http\Traits;

use App\Http\Models\Guestbook;
use Illuminate\Http\Request;

/**
 * Trait GuestbookTrait
 * @package App\Http\Traits
 */
trait GuestbookTrait
{
    /**
     * @param $page
     * @param int $success
     * @return array|string
     */
    public static function guestbook_show($page, $success = 0)
    {
        $data = array();
        $Entries = Guestbook::where('ver_oeff', '=', '1')->orderBy('datum', 'desc')->get();
        if (count($Entries) == 0) {
            return array();
        }
        $Entries->each(function ($e) use (&$data) {
            $data[] = $e;
        });
        return view('guestbook.guestbook_overview')->with('data', $data)->with('success', $success)->render();
    }

    /**
     * @param Request $request
     * @return string
     */
    public static function add(Request $request)
    {
        $data = [];
        $inputs = $request->all();
        $data['name'] = '';
        $data['ort'] = '';
        $data['beitrag'] = '';
        $data['emailadresse'] = '';
        $data['www'] = '';
        return view('guestbook.guestbook_add_edit')->with('data', $data)->render();
    }

    /**
     * @param $id
     * @return string
     */
    public static function edit($id)
    {
        $data = [];
        $data['name'] = '';
        $data['ort'] = '';
        $data['beitrag'] = '';
        $data['emailadresse'] = '';
        $data['www'] = '';
        return view('guestbook.guestbook_add_edit')->with('data', $data)->render();
    }

    /**
     * @param $inputs
     */
    public static function save($inputs)
    {
        $add = new Guestbook();
        $add->name = FxToolsTrait::checkChar($inputs['name']);
        $add->ort = FxToolsTrait::checkChar($inputs['ort']);
        $add->beitrag = FxToolsTrait::checkChar($inputs['beitrag']);
        $add->emailadresse = FxToolsTrait::checkChar($inputs['emailadresse']);
        $add->www = FxToolsTrait::checkChar($inputs['www']);
        $add->ver_oeff = '0';
        $add->save();
    }

    /**
     * @param $id
     * @param $hash
     */
    public static function active_by_mail($id, $hash)
    {
    }

    /**
     * @return array|string
     */
    public static function adminShow()
    {
        $data = array();
        $Entries = Guestbook::orderBy('created_at', 'desc')->get();
        if (count($Entries) == 0) {
            return array();
        }
        $Entries->each(function ($e) use (&$data) {
            $data[] = $e;
        });
        return view('guestbook.guestbook_admin_overview')->with('data', $data)->render();
    }
}
