<?php

namespace App\Http\Traits;

use App\Http\Models\Einsaetze;
use App\Http\Models\EinsatzBegriff;

trait EmergencyStatisticTrait
{
    public function getEmergencyCountStatistic(): array
    {
        $first = $this->getFirstYear();
        $emergencies = [
            'feuer' => 0,
            'thl' => 0,
            'heumessung' => 0,
            'fehlalarm' => 0,
        ];
        $begriffe = $this->getBegriffBereich();
        $Emergency = Einsaetze::get();
        $Emergency->each(function ($e) use (&$emergencies, $begriffe) {
            if (in_array($e->cms_einsatz_begriffe_id, $begriffe['feuer'])) {
                $emergencies['feuer'] += 1;
            }
            if (in_array($e->cms_einsatz_begriffe_id, $begriffe['thl'])) {
                $emergencies['thl'] += 1;
            }
            if (in_array($e->cms_einsatz_begriffe_id, $begriffe['fehlalarm'])) {
                $emergencies['fehlalarm'] += 1;
            }
            if (in_array($e->cms_einsatz_begriffe_id, $begriffe['heumessung'])) {
                $emergencies['heumessung'] += 1;
            }
        });
        return [
            'data' => [
                $emergencies['feuer'],
                $emergencies['thl'],
                $emergencies['heumessung'],
                $emergencies['fehlalarm'],
            ],
            'legende' => [
                'Feuer',
                'Technische Hilfe',
                'Heumessung',
                'Fehlalarm'
            ],
            'startYear' => $first,
            'endYear' => date('Y'),
        ];
    }

    private function getFirstYear(): int
    {
        $first = date('Y');
        $Emergency = Einsaetze::orderBy('einsatz_begin', 'ASC')->take(1)->get();
        $Emergency->each(function ($e) use (&$first) {
            $date = explode(' ', $e->einsatz_begin);
            $date = explode('-', $date['0']);
            $first = $date['0'];
        });
        return $first;
    }

    private function getBegriffBereich()
    {
        $data = [];
        $data['feuer'] = [];
        $data['thl'] = [];
        $data['heumessung'] = [];
        $data['fehlalarm'] = [];
        $EinsatzBegriffe = EinsatzBegriff::get();
        $EinsatzBegriffe->each(function ($eb) use (&$data) {
            if ($eb->feuer === '1') {
                $data['feuer'][] = $eb->id;
            }
            if ($eb->thl === '1') {
                $data['thl'][] = $eb->id;
            }
            if ($eb->heumessung === '1') {
                $data['heumessung'][] = $eb->id;
            }
            if ($eb->fehlalarm === '1') {
                $data['fehlalarm'][] = $eb->id;
            }
        });
        return $data;
    }

