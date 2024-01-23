<?php

namespace App\Http\Traits;

use App\Http\Models\Termine;
use App\Http\Models\TerminePlaces;
use App\Http\Models\TermineWearingTypes;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Input;

/**
 * Trait TermineTrait
 * @package App\Http\Traits
 */
trait TermineTrait
{
    public function getAdminTermine(): array
    {
        $data = [];
        $year = 0;
        $month = 0;
        $getTermine = Termine::orderBy('date_start', 'DESC')->get();
        $getTermine->each(function ($t) use (&$data, &$year, &$month) {
            $date = explode('-', $t->date_start);
            if ($year !== $date['0']) {
                $year = $date['0'];
                $data[] = [
                    'headline_year' => $year
                ];
                $month = 0;
            }
            if ($month !== $date['1']) {
                $month = $date['1'];
                $data[] = [
                    'headline_month' => $month
                ];
            }
            $data[] = [
                'id' => $t->id,
                'year' => $date['0'],
                'month' => $date['1'],
                'day' => $date['2'],
                'dayofweek' => $this->getDayofWeek($date),
                'date_start' => $t->date_start,
                'date_end' => $t->date_end,
                'time_start' => $t->time_start,
                'time_end' => $t->time_end,
                'title' => $t->title,
                'description' => $t->description,
                'active' => $t->active,
                'is_public' => $t->is_public,
                'is_cancel' => $t->is_cancel,
                'is_cancel_text' => $t->is_cancel_text,
            ];
        });
        return $data;
    }

    /**
     * @param Request $request
     * @return array
     */
    public function setAdminTermine(Request $request): array
    {
        try {
            $inputs = $request->all();
            $timestart = $this->checkText($inputs['timestart']);
            $timeend = $this->checkText($inputs['timeend']);
            $timestart = $this->checkEmptyValueSetNull($timestart);
            $timeend = $this->checkEmptyValueSetNull($timeend);
            if ($timestart !== null) {
                $timestart .= ':00';
            }

            if ($timeend !== null) {
                $timeend .= ':00';
            }

            if (0 != $inputs['id']) {
                $save = Termine::find($inputs['id']);
                $save->active = $this->setBoolean($inputs['active']);
                $save->is_cancel = $this->setBoolean($inputs['is_cancel']);
                $save->is_public = $this->setBoolean($inputs['is_public']);
                $save->must_be = $this->setBoolean($inputs['must_be']);
                $save->is_cancel_text = $this->checkText($inputs['is_cancel_text']);
                $save->title = $this->checkText($inputs['title']);
                $save->description = $this->checkText($inputs['description']);
                $save->place_id = $this->checkText($inputs['place_id']);
                $save->wear_id = $this->checkText($inputs['wear_id']);
                $save->date_start = $this->checkText($inputs['datestart']);
                $save->date_end = $this->checkText($inputs['dateend']);
                $save->time_start = $timestart;
                $save->time_end = $timeend;
                $save->save();
            } else {
                $save = new Termine();
                $save->active = $this->setBoolean($inputs['active']);
                $save->is_cancel = $this->setBoolean($inputs['is_cancel']);
                $save->is_public = $this->setBoolean($inputs['is_public']);
                $save->must_be = $this->setBoolean($inputs['must_be']);
                $save->is_cancel_text = $this->checkText($inputs['is_cancel_text']);
                $save->title = $this->checkText($inputs['title']);
                $save->description = $this->checkText($inputs['description']);
                $save->place_id = $this->checkText($inputs['place_id']);
                $save->wear_id = $this->checkText($inputs['wear_id']);
                $save->date_start = $this->checkText($inputs['datestart']);
                $save->date_end = $this->checkText($inputs['dateend']);
                $save->time_start = $timestart;
                $save->time_end = $timeend;
                $save->save();
            }
            $this->cleanPageData();
            $data = [];
            $data['success'] = true;
            return $data;
        } catch (Exception $exception) {
            $data = [];
            $data['success'] = false;
            $data['errors'] = [
                'code' => $exception->getCode(),
                'message' => $exception->getMessage()
            ];
            return $data;
        }
    }

    /**
     * @param int $limit
     * @return array
     */
    public function getWidgetTermine(int $limit = 0): array
    {
        $data = [];
        $Termine = Termine::where('date_start', '>=', date('Y-m-d') . ' 00:00:00')
            ->where('active', '=', '1')
            ->where('is_public', '=', '1')
            ->orderBy('date_start', 'ASC')
            ->take($limit)
            ->get();
        $Termine->each(function ($t) use (&$data) {
            $data[] = [
                'id' => $t->id,
                'date_start' => $this->makeDatum($t->date_start),
                'time_start' => $this->makeZeit($t->time_start),
                'title' => $t->title,
                'description' => $t->description,
                'active' => $t->active,
                'is_public' => $t->is_public,
                'is_cancel' => $t->is_cancel,
                'is_cancel_text' => $t->is_cancel_text,
            ];
        });
        return $data;
    }

