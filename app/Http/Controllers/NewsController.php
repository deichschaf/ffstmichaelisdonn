<?php

namespace App\Http\Controllers;

use App\Http\Models\News;
use App\Http\Traits\NewsTrait;
use App\Http\Models\Layout;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Session;

/**
 * Class NewsController
 * @package App\Http\Controllers
 */
class NewsController extends GroundController
{
    public function getNewsOverviewApi(): JsonResponse
    {
        $data = [];
        $data['news'] = $this->getAdminNews();
        $data['form_add_url'] = $this->getAdminPath().'/news/add';
        $data['form_edit_url'] = $this->getAdminPath().'/news/edit';
        $data['form_copy_url'] = $this->getAdminPath().'/news/copy';
        $data['form_save_url'] = '/api'.$this->getAdminPath().'/news/save/';
        return response()->json($data, 200);
    }

    /**
     * @return string
     */
    public function news_overview()
    {
        $data = NewsTrait::news_show();
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
        $data = NewsTrait::getNews($id);
        Session::put('social_sharing.type', 'article');
        $l = new Layout();
        return $l->layout_content($data['content'], $data['title'], false, false);
    }

    /**
     * @return string
     */
    public function adminShow()
    {
        $data = NewsTrait::news_show();
        $l = new Layout();
        return $l->layout_admin_content($data['content'], $data['title'], false, false);
    }

    /**
     *
     */
    public function adminAdd()
    {
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
     *
     */
    public function adminSave()
    {
        $this->clearPageCache();
    }
}
