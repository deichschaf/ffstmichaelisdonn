<?php

namespace App\Http\Traits;

use App\Http\Enum\ActiveEnum;
use App\Http\Models\AlarmEmail;
use App\Http\Models\Einsaetze;
use App\Http\Models\EinsatzBegriff;
use App\Http\Models\EinsatzBezirk;
use App\Http\Models\EinsatzFahrzeug;
use App\Http\Models\EmergencyMissionScenario;
use App\Http\Models\EmergencyTypeCategory;
use App\Http\Models\EmergencyUnits;
use App\Http\Models\Fahrzeuge;
use App\Http\Models\Feuerwehren;
use App\Http\Models\Presse;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

trait EinsaetzeTrait
{
    private const EMERGENCY_TYPE_EXERCISE = 'Übung';
    private const EMERGENCY_TYPE_ACTION = 'Einsatz';
    public $fahrzeuge = [];
    public $feuerwehren = [];
    private $year = 0;
    private $EinsatzBegriffeArray = [];
    private $start_year = 2004;
    private $end_year = 0;
    private $year_now = 0;
    private $maximum = 0;
    private $legende = [];

    /**
     * @param int $messageId
     * @return array|null
     */
    public function getLastEmergencyMessage(int $messageId = 0): array|null
    {
        if ($messageId !== 0) {
            $count = AlarmEmail::where('id', '=', $messageId)->count();
            if ($count !== 1) {
                return null;
            }
            $Message = AlarmEmail::where('id', '=', $messageId)->get();
            $scenario = $Message['0']->emergency_scenario;
            $emergency_info = $Message['0']->emergency_info;
            $date_time = $Message['0']->emergency_date_time;
        } else {
            $Message = AlarmEmail::orderBy('id', 'DESC')->take(1)->get();
            $scenario = $Message['0']->emergency_scenario;
            $date_time = $Message['0']->emergency_date_time;
            $count = AlarmEmail::where('emergency_number', '=', $Message['0']->emergency_number)->count();
            if ($count > 1) {
                $Message2 = AlarmEmail::where('emergency_number', '=', $Message['0']->emergency_number)
                    ->orderBy('id', 'ASC')->take(1)->get();
                $scenario = $Message2['0']->emergency_scenario;
                $emergency_info = $Message2['0']->emergency_info;
                $date_time = $Message2['0']->emergency_date_time;
            }
        }
        $scenarien = $this->getScenarios();
        $scenarioId = 0;
        if (array_key_exists($scenario, $scenarien)) {
            $scenarioId = $scenarien[$scenario];
        }
        if ($emergency_info !== '') {
            $scenario = $scenario . ', ' . $emergency_info;
        }
        $default_vehicles = $this->getDefaultVehicleIDs();
        $data = [];
        $Message->each(function ($m) use ($scenario, $scenarioId, $date_time, $default_vehicles, &$data) {
            $datetime = explode(' ', $date_time);
            $stations = $this->getUnitsReplace($m->emergency_stations);
            $stationIds = $this->getUnitsIDs($stations);
            $eraseHelp = false;
            $rics = $this->getUnitRics('eraseHelp');
            foreach ($rics as $k => $ric) {
                if (preg_match('/' . $ric . '/', $m->emergency_stations)) {
                    $eraseHelp = true;
                }
            }

            $type = 0;

            if (strtolower(substr($scenario, 0, 3)) === 'feu') {
                $type = 1;
            }
            if (strtolower(substr($scenario, 0, 2)) === 'th') {
                $type = 2;
            }

            $data = [
                'id' => $m->id,
                'emergency_date_time' => $date_time,
                'german_date' => $datetime['0'],
                'german_time' => $datetime['1'],
                'emergency_priority' => $m->emergency_priority,
                'emergency_number' => $m->emergency_number,
                'emergency_workstation' => $m->emergency_workstation,
                'emergency_scenario' => $scenario,
                'scenarioId' => $scenarioId,
                'emergency_info' => $m->emergency_info,
                'emergency_place' => $m->emergency_place,
                'emergency_place_lat' => $m->emergency_place_lat,
                'emergency_place_lng' => $m->emergency_place_lng,
                'emergency_place_info' => $m->emergency_place_info,
                'emergency_information' => $m->emergency_information,
                'emergency_stations' => $m->emergency_stations,
                'emergency_stations_replace' => $stations,
                'stationIds' => $stationIds,
                'default_vehicles' => $default_vehicles,
                'eraseHelp' => $eraseHelp,
                'alarm_type' => 'einsatz',
                'type' => $type,
                'is_alarm' => true
            ];
        });
        return $data;
    }

    /**
     * @return array
     */
    private function getScenarios(): array
    {
        $data = [];
        $Scenarios = EmergencyMissionScenario::orderBy('scenario', 'ASC')->get();
        $Scenarios->each(function ($es) use (&$data) {
            $data[$es->scenario] = $es->id;
        });
        return $data;
    }

    /**
     * @param $units
     * @return array
     */
    private function getUnitsReplace($units = ''): array
    {
        $units = explode(',', $units);
        foreach ($units as $k => $value) {
            $original = $value;
            if ($this->isRKISH($value)) {
                $value = 'Rettungsdienst-Kooperation in Schleswig-Holstein gGmbH';
            } else {
                $replace = $this->makeUnitsReplace($value);
                if ($replace !== $original) {
                    $value = "Feuerwehr " . $replace;
                } else {
                    $value = $replace;
                }
            }
            $units[$k] = $value;
        }
        return array_unique($units);
    }

    /**
     * @param string $unit
     * @return bool
     */
    private function isRKISH(string $unit): bool
    {
        $unit = strtolower($unit);
        if (substr($unit, 0, 7) === 'ret hei') {
            return true;
        }
        if (substr($unit, 0, 6) === 'ret iz') {
            return true;
        }
        return false;
    }

    /**
     * @param string $unit
     * @return string
     */
    private function makeUnitsReplace(string $unit = ''): string
    {
        $group = [
            '_TECHN-HILFE', '_ZUGALARM-1', ' ZUGALARM-1', '_ZUGALARM-2', ' ZUGALARM-2', '_LÖSCHHILFE-1', ' LÖSCHHILFE-1', '_LÖSCHHILFE-2', ' LÖSCHHILFE-2', '_SIRENENALARM', ' SIRENENALARM', '_DME-VOLLALARM', ' DME-VOLLALARM', '_'
        ];
        $unit = str_replace($group, '', $unit);
        $unit = trim($unit);
        return $unit;
    }

    /**
     * @param array $stations
     * @return array
     */
    private function getUnitsIDs(array $stations = []): array
    {
        $units = [];
        $Units = Feuerwehren::get();
        $Units->each(function ($u) use (&$units, $stations) {
            if (in_array($u->feuerwehr, $stations)) {
                $units[] = ['value' => $u->id, 'label' => $u->feuerwehr];
            }
        });
        return $units;
    }

    /**
     * @param string $ric
     * @return string[]
     */
    private function getUnitRics(string $ric = ''): array
    {
        switch ($ric) {
            case 'eraseHelp':
                $rics = [
                    'Sankt Michaelisdonn_LÖSCHHILFE-1',
                    'Sankt Michaelisdonn_LÖSCHHILFE-2'
                ];
                break;
            default:
                $rics = [
                    'Sankt Michaelisdonn_DME-VOLLALARM',
                    'Sankt Michaelisdonn_SIRENENALARM',
                    'Sankt Michaelisdonn_LÖSCHHILFE-1',
                    'Sankt Michaelisdonn_LÖSCHHILFE-1'
                ];
        }
        return $rics;
    }

    /**
     * @return array
     */
    public function getDefaultUnitsIDs(): array
    {
        $units = [];
        $Units = Feuerwehren::where('is_default', '=', '1')->get();
        $Units->each(function ($u) use (&$units) {
            $units[] = ['value' => $u->id, 'label' => $u->feuerwehr];
        });
        return $units;
    }

    /**
     * @return array
     */
    public function getAdminEmergencies(): array
    {
        $data = Cache::remember(
            __CLASS__ . '_' . __FUNCTION__,
            Config::get('CacheConfig.cache_content_timeout'),
            function () {
                $data = [];
                $Einsatz = Einsaetze::orderBy('einsatz_begin', 'desc')
                    ->get();
                $Einsatz->each(function ($e) use (&$data) {
                    $date = explode(' ', $e->einsatz_begin);
                    $year = explode('-', $date['0']);
                    $data[] = [
                        'id' => $e->id,
                        'beginn' => $this->makeDatumZeitStatic($e->einsatz_begin),
                        'is_alarm' => $e->is_alarm,
                        'einsatz_art' => $e->einsatz_art,
                        'einsatz_ort' => $e->einsatz_ort,
                        'loeschhilfe' => $e->loeschhilfe,
                        'active' => $e->aktiv,
                        'year' => $year['0'],
                    ];
                });
                return $data;
            }
        );
        return $data;
    }

    public function getLastAlarmTime(): string
    {
        $datetime = '';
        $Einsatz = Einsaetze::orderBy('einsatz_begin', 'desc')
            ->where('aktiv', '=', '1')
            ->take(1)
            ->get();
        $Einsatz->each(function ($e) use (&$datetime) {
            $datetime = str_replace(" ", "T", $e->einsatz_begin);
        });
        return $datetime;
    }

    /**
     * @param int $year
     * @return int
     */
    public function getEmergencyStatisticCount(int $year = 0): int
    {
        return Einsaetze::whereBetween('einsatz_begin', [$year . '-01-01 00:00:00', $year . '-12-31 23:59:59'])->count();
    }

    public function getEmergencyDetails($year = 0, $id = 0): array
    {
        $data = Cache::remember(
            __CLASS__ . '_' . __FUNCTION__ . '_year_' . $year . '_id_' . $id,
            Config::get('CacheConfig.cache_content_timeout'),
            function () use ($id) {
                $data = [];
                $Einsatz = Einsaetze::where('id', '=', $id)
                    ->where('aktiv', '=', '1')
                    ->get();
                $Einsatz->each(function ($e) use (&$data) {
                    $data = [
                        'beginn' => $this->makeDatumZeitStatic($e->einsatz_begin),
                        'ende' => $this->makeDatumZeitStatic($e->einsatz_ende),
                        'dauer' => $this->getEmergencyWorkTime($e->einsatz_begin, $e->einsatz_ende),
                        'einsatz_nummer' => $e->einsatz_nummer,
                        'einsatz_typ' => $e->einsatz_typ,
                        'is_alarm' => $e->is_alarm,
                        'einsatz_art' => $e->einsatz_art,
                        'access_road' => $e->access_road,
                        'einsatz_ort' => $e->einsatz_ort,
                        'einsatz_beschreibung' => $e->einsatz_beschreibung,
                        'begriff_id' => $e->cms_einsatz_begriff_id,
                        'emergency_definition_id' => $e->emergency_definition_id,
                        'loeschhilfe' => $e->loeschhilfe,
                        'boeswilliger_alarm' => $e->malicious_alarm,
                        'fehlalarm' => $e->false_alarm,
                        'einsatz_youtube' => $e->einsatz_youtube,
                        'einsatz_fahrzeuge' => $e->einsatz_fahrzeuge,
                        'einsatz_fahrzeuge_alarmierung' => $e->einsatz_fahrzeuge_alarmierung,
                        'alarmierung_wehrfuehrer' => $e->alarmierung_wehrfuehrer,
                        'alarmierung_gruppenfuehrer' => $e->alarmierung_gruppenfuehrer,
                        'alarmierung_alle' => $e->alarmierung_alle,
                        'pressetext' => $e->pressetext,
                        'presse' => $e->presse,
                        'fahrzeuge' => $this->getEmergencyVehicles($e->id),
                        'einheiten' => $this->getEmergencyStations($e->id),
                        'geo_l' => round($e->einsatz_ort_lon, 4),
                        'geo_b' => round($e->einsatz_ort_lat, 4),
                    ];
                });
                return $data;
            }
        );
        return $data;
    }