    /**
     * @return array
     */
    public function getScheduler(): array
    {
        $data = Cache::remember(
            __CLASS__ . '_' . __FUNCTION__,
            Config::get('CacheConfig.cache_content_timeout'),
            function () {
                $getWear = $this->getWear();
                $places = $this->getPlaces();
                $heute = date('Y-m-d');
                $termine = [];
                $Termine = Termine::where('is_public', '=', '1')
                    ->where('active', '=', '1')
                    ->where('date_start', '>=', $heute)
                    ->orderBy('date_start', 'ASC')
                    ->orderBy('time_start', 'ASC')
                    ->get();
                $Termine->each(function ($t) use (&$termine, $getWear, $places) {
                    $termine[] = array(
                        'id' => $t->id,
                        'title' => $t->title,
                        'date' => $this->makeDatum($t->date_start, $t->date_end),
                        'time' => $this->makeZeit($t->time_start, $t->time_end),
                        'place' => $places[$t->place_id],
                        'description' => $t->description,
                        'wear' => $getWear[$t->wear_id],
                        'zeichen' => $t->sign,
                        'is_cancel' => $t->is_cancel,
                        'is_cancel_text' => $t->is_cancel_text,
                    );
                });
                return $termine;
            }
        );
        return $data;
    }

    public function getWear()
    {
        $data = [];
        $data['0'] = '---';
        $Types = TermineWearingTypes::orderBy('id', 'ASC')->get();
        $Types->each(function ($t) use (&$data) {
            $data[$t->id] = $t->wear;
        });
        return $data;
    }

    /**
     * @return array
     */
    public function getPlaces(): array
    {
        $data = [];
        $data['0'] = '---';
        $Types = TerminePlaces::orderBy('id', 'ASC')->get();
        $Types->each(function ($t) use (&$data) {
            $data[$t->id] = $t->title . ', ' . $t->city;
        });
        return $data;
    }

    public function preDataApi(): JsonResponse
    {
        $data = [];
        $data['wearing'] = $this->getWearingTypes();
        $data['places'] = $this->getPlacesSelectValues();
        return response()->json($data, 200);
    }

    /**
     * @return array
     */
    public function getWearingTypes(): array
    {
        $data = [];
        $data[] = [
            'id' => 0,
            'name' => '----',
            'value' => 0,
            'label' => '----',
        ];
        $Types = TermineWearingTypes::orderBy('id', 'ASC')->get();
        $Types->each(function ($t) use (&$data) {
            $data[] = [
                'id' => $t->id,
                'name' => $t->wear,
                'value' => $t->id,
                'label' => $t->wear,
            ];
        });
        return $data;
    }

    /**
     * @return array
     */
    public function getPlacesSelectValues(): array
    {
        $data = [];
        $data[] = [
            'id' => 0,
            'name' => '----',
            'value' => 0,
            'label' => '----',
        ];
        $getPlaces = TerminePlaces::orderBy('title', 'ASC')->get();
        $getPlaces->each(function ($t) use (&$data) {
            $data[] = [
                'id' => $t->id,
                'name' => $t->title . ', ' . $t->city,
                'value' => $t->id,
                'label' => $t->title . ', ' . $t->city,
            ];
        });
        return $data;
    }

    /**
     * Termine für alle Sichtbar auf der Homepage
     */
    public function showTermine($limit = false)
    {
        $termine = array();
        $heute = date('Y-m-d');
        if ($limit !== false) {
            $Termine = Termine::where('is_public', '=', '1')
                ->where('active', '=', '1')
                ->where('date_start', '>=', $heute)
                ->orderBy('date_start', 'ASC')
                ->orderBy('time_start', 'ASC')
                ->take($limit)
                ->get();
        } else {
            $Termine = Termine::where('is_public', '=', '1')
                ->where('active', '=', '1')
                ->where('date_start', '>=', $heute)
                ->orderBy('date_start', 'ASC')
                ->orderBy('time_start', 'ASC')
                ->get();
        }
        $Termine->each(function ($t) use (&$termine) {
            $termine[] = array(
                'title' => $t->title,
                'id' => $t->id,
                'date_start' => $this->makeDatum($t->date, $t->date_end),
                'zeit' => $this->makeZeit($t->time_start, $t->time_end),
                'ort' => $t->veranstaltungsort,
                'beschreibung' => $t->beschreibung,
                'is_cancel' => $t->is_cancel,
                'is_cancel_text' => $t->is_cancel_text,
            );
        });
        return $termine;
    }

