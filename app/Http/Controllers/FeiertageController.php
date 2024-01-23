<?php

namespace App\Http\Controllers;

use App\Http\Models\HappyHoliday;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Models\Layout;
use App\Http\Traits\FxToolsTrait;
use Illuminate\Http\Request;
use App\Http\Traits\AdminTrait;

class FeiertageController extends GroundController
{
    public function admin_overview()
    {
        $this->checkadmin();
        $data = [];
        $data['title'] = 'Feiertage';
        $holidays = [];
        $Holidays = HappyHoliday::orderBy('beginn')->get();
        $Holidays->each(function ($h) use (&$holidays) {
            $holidays[] = [
              'id' => $h->id,
              'beginn' => FxToolsTrait::datum_de_static($h->beginn),
              'ende' => FxToolsTrait::datum_de_static($h->end),
              'template' => $h->template,
            ];
        });
        $data['holidays'] = $holidays;
        $content =  view('holiday.overview')
                    ->with('data', $data)
                    ->with('templates', $this->getTemplates())
                    ->render();
        $l = new Layout();
        return $l->layout_admin_content($content, $data['title'], false, false);
    }
    public function adminAdd()
    {
        $this->checkadmin();
        $data = [];
        $data['title'] = 'Feiertag hinzufügen';
        $data['feiertag'] = [
            'id' => '',
            'beginn' => '',
            'ende' => '',
            'template' => 'christmas',
        ];
        $content =  view('holiday.add_edit')
                    ->with('data', $data)
                    ->with('templates', $this->getTemplates())
                    ->render();
        $l = new Layout();
        return $l->layout_admin_content($content, $data['title'], false, false);
    }
    public function adminEdit($id)
    {
        $this->checkadmin();
        $data = [];
        $data['title'] = 'Feiertag ändern';
        $feiertag = [];
        $Feiertag = HappyHoliday::whereId($id)->get();
        $Feiertag->each(function ($f) use (&$feiertag) {
            $feiertag = [
                'id' => $f->id,
                'beginn' => FxToolsTrait::datum_de_static($f->beginn),
                'ende' => FxToolsTrait::datum_de_static($f->end),
                'template' => $f->template,
            ];
        });
        $data['feiertag'] = $feiertag;
        $content =  view('holiday.add_edit')
                    ->with('data', $data)
                    ->with('templates', $this->getTemplates())
                    ->render();
        $l = new Layout();
        return $l->layout_admin_content($content, $data['title'], false, false);
    }

    private function addYear($date)
    {
        return date('Y-m-d', strtotime($date . " +1 year"));
    }

    public function admin_copy($id)
    {
        $this->checkadmin();
        $data = [];
        $data['title'] = 'Feiertag neu anlegen';
        $feiertag = [];
        $Feiertag = HappyHoliday::whereId($id)->get();
        $Feiertag->each(function ($f) use (&$feiertag) {
            $feiertag = [
                'id' => '0',
                'beginn' => FxToolsTrait::datum_de_static($this->addYear($f->beginn)),
                'ende' => FxToolsTrait::datum_de_static($this->addYear($f->end)),
                'template' => $f->template,
            ];
        });
        $data['feiertag'] = $feiertag;
        $content =  view('holiday.add_edit')
            ->with('data', $data)
            ->with('templates', $this->getTemplates())
            ->render();
        $l = new Layout();
        return $l->layout_admin_content($content, $data['title'], false, false);
    }
    public function adminDelete()
    {
        $this->checkadmin();
    }

    public function adminDeletePost()
    {
        $this->checkadmin();
    }
    public function adminSave(Request $request)
    {
        $this->checkadmin();
        $inputs = $request->all();
        if ($inputs['id'] !== 0 && $inputs['id'] !== '' && $inputs['id'] !== null) {
            $update = HappyHoliday::find($inputs['id']);
            $update->beginn = FxToolsTrait::datum_en_static($inputs['beginn']);
            $update->end = FxToolsTrait::datum_en_static($inputs['ende']);
            $update->template = $inputs['partner_start'];
            $update->save();
        } else {
            $add = new HappyHoliday();
            $add->beginn = FxToolsTrait::datum_en_static($inputs['beginn']);
            $add->end = FxToolsTrait::datum_en_static($inputs['ende']);
            $add->template = $inputs['template'];
            $add->save();
        }
        return redirect()->route('admin.happy_holiday');
    }
    private function checkadmin()
    {
        $return = AdminTrait::checkIsLogin();
        if (is_object($return)) {
            return $return;
        }
    }
}