    /**
     * @param string $begin
     * @param string $end
     * @return array
     */
    private function getEmergencyWorkTime(string $begin = '', string $end = ''): array
    {
        $seconds = $this->makeDateDiff('s', $begin, $end);
        $timearray = $this->timespanArray($seconds);
        $timearray['day'] = (int)$timearray['day'];
        return $timearray;
    }

    private function getEmergencyVehicles($id = 0): array
    {
        $data = [];
        $EinsatzFahrzeuge = EinsatzFahrzeug::where('einsatz_id', '=', $id)->get();
        $EinsatzFahrzeuge->each(function ($ef) use (&$data) {
            $vehicle = $this->getVehicle($ef->fahrzeug_id);
            if (count($vehicle) > 0) {
                $data[] = $vehicle;
            }
        });
        return $data;
    }

    private function getEmergencyStations($id = 0): array
    {
        $data = [];
        $EinsatzStationen = EmergencyUnits::where('cms_einsatz_id', '=', $id)->get();
        $EinsatzStationen->each(function ($eu) use (&$data) {
            $unit = $this->getEmergencyUnit($eu->cms_feuerwehren_id);
            if (count($unit) > 0) {
                $data[] = $unit;
            }
        });
        return $data;
    }

    private function getEmergencyUnit($id = 0): array
    {
        $data = [];
        $Unit = Feuerwehren::where('id', '=', $id)->get();
        $Unit->each(function ($u) use (&$data) {
            $data = [
                'unit' => $u->feuerwehr,
                'link' => $u->homepage
            ];
        });
        return $data;
    }

    /**
     * @return array
     */
    public function getEmergencyStatistics(): array
    {
        $data = Cache::remember(
            __CLASS__ . '_' . __FUNCTION__,
            Config::get('CacheConfig.cache_content_timeout'),
            function () {
                $getEmergency = $this->getEmergencies();
                $monthstatistic = [];
                foreach ($getEmergency['statistics'] as $k => $row) {
                    $monthstatistic[] = (object)[
                        'data' => $row['data'],
                        'borderColor' => 'rgb(' . $this->makeColor() . ')',
                        'backgroundColor' => 'rgba(' . $this->makeColor() . ', 0.5)',
                    ];
                }
                $data = [];
                $data['countStatistic'] = $this->getEmergencyCountStatistic();
                #$data['statistic'] = $this->getEmergencyStatistic();
                $data['area'] = $this->getEmergencyAreaStatistic();
                $data['overview'] = $this->getEmergencyStatisticOverview();
                $data['monthstatistic'] = $monthstatistic;
                return $data;
            }
        );
        return $data;
    }

    /**
     * @return array
     */
    public function getEmergencies(): array
    {
        $data = Cache::remember(
            __CLASS__ . '_' . __FUNCTION__,
            Config::get('CacheConfig.cache_content_timeout'),
            function () {
                $data = [];
                $entries = [];
                $statistics = [];
                $data['years'] = [];
                $data['statistics'] = [];
                $count = [];
                for ($i = date('Y'); $i >= $this->start_year; $i--) {
                    $date['entries'][$i] = [];
                    $data['years'][] = (int)$i;
                    $data['statistics'][(int)$i] = [
                        'data' => [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0],
                        'borderColor' => 'rgb(255, 99, 132)',
                        'backgroundColor' => 'rgba(255, 99, 132, 0.5)',
                        'label' => (int)$i
                    ];
                }
                $statistics = $data['statistics'];
                $Einsatz = Einsaetze::orderBy('einsatz_begin', 'desc')
                    ->where('aktiv', '=', '1')
                    ->get();
                $Einsatz->each(function ($e) use (&$entries, &$count, &$statistics) {
                    $date = explode(' ', $e->einsatz_begin);
                    $year = explode('-', $date['0']);
                    if (!array_key_exists($year['0'], $count)) {
                        $count[$year['0']] = 0;
                    }
                    if (!array_key_exists($year['0'], $entries)) {
                        $entries[$year['0']] = [];
                        $entries[$year['0']][12] = [];
                        $entries[$year['0']][11] = [];
                        $entries[$year['0']][10] = [];
                        $entries[$year['0']][9] = [];
                        $entries[$year['0']][8] = [];
                        $entries[$year['0']][7] = [];
                        $entries[$year['0']][6] = [];
                        $entries[$year['0']][5] = [];
                        $entries[$year['0']][4] = [];
                        $entries[$year['0']][3] = [];
                        $entries[$year['0']][2] = [];
                        $entries[$year['0']][1] = [];
                    }
                    $month = (int)$year['1'];
                    if (!array_key_exists($month, $entries[$year['0']])) {
                        $entries[$year['0']][$month] = [];
                    }
                    $c = $statistics[$year['0']]['data'][($month - 1)];
                    $statistics[$year['0']]['data'][($month - 1)] = $c + 1;
                    $entries[$year['0']][$month][] = [
                        'id' => $e->id,
                        'beginn' => $this->makeDatumZeitStatic($e->einsatz_begin),
                        'einsatz_art' => $e->einsatz_art,
                        'is_alarm' => $e->is_alarm,
                        'einsatz_ort' => $e->einsatz_ort,
                        'year' => $year['0'],
                    ];
                    $count[$year['0']] += 1;
                });

                foreach ($entries as $key => $row) {
                    $c = $count[$key];
                    foreach ($row as $k2 => $r2) {
                        if (count($entries[$key][$k2]) === 0) {
                            unset($entries[$key][$k2]);
                        } else {
                            foreach ($r2 as $k3 => $r3) {
                                $entries[$key][$k2][$k3]['no'] = $c;
                                $c--;
                            }
                        }
                    }
                }
                $data['statistics'] = (array)$statistics;
                $data['entries'] = $entries;
                //dd($data);
                return $data;
            }
        );
        return $data;
    }

    private function makeColor()
    {
        $colors = [];
        $colors[] = random_int(0, 255);
        $colors[] = random_int(0, 255);
        $colors[] = random_int(0, 255);
        return implode(',', $colors);
    }

    /**
     * @return array
     */
    public function getEmergencyTypes(): array
    {
        $data = [];
        $data[] = [
            'id' => 0,
            'name' => '----',
            'value' => 0,
            'label' => '----',
        ];
        $Types = EmergencyTypeCategory::orderBy('pos', 'ASC')->get();
        $Types->each(function ($t) use (&$data) {
            $data[] = [
                'id' => $t->id,
                'name' => $t->emergency_type_category,
                'value' => $t->id,
                'label' => $t->emergency_type_category,
            ];
        });
        return $data;
    }

    /**
     * @return array
     */
    public function getEmergencyAlarmMails(): array
    {
        $data = [];
        $data[] = [
            'id' => 0,
            'name' => '----',
            'parent_id' => 0,
            'value' => 0,
            'label' => '----',
        ];
        $Alarms = AlarmEmail::where('original_id', '=', 0)
            ->where('emergency_date_time', '!=', null)
            ->orderBy('emergency_date_time', 'DESC')
            ->get();
        $Alarms->each(function ($a) use (&$data) {
            $data[] = [
                'id' => $a->id,
                'name' => $this->makeDateTimeDe($a->emergency_date_time) . ' -> ' . $a->emergency_scenario,
                'value' => $a->id,
                'label' => $this->makeDateTimeDe($a->emergency_date_time) . ' -> ' . $a->emergency_scenario,
            ];
        });
        return $data;
    }

    /**
     * @return array
     */
    public function getEmergencyAlarmTypes(): array
    {
        $data = [];
        $data[] = [
            'id' => strtolower(self::EMERGENCY_TYPE_ACTION),
            'name' => self::EMERGENCY_TYPE_ACTION,
            'value' => strtolower(self::EMERGENCY_TYPE_ACTION),
            'label' => self::EMERGENCY_TYPE_ACTION,
        ];
        $data[] = [
            'id' => 'uebung',
            'name' => self::EMERGENCY_TYPE_EXERCISE,
            'value' => 'uebung',
            'label' => self::EMERGENCY_TYPE_EXERCISE,
        ];
        return $data;
    }

    /**
     * @return array
     *
     * FEU, TH, Absicherung, (siehe MPFeuer)
     */
    public function getEmergencyTypeCategory(): array
    {
        $data = [];
        $data[] = [
            'id' => 0,
            'name' => '----',
            'parent_id' => 0,
            'value' => 0,
            'label' => '----',
        ];
        return $data;
    }

    /**
     * @return void
     */
    public function getEmergencyUnits(): array
    {
        $data = Cache::remember(
            __CLASS__ . '_' . __FUNCTION__,
            Config::get('CacheConfig.cache_content_timeout'),
            function () {
                $data = [];
                $data = $this->getUnits($data, 'feuerwehr');
                $data = $this->getUnits($data, 'speziel');
                $data = $this->getUnits($data, 'rkish');
                $data = $this->getUnits($data, 'drk');
                $data = $this->getUnits($data, 'thw');
                $data = $this->getUnits($data, 'dgzrs');
                $data = $this->getUnits($data, 'polizei');
                return $data;
            }
        );
        return $data;
    }

    /**
     * @param $data
     * @param $unit
     * @return array
     */
    private function getUnits($data = [], $unit = ''): array
    {
        $Units = Feuerwehren::orderBy('feuerwehr', 'ASC')
            ->where('is_' . $unit, '=', '1')
            ->get();
        $Units->each(function ($f) use (&$data) {
            $data[] = [
                'value' => $f->id,
                'label' => $f->feuerwehr,
            ];
        });
        return $data;
    }

