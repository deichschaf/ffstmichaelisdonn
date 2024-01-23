<?php

namespace App\Http\Traits;

use App\Http\Enum\ActiveEnum;
use App\Http\Models\Fahrzeuge;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Config;

trait VehiclesTrait
{
    /**
     * @param int $id
     * @return array
     */
    public function getVehicle(int $id = 0): array
    {
        $data = Cache::remember(
            __CLASS__ . '_' . __FUNCTION__ . '_id_' . $id,
            Config::get('CacheConfig.cache_content_timeout'),
            function () use ($id) {
                $data = [];
                $getVerhicle = Fahrzeuge::where('id', '=', $id)->get();
                $getVerhicle->each(function ($v) use (&$data) {
                    $data = [
                        'id' => $v->id,
                        'fahrzeug' => $v->fahrzeug,
                        'kennzeichen' => $v->kennzeichen,
                        'zugelassen' => $v->zugelassen,
                        'bos_kennung' => $v->bos_kennung,
                        'motorleistung' => $v->motorleistung,
                        'fahrgestell' => $v->fahrgestell,
                        'bild' => $v->bild,
                        'img' => $v->bild,
                        'images' => $this->getPictureSrc($v->bild),
                    ];
                });
                return $data;
            }
        );
        return $data;
    }

    /**
     * @return array
     */
    public function getVehicles(): array
    {
        $data = Cache::remember(
            __CLASS__ . '_' . __FUNCTION__,
            Config::get('CacheConfig.cache_content_timeout'),
            function () {
                $data = [];
                $active = [];
                $deactive = [];
                $getVehicles = $this->getVehicleList(ActiveEnum::Deactive, 1);
                if (count($getVehicles) > 0) {
                    $active = array_merge($active, $getVehicles);
                }
                $getVehicles = $this->getVehicleList(ActiveEnum::Deactive, 0);
                if (count($getVehicles) > 0) {
                    $active = array_merge($active, $getVehicles);
                }

                $getVehicles = $this->getVehicleList(ActiveEnum::Active, 1);
                if (count($getVehicles) > 0) {
                    $deactive = array_merge($deactive, $getVehicles);
                }
                $getVehicles = $this->getVehicleList(ActiveEnum::Active, 0);
                if (count($getVehicles) > 0) {
                    $deactive = array_merge($deactive, $getVehicles);
                }

                $data['active'] = $active;
                $data['deactive'] = $deactive;
                return $data;
            }
        );
        return $data;
    }

    /**
     * @param ActiveEnum $inactive
     * @param int $bos
     * @return array
     */
    private function getVehicleList(ActiveEnum $inactive = ActiveEnum::Deactive, int $bos = 1): array
    {
        $vehicles = [];
        $b = '=';
        if ($bos === 1) {
            $b = '!=';
        }
        $getVerhicle = Fahrzeuge::where('is_person', '=', ActiveEnum::Deactive)
            ->where('ausrangiert', '=', $inactive)
            ->where('bos_kennung', $b, null)
            ->get();
        $getVerhicle->each(function ($v) use (&$vehicles) {
            $vehicles[] = [
                'id' => $v->id,
                'fahrzeug' => $v->fahrzeug,
                'kennzeichen' => $v->kennzeichen,
                'zugelassen' => $v->zugelassen,
                'bos_kennung' => $v->bos_kennung,
                'motorleistung' => $v->motorleistung,
                'fahrgestell' => $v->fahrgestell,
                'bild' => $v->bild,
                'img' => $v->bild,
                'images' => $this->getPictureSrc($v->bild),
            ];
        });
        return $vehicles;
    }

