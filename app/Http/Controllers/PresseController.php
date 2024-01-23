<?php

namespace App\Http\Controllers;

use App\Http\Models\Presse;
use App\Http\Traits\PresseTrait;
use App\Http\Models\Layout;
use Illuminate\Support\Facades\Session;

class PresseController extends GroundController
{
    /**
     * @return string
     */
    public function presse_show()
    {
        $data = PresseTrait::news_show();
        $l = new Layout();
        return $l->layout_content($data['content'], $data['title'], false, false);
    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|string
     */
    public function getArtikel($id)
    {
        if (!is_numeric($id)) {
            return redirect('news');
        }
        $data = PresseTrait::getNews($id);
        session(['social_sharing.type' => 'article']);
        $l = new Layout();
        return $l->layout_content($data['content'], $data['title'], false, false);
    }

    public function adminShow()
    {
        $data = PresseTrait::news_show();
        $l = new Layout();
        return $l->layout_admin_content($data['content'], $data['title'], false, false);
    }

    public function adminAdd()
    {
    }
    public function adminEdit($id)
    {
    }
    public function adminDelete($id)
    {
    }
    public function adminDeletePost()
    {
    }
    public function adminSave()
    {
    }
}