    public function getEmergencyArea(): array
    {
        $data = Cache::remember(
            __CLASS__ . '_' . __FUNCTION__,
            Config::get('CacheConfig.cache_content_timeout'),
            function () {
                $data = [];
                $area = [];
                $bezirk = [];
                $unitstations = [];
                $getEinsatzBezirk = EinsatzBezirk::where('primaer', '=', ActiveEnum::Active)->orderBy('id', 'ASC')->get();
                $getEinsatzBezirk->each(function ($e) use (&$area, &$bezirk) {
                    if (!array_key_exists($e->bezirk, $area)) {
                        $area[$e->bezirk] = [];
                        $bezirk[$e->bezirk] = $e->name;
                    }
                    $area[$e->bezirk][] = [$e->lat, $e->lng];
                });
                $getEinsatzBezirk = EinsatzBezirk::where('primaer', '=', ActiveEnum::Deactive)->orderBy('id', 'ASC')->get();
                $getEinsatzBezirk->each(function ($e) use (&$area, &$bezirk) {
                    if (!array_key_exists($e->bezirk, $area)) {
                        $area[$e->bezirk] = [];
                        $bezirk[$e->bezirk] = $e->name;
                    }
                    $area[$e->bezirk][] = [$e->lat, $e->lng];
                });

                /*$getUnitStations = Feuerwehren::where('geo_l', '!=', 0)->where('geo_b', '!=', 0)->get();
                $getUnitStations->each(function ($eu) use (&$unitstations) {
                    $unitstations[] = [
                        'name' => $eu->feuerwehr,
                        'geo_l' => $eu->geo_l,
                        'geo_b' => $eu->geo_b,
                        'icon'=>$this->getStationIcon($eu),
                    ];
                });*/
                $unitstations = $this->getStationsLocations('fire');

                return [
                    'bezirk' => $bezirk,
                    'area' => $area,
                    'unitstations' => (array)$unitstations,
                ];
            }
        );
        return $data;
    }

    /**
     * @param string $only
     * @return array
     */
    private function getStationsLocations(string $only = ''): array
    {
        $data = Cache::remember(
            __CLASS__ . '_' . __FUNCTION__ . '_only_' . $only,
            Config::get('CacheConfig.cache_content_timeout'),
            function () use ($only) {
                $data = [];
                $getStations = Feuerwehren::where('geo_l', '!=', '0')
                    ->where('geo_b', '!=', '0')
                    ->get();
                $getStations->each(function ($s) use ($only, &$data) {
                    $data[] = [
                        'name' => $s->feuerwehr,
                        'location' => [$s->geo_l, $s->geo_b],
                        'icon' => $this->getStationIcon($s, $only),
                    ];
                });
                return (array)$data;
            }
        );
        return $data;
    }

    /**
     * @param object $s
     * @param string $only
     * @return string
     */
    private function getStationIcon(object $s, string $only = ''): string
    {
        if (($s->is_feuerwehr === ActiveEnum::Active || $s->is_feuerwehr === "1") && ($only === '' || $only === 'fire')) {
            return 'fire';
        }
        if (($s->is_rkish === ActiveEnum::Active || $s->is_rkish === "1") && ($only === '' || $only === 'rkish')) {
            return 'rkish';
        }
        if (($s->is_drk === ActiveEnum::Active || $s->is_drk === "1") && ($only === '' || $only === 'drk')) {
            return 'drk';
        }
        if (($s->is_thw === ActiveEnum::Active || $s->is_thw === "1") && ($only === '' || $only === 'thw')) {
            return 'thw';
        }
        if (($s->is_dgzrs === ActiveEnum::Active || $s->is_dgzrs === "1") && ($only === '' || $only === 'dgzrs')) {
            return 'dgzrs';
        }
        if (($s->is_polizei === ActiveEnum::Active || $s->is_polizei === "1") && ($only === '' || $only === 'polizei')) {
            return 'police';
        }
        if (($s->is_speziel === ActiveEnum::Active || $s->is_special === "1") && ($only === '' || $only === 'spezial')) {
            return 'special';
        }
        return '';
    }

    /**
     * @return array
     */
    public function getEmergencyDefinitions(): array
    {
        $data = Cache::remember(
            __CLASS__ . '_' . __FUNCTION__,
            Config::get('CacheConfig.cache_content_timeout'),
            function () {
                $data = [];
                $data[] = [
                    'id' => 0,
                    'name' => '----',
                    'value' => 0,
                    'label' => '----',
                ];
                $Scenario = EmergencyMissionScenario::orderBy('scenario', 'ASC')->get();
                $Scenario->each(function ($s) use (&$data) {
                    $data[] = [
                        'id' => $s->id,
                        'name' => $s->scenario,
                        'value' => $s->id,
                        'label' => $s->scenario
                    ];
                });
                return $data;
            }
        );
        return $data;
    }

    public function getEmerencyYearStatistic()
    {
        $data = Cache::remember(
            __CLASS__ . '_' . __FUNCTION__,
            Config::get('CacheConfig.cache_content_timeout'),
            function () {
                $data = 0;
                $Einsatz = Einsaetze::where('einsatz_begin', '=', self::EMERGENCY_TYPE_ACTION)
                    ->orderBy('einsatz_begin', 'desc')
                    ->take(1)
                    ->get();
                return $data;
            }
        );
        return $data;
    }

    /**
     * @param Request $request
     * @return array|JsonResponse
     */
    public function setEmergencyContent(Request $request): array|JsonResponse
    {
        #dd($request->all());
        try {
            $data = [];
            $data['success'] = true;
            $data['errors'] = [];
            $data['errorMessage'] = [];
            $data['errorCode'] = '';
            $inputs = $request->all();
            if (is_numeric($inputs['id']) && $inputs['id'] > 0) {
                $save = Einsaetze::find($inputs['id']);
            } else {
                $save = new Einsaetze();
            }
            $save->alarm_email_id = $inputs['alarm_email_id'];
            $save->cms_einsatz_begriffe_id = $inputs['emergency_definition_id'];
            $save->emergency_definition_id = $inputs['emergency_definition_id'];
            $save->loeschhilfe = $this->setBoolean($inputs['erase_help']);
            $save->malicious_alarm = $this->setBoolean($inputs['malicious_alarm']);
            $save->false_alarm = $this->setBoolean($inputs['false_alarm']);
            $save->einsatz_begin = $inputs['start_date'] . ' ' . $inputs['start_time'];
            $save->einsatz_ende = $inputs['end_date'] . ' ' . $inputs['end_time'];
            #$save->einsatz_nummer = $inputs[''];
            $save->einsatz_ort = $this->checkText($inputs['place']);
            $save->einsatz_art = $inputs['emergency_scenario'];
            $save->einsatz_beschreibung = $this->checkText($inputs['description']);
            #$save->einsatz_fahrzeuge = $inputs[''];
            #$save->einsatz_fahrzeuge_alarmierung = $inputs[''];
            #$save->einsatz_youtube = $inputs[''];
            $save->einsatz_typ = $inputs['alarm_type'];
            $save->einsatz_erstellt_am = date('Y-m-d H:i:s');
            #$save->einsatz_erstellt_von = $inputs[''];
            #$save->einsatz_geaendert_am = $inputs[''];
            #$save->einsatz_geaendert_von = $inputs[''];
            $save->aktiv = $this->setBoolean($inputs['active']);
            $save->bemerkung = $this->checkText($inputs['description_intern']);
            $save->alarmierung_wehrfuehrer = $this->setBoolean($inputs['alarm_chief']);
            $save->alarmierung_gruppenfuehrer = $this->setBoolean($inputs['alarm_group']);
            $save->alarmierung_alle = $this->setBoolean($inputs['alarm_full']);
            $save->is_alarm = $this->setBoolean($inputs['withAlarm']);
            $save->einsatz_bilder = 0;
            $save->einsatz_ort_lon = $inputs['lon'];
            $save->einsatz_ort_lat = $inputs['lat'];
            #$save->einsatz_bericht = $this->checkText($inputs['']);
            #$save->pressetext = $this->checkText($inputs['']);
            #$save->presse = $inputs[''];
            $save->save();
            $subdata = $this->setEmergencyVehicle($save->id, $inputs['vehicle']);
            $data = $this->checkSubData($subdata, $data);
            if ($data['success'] === false) {
                return $this->makeJsonLogging(
                    __CLASS__,
                    __FUNCTION__,
                    __LINE__,
                    $data['errorCode'],
                    $data['errorMessage'],
                    0
                );
            }
            $subdata = $this->setEmergencyUnits($save->id, $inputs['units']);
            $data = $this->checkSubData($subdata, $data);
            if ($data['success'] === false) {
                return $this->makeJsonLogging(
                    __CLASS__,
                    __FUNCTION__,
                    __LINE__,
                    $data['errorCode'],
                    $data['errorMessage'],
                    0
                );
            }
            return $data;
        } catch (Exception $exception) {
            return $this->makeJsonLogging(
                __CLASS__,
                __FUNCTION__,
                __LINE__,
                $exception->getCode(),
                $exception->getMessage(),
                0
            );
        }
    }

    /**
     * @param $einsatz_id
     * @param $vehicles
     * @return array
     */
    private function setEmergencyVehicle($einsatz_id = 0, $vehicles = []): array
    {
        try {
            EinsatzFahrzeug::where('einsatz_id', '=', $einsatz_id)->delete();
            if (count($vehicles) > 0) {
                foreach ($vehicles as $k => $value) {
                    $save = new EinsatzFahrzeug();
                    $save->einsatz_id = $einsatz_id;
                    $save->fahrzeug_id = $value['value'];
                    $save->save();
                }
            }
            $data = [];
            $data['success'] = true;
            $data['errors'] = [];
            return $data;
        } catch (Exception $exception) {
            return $this->makeJsonLogging(
                __CLASS__,
                __FUNCTION__,
                __LINE__,
                $exception->getCode(),
                $exception->getMessage(),
                0
            );
        }
    }

    /**
     * @param $einsatz_id
     * @param $units
     * @return array
     */
    private function setEmergencyUnits($einsatz_id = 0, $units = []): array
    {
        try {
            EmergencyUnits::where('cms_einsatz_id', '=', $einsatz_id)->delete();
            if (count($units) > 0) {
                foreach ($units as $k => $value) {
                    $save = new EmergencyUnits();
                    $save->cms_einsatz_id = $einsatz_id;
                    $save->cms_feuerwehren_id = $value['value'];
                    $save->save();
                }
            }
            $data = [];
            $data['success'] = true;
            $data['errors'] = [];
            return $data;
        } catch (Exception $exception) {
            return $this->makeJsonLogging(
                __CLASS__,
                __FUNCTION__,
                __LINE__,
                $exception->getCode(),
                $exception->getMessage(),
                0
            );
        }
    }

