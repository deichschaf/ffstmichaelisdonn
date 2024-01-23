<?php

namespace App\Http\Controllers;

use App\Http\Models\Widget;
use App\Http\Models\Layout;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Http\Traits\FxToolsTrait;

/***
 * Class WidgetController
 * @package App\Http\Controllers
 * @Todo: Upload für Flyer
 * @Todo: Kopieren von Widgets
 */

class WidgetController extends GroundController
{
    /**
     * @return string
     */
    public function admin_overview()
    {
        $data = [];
        $Widgets = Widget::all()->sortBy('position')->sortBy('pos');
        $WidgetsData = [];
        $Widgets->each(function ($w) use (&$WidgetsData) {
            $WidgetsData[] = [
                'id' => $w->id,
                'name' => $w->WidgetName,
                'param' => $w->param,
                'position' => $w->position,
                'pos' => $w->pos,
                'active' => $w->active,
            ];
        });
        $data['widgets'] = $WidgetsData;
        $content =  view('widget.admin_overview')->with('data', $data)->render();
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
        $data['widget'] = [
            'name' => '',
            'param' => '',
            'active' => '0',
            'position' => 'left',
            'id' => '',
        ];
        $content =  view('widget.adminAdd_edit')->with('data', $data)->render();
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
        $data['widget'] = [
            'name' => '',
            'param' => '',
            'active' => '0',
            'position' => 'left',
            'id' => '',
        ];

        $widget = [];
        $Widget = Widget::where('id', '=', $id)->get();
        $Widget->each(function ($w) use (&$widget) {
            $widget['id'] = $w->id;
            $widget['name'] = $w->WidgetName;
            $widget['param'] = $w->param;
            $widget['position'] = $w->position;
            $widget['pos'] = $w->pos;
            $widget['active'] = $w->active;
        });
        $data['widget'] = $widget;

        $content =  view('widget.adminAdd_edit')->with('data', $data)->render();
        $l = new Layout();
        return $l->layout_admin_content($content, '', false, false);
    }

    /**
     *
     */
    public function adminDelete()
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

        if (!array_key_exists('active', $inputs)) {
            $inputs['active'] = '0';
        }

        if ($inputs['id'] !== 0) {
            $update = Widget::find($inputs['id']);
            $update->WidgetName = FxToolsTrait::checkChar($inputs['name']);
            $update->param = FxToolsTrait::checkChar($inputs['param']);
            $update->position = FxToolsTrait::checkChar($inputs['position']);
            $update->pos = FxToolsTrait::checkChar($inputs['pos']);
            $update->active = $inputs['active' ];
            $update->save();
        } else {
            $add = new Widget();
            $add->WidgetName = FxToolsTrait::checkChar($inputs['name']);
            $add->param = FxToolsTrait::checkChar($inputs['param']);
            $add->position = FxToolsTrait::checkChar($inputs['position']);
            $add->pos = FxToolsTrait::checkChar($inputs['pos']);
            $add->active = $inputs['active'];
            $add->save();
        }
        $this->clearPageCache();
        return redirect()->route('admin.widget');
    }
}
