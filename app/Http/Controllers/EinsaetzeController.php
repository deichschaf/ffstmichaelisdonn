<?php

namespace App\Http\Controllers;

use App\Http\Models\Layout;
use App\Http\Traits\EinsaetzeTrait;
use App\Http\Traits\SchadenslisteTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class EinsaetzeController extends GroundController
{
    /**
     * @return JsonResponse
     */
    public function emergencyOverviewApi(): JsonResponse
    {
        $data = [];
        $data['emergencies'] = $this->getAdminEmergencies();
        $data['form_add_url'] = $this->getAdminPath() . '/emergency/add';
        $data['form_edit_url'] = $this->getAdminPath() . '/emergency/edit';
        $data['form_save_url'] = '/api' . $this->getAdminPath() . '/emergency/save/';
        return response()->json($data, 200);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function saveData(Request $request): JsonResponse
    {
        $data = $this->setEmergencyContent($request);
        if ($data['success'] === true) {
            return response()->json($data, 200);
        } else {
            return response()->json($data, $data['errorCode']);
        }
    }

    /**
     * @param $id
     * @return JsonResponse
     */
    public function getLastEmergency($id = 0): JsonResponse
    {
        $data = [];
        $data['message'] = $this->getLastEmergencyMessage($id);
        return response()->json($data, 200);
    }

    /**
     * @return JsonResponse
     */
    public function preDataApi(): JsonResponse
    {
        $data = [];
        $data['types'] = $this->getEmergencyTypes();
        $data['units'] = $this->getEmergencyUnits();
        $data['default_units'] = $this->getDefaultUnitsIDs();
        $data['default_vehicles'] = $this->getDefaultVehicleIDs();
        $data['vehicle'] = $this->getVehiclesOption();
        $data['definitions'] = $this->getEmergencyDefinitions();
        $data['emergencytypes'] = $this->getEmergencyAlarmTypes();
        $data['listalarms'] = $this->getEmergencyAlarmMails();
        return response()->json($data, 200);
    }

    public function show_schadensliste()
    {
        $data = [];
        $data['eg'] = SchadenslisteTrait::eg();
        $data['ew'] = SchadenslisteTrait::ew();
        $data['gsa'] = SchadenslisteTrait::gsa();
        $content = view('intern.schadensliste')->with('data', $data)->render();
        $l = new Layout();
        return $l->layout_content($content, '', false, false);
    }

    public function schadensliste_loader(Request $request)
    {
        $inputs = $request->all();
        $data = [];
        $gsa = $inputs['gsa'];
        $ew = $inputs['ew'];
        $eg = $inputs['eg'];
        $data['content'] = SchadenslisteTrait::getSchaden($gsa, $ew, $eg);
        return view('intern.schadensliste_loader')->with('data', $data)->render();
    }

    public function einsatz_statistik_show()
    {
        $data = [];
        $data['title'] = 'Einsatzstatistik';
        $content = '';
        $content .= EinsaetzeTrait::getEinsatzStatistic('dia');
        $content .= EinsaetzeTrait::getEinsatzStatistic('statistik');
        $content .= EinsaetzeTrait::getEinsatzStatistic('gebiet');
        $content .= EinsaetzeTrait::getEinsatzStatistic('overview');
        $l = new Layout();
        return $l->layout_content($content, $data['title'], false, false);
    }


    /**
     * Zeige alle Einsätze im ausgewählten Jahr oder nimm das aktuelle Jahr als Standard
     */
    public function einsaetze_show($jahr = false)
    {
        $data = EinsaetzeTrait::einsaetze_show_trait($jahr);
        $l = new Layout();
        return $l->layout_content($data['content'], $data['title'], false, false);
    }

    public function getAllEmergencys(): JsonResponse
    {
        $data = [];
        $data['emergencyData'] = $this->getEmergencyData();
        $data['emergency'] = $this->getEmergencyList();
        return response()->json($data, 200);
    }

    public function saveEmergencyType(Request $request): JsonResponse
    {
        $data = $this->setEmergencyScenarioId($request);
        if ($data['success'] === true) {
            return response()->json($data, 200);
        } else {
            return response()->json($data, $data['errorCode']);
        }
    }
}