    /**
     * @return array
     */
    public function getEmergencyList(): array
    {
        $data = [];
        $Einsatz = Einsaetze::orderBy('id', 'DESC')
            ->get();
        $Einsatz->each(function ($e) use (&$data) {
            $data[] = [
                'id' => $e->id,
                'title' => $e->einsatz_art,
                'description' => $e->einsatz_beschreibung,
                'emergency_definition_id' => $e->emergency_definition_id,
            ];
        });
        return $data;
    }

    /**
     * @return array
     */
    public function getEmergencyData(): array
    {
        $data = [];
        $data[] = [
            'id' => 0,
            'name' => '---nicht zugeordnet---',
            'value' => 0,
            'label' => '---nicht zugeordnet---',
        ];
        $Scenarios = EmergencyMissionScenario::orderBy('scenario', 'ASC')->get();
        $Scenarios->each(function ($es) use (&$data) {
            $data[] = [
                'id' => $es->id,
                'name' => $es->scenario,
                'value' => $es->id,
                'label' => $es->scenario
            ];
        });
        return $data;

    }

    /**
     * @param Request $request
     * @return array
     */
    public function setEmergencyScenarioId(Request $request): array
    {
        try {
            $inputs = $request->all();
            $save = Einsaetze::find($inputs['id']);
            $save->emergency_definition_id = $inputs['emergencyId'];
            $save->save();
            $data = [];
            $data['success'] = true;
            $data['errors'] = [];
            return $data;
        } catch (Exception $exception) {
            return $this->makeJsonLogging(
                __CLASS__,
                __FUNCTION__,
                __LINE__,
                $exception->getCode(),
                $exception->getMessage(),
                0
            );
        }
    }

    public function showLastEinsatz()
    {
        $data = Cache::remember(
            __CLASS__ . '_' . __FUNCTION__,
            Config::get('CacheConfig.cache_content_timeout'),
            function () {
                $data = [];
                $Einsatz = Einsaetze::where('einsatz_typ', '=', self::EMERGENCY_TYPE_ACTION)
                    ->orderBy('einsatz_begin', 'desc')
                    ->where('aktiv', '=', '1')
                    ->take(1)
                    ->get();
                $Einsatz->each(function ($e) use (&$data) {
                    $date = explode(' ', $this->makeDatumZeitStatic($e->einsatz_begin));
                    $data['id'] = $e->id;
                    $data['begin_time'] = $date['1'];
                    $data['begin_date'] = $date['0'];
                    $data['einsatz_art'] = $e->einsatz_art;
                    $data['is_alarm'] = $e->is_alarm;
                    $data['einsatz_ort'] = $e->einsatz_ort;
                    $datum = explode(' ', $e->einsatz_begin);
                    $jahr = explode('-', $datum['0']);
                    $data['jahr'] = $jahr['0'];
                });
                return $data;
            }
        );
        return $data;
    }

    /***
     * @param int $onlydata
     * @return array|string
     */
    public function getEinsatzArea($onlydata = 0)
    {
        $data = [];
        $data['areas'] = [];
        $EinsatzArea = EinsatzBezirk::where('primaer', '=', '1')->get();
        $EinsatzArea->each(function ($eb) use (&$data) {
            if (!array_key_exists($eb->bezirk, $data['areas'])) {
                $data['areas'][$eb->bezirk] = [];
            }
            $data['areas'][$eb->bezirk][] = [
                'lat' => $eb->lat,
                'lng' => $eb->lng,
                'name' => $eb->name,
            ];
        });
        $EinsatzArea = EinsatzBezirk::where('primaer', '=', '0')->get();
        $EinsatzArea->each(function ($eb) use (&$data) {
            if (!array_key_exists($eb->bezirk, $data['areas'])) {
                $data['areas'][$eb->bezirk] = [];
            }
            $data['areas'][$eb->bezirk][] = [
                'lat' => $eb->lat,
                'lng' => $eb->lng,
                'name' => $eb->name,
            ];
        });
        if ($onlydata === 1) {
            return $data;
        }
        return view('einsaetze.einsatz_gebiet')->with('data', $data)->render();
    }

    public function einsaetze_adminadd()
    {
        $datas['id'] = '0';
        $datas['einsatz_id'] = '0';
        $datas['einsatz_beginn'] = '';
        $datas['einsatz_ende'] = '';
        $datas['einsatz_nummer'] = '';
        $datas['einsatz_ort'] = '';
        $datas['einsatz_art'] = '';
        $datas['einsatz_beschreibung'] = '';
        $datas['einsatz_fahrzeuge'] = '';
        $datas['einsatz_youtube'] = '';
        $datas['einsatz_typ'] = '';
        $datas['cms_einsatz_begriffe_id'] = 0;
        $datas['einsatz_fahrzeuge_alarmierung'] = '';
        $datas['aktiv'] = '1';
        $datas['bemerkung'] = '';
        $datas['einsatz_bilder'] = '';
        $datas['einsatz_ort_lon'] = 0;
        $datas['einsatz_ort_lat'] = 0;
        $datas['einsatz_bericht'] = '';
        $datas['pressetext'] = '';
        $datas['presse'] = '';
        $datas['ausgerueckte_fahrzeuge'] = $this->getAdminEinsatzFahrzeuge();
        $datas['presse_array'] = $this->getEinsatzPressen();
        $content = $this->einsaetze_adminedit_content($datas);
        return array('content' => $content, 'title' => 'Einsätze hinzufügen');
    }

    /**
     * Holt alle Fahrzeuge zum auswählen in dem Einsatz.
     * inkl. Div Box Float Left
     */
    public function getAdminEinsatzFahrzeuge()
    {
    }

    public function getEinsatzPressen()
    {
        $data = [];
        $data['0'] = '---';
        $Presse = Presse::orderBy('id', 'DESC')->get();
        $Presse->each(function ($p) use (&$data) {
            $data[$p->id] = $p->datum . ' - ' . $p->titel;
        });
        return $data;
    }

    private function einsaetze_adminedit_content($datas = [])
    {
        return view('einsaetze.admin_einsaetze_edit')->with('data', $datas)->render();
    }

    public function einsaetze_adminedit($id)
    {
        $datas = $this->getEinsaetzeAdminGetData($id);
        if ($datas === '-1') {
            return redirect()->route('admin.einsaetze')->with(['error' => 'global.data.404']);
        }
        $datas['presse_array'] = $this->getEinsatzPressen();
        $content = $this->einsaetze_adminedit_content($datas);
        return array('content' => $content, 'title' => 'Einsätze editieren');
    }

    private function getEinsaetzeAdminGetData($id)
    {
        $datas = [];
        $Einsaetze = Einsaetze::where('id', '=', $id)->get();
        if (count($Einsaetze) === 0) {
            return '-1';
        }
        $Einsaetze->each(function ($e) use (&$datas) {
            $datas['id'] = $e->id;
            $datas['einsatz_id'] = $e->id;
            $datas['einsatz_beginn'] = $this->makeDatumZeitStatic($e->einsatz_begin);
            $datas['einsatz_ende'] = $this->makeDatumZeitStatic($e->einsatz_ende);
            $datas['einsatz_nummer'] = $e->einsatz_nummer;
            $datas['einsatz_ort'] = $e->einsatz_ort;
            $datas['einsatz_art'] = $e->einsatz_art;
            $datas['is_alarm'] = $e->is_alarm;
            $datas['einsatz_beschreibung'] = $e->einsatz_beschreibung;
            $datas['ausgerueckte_fahrzeuge'] = $this->getEinsatzfahrzeuge($e->id);
            $datas['einsatz_fahrzeuge'] = $e->einsatz_fahrzeuge;
            $datas['einsatz_youtube'] = $e->einsatz_youtube;
            $datas['einsatz_typ'] = $e->einsatz_typ;
            $datas['cms_einsatz_begriffe_id'] = $e->cms_einsatz_begriffe_id;
            $datas['einsatz_fahrzeuge_alarmierung'] = $e->einsatz_fahrzeuge_alarmierung;
            $datas['aktiv'] = $e->aktiv;
            $datas['bemerkung'] = $e->bemerkung;
            $datas['einsatz_bilder'] = $e->einsatz_bilder;
            $datas['einsatz_ort_lon'] = $e->einsatz_ort_lon;
            $datas['einsatz_ort_lat'] = $e->einsatz_ort_lat;
            $datas['einsatz_bericht'] = $e->einsatz_bericht;
            $datas['pressetext'] = $e->pressetext;
            $datas['presse'] = $e->presse;
        });
        return $datas;
    }

    public function getEinsatzfahrzeuge($einsatz_id)
    {
        $content = Cache::remember(
            __CLASS__ . '_' . __FUNCTION__ . '_.EinsatzID_' . $einsatz_id,
            Config::get('CacheConfig.cache_content_timeout'),
            function () use ($einsatz_id) {
                $fahrzeuge = [];
                $einsatzfahrzeuge = $this->fahrzeuge;

                $Fahrzeuge = EinsatzFahrzeug::where('einsatz_id', '=', $einsatz_id)->get();
                $Fahrzeuge->each(function ($f) use (&$fahrzeuge, $einsatzfahrzeuge) {
                    if (array_key_exists($f->id, $einsatzfahrzeuge)) {
                        $fahrzeuge[] = $einsatzfahrzeuge[$f->id];
                    }
                });

                if (count($fahrzeuge) > 0) {
                    $fahrzeug_bilder = [];
                    /*
                    foreach($fahrzeuge as $key => $fahrzeug){
                        if (strtolower($fahrzeug['path']) !== 'null'){
                            $path = 'fileadmin'.DIRECTORY_SEPARATOR.'fahrzeuge'.DIRECTORY_SEPARATOR;
                            $image_path = MakeImageTrait::makeImage($path.$fahrzeug['path'], 200,200);
                            $fahrzeug_bilder[] = '<img src="'.$image_path.'" alt="'.
                    $fahrzeug['name'].'" title="'.$fahrzeug['name'].'">';
                        }
                    }*/
                    $fahrzeuge = join(' ', $fahrzeug_bilder);
                } else {
                    $fahrzeuge = '';
                }
                return $fahrzeuge;
            }
        );
        return $content;
    }

    public function makeEinsaetzeAdminDelete($id)
    {
        $datas = $this->getEinsaetzeAdminGetData($id);
        if ($datas === '-1') {
            return redirect()->route('admin.einsaetze')->with(['error' => 'global.data.404']);
        }
    }

    public function makeEinsaetzeAdminDeletePost($id)
    {
        $datas = $this->getEinsaetzeAdminGetData($id);
        if ($datas === '-1') {
            return redirect()->route('admin.einsaetze')->with(['error' => 'global.data.404']);
        }
    }

    public function makeEinsaetzeAdminSave($data = [])
    {
    }