    public function getVehiclesDetails($id = 0, $params2 = ''): array
    {
        $data = Cache::remember(
            __CLASS__ . '_' . __FUNCTION__ . '_id_' . $id,
            Config::get('CacheConfig.cache_content_timeout'),
            function () use ($id) {
                $data = [];
                $getVehicle = Fahrzeuge::where('is_person', '=', ActiveEnum::Deactive)
                    ->where('id', '=', $id)
                    ->get();
                $getVehicle->each(function ($v) use (&$data) {
                    $data = [
                        'id' => $v->id,
                        'fahrzeug' => $v->fahrzeug,
                        'allgemein' => $v->allgemein,
                        'kennzeichen' => $v->kennzeichen,
                        'bos_kennung' => $v->bos_kennung,
                        'zugelassen' => $v->zugelassen,
                        'motorleistung' => $v->motorleistung,
                        'fahrgestell' => $v->fahrgestell,
                        'zulaessiges_gesamtgewicht' => $v->zulaessiges_gesamtgewicht,
                        'aufbau' => $v->aufbau,
                        'ausfahrhoehe' => $v->ausfahrhoehe,
                        'sitzplaetze' => $v->sitzplaetze,
                        'tank' => $v->tank,
                        'beladung_ueber_normal' => $v->beladung_ueber_normal,
                        'besonderheiten' => $v->besonderheiten,
                        'bild' => $v->bild,
                        'img' => $v->bild,
                        'images' => $this->getPictureSrc($v->bild, '/fileadmin/fahrzeuge'),
                    ];
                });
                return $data;
            }
        );
        return $data;
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function saveData(Request $request): JsonResponse
    {

    }

    /**
     * @return array
     */
    public function getDefaultVehicleIDs(): array
    {
        $vehicle = [];
        $Vehicle = Fahrzeuge::where('is_default', '=', '1')
            ->get();
        $Vehicle->each(function ($u) use (&$vehicle) {
            $vehicle[] = ['value' => $u->id, 'label' => $this->makeVehicleName($u)];
        });
        return $vehicle;
    }

    /**
     * @param object $f
     * @return string
     */
    private function makeVehicleName(object $f): string
    {
        $data = [];
        $data[] = $f->fahrzeug;
        if ($f->bos_kennung != '') {
            $data[] = '(' . $f->bos_kennung . ')';
        } else {
            $data[] = '(' . $f->kennzeichen . ')';
        }
        return implode(' ', $data);
    }

    /**
     * @return array
     */
    public function getVehiclesOption(): array
    {
        $vehicle = [];
        $Vehicle = Fahrzeuge::get();
        $Vehicle->each(function ($u) use (&$vehicle) {
            $vehicle[] = ['value' => $u->id, 'label' => $this->makeVehicleName($u)];
        });
        return $vehicle;
    }

    /**
     * @param int $id
     * @return array
     */
    private function getVehicleDetails(int $id = 0): array
    {
        $vehicles = [];
        $Vehicle = Fahrzeuge::where('is_person', '=', ActiveEnum::Deactive)
            ->where('id', '=', $id)
            ->get();
        $Vehicle->each(function ($v) use (&$vehicles) {
            $vehicles[] = [
                'id' => $v->id,
                'fahrzeug' => $v->fahrzeug,
                'allgemein' => $v->allgemein,
                'kennzeichen' => $v->kennzeichen,
                'bos_kennung' => $v->bos_kennung,
                'zugelassen' => $v->zugelassen,
                'motorleistung' => $v->motorleistung,
                'fahrgestell' => $v->fahrgestell,
                'zulaessiges_gesamtgewicht' => $v->zulaessiges_gesamtgewicht,
                'aufbau' => $v->aufbau,
                'ausfahrhoehe' => $v->ausfahrhoehe,
                'sitzplaetze' => $v->sitzplaetze,
                'tank' => $v->tank,
                'beladung_ueber_normal' => $v->beladung_ueber_normal,
                'besonderheiten' => $v->besonderheiten,
                'bild' => $v->bild,
                'img' => $v->bild,
                'images' => $this->getPictureSrc($v->bild, '/fileadmin/fahrzeuge'),
            ];
        });
        return $vehicles;
    }

}