    public function getEmergencyStatistic(): array
    {
        $begriffe = $this->getBegriffe();
        $first = $this->getFirstYear();
        $count = [];
        $Emergency = Einsaetze::get();
        $Emergency->each(function ($e) use (&$count) {
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
            $data[] = $val;
            $legende[] = $txt;
        }
        return [
            'data' => $data,
            'legende' => $legende,
            'startYear' => $first,
            'endYear' => date('Y'),
        ];
    }

    public function getEmergencyStatisticOverview(): array
    {
        $first = $this->getFirstYear();
        $data = [];
        $label = [];
        $sum = [];
        $feuer = [];
        $thl = [];
        $heumessung = [];
        $fehlalarm = [];
        $begriffe = $this->getBegriffBereich();
        $emergencies = [
            'feuer' => 0,
            'thl' => 0,
            'heumessung' => 0,
            'fehlalarm' => 0,
        ];
        $maxemergencies = [
            'feuer' => 0,
            'thl' => 0,
            'heumessung' => 0,
            'fehlalarm' => 0,
            'sum' => 0,
        ];

        for ($year = $first; $year <= date('Y'); $year++) {
            $year_emergencies = [
                'feuer' => 0,
                'thl' => 0,
                'heumessung' => 0,
                'fehlalarm' => 0,
                'sum' => 0,
            ];
            $Emergency = Einsaetze::where('einsatz_begin', '>=', $year . '-01-01 00:00:00')
                ->where('einsatz_begin', '<=', $year . '-12-31 23:59:59')->get();
            $Emergency->each(function ($e) use (&$year_emergencies, $begriffe) {
                if (in_array($e->cms_einsatz_begriffe_id, $begriffe['feuer'])) {
                    $year_emergencies['feuer'] = $year_emergencies['feuer'] + 1;
                    $year_emergencies['sum'] = $year_emergencies['sum'] + 1;
                }
                if (in_array($e->cms_einsatz_begriffe_id, $begriffe['thl'])) {
                    $year_emergencies['thl'] = $year_emergencies['thl'] + 1;
                    $year_emergencies['sum'] = $year_emergencies['sum'] + 1;
                }
                if (in_array($e->cms_einsatz_begriffe_id, $begriffe['heumessung'])) {
                    $year_emergencies['heumessung'] = $year_emergencies['heumessung'] + 1;
                    $year_emergencies['sum'] = $year_emergencies['sum'] + 1;
                }
                if (in_array($e->cms_einsatz_begriffe_id, $begriffe['fehlalarm'])) {
                    $year_emergencies['fehlalarm'] = $year_emergencies['fehlalarm'] + 1;
                    $year_emergencies['sum'] = $year_emergencies['sum'] + 1;
                }
            });

            $emergencies['feuer'] = $emergencies['feuer'] + $year_emergencies['feuer'];
            $emergencies['thl'] = $emergencies['thl'] + $year_emergencies['thl'];
            $emergencies['fehlalarm'] = $emergencies['fehlalarm'] + $year_emergencies['fehlalarm'];
            $emergencies['heumessung'] = $emergencies['heumessung'] + $year_emergencies['heumessung'];

            $year_emergencies['sum'] = $year_emergencies['feuer'] + $year_emergencies['thl'] + $year_emergencies['fehlalarm'] + $year_emergencies['heumessung'];
            if ($maxemergencies['sum'] < $year_emergencies['sum']) {
                $maxemergencies['sum'] = $year_emergencies['sum'];
            }
            if ($maxemergencies['feuer'] < $year_emergencies['feuer']) {
                $maxemergencies['feuer'] = $year_emergencies['feuer'];
            }
            if ($maxemergencies['thl'] < $year_emergencies['thl']) {
                $maxemergencies['thl'] = $year_emergencies['thl'];
            }
            if ($maxemergencies['fehlalarm'] < $year_emergencies['fehlalarm']) {
                $maxemergencies['fehlalarm'] = $year_emergencies['fehlalarm'];
            }
            if ($maxemergencies['heumessung'] < $year_emergencies['heumessung']) {
                $maxemergencies['heumessung'] = $year_emergencies['heumessung'];
            }
            $label[] = $year;
            $sum[] = $year_emergencies['sum'];
            $feuer[] = $year_emergencies['feuer'];
            $thl[] = $year_emergencies['feuer'];
            $heumessung[] = $year_emergencies['heumessung'];
            $fehlalarm[] = $year_emergencies['fehlalarm'];
        }

        return [
            'data' => [
                (object)[
                    'label' => 'Einsätze',
                    'data' => $sum,
                    'backgroundColor' => 'rgba(255, 99, 132, 0.5)',
                ],
                (object)[
                    'label' => 'Feuer',
                    'data' => $feuer,
                    'backgroundColor' => 'rgba(54, 162, 235, 0.5)',
                ],
                (object)[
                    'label' => 'Technische Hilfe',
                    'data' => $thl,
                    'backgroundColor' => 'rgba(255, 206, 86, 0.5)',
                ],
                (object)[
                    'label' => 'Heumessung',
                    'data' => $heumessung,
                    'backgroundColor' => 'rgba(75, 192, 192, 0.5)',
                ],
                (object)[
                    'label' => 'Fehlalarm',
                    'data' => $fehlalarm,
                    'backgroundColor' => 'rgba(153, 102, 255, 0.5)',
                ]
            ],
            'legende' => $label,
            'startYear' => $first,
            'endYear' => date('Y'),
        ];
    }

    public function getEmergencyAreaStatistic(): array
    {
        $data = [];
        $label = [];
        $area_inside = [];
        $area_outside = [];
        $first = $this->getFirstYear();
        $max = [
            'innerhalb' => 0,
            'ausserhalb' => 0,
        ];

        for ($year = $first; $year <= date('Y'); $year++) {
            $area = [
                'innerhalb' => 0,
                'ausserhalb' => 0,
            ];
            $Emergency = Einsaetze::where('einsatz_begin', '>=', $year . '-01-01 00:00:00')
                ->where('einsatz_begin', '<=', $year . '-12-31 23:59:59')->get();
            $Emergency->each(function ($e) use (&$area) {
                if ($e->loeschhilfe === '1') {
                    $area['ausserhalb'] += 1;
                } else {
                    $area['innerhalb'] += 1;
                }
            });
            if ($max['innerhalb'] < $area['innerhalb']) {
                $max['innerhalb'] = $area['innerhalb'];
            }
            if ($max['ausserhalb'] < $area['ausserhalb']) {
                $max['ausserhalb'] = $area['ausserhalb'];
            }
            //$data[] = [$year, $area['innerhalb'], $area['ausserhalb']];
            $label[] = $year;
            $area_inside[] = $area['innerhalb'];
            $area_outside[] = $area['ausserhalb'];
        }
        //$legende = ['Löschbezirk', 'Löschhilfe'];
        return [
            'data' => [
                (object)[
                    'label' => 'Löschbezirk',
                    'data' => $area_inside,
                    'backgroundColor' => 'rgba(255, 99, 132, 0.5)',
                ],
                (object)[
                    'label' => 'Löschhilfe',
                    'data' => $area_outside,
                    'backgroundColor' => 'rgba(53, 162, 235, 0.5)',
                ]
            ],
            'legende' => $label,
            'startYear' => $first,
            'endYear' => date('Y'),
        ];
    }
}