    public function einsaetze_adminshow()
    {
        $data = [];
        $data['einsaetze'] = $this->getAdminEinsaetze();
        $data['title'] = 'Einsätze';
        $content = view('einsaetze.admin_einsaetze')->with('data', $data)->render();
        return array('content' => $content, 'title' => $data['title']);
    }

    private function getAdminEinsaetze()
    {
        $this->SetEinsatzBegriffe();
        $Einsaetze = Einsaetze::orderBy('einsatz_begin', 'desc')
            ->orderBy('einsatz_nummer', 'desc')
            ->get();
        $einsaetze = [];
        $einsatz_typ = array(
            self::EMERGENCY_TYPE_ACTION => self::EMERGENCY_TYPE_ACTION,
            'uebung' => self::EMERGENCY_TYPE_EXERCISE
        );
        $sichtbar = array(
            '0' => 'deaktiv',
            '1' => 'aktiv',
        );


        $Einsaetze->each(function ($e) use (&$einsaetze, $einsatz_typ, $sichtbar) {
            $date_time = explode(' ', $e->einsatz_begin);
            $date = explode('-', $date_time['0']);
            $einsaetze[] = [
                'id' => $e->id,
                'jahr' => $date['0'],
                'einsatz_id' => $e->einsatz_id,
                'einsatz_typ' => $einsatz_typ[$e->einsatz_typ],
                'beginn' => FxToolsTrait::makeGermanDateTime($e->einsatz_begin),
                'ende' => FxToolsTrait::makeGermanDateTime($e->einsatz_ende),
                'einsatz_nummer' => $e->einsatz_nummer,
                'einsatz_ort' => $e->einsatz_ort,
                'einsatz_art' => $e->einsatz_art,
                'is_alarm' => $e->is_alarm,
                'einsatz_begriff' => $this->EinsatzBegriffe($e->cms_einsatz_begriffe_id),
                'aktiv' => $sichtbar[$e->aktiv],
            ];
        });
        return $einsaetze;
    }

    private function SetEinsatzBegriffe()
    {
        $this->EinsatzBegriffeArray = $this->BuildEinsatzBegiffe();
    }

    /***
     * Von hier kommen absofort alle Einsatzbegriffe als Array!
     * Dadurch weniger SQL Abfragen!
     * Cache um das Array Bauen!
     */
    public function BuildEinsatzBegiffe()
    {
        $begriffe = Cache::remember(
            __CLASS__ . '_' . __FUNCTION__,
            Config::get('CacheConfig.cache_content_timeout'),
            function () {
                $begriffe = [];
                $begriffe['0'] = '';
                $EinsatzBegriffe = EinsatzBegriff::get();
                $EinsatzBegriffe->each(function ($e) use (&$begriffe) {
                    $begriffe[$e->id] = $e->begriff;
                });
                return $begriffe;
            }
        );
        return $begriffe;
    }

    private function EinsatzBegriffe($id)
    {
        $begriffe = $this->EinsatzBegriffeArray;
        if (!array_key_exists($id, $begriffe)) {
            return '';
        }
        return $begriffe[$id];
    }

    public function einsaetze_show_trait($jahr = false)
    {
        $this->getEinsatzFahrzeug();
        $this->getFeuerwehrenWithHomepage();
        $data = [];
        $data['title'] = 'Einsätze';
        #$data['links'] = $this->build_einsaetze_links($jahr);
        #$data['einsaetze'] = $this->getEinsaetze(false);
        $data['einsaetze'] = $this->getEinsaetzeAll($jahr);
        $data['monate'] = $this->getMonate($jahr);
        $data['months'] = $this->getAllMonth();
        $jahre = [];
        for ($i = $this->end_year; $i >= $this->start_year; $i--) {
            $jahre[] = $i;
        }
        if ($jahr === false) {
            $jahr = date('Y');
        }
        $data['jahr'] = $jahr;
        $content = view('einsaetze.einsaetze')->with('data', $data)->with('jahre', $jahre)->render();
        return array('content' => $content, 'title' => $data['title']);
    }

    /**
     * Gib ein Array aller möglichen Einsatzfahrzeugen zurück
     */
    public function getEinsatzFahrzeug()
    {
        $fahrzeuge = Cache::remember(
            __CLASS__ . '_' . __FUNCTION__,
            Config::get('CacheConfig.cache_content_timeout'),
            function () {
                $fahrzeuge = [];
                $fahrzeuge_1 = $this->getFahrzeuge('=', 0);
                $fahrzeuge_2 = $this->getFahrzeuge('!=', 0);
                $fahrzeuge_3 = $this->getFahrzeuge('=', 1);
                $fahrzeuge_4 = $this->getFahrzeuge('!=', 1);

                if (count($fahrzeuge_1) > 0) {
                    foreach ($fahrzeuge_1 as $key => $val) {
                        $fahrzeuge[$key] = $val;
                    }
                }
                if (count($fahrzeuge_2) > 0) {
                    foreach ($fahrzeuge_2 as $key => $val) {
                        $fahrzeuge[$key] = $val;
                    }
                }
                if (count($fahrzeuge_3) > 0) {
                    foreach ($fahrzeuge_3 as $key => $val) {
                        $fahrzeuge[$key] = $val;
                    }
                }
                if (count($fahrzeuge_4) > 0) {
                    foreach ($fahrzeuge_4 as $key => $val) {
                        $fahrzeuge[$key] = $val;
                    }
                }
                return $fahrzeuge;
            }
        );

        $this->fahrzeuge = $fahrzeuge;
        return '';
    }

    /**
     * Holt alle Technischen Details zu dem Fahrzeugen
     */
    public function getFahrzeuge($bos = '=', $ausrangiert = '0')
    {
        $cache_key = '';
        if ($bos === '=') {
            $cache_key .= '1';
        } else {
            $cache_key .= '0';
        }
        $content = Cache::remember(
            __CLASS__ . '_' . __FUNCTION__ . '_' . $cache_key . '_' . $ausrangiert,
            Config::get('CacheConfig.cache_content_timeout'),
            function () use ($bos, $ausrangiert) {
                $einsatzfahrzeuge = [];
                $Fahrzeuge = Fahrzeuge::where('ausrangiert', '=', $ausrangiert)
                    ->where('bos_kennung', $bos, '')
                    ->orderBy('bos_kennung', 'ASC')
                    ->get();
                $Fahrzeuge->each(function ($fz) use (&$einsatzfahrzeuge) {
                    $name = '';
                    if ($fz->bos_kennung !== '') {
                        $name = $fz->bos_kennung . ' ';
                    }
                    $name .= $fz->fahrzeug;
                    $einsatzfahrzeuge[$fz->id] = array('path' => $fz->bild, 'name' => $name);
                });
                return $einsatzfahrzeuge;
            }
        );
        return $content;
    }

    /**
     * Gibt ein Array mit Feuerwehren zurück wo die möglichen Homepages haben
     */
    public function getFeuerwehrenWithHomepage()
    {
        $wehren = Cache::remember(
            __CLASS__ . '_' . __FUNCTION__,
            Config::get('CacheConfig.cache_content_timeout'),
            function () {
                $Wehren = Feuerwehren::get();
                $Wehren->each(function ($w) {
                    if (substr($w->homepage, 0, 3) === 'www') {
                        $homepage = 'http://' . $w->homepage;
                        $update = Feuerwehren::where('cms_feuerwehr_id', '=', $w->cms_feuerwehr_id)
                            ->update(array('homepage' => $homepage));
                    }
                });

                $wehren = [];
                $Wehren = Feuerwehren::where('homepage', '!=', '')->get();
                $Wehren->each(function ($fw) use (&$wehren) {
                    $wehren[$fw->feuerwehr] = str_replace(
                        '</a>',
                        ' <i class="fa fa-home"></i></a>',
                        link_to(
                            $fw->homepage,
                            $fw->feuerwehr,
                            array('target' => '_blank'),
                            null
                        )
                    );
                });
                return $wehren;
            }
        );
        $this->feuerwehren = $wehren;
        return '';
    }

    public function getEinsaetzeAll($jahr = false)
    {
        $this->end_year = date('Y');
        $Einsaetze = Einsaetze::where('aktiv', '=', '1')
            ->orderBy('einsatz_begin', 'desc')
            ->orderBy('einsatz_nummer', 'desc')
            ->get();
        $count = count($Einsaetze);
        if ($count === 0) {
            return [];
        }
        $einsatz_begriffe = $this->getEinsatzBegriffe();
        $einsaetze = [];
        $einsatz_typ = array(
            self::EMERGENCY_TYPE_ACTION => self::EMERGENCY_TYPE_ACTION,
            'uebung' => self::EMERGENCY_TYPE_EXERCISE
        );

        for ($i = $this->start_year; $i <= $this->end_year; $i++) {
            $einsaetze[$i] = [];
        }

        $count_year = Cache::remember(
            __CLASS__ . '_' . __FUNCTION__,
            Config::get('CacheConfig.cache_content_timeout'),
            function () {
                $Counter = DB::table('cms_einsaetze')
                    ->select(DB::raw('DATE_FORMAT (einsatz_begin, "%Y") AS year, COUNT(*) AS count'))
                    ->groupBy('year')
                    ->get();
                $count_year = [];
                foreach ($Counter as $k => $row) {
                    $count_year[$row->year] = $row->count;
                }
                return $count_year;
            }
        );

        $Einsaetze->each(function ($e) use (&$einsaetze, $einsatz_typ, &$count, $einsatz_begriffe, &$count_year) {
            $date = explode(' ', $e->einsatz_begin);
            $date = explode('-', $date['0']);
            $monat = $date['1'];
            if ($monat < 10) {
                $monat = str_replace('0', '', $monat);
            }
            $jahr = $date['0'];

            $cache_data = [
                'monat' => $monat,
                self::EMERGENCY_TYPE_ACTION => $e,
                'jahr' => $jahr,
                'count_year' => $count_year,
                'einsatz_typ' => $einsatz_typ,
                'einsatz_begriffe' => $einsatz_begriffe,
            ];
            $id = $e->id;

            $einsatz = Cache::remember(
                __CLASS__ . '_' . __FUNCTION__ . '_ID_' . $id,
                Config::get('CacheConfig.cache_content_timeout'),
                function () use ($cache_data) {
                    $e = $cache_data[self::EMERGENCY_TYPE_ACTION];
                    $einsatz = [
                        'monat' => $cache_data['monat'],
                        'id' => $e->id,
                        #'einsatznummer' => $count.'/'.$jahr,
                        'jahr' => $cache_data['jahr'],
                        'einsatznummer' => $cache_data['count_year'][$cache_data['jahr']],
                        'einsatz_typ' => $cache_data['einsatz_typ'][$e->einsatz_typ],
                        'beginn' => FxToolsTrait::makeGermanDateTime($e->einsatz_begin),
                        'ende' => FxToolsTrait::makeGermanDateTime($e->einsatz_ende),
                        'einsatz_nummer' => $e->einsatz_nummer,
                        'fahrzeuge' => $this->getEinsatzfahrzeuge($e->id),
                        'einsatz_art' => $e->einsatz_art,
                        'is_alarm' => $e->is_alarm,
                        'einsatz_ort' => $e->einsatz_ort,
                        'einsatz_beschreibung' => $e->einsatz_beschreibung,
                        'einsatz_fahrzeuge' => $this->getEinheiten($e->einsatz_fahrzeuge),
                        'einsatz_youtube' => $e->einsatz_youtube,
                        'einsatz_ort_lat' => $e->einsatz_ort_lat,
                        'einsatz_ort_lng' => $e->einsatz_ort_lng,
                        'einsatz_bilder' => '',
                        'einsatz_bericht' => '',
                        'presse' => '',
                        'einsatz_begriff' => $cache_data['einsatz_begriffe'][$e->cms_einsatz_begriffe_id]['begriff'],
                        'einsatz_color' => $cache_data['einsatz_begriffe'][$e->cms_einsatz_begriffe_id]['color'],
                    ];
                    return $einsatz;
                }
            );
            $einsaetze[$jahr][] = $einsatz;
            $count_year[$jahr] = $count_year[$jahr] - 1;
        });
        return $einsaetze;
    }

