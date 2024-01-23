<?php
namespace App\Http\Controllers;

use App\Http\Models\Layout;
use App\Http\Models\Termine;
use App\Http\Traits\TermineTrait;
use App\Http\Traits\FxToolsTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * Class TermineController
 * @package App\Http\Controllers
 */
class TermineController extends GroundController
{
    public function getAdminTermineOverview():JsonResponse
    {
        $data = [];
        $data['termine'] = $this->getAdminTermine();
        $data['form_add_url'] = $this->getAdminPath().'/termine/add';
        $data['form_edit_url'] = $this->getAdminPath().'/termine/edit';
        $data['form_copy_url'] = $this->getAdminPath().'/termine/copy';
        $data['form_save_url'] = '/api'.$this->getAdminPath().'/termine/save/';
        return response()->json($data, 200);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function saveData(Request $request): JsonResponse
    {
        try {
            $data = $this->setAdminTermine($request);
            return response()->json($data, 200);
        } catch (\Exception $exception) {
            $data= [];
            $data['success'] = false;
            $data['errors'] = [
                'code'=>$exception->getCode(),
                'message'=>$exception->getMessage()
            ];
            return response()->json($data, 500);
        }
    }

    /**
     * show the termins on facebook
     */
    public function show_facebooktermine()
    {
        #$ALL = $this->ge
    }

    /**
     *
     */
    public function show_website()
    {
        $data = array();
        $data['title'] = 'Termine';
        $data['termine'] = $this->getAllTermine();
        $content =  view('termine.termine')->with('data', $data)->render();
        $l = new Layout();
        return $l->layout_content($content, $data['title'], false, false);
    }

    /**
     * @param $user
     * @return mixed
     */
    public function show_ics()
    {
        $user = false;
        echo $this->getICS($user);
        exit();
    }

    /**
     * @param $id
     */
    public function show_ics_user($id)
    {
        $user = false;
        echo $this->getICS($user);
        exit();
    }

    /**
     *
     */
    public function adminAdd()
    {
        $data = [];
        $data['id'] = '';
        $data['datum'] = '';
        $data['datum_von'] = '';
        $data['datum_bis'] = '';
        $data['beginn'] = '';
        $data['uhrzeit_von'] = '';
        $data['uhrzeit_bis'] = '';
        $data['ort'] = '';
        $data['veranstaltungsort'] = '';
        $data['titel'] = '';
        $data['beschreibung'] = '';
        $data['veranstalter'] = '';
        $data['kosten'] = '';
        $data['anmeldung'] = '';
        $data['abfahrt'] = '';
        $data['kleidung'] = '';
        $data['pflicht'] = '0';
        $data['is_public'] = '0';
        $data['aktiv'] = '1';
        $data['at_traeger'] = '0';
        $data['vorstand'] = '0';
        $data['musikzug'] = '0';
        $data['sprechfunk'] = '0';
        $data['funkuebung'] = '0';
        $data['kleidungen'] = $this->getWear();

        $content =  view('termine.adminAdd_edit')->with('data', $data)->render();
        $l = new Layout();
        return $l->layout_admin_content($content, '', false, false);
    }

    /**
     * @param $id
     */
    public function adminEdit($id)
    {
        $data = [];

        $data['id'] = '';
        $data['datum'] = '';
        $data['datum_von'] = '';
        $data['datum_bis'] = '';
        $data['beginn'] = '';
        $data['uhrzeit_von'] = '';
        $data['uhrzeit_bis'] = '';
        $data['ort'] = '';
        $data['veranstaltungsort'] = '';
        $data['titel'] = '';
        $data['beschreibung'] = '';
        $data['veranstalter'] = '';
        $data['kosten'] = '';
        $data['anmeldung'] = '';
        $data['abfahrt'] = '';
        $data['kleidung'] = '';
        $data['pflicht'] = '0';
        $data['is_public'] = '0';
        $data['aktiv'] = '0';
        $data['at_traeger'] = '0';
        $data['vorstand'] = '0';
        $data['musikzug'] = '0';
        $data['sprechfunk'] = '0';
        $data['funkuebung'] = '0';
        $Termine = Termine::where('id', '=', $id)->get();
        $Termine->each(function ($t) use (&$data) {
            $data['id'] = $t->id;
            $data['datum'] = FxToolsTrait::datum_de_static($t->datum);
            // $data['datum_von'] = ;
            $data['datum_bis'] = FxToolsTrait::datum_de_static($t->datum_bis);
            $data['beginn'] = '';
            $data['uhrzeit_von'] = '';
            $data['uhrzeit_bis'] = '';
            $data['ort'] = $t->ort;
            $data['veranstaltungsort'] = $t->veranstaltungsort;
            $data['titel'] = $t->veranstaltung;
            $data['beschreibung'] = $t->beschreibung;
            $data['veranstalter'] = $t->veranstalter;
            $data['kosten'] = $t->kosten;
            $data['anmeldung'] = $t->anmeldung;
            $data['abfahrt'] = $t->abfahrt;
            $data['kleidung'] = $t->kleidung;
            $data['pflicht'] = $t->pflicht;
            $data['is_public'] = $t->is_public;
            $data['aktiv'] = $t->aktivr;
            $data['at_traeger'] = $t->at_traeger;
            $data['vorstand'] = $t->vorstand;
            $data['musikzug'] = $t->musikzug;
            $data['sprechfunk'] = $t->sprechfunk;
            $data['funkuebung'] = $t->funkuebung;
        });
        $data['kleidungen'] = $this->getWear();
        $content =  view('termine.adminAdd_edit')->with('data', $data)->render();
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
     * @param $id
     */
    public function adminDelete_now($id)
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
            $update = Termine::find($inputs['id']);
            $update->datum = FxToolsTrait::datum_en_static($inputs['datum']);
            $update->datum_von = FxToolsTrait::datum_en_static($inputs['datum']);
            $update->datum_bis = FxToolsTrait::datum_en_static($inputs['datum_bis']);
            $update->beginn = FxToolsTrait::zeit_static($inputs['beginn'], '55:55:55');
            $update->uhrzeit_von = FxToolsTrait::zeit_static($inputs['beginn'], '55:55:55');
            $update->uhrzeit_bis = FxToolsTrait::zeit_static($inputs['uhrzeit_bis'], '55:55:55');
            $update->ort = FxToolsTrait::checkChar($inputs['ort']);
            $update->veranstaltungsort = FxToolsTrait::checkChar($inputs['veranstaltungsort']);
            $update->veranstaltung = FxToolsTrait::checkChar($inputs['titel']);
            $update->beschreibung = FxToolsTrait::checkChar($inputs['beschreibung']);
            #$update->veranstalter = FxToolsTrait::checkChar($inputs['veranstalter']);
            #$update->kosten = FxToolsTrait::checkChar($inputs['kosten']);
            #$update->anmeldung = FxToolsTrait::checkChar($inputs['anmeldung']);
            $update->abfahrt = FxToolsTrait::datum_en_static($inputs['abfahrt']);
            $update->kleidung = FxToolsTrait::checkChar($inputs['kleidung']);
            $update->pflicht = FxToolsTrait::checkChar($inputs['pflicht']);
            $update->is_public = FxToolsTrait::checkChar($inputs['is_public']);
            $update->aktiv = FxToolsTrait::checkChar($inputs['aktiv']);
            $update->at_traeger = FxToolsTrait::checkChar($inputs['at_traeger']);
            $update->vorstand = FxToolsTrait::checkChar($inputs['vorstand']);
            $update->musikzug = FxToolsTrait::checkChar($inputs['musikzug']);
            $update->sprechfunk = FxToolsTrait::checkChar($inputs['sprechfunk']);
            $update->funkuebung = FxToolsTrait::checkChar($inputs['funkuebung']);
            $update->save();
        } else {
            $add = new Termine();
            $add->datum = FxToolsTrait::datum_en_static($inputs['datum']);
            $add->datum_von = FxToolsTrait::datum_en_static($inputs['datum']);
            $add->datum_bis = FxToolsTrait::datum_en_static($inputs['datum_bis']);
            $add->beginn = FxToolsTrait::zeit_static($inputs['beginn'], '55:55:55');
            $add->uhrzeit_von = FxToolsTrait::zeit_static($inputs['beginn'], '55:55:55');
            $add->uhrzeit_bis = FxToolsTrait::zeit_static($inputs['uhrzeit_bis'], '55:55:55');
            $add->ort = FxToolsTrait::checkChar($inputs['ort']);
            $add->veranstaltungsort = FxToolsTrait::checkChar($inputs['veranstaltungsort']);
            $add->veranstaltung = FxToolsTrait::checkChar($inputs['titel']);
            $add->beschreibung = FxToolsTrait::checkChar($inputs['beschreibung']);
            #$add->veranstalter = FxToolsTrait::checkChar($inputs['veranstalter']);
            #$add->kosten = FxToolsTrait::checkChar($inputs['kosten']);
            #$add->anmeldung = FxToolsTrait::checkChar($inputs['anmeldung']);
            $add->abfahrt = FxToolsTrait::datum_en_static($inputs['abfahrt']);
            $add->kleidung = FxToolsTrait::checkChar($inputs['kleidung']);
            $add->pflicht = FxToolsTrait::checkChar($inputs['pflicht']);
            $add->is_public = FxToolsTrait::checkChar($inputs['is_public']);
            $add->aktiv = FxToolsTrait::checkChar($inputs['aktiv']);
            $add->at_traeger = FxToolsTrait::checkChar($inputs['at_traeger']);
            $add->vorstand = FxToolsTrait::checkChar($inputs['vorstand']);
            $add->musikzug = FxToolsTrait::checkChar($inputs['musikzug']);
            $add->sprechfunk = FxToolsTrait::checkChar($inputs['sprechfunk']);
            $add->funkuebung = FxToolsTrait::checkChar($inputs['funkuebung']);
            $add->save();
        }
        $this->clearPageCache();
        return redirect()->route('admin.termine');
    }

    /**
     *
     */
    public function adminShow($all = 0)
    {
        $data = [];
        if ($all === 1) {
            $Termine = Termine::orderBy('datum', 'ASC')->get();
        } else {
            $Termine = Termine::where('datum', '>=', date('Y-m-d'))->orderBy('datum', 'ASC')->get();
        }
        $termine = [];
        $Termine->each(function ($t) use (&$termine) {
            $termine[$t->id] = [
                'id' => $t->id,
                'datum' => FxToolsTrait::datum_de_static($t->datum),
                'datum_bis' => FxToolsTrait::datum_de_static($t->datum_bis),
                'titel' => $t->veranstaltung,
                'ort' => $t->veranstaltungsort,
            ];
        });
        $data['termine'] = $termine;
        $content =  view('termine.admin_overview')->with('data', $data)->render();
        $l = new Layout();
        return $l->layout_admin_content($content, '', false, false);
    }
}