    /**
     * @return array
     */
    public function getAllTermine()
    {
        $termine = array();
        $heute = date('Y-m-d');
        $Termine = Termine::where('date_start', '>=', $heute)
            ->orderBy('date_start', 'ASC')
            ->orderBy('time_start', 'ASC')
            ->get();
        $getWear = $this->getWear();
        $Termine->each(function ($t) use (&$termine, $getWear) {
            $termine[] = array(
                'termin' => $t->veranstaltung,
                'id' => $t->cms_termine_id,
                'date' => $this->makeDatum($t->date_start, $t->date_end),
                'zeit' => $this->makeZeit($t->time_start, $t->time_end),
                'ort' => $t->veranstaltungsort,
                'beschreibung' => $t->beschreibung,
                'kleidung' => $getWear[$t->wear_id],
                'sign' => $t->sign,
                'is_cancel' => $t->is_cancel,
                'is_cancel_text' => $t->is_cancel_text,
            );
        });
        return $termine;
    }

    public function getAllTermineAnwesenheit()
    {
        $termine = array();
        $heute = date('Y-m-d');
        $Termine = Termine::where('date_start', '<=', $heute)
            ->orderBy('date_start', 'DESC')
            ->orderBy('time_start', 'ASC')
            ->get();
        $Termine->each(function ($t) use (&$termine) {
            $where = [];
            $where[] = $t->termin;
            if ($t->veranstaltungsort !== '') {
                $where[] = $t->veranstaltungsort;
            }
            $termine[] = array(
                'id' => $t->id,
                'date_start' => FxToolsTrait::makeDatumDeStatic($t->date_start) . ' ' . FxToolsTrait::zeit_static($t->time_start),
                'where' => join(', ', $where),
                'type' => 'uebung'
            );
        });
        return $termine;
    }

    /**
     * Termine nur für Mitglieder
     */
    public function makeNoPublicly()
    {
    }

    public function getICS(Request $request, $user)
    {
        $data = array();
        $data['entry'] = $this->buildICS();
        $entrys = join("", $data['entry']);
        $content = view('icalc.icalc_main')->with('entrys', $entrys)->render();
        $content = $this->makeIcsReplace($content);

        $input = $request->all();
        $outlook = 0;

        if (array_key_exists('outlook', $input)) {
            if ($input['outlook'] === '1') {
                $outlook = 1;
            }
        }
        if ($outlook === 1) {
            header("Content-type: text/calendar; charset=" . TermineTrait::getCharSet());
            header("Content-type: text/v-calendar; charset=" . TermineTrait::getCharSet());
        }
        header("Content-Disposition: inline; filename=" . env('ICS_FILE_NAME', 'calender.ics'));
        echo str_ireplace('<br>', ' ', $content);
        exit();
    }

    /***
     * Check if date is in the winter or in the summertime
     * @param $date
     * @return string
     */
    public function getTerminInSummerTime($date)
    {
        $date_cut = explode('-', $date);
        $year = $date_cut['0'];
        $month = $date_cut['1'];
        $day = $date_cut['2'];
        $timestamp = mktime(2, 0, 0, $month, $day, $year);

        $start = $this->getSummerTimeStart($year);
        $end = $this->getSummerTimeEnd($year);

        if (($start >= $timestamp) && ($timestamp <= $end)) {
            return '1';
        }
        return '0';
    }

    /**
     * show the start of the summertime
     * @param $year int
     * @return int
     */
    public function getSummerTimeStart($year)
    {
        return mktime(
            2,
            0,
            0,
            3,
            31 - date('w', mktime(2, 0, 0, 3, 31, $year)),
            $year
        );
    }

    /***
     * show the end of the summertime
     * @param $year int
     * @return int
     */
    public function getSummerTimeEnd($year)
    {
        return mktime(
            2,
            0,
            0,
            10,
            31 - date('w', mktime(2, 0, 0, 10, 31, $year)),
            $year
        );
    }

    public function getCharSet($upper = false)
    {
        return 'utf-8';
        //return 'windows-1252';
    }

    /***
     * calc if the year have 28 or 29 days in the february
     * @param $year int
     * @return boolean
     */
    public function periodyear($year)
    {
        $year = trim($year);
        if ($year % 400 === 0) {
            return "true";
        } elseif ($year % 4 === 0 && $year % 100 !== 0) {
            return "true";
        } else {
            return "false";
        }
    }

