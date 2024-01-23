<?php

/**
 * Created by PhpStorm.
 * User: Jörg-Marten Hoffmann
 * Date: 15.04.2015
 * Time: 06:55
 */

namespace App\Http\Controllers;

use App\Http\Models\Layout;
use App\Http\Traits\GuestbookTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

/**
 * Class GuestbookController
 * @package App\Http\Controllers
 */
class GuestbookController extends GroundController
{
    /**
     * @param int $page
     * @return string
     */
    public function guestbook_show($page = 0)
    {
        $content = GuestbookTrait::show($page, 0);
        $data = array();
        $data['title'] = ' - Einträge';
        $l = new Layout();
        return $l->layout_content($content, $data['title'], false, false);
    }

    /**
     * @param int $page
     * @return string
     */
    public function show_success($page = 0)
    {
        $content = GuestbookTrait::show($page, 1);
        $data = array();
        $data['title'] = ' - Einträge';
        $l = new Layout();
        return $l->layout_content($content, $data['title'], false, false);
    }

    /**
     * @param $id
     * @param $hash
     */
    public function admin_activate($id, $hash)
    {
        $this->clearPageCache();
    }

    /**
     * @param $id
     * @param $hash
     */
    public function admin_deactivate($id, $hash)
    {
        $this->clearPageCache();
    }

    /**
     * @return string
     */
    public function add()
    {
        $content = GuestbookTrait::add();
        $data = array();
        $data['title'] = ' - Einträge';
        $l = new Layout();
        return $l->layout_content($content, $data['title'], false, false);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function save(Request $request)
    {
        $inputs = $request->all();
        $validator = \Validator::make($inputs, [
            'name' => 'required|name',
            'ort' => 'required|city',
            'beitrag' => 'required|namefullnumbers',
            'emailadresse' => 'required|email',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withInput($request->all())
                ->withErrors($validator->errors());
        }

        $inputs['datum'] = date('d.m.Y H:i:s');

        $save = GuestbookTrait::save($inputs);

        Mail::queue(['email.guestbook_html', 'email.guestbook_text'], $inputs, function ($m) use ($inputs) {
            $m->to(env('GUESTBOOK_EMPLOYER', 'HOMEPAGE_EMAIL'));
            $m->subject('Gästebuch ' . HOMEPAGETITEL);
        });
        return redirect()->to('/gaestebuch/success');
        #return redirect()->route('gaestebuch');
    }

    /**
     * @param $id
     * @param $hash
     */
    public function active_by_mail($id, $hash)
    {
    }

    /**
     * @return string
     */
    public function adminShow()
    {
        $content = GuestbookTrait::adminShow();
        $data = array();
        $data['title'] = ' - Einträge';
        $l = new Layout();
        return $l->layout_admin_content($content, $data['title'], false, false);
    }

    /**
     * @param $id
     */
    public function adminEdit($id)
    {
    }

    /**
     * @param $id
     */
    public function admin_comment($id)
    {
    }

    /**
     * @param $id
     */
    public function adminDelete($id)
    {
    }

    /**
     * @param $id
     */
    public function admin_active($id)
    {
        $this->clearPageCache();
    }
}
