<?php

namespace App\Http\Controllers;

use App\Http\Models\AlarmEmail;
use App\Http\Models\MitgliedAnwesenheit;
use App\Http\Models\MitgliedAnwesenheitEreignis;
use App\Http\Models\Mitglieder;
use App\Http\Traits\TermineTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AnwesenheitController extends EinsaetzeController
{
    public function show_start()
    {
        $content = view('einsatzapp.anwesenheit_protokoll')->render();
        return $this->LoadTemplate($content, false);
    }

    public function getMitglieder()
    {
        return response()->json($this->getMitgliederData());
    }

    private function getDateTime()
    {
        return date('Y-m-d H:i:s');
    }

    private function AnwesenheitToken()
    {
        return Hash::make('password', [
            'memory' => 1024,
            'time' => 2,
            'threads' => 2,
        ]);
    }

    public function einsatz()
    {
        $dates = $this->getAllEinsatze();
        $mitglieder = $this->getMitgliederData();
        $gruende = $this->Abwesenheitsgruende();
        $content = view('einsatzapp.anwesenheit')->with('dates', $dates)->with('anwesenheit_token', $this->AnwesenheitToken())->with('date_time', $this->getDateTime())->with('mitglieder', $mitglieder)->with('type', 'emergency')->with('gruende', $gruende)->render();
        return $this->LoadTemplate($content, false);
    }

    public function uebung()
    {
        $dates = $this->getAnwesenheitUebungsdienste();
        $mitglieder = $this->getMitgliederData();
        $gruende = $this->Abwesenheitsgruende();
        $content = view('einsatzapp.anwesenheit')
            ->with('dates', $dates)
            ->with('anwesenheit_token', $this->AnwesenheitToken())
            ->with('date_time', $this->getDateTime())
            ->with('mitglieder', $mitglieder)
            ->with('type', 'uebung')
            ->with('gruende', $gruende)
            ->render();
        return $this->LoadTemplate($content, false);
    }

    public function absicherung()
    {
        $mitglieder = $this->getMitgliederData();
        $gruende = $this->Abwesenheitsgruende();
        $content = view('einsatzapp.anwesenheit')
            ->with('dates', $dates)
            ->with('anwesenheit_token', $this->AnwesenheitToken())
            ->with('date_time', $this->getDateTime())
            ->with('mitglieder', $mitglieder)
            ->with('type', 'absicherung')
            ->with('gruende', $gruende)
            ->render();
        return $this->LoadTemplate($content, false);
    }

    public function hydranten()
    {
        $mitglieder = $this->getMitgliederData();
        $gruende = $this->Abwesenheitsgruende();
        $content = view('einsatzapp.anwesenheit')
            ->with('dates', $dates)
            ->with('anwesenheit_token', $this->AnwesenheitToken())
            ->with('date_time', $this->getDateTime())
            ->with('mitglieder', $mitglieder)
            ->with('type', 'hydranten')
            ->with('gruende', $gruende)
            ->render();
        return $this->LoadTemplate($content, false);
    }

    public function anwesenheit_speichern(Request $request)
    {
        $last_id = 0;
        $Content = MitgliedAnwesenheitEreignis::where('anwesenheit_token', '=', $request->get('anwesenheit_token'))->get();
        if (count($Content) === 1) {
            $Content->each(function ($mae) use (&$last_id) {
                $last_id = $mae->id;
            });
        } else {
            $einsatz_id = 0;
            $termin_id = 0;
            if ($request->get('anwesenheit_type') === 'emergency') {
                $einsatz_id = $request->get('anwesenheit_id');
            }
            if ($request->get('anwesenheit_type') === 'uebung') {
                $termin_id = $request->get('anwesenheit_id');
            }
            $save = new MitgliedAnwesenheitEreignis();
            $save->date_time = $request->get('date_time');
            $save->ereignis = $request->get('anwesenheit_type');
            $save->einsatz_id = $einsatz_id;
            $save->termin_id = $termin_id;
            $save->send_mail = '0';
            $save->anwesenheit_token = $request->get('anwesenheit_token');
            $save->save();
            $last_id = $save->id;
        }


        $status = $this->Abwesenheitsgruende();

        $save = new MitgliedAnwesenheit();
        $save->cms_mitglieder_anwesenheit_ereignis_id = $last_id;
        $save->mitglied_id = $request->get('mitglied_id');
        $save->status = $status[$request->get('select_type')];
        $save->bemerkung = '';
        $save->save();
        return response()->json(['status', 200]);
    }

    private function getEvents()
    {
        $events = [];
        $accidents = $this->getAllEinsatze();
        foreach ($accidents as $key => $row) {
            $events[] = $accidents[$key];
        }
        return $events;
    }

    private function getEinsatzInfo()
    {
        $data = [];
        $Einsatz = AlarmEmail::orderBy('created_at', 'DESC')->take(1)->get();
        $Einsatz->each(function ($e) use (&$data) {
            $data[] = [
                'id' => $e->id,
                'date' => $e->created_at,
                'where' => $e->emergency_place,
                'type' => 'emergency'
            ];
        });
        return $data;
    }

    private function getAllEinsatze()
    {
        $data = [];
        $Einsatze = AlarmEmail::orderBy('created_at', 'DESC')->get();
        $Einsatze->each(function ($e) use (&$data) {
            $data[] = [
                'id' => $e->id,
                'date' => $e->created_at,
                'where' => $e->emergency_place,
                'type' => 'emergency'
            ];
        });
        return $data;
    }

    private function getAnwesenheitEinsaetze()
    {
    }

    private function getAnwesenheitUebungsdienste()
    {
        $Termine = TermineTrait::getAllTermineAnwesenheit();
        return $Termine;
    }

    private function getAnwesenheitHydranten()
    {
    }

    private function SaveIncident()
    {
    }

    public function SaveStatus(Request $request)
    {
    }

    public function SaveStatusText(Request $request)
    {
    }

    private function Abwesenheitsgruende()
    {
        $gruende = [];
        $gruende['0'] = 'Undefiniert';
        $gruende['1'] = 'Anwesend';
        $gruende['2'] = 'Unentschuldigt';
        $gruende['3'] = 'Entschuldigt';
        $gruende['4'] = 'Urlaub';
        $gruende['5'] = 'Krank';
        $gruende['6'] = 'Brandsicherheitswache';
        return $gruende;
    }

    private function getMitgliederData()
    {
        $mitglieder = [];
        $Mitglieder = Mitglieder::where('altgedienter', '=', '0')
            ->where('ausgeschieden', '=', '0')
            ->orderBy('nachname', 'ASC')
            ->orderBy('vorname', 'ASC')
            ->get();
        $Mitglieder->each(function ($m) use (&$mitglieder) {
            $mitglieder[] = array(
                'id' => $m->id,
                'vorname' => $m->vorname,
                'nachname' => $m->nachname,
                'bild' => $m->bild,
            );
        });
        return $mitglieder;
    }
}