    private function getEinsatzBegriffe()
    {
        $begriffe = [];
        $EinsatzBegriff = EinsatzBegriff::get();
        if (count($EinsatzBegriff) === 0) {
            return '';
        }

        $begriffe['0'] = [
            'id' => '0',
            'begriff' => 'EMPTY',
            'kurz' => 'EMPTY',
            'einsatz_zeichen' => '',
            'feuer' => '',
            'thl' => '',
            'color' => 'red'
        ];

        $EinsatzBegriff->each(function ($eb) use (&$begriffe) {
            $thl = 0;
            $feuer = 0;
            $color = 'cyan';
            if ($eb->heumessung === '1' || $eb->thl === '1') {
                $thl = 1;
                $color = 'blue';
            }
            if ($eb->feuer === '1' || $eb->fehlalarm === '1') {
                $feuer = 1;
                $color = 'red';
            }
            $begriffe[$eb->id] = array(
                'id' => $eb->id,
                'begriff' => $eb->begriff,
                'kurz' => $eb->kurz,
                'einsatz_zeichen' => $eb->einsatz_zeichen,
                'feuer' => $feuer,
                'thl' => $thl,
                'color' => $color
            );
        });
        return $begriffe;
    }

    public function getEinheiten($einheiten)
    {
        $einheiten_array = explode(',', $einheiten);
        $einheiten = [];
        $all_einheiten = $this->feuerwehren;
        foreach ($einheiten_array as $key => $val) {
            $val = trim($val);
            if ($val !== '') {
                if (array_key_exists($val, $all_einheiten)) {
                    $einheiten[] = $all_einheiten[$val];
                } else {
                    $einheiten[] = $val;
                }
            }
        }
        return join(', ', $einheiten);
    }

    private function getMonate($jahr)
    {
        $monate = $this->getAllMonth();

        $m_ids = [];
        if ($jahr === date('Y')) {
            if (date('m') < 12) {
                for ($i = 1; $i <= date('m'); $i++) {
                    $m_ids[] = $i;
                }
                foreach ($monate as $key => $val) {
                    if (!in_array($key, $m_ids)) {
                        unset($monate[$key]);
                    }
                }
            }
        }
        return $monate;
    }

    private function getAllMonth()
    {
        $monate = [];
        $monate['12'] = 'Dezember';
        $monate['11'] = 'November';
        $monate['10'] = 'Oktober';
        $monate['9'] = 'September';
        $monate['8'] = 'August';
        $monate['7'] = 'Juli';
        $monate['6'] = 'Juni';
        $monate['5'] = 'Mai';
        $monate['4'] = 'April';
        $monate['3'] = 'März';
        $monate['2'] = 'Februar';
        $monate['1'] = 'Januar';
        return $monate;
    }

    /**
     * @todo Generate Google Koordinaten with api
     */

    public function einsatz_details($jahr = false, $view)
    {
        $content = Cache::remember(
            __CLASS__ . '_' . __FUNCTION__ . '_view_' . $view,
            Config::get('CacheConfig.cache_content_timeout'),
            function () use ($jahr, $view) {
                $this->getEinsatzFahrzeug();
                $this->getFeuerwehrenWithHomepage();
                $data = [];
                $data['title'] = 'Einsätze';
                $data['links'] = $this->build_einsaetze_links($jahr);
                $data['einsaetze'] = $this->getEinsatz($view);
                $data['showgooglemaps'] = 1;
                $content = view('einsaetze.details')->with('data', $data)->render();
                return array('content' => $content, 'title' => $data['title']);
            }
        );
        return $content;
    }

    private function build_einsaetze_links($jahr = false)
    {
        if ($jahr === false) {
            $jahr = date('Y');
        }
        $beginn = $this->getZeitraum();
        $ende = date('Y');
        if (!is_numeric($jahr)) {
            $jahr = date('Y');
        } else {
            if ($jahr < $beginn || $jahr > $ende) {
                $jahr = $ende;
            }
        }
        $this->year = $jahr;

        $array_links = $this->build_link('einsaetze', $beginn, $ende, $jahr);
        $links = [];
        foreach ($array_links as $key => $val) {
            if ($key === $jahr) {
                $links[] = link_to($val, $key, ['class' => 'active']);
            } else {
                $links[] = link_to($val, $key);
            }
        }

        return join(' | ', $links);
    }

    /**
     * Zeige das erste Jahr was in der Datenbank verfügbar ist und gibt array zurück
     */
    public function getZeitraum()
    {
        $content = Cache::remember(
            __CLASS__ . '_' . __FUNCTION__,
            Config::get('CacheConfig.cache_content_timeout'),
            function () {
                $beginn = '';
                $Einsatz = Einsaetze::orderBy('einsatz_begin', 'asc')->take(1)->get();
                $Einsatz->each(function ($e) use (&$beginn) {
                    $beginn = $e->einsatz_begin;
                    $beginn = explode(' ', $beginn);
                    $beginn = explode('-', $beginn['0']);
                    $beginn = $beginn['0'];
                });
                return $beginn;
            }
        );
        return $content;
    }

    /**
     * Baut Links zu den jeweiligen Jahren für die Navigation
     */
    public function build_link($url, $beginn, $ende, $jahr)
    {
        $links = [];
        for (
            $ende;
            $ende >= $beginn;
            $ende--
        ) {
            $links[$ende] = $url . '/' . $ende;
        }
        return $links;
    }

    /**
     * Holt alle Details zum ausgewählten Einsatz
     */
    public function getEinsatz($view)
    {
        $content = Cache::remember(
            __CLASS__ . '_' . __FUNCTION__ . '_VIEW_' . $view,
            Config::get('CacheConfig.cache_content_timeout'),
            function () use ($view) {
                $Einsaetze = Einsaetze::where('id', '=', $view)
                    ->where('aktiv', '=', '1')
                    ->get();
                //echo 'Count: '.count($Einsaetze);
                $count = count($Einsaetze);
                if ($count === 0) {
                    return [];
                }
                $einsatz_begriffe = $this->getEinsatzBegriffe();
                $einsaetze = [];
                $einsatz_typ = array(
                    self::EMERGENCY_TYPE_ACTION => self::EMERGENCY_TYPE_ACTION,
                    'uebung' => self::EMERGENCY_TYPE_EXERCISE
                );

                $Einsaetze->each(function ($e) use (&$einsaetze, $einsatz_typ, $einsatz_begriffe) {
                    $jahr = date('Y');
                    $einsaetze[] = array(
                        'id' => $e->id,
                        'jahr' => substr($e->einsatz_begin, 0, 4),
                        'einsatznummer' => $this->getEinsaetzeNummer($e->id, $jahr) . '/' . $jahr,
                        'einsatz_typ' => $einsatz_typ[$e->einsatz_typ],
                        'beginn' => FxToolsTrait::makeGermanDateTime($e->einsatz_begin),
                        'ende' => FxToolsTrait::makeGermanDateTime($e->einsatz_ende),
                        'einsatz_nummer' => $e->einsatz_nummer,
                        'fahrzeuge' => $this->getEinsatzfahrzeuge($e->id),
                        'is_alarm' => $e->is_alarm,
                        'einsatz_art' => $e->einsatz_art,
                        'einsatz_ort' => $e->einsatz_ort,
                        'einsatz_beschreibung' => $e->einsatz_beschreibung,
                        'einsatz_fahrzeuge' => $this->getEinheiten($e->einsatz_fahrzeuge),
                        'einsatz_youtube' => $e->einsatz_youtube,
                        'einsatz_ort_lat' => $e->einsatz_ort_lat,
                        'einsatz_ort_lng' => $e->einsatz_ort_lng,
                        'einsatz_bilder' => '',
                        'einsatz_bericht' => '',
                        'presse' => '',
                        'einsatz_begriff' => $einsatz_begriffe[$e->cms_einsatz_begriffe_id]['begriff'],
                        'einsatz_color' => $einsatz_begriffe[$e->cms_einsatz_begriffe_id]['color'],
                    );
                });
                return $einsaetze;
            }
        );
        return $content;
    }

    private function getEinsaetzeNummer($id, $startjahr = 0)
    {
        if ($startjahr !== 0) {
            if ($startjahr >= 2004 && $startjahr <= $this->year) {
                $jahr = $startjahr;
            }
        }
        $jahr = $this->year;
        $start = $jahr . '-01-01 00:00:00';
        $ende = $jahr . '-12-31 23:59:59';
        $Einsaetze = Einsaetze::where('einsatz_begin', '>=', $start)
            ->where('einsatz_begin', '<=', $ende)
            ->where('aktiv', '=', '1')
            ->orderBy('einsatz_begin', 'desc')
            ->orderBy('einsatz_nummer', 'desc')
            ->get();
        $count = count($Einsaetze);

        foreach ($Einsaetze as $key => $e) {
            if ($e->id === $id) {
                break;
            } else {
                $count--;
            }
        }
        return $count;
    }