    /***
     * @return array
     * @todo UTF8 content wird nicht korrekt angezeigt!
     */
    private function buildICS()
    {
        $entrys = array();
        $Termine = Termine::where('date_start', '!=', '0000-00-00')
            ->where('date_start', '>=', "'" . date('Y') . "-1-1'")
            ->where('active', '=', '1')
            ->orderBy('date_start', 'ASC')
            ->get();
        $Termine->each(function ($t) use (&$entrys) {
            $data = array();

            $date_start = self::icaldate($t->date, $t->time_start);
            $date_end = self::icaldate($t->date_end, $t->time_end);

            $data['termin'] = self::convert($t->termin);
            $data['id'] = $t->id;
            $data['time_start'] = $date_start;
            $data['ende'] = $date_end;
            $data['veranstaltungsort'] = self::convert($t->veranstaltungsort);
            $data['beschreibung'] = self::convert($t->beschreibung);
            $entrys[] = view('icalc.icalc_entry')->with('data', $data)->render();
        });
        return $entrys;
    }

    /**
     * Baut das date um zu einem Kalenderdate
     * @param $date
     * @param $time
     * @return string
     */
    private function icaldate($date, $time, $timeold = false)
    {
        $summertime = $this->getTerminInSummerTime($date);
        $str = '';
        $date = explode('-', $date);
        $date = join('', $date);
        if ($time != '55:55:55') {
            $time = explode(':', $time);
            $time = join('', $time);
            if ($summertime === 1) {
                $time = $time - 10000;
            }
        } else {
            #$time='000000';
            if ($timeold === false) {
                $time = '000000';
            } else {
                if ($timeold == '55:55:55') {
                    $time = '020000';
                } else {
                    $time = explode(':', $timeold);
                    $time = ($time['0'] + 2) . $time['1'] . '00';
                    if ($summertime === 1) {
                        $time = $time - 10000;
                    }
                }
            }
        }

        $summertime =

        $str = $date . 'T' . $time; //.'Z';
        return $str;
    }

    private function convert($txt)
    {
        #$txt = utf8_decode($txt);
        #$txt = utf8_encode($txt);
        #$txt = iconv('UTF-8', 'WINDOWS-1252', $txt);
        return $txt;
    }

    private function makeIcsReplace($content)
    {
        $content = str_replace(' METHOD:PUBLISH', 'METHOD:PUBLISH', $content);
        $content = str_replace(' VERSION:', 'VERSION:', $content);
        $content = str_replace(' PRODID:', 'PRODID:', $content);
        $content = str_replace(' BEGIN:', 'BEGIN:', $content);
        $content = str_replace(' SUMMARY;', 'SUMMARY;', $content);
        $content = str_replace(' SUMMARY:', 'SUMMARY:', $content);
        $content = str_replace(' UID:', 'UID:', $content);
        $content = str_replace(' STATUS:', 'STATUS:', $content);
        $content = str_replace(' DTSTART;', 'DTSTART;', $content);
        $content = str_replace(' DTEND;', 'DTEND;', $content);
        $content = str_replace(' LAST-MODIFIED:', 'LAST-MODIFIED:', $content);
        $content = str_replace(' LOCATION;', 'LOCATION;', $content);
        $content = str_replace(' LOCATION:', 'LOCATION:', $content);
        $content = str_replace(' DESCRIPTION;', 'DESCRIPTION;', $content);
        $content = str_replace(' DESCRIPTION:', 'DESCRIPTION:', $content);
        $content = str_replace(' END:', 'END:', $content);
        return $content;
    }

    private function getTermine($is_public = 0)
    {
    }

    private function buildICSUser($user_id)
    {
        $user = [
            'iuk' => '0',
            'stab' => '0',
        ];
        $entrys = array();
        $Termine = Termine::where('date_start', '!=', '0000-00-00')
            ->where('date_start', '>=', "'" . date('Y') . "-1-1'")
            ->where('active', '=', '1')
            ->orderBy('date_start', 'ASC')
            ->get();
        $Termine->each(function ($t) use (&$entrys, $user) {
            if (
                ($user['iuk'] === '1' && $t->iuk == '1')
                ||
                ($user['stab'] === '1' && $t->stab == '1')
                ||
                ($t->alle == '1')
            ) {
                $data = array();

                $date_start = self::icaldate($t->date, $t->time_start);
                $date_end = self::icaldate($t->date_end, $t->time_end);

                $data['termin'] = self::convert($t->termin);
                $data['id'] = $t->id;
                $data['time_start'] = $date_start;
                $data['ende'] = $date_end;
                $data['veranstaltungsort'] = self::convert($t->veranstaltungsort);
                $data['beschreibung'] = self::convert($t->beschreibung);
                $entrys[] = view('icalc.icalc_entry')->with('data', $data)->render();
            }
        });
        return $entrys;
    }
}