    /**
     * Holt alle Einsätze zum ausgewählten Jahr
     */
    public function getEinsaetze($jahr)
    {
        $content = Cache::remember(
            __CLASS__ . '_' . __FUNCTION__ . '_jahr_' . $jahr,
            Config::get('CacheConfig.cache_content_timeout'),
            function () use ($jahr) {
                $jahr = $this->year;
                $start = $jahr . '-01-01 00:00:00';
                $ende = $jahr . '-12-31 23:59:59';
                $Einsaetze = Einsaetze::where('einsatz_begin', '>=', $start)
                    ->where('einsatz_begin', '<=', $ende)
                    ->where('aktiv', '=', '1')
                    ->orderBy('einsatz_begin', 'desc')
                    ->orderBy('einsatz_nummer', 'desc')
                    ->get();
                //echo 'Count: '.count($Einsaetze);
                $count = count($Einsaetze);
                if ($count === 0) {
                    return [];
                }
                $einsatz_begriffe = $this->getEinsatzBegriffe();
                $einsaetze = [];
                $einsatz_typ = array(
                    self::EMERGENCY_TYPE_ACTION => self::EMERGENCY_TYPE_ACTION,
                    'uebung' => self::EMERGENCY_TYPE_EXERCISE
                );

                $Einsaetze->each(function ($e) use (&$einsaetze, $einsatz_typ, &$count, $jahr, $einsatz_begriffe) {
                    $date = explode(' ', $e->einsatz_begin);
                    $date = explode('-', $date['0']);
                    $monat = $date['1'];
                    if ($monat < 10) {
                        $monat = str_replace('0', '', $monat);
                    }
                    $einsaetze[] = array(
                        'monat' => $monat,
                        'id' => $e->id,
                        #'einsatznummer' => $count.'/'.$jahr,
                        'jahr' => $jahr,
                        'einsatznummer' => $count,
                        'einsatz_typ' => $einsatz_typ[$e->einsatz_typ],
                        'beginn' => FxToolsTrait::makeGermanDateTime($e->einsatz_begin),
                        'ende' => FxToolsTrait::makeGermanDateTime($e->einsatz_ende),
                        'einsatz_nummer' => $e->einsatz_nummer,
                        'fahrzeuge' => $this->getEinsatzfahrzeuge($e->id),
                        'is_alarm' => $e->is_alarm,
                        'einsatz_art' => $e->einsatz_art,
                        'einsatz_ort' => $e->einsatz_ort,
                        'einsatz_beschreibung' => $e->einsatz_beschreibung,
                        'einsatz_fahrzeuge' => $this->getEinheiten($e->einsatz_fahrzeuge),
                        'einsatz_youtube' => $e->einsatz_youtube,
                        'einsatz_ort_lat' => $e->einsatz_ort_lat,
                        'einsatz_ort_lng' => $e->einsatz_ort_lng,
                        'einsatz_bilder' => '',
                        'einsatz_bericht' => '',
                        'presse' => '',
                        'einsatz_begriff' => $einsatz_begriffe[$e->cms_einsatz_begriffe_id]['begriff'],
                        'einsatz_color' => $einsatz_begriffe[$e->cms_einsatz_begriffe_id]['color'],
                    );
                    $count--;
                });
                return $einsaetze;
            }
        );
        return $content;
    }

    /***
     * @todo check response of error -> json info to browser user
     */
    public function getGoogleMapsKoordinaten(Request $request)
    {
        $input = $request->all();
        $place = $input['place'];
        $place = trim($place);
        $place = str_ireplace('ä', 'ae', $place);
        $place = str_ireplace('ö', 'oe', $place);
        $place = str_ireplace('ü', 'ue', $place);
        $place = str_ireplace('ß', 'ss', $place);
        $place = str_ireplace(' ', '+', $place);
        $place .= '+DE'; // Setzt Deutschland ans Ende.

        $json = '';
        try {
            $url = 'https://maps.googleapis.com/maps/api/geocode/json?address=' . $place;
            $url .= '&key=' . env('GOOGLE_GEOCODE_KEY', '');
            /***
             * @todo check Connection!!!!
             */
            $Client = ConnectionTrait();
            $response = $Client->send($url, 'GET', '');
            $json_encode = json_encode($response);
            if (count($json_encode['result']) > 0) {
            } else {
                $json = [];
                $json['status'] = 'error';
                $json['message'] = '';
            }
        } catch (Exception $e) {
            $json = [];
            $json['status'] = 'error';
            $json['message'] = 'Connection.error';
        }
        return json_decode($json);
    }

    /**
     * @param $id
     * @return array
     */

    public function show_koordinaten($id)
    {
        $Einsatz = Einsaetze::where('id', '=', $id)->where('aktiv', '=', '1')->get();
        if (count($Einsatz) === 0) {
            return [];
        }
        $details = [];
        $Einsatz->each(function ($e) use (&$details) {
            $details['lat'] = $e->einsatz_ort_lon;
            $details['lng'] = $e->einsatz_ort_lat;
        });
        return $details;
    }

    /**
     * Gigt einen Aray von Presselinks zurück
     */
    public function getEinsatzPresse($id)
    {
        $data = [];
        return $data;
    }

    /**
     * Gibt ein Array mit allen Links zu Einsartbildern zurück
     */
    public function getEinsatzBilder($id)
    {
        $data = [];
        return $data;
    }

    /***
     * Empfängt alle Externen Einsätze um diese Lokal zu speichern
     */
    public function ApiRequestEinsaetze(Request $request)
    {
        $input = $request->all();
        $json = $input['json'];
        if (!is_json($json)) {
            echo 'Fehler beim Import: Kein JSON String!';
            Log::error('Fehler beim Einsatz Import');
            Log::error($json);
            die();
        }
        $data = json_encode($json);

        echo 'Daten erfolgreich übermittelt!';
        Log::error('Einsatzsätze: Daten erfolgreich importiert!');
        die();
    }

    /***
     * @param string $diagram
     * @return string
     */
    public function getEinsatzStatistic($diagram = '')
    {
        $anfang = $this->getanfang();
        $data = [];
        switch ($diagram) {
            case 'dia':
                $data['title'] = 'Einsätze FF Sankt Michaelisdonn ' . $anfang . ' - ' . date('Y');
                $data['id'] = 'id_' . $diagram . '_' . date('Y');
                $data['imagebordertype'] = 'plain';
                $data['plottype'] = 'pie';
                $data['datatype'] = 'text-data-single';
                $data['datacolors'] = [
                    FxToolsTrait::makeColorNameToHex('red'),
                    FxToolsTrait::makeColorNameToHex('cyan'),
                    FxToolsTrait::makeColorNameToHex('orange'),
                    FxToolsTrait::makeColorNameToHex('yellow')
                ];
                $data['colors'] = ['red', 'cyan', 'orange', 'yellow'];
                $data['data'] = $this->getStatisticEinsaetze();
                $data['legend'] = $this->getLegende();
                break;
            case 'statistik':
                $data['title'] = 'Einsätze FF Sankt Michaelisdonn ' . $anfang . ' - ' . date('Y');
                $data['id'] = 'id_' . $diagram . '_' . date('Y');
                $data['imagebordertype'] = 'plain';
                $data['plottype'] = 'pie';
                $data['datatype'] = 'text-data-single';
                $data['datacolors'] = [];
                $data['data'] = $this->getEinsatzStatistik();
                $data['legend'] = $this->getLegende();
                break;
            case 'gebiet':
                $data['title'] = 'Einsatzgebiet FF Sankt Michaelisdonn';
                $data['id'] = 'id_' . $diagram;
                $data['plottype'] = 'bars';
                $data['datatype'] = 'text-data';
                $data['datacolors'] = [
                    FxToolsTrait::makeColorNameToHex('blue'),
                    FxToolsTrait::makeColorNameToHex('red'),
                    FxToolsTrait::makeColorNameToHex('cyan'),
                    FxToolsTrait::makeColorNameToHex('yellow')
                ];
                $data['colors'] = ['blue', 'red', 'cyan', 'yellow'];
                $data['data'] = $this->getEinsatzgebiet();
                $data['legend'] = $this->getLegende();
                $data['plotareaworld'] = [count($data['data']), $this->getMaximum()];
                $data['legendworld'] = $this->getMaximum();
                $data['plotbordertype'] = 'full';
                break;
            default:
                $data['title'] = 'Einsatzübersicht FF Sankt Michaelisdonn';
                $data['id'] = 'id_' . $diagram;
                $data['plottype'] = 'bars';
                $data['datatype'] = 'text-data';
                $data['datacolors'] = [
                    FxToolsTrait::makeColorNameToHex('blue'),
                    FxToolsTrait::makeColorNameToHex('red'),
                    FxToolsTrait::makeColorNameToHex('cyan'),
                    FxToolsTrait::makeColorNameToHex('orange'),
                    FxToolsTrait::makeColorNameToHex('yellow')
                ];
                $data['colors'] = ['blue', 'red', 'cyan', 'orange', 'yellow'];
                $data['data'] = $this->getEinsatzuebersicht();
                $data['legend'] = $this->getLegende();
                $data['plotareaworld'] = [count($data['data']), $this->getMaximum()];
                $data['legendworld'] = $this->getMaximum();
                $data['plotbordertype'] = 'full';
        }
        if ($diagram === 'statistik') {
            $colorarray = $this->getRandColors(count($data['data']));
            $data['datacolors'] = $colorarray['hex'];
            $data['colors'] = $colorarray['name'];
        }
        $view = '';
        if ($data['plottype'] === 'pie') {
            $view = view('partials.canvas.pie')->with('data', $data)->render();
        }
        if ($data['plottype'] === 'bars') {
            $view = view('partials.canvas.barchar')->with('data', $data)->with('diagram', $diagram)->render();
        }
        return $view;
    }

    /***
     * @return false|mixed|string
     */
    private function getanfang()
    {
        $anfang = date('Y');
        $Einsatz = Einsaetze::orderBy('einsatz_begin', 'ASC')->take(1)->get();
        $Einsatz->each(function ($e) use (&$anfang) {
            $datum = explode(' ', $e->einsatz_begin);
            $datum = explode('-', $datum['0']);
            $anfang = $datum['0'];
        });
        return $anfang;
    }

    /***
     * @return array
     */
    private function getStatisticEinsaetze()
    {
        $anfang = $this->getanfang();
        $maximum = $this->maximum;
        $begriffe = $this->getBegriffBereich();
        $einsaetze = [
            'feuer' => 0,
            'thl' => 0,
            'heumessung' => 0,
            'fehlalarm' => 0,
        ];
        $Einsaetze = Einsaetze::get();
        $Einsaetze->each(function ($e) use (&$einsaetze, $begriffe) {
            if (in_array($e->cms_einsatz_begriffe_id, $begriffe['feuer'])) {
                $einsaetze['feuer'] = $einsaetze['feuer'] + 1;
            }
            if (in_array($e->cms_einsatz_begriffe_id, $begriffe['thl'])) {
                $einsaetze['thl'] = $einsaetze['thl'] + 1;
            }
            if (in_array($e->cms_einsatz_begriffe_id, $begriffe['fehlalarm'])) {
                $einsaetze['fehlalarm'] = $einsaetze['fehlalarm'] + 1;
            }
            if (in_array($e->cms_einsatz_begriffe_id, $begriffe['heumessung'])) {
                $einsaetze['heumessung'] = $einsaetze['heumessung'] + 1;
            }
        });
        $data = [
            'Feuer' => $einsaetze['feuer'],
            'THL' => $einsaetze['thl'],
            'Heumessung' => $einsaetze['heumessung'],
            'Fehlalarm' => $einsaetze['fehlalarm']
        ];
        $this->legende = ['Feuer', 'Technische Hilfe', 'Heumessung', 'Fehlalarm'];
        $max = $this->checkMaximum($einsaetze['feuer'], $einsaetze['thl'], $einsaetze['heumessung'], $einsaetze['fehlalarm']);
        return $data;
    }

    private function checkMaximum($feuer = 0, $thl = 0, $fehlalarm = 0, $heumessung = 0, $gesamt = 0)
    {
        $max = $this->maximum;
        if ($max < $feuer) {
            $max = $feuer;
        }
        if ($max < $thl) {
            $max = $thl;
        }
        if ($max < $fehlalarm) {
            $max = $fehlalarm;
        }
        if ($max < $heumessung) {
            $max = $heumessung;
        }
        if ($max < $gesamt) {
            $max = $gesamt;
        }
        $this->maximum = $max + 2;
    }

    private function getLegende()
    {
        return $this->legende;
    }

    /***
     * @return array
     */
    private function getEinsatzStatistik()
    {
        $begriffe = $this->getBegriffe();
        $count = [];
        $Einsaetze = Einsaetze::get();
        $Einsaetze->each(function ($e) use (&$count) {
            if (array_key_exists($e->cms_einsatz_begriffe_id, $count)) {
                $count[$e->cms_einsatz_begriffe_id] = $count[$e->cms_einsatz_begriffe_id] + 1;
            } else {
                $count[$e->cms_einsatz_begriffe_id] = 1;
            }
        });
        $legende = [];
        $data = [];
        arsort($count);
        foreach ($count as $key => $val) {
            $txt = FxToolsTrait::makeCharReplaceOffStatic($begriffe[$key]);
            #$data[] = [$txt, $val];
            #$legende[] = $txt . ' ' . $val . 'x';
            $data[] = $val;
            $legende[] = $txt;
        }

        $this->legende = $legende;
        return $data;
    }

    /***
     * @return array
     */
    private function getBegriffe()
    {
        $begriffe = [];
        $EinsatzBegriffe = EinsatzBegriff::orderBy('begriff', 'ASC')->get();
        $EinsatzBegriffe->each(function ($eb) use (&$begriffe) {
            $begriffe[$eb->id] = $eb->begriff;
        });
        return $begriffe;
    }

    /***
     * @return array
     */
    private function getEinsatzgebiet()
    {
        $data = [];
        $anfang = $this->getanfang();
        $max = [
            'innerhalb' => 0,
            'ausserhalb' => 0,
        ];

        for ($jahr = $anfang; $jahr <= date('Y'); $jahr++) {
            $loeschbereich = [
                'innerhalb' => 0,
                'ausserhalb' => 0,
            ];
            $Einsaetze = Einsaetze::where('einsatz_begin', '>=', $jahr . '-01-01 00:00:00')
                ->where('einsatz_begin', '<=', $jahr . '-12-31 23:59:59')->get();
            $Einsaetze->each(function ($e) use (&$loeschbereich) {
                if ($e->loeschhilfe === '1') {
                    $loeschbereich['ausserhalb'] = $loeschbereich['ausserhalb'] + 1;
                } else {
                    $loeschbereich['innerhalb'] = $loeschbereich['innerhalb'] + 1;
                }
            });
            if ($max['innerhalb'] < $loeschbereich['innerhalb']) {
                $max['innerhalb'] = $loeschbereich['innerhalb'];
            }
            if ($max['ausserhalb'] < $loeschbereich['ausserhalb']) {
                $max['ausserhalb'] = $loeschbereich['ausserhalb'];
            }
            $data[] = [$jahr, $loeschbereich['innerhalb'], $loeschbereich['ausserhalb']];
        }
        $this->legende = ['Löschbezirk', 'Löschhilfe'];
        $max = $this->checkMaximum($max['innerhalb'], $max['ausserhalb']);
        return $data;
    }

    private function getMaximum()
    {
        return $this->maximum;
    }

    /***
     * @return array
     */
    private function getEinsatzuebersicht()
    {
        $anfang = $this->getanfang();
        $data = [];
        $maximum = $this->maximum;
        $begriffe = $this->getBegriffBereich();
        $einsaetze = [
            'feuer' => 0,
            'thl' => 0,
            'heumessung' => 0,
            'fehlalarm' => 0,
        ];
        $maxeinsaetze = [
            'feuer' => 0,
            'thl' => 0,
            'heumessung' => 0,
            'fehlalarm' => 0,
            'gesamt' => 0,
        ];

        for ($jahr = $anfang; $jahr <= date('Y'); $jahr++) {
            $jahr_einsaetze = [
                'feuer' => 0,
                'thl' => 0,
                'heumessung' => 0,
                'fehlalarm' => 0,
                'gesamt' => 0,
            ];
            $Einsaetze = Einsaetze::where('einsatz_begin', '>=', $jahr . '-01-01 00:00:00')
                ->where('einsatz_begin', '<=', $jahr . '-12-31 23:59:59')->get();
            $Einsaetze->each(function ($e) use (&$jahr_einsaetze, $begriffe) {
                if (in_array($e->cms_einsatz_begriffe_id, $begriffe['feuer'])) {
                    $jahr_einsaetze['feuer'] = $jahr_einsaetze['feuer'] + 1;
                    $jahr_einsaetze['gesamt'] = $jahr_einsaetze['gesamt'] + 1;
                }
                if (in_array($e->cms_einsatz_begriffe_id, $begriffe['thl'])) {
                    $jahr_einsaetze['thl'] = $jahr_einsaetze['thl'] + 1;
                    $jahr_einsaetze['gesamt'] = $jahr_einsaetze['gesamt'] + 1;
                }
                if (in_array($e->cms_einsatz_begriffe_id, $begriffe['heumessung'])) {
                    $jahr_einsaetze['heumessung'] = $jahr_einsaetze['heumessung'] + 1;
                    $jahr_einsaetze['gesamt'] = $jahr_einsaetze['gesamt'] + 1;
                }
                if (in_array($e->cms_einsatz_begriffe_id, $begriffe['fehlalarm'])) {
                    $jahr_einsaetze['fehlalarm'] = $jahr_einsaetze['fehlalarm'] + 1;
                    $jahr_einsaetze['gesamt'] = $jahr_einsaetze['gesamt'] + 1;
                }
            });

            $einsaetze['feuer'] = $einsaetze['feuer'] + $jahr_einsaetze['feuer'];
            $einsaetze['thl'] = $einsaetze['thl'] + $jahr_einsaetze['thl'];
            $einsaetze['fehlalarm'] = $einsaetze['fehlalarm'] + $jahr_einsaetze['fehlalarm'];
            $einsaetze['heumessung'] = $einsaetze['heumessung'] + $jahr_einsaetze['heumessung'];

            $jahr_einsaetze['gesamt'] = $jahr_einsaetze['feuer'] + $jahr_einsaetze['thl'] + $jahr_einsaetze['fehlalarm'] + $jahr_einsaetze['heumessung'];
            if ($maxeinsaetze['gesamt'] < $jahr_einsaetze['gesamt']) {
                $maxeinsaetze['gesamt'] = $jahr_einsaetze['gesamt'];
            }
            if ($maxeinsaetze['feuer'] < $jahr_einsaetze['feuer']) {
                $maxeinsaetze['feuer'] = $jahr_einsaetze['feuer'];
            }
            if ($maxeinsaetze['thl'] < $jahr_einsaetze['thl']) {
                $maxeinsaetze['thl'] = $jahr_einsaetze['thl'];
            }
            if ($maxeinsaetze['fehlalarm'] < $jahr_einsaetze['fehlalarm']) {
                $maxeinsaetze['fehlalarm'] = $jahr_einsaetze['fehlalarm'];
            }
            if ($maxeinsaetze['heumessung'] < $jahr_einsaetze['heumessung']) {
                $maxeinsaetze['heumessung'] = $jahr_einsaetze['heumessung'];
            }
            $data[] = [$jahr, $jahr_einsaetze['gesamt'], $jahr_einsaetze['feuer'], $jahr_einsaetze['thl'], $jahr_einsaetze['heumessung'], $jahr_einsaetze['fehlalarm']];
        }
        $this->legende = ['Einsätze', 'Feuer', 'Technische Hilfe', 'Heumessung', 'Fehlalarm'];
        $max = $this->checkMaximum($maxeinsaetze['feuer'], $maxeinsaetze['thl'], $maxeinsaetze['fehlalarm'], $maxeinsaetze['heumessung'], $maxeinsaetze['gesamt']);
        return $data;
    }

    /***
     * @param $count
     * @return array
     */
    private function getRandColors($count)
    {
        $all_colors = FxToolsTrait::getColorNameHex();
        $hexcolor = [];
        $colorName = [];
        foreach ($all_colors as $name => $hex) {
            $hexcolor[] = $hex;
            $colorName[] = $name;
        }
        $count_all_colors = count($all_colors);
        $array = [];
        $numbers = [];
        for ($i = 0; $i < $count; $i++) {
            $numbers = $this->RandColorNumbers($count_all_colors, $numbers);
        }
        foreach ($numbers as $k => $val) {
            $array['hex'][] = '#' . $hexcolor[$k];
            $array['name'][] = $colorName[$k];
        }

        return $array;
    }

    private function RandColorNumbers($max, $numbers)
    {
        $new = rand(0, $max);
        if (in_array($new, $numbers)) {
            $numbers = $this->RandColorNumbers($max, $numbers);
        } else {
            $numbers[] = $new;
        }
        return $numbers;
    }

    private function getCountEinsaetze()
    {
        $data = [];
        $Einsaetze = Einsaetze::where('aktiv', '=', '1')->orderBy('einsatz_begin', 'ASC')->get();
        $Einsaetze->each(function ($e) use (&$data) {
        });
        return $data;
    }

    private function setStorageFahrzeuge($fahrzeuge)
    {
        $this->set('fahrzeuge', $fahrzeuge);
    }

    private function getStorageFahrzeuge()
    {
        return $this->get('fahrzeuge');
    }

    /***
     * @param $colors
     * @param $all_colors
     * @param $count_all_colors
     * @return mixed
     */
    private function genColors($colors, $all_colors, $count_all_colors)
    {
        $rand_key = rand(0, $count_all_colors);
        $new_color = '';
        if (array_key_exists($rand_key, $all_colors)) {
            $new_color = $all_colors[$rand_key];
        }

        if (in_array($new_color, $colors) || $new_color === '') {
            $new_color = $this->genColors($colors, $all_colors, $count_all_colors);
        }
        $colors[] = $new_color;
        return $colors;
    }
}
