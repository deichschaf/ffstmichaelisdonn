<?php

namespace App\Http\Traits;

use App\Http\Models\DWDWeather;
use Illuminate\Support\Facades\Lang;

trait WeatherTrait
{
    public function getWeather(): array
    {
        $data = '';
        $getDWDWeather = DWDWeather::where('area', 'DWDWarnungen')->orderBy('created_at', 'desc')->take(1)->get();
        $getDWDWeather->each(function ($dwd) use (&$data) {
            $data = $dwd->content;
        });

        $data = (json_decode($data));
        $time = date('d.m.Y H:i:s', substr($data->time, 0, -3));
        $copy = str_ireplace('copyright', '', $data->copyright);
        $warnungen = [];
        if ($data->warnings !== null && $data->warnings !== false) {
            if (is_object($data->warnings)) {
                foreach ($data->warnings as $key => $values) {
                    foreach ($values as $key2 => $area) {
                        if (
                            $area->regionName === 'Kreis Dithmarschen - Küste'
                            ||
                            $area->regionName === 'Kreis Dithmarschen - Binnenland'
                            ||
                            $area->regionName === 'Kreis Dithmarschen'
                        ) {
                            $warnungen[] = [
                                'weathertype' => $this->getUnwetterHeadline($area->level),
                                'region' => $area->regionName,
                                'headline' => $this->makeReplaceHeadline($area->headline),
                                'event' => $area->event,
                                'start' => date('d.m.Y H:i', substr($area->start, 0, -3)),
                                'end' => date('d.m.Y H:i', substr($area->end, 0, -3)),
                                'description' => $area->description,
                                'instruction' => $this->makeWeatherTextReplace($area->instruction),
                                'type' => $area->type,
                                'icontype'=> Lang::get('weather.headline.' . ($area->type + 1)),
                                'level' => $area->level,
                            ];
                        }
                    }
                }
            }
        }

        $vorabinfo = [];
        if ($data->vorabInformation !== null && $data->vorabInformation !== false) {
            if (is_object($data->vorabInformation)) {
                foreach ($data->vorabInformation as $key => $values) {
                    foreach ($values as $key2 => $area) {
                        if (
                            $area->regionName === 'Kreis Dithmarschen - Küste'
                            ||
                            $area->regionName === 'Kreis Dithmarschen - Binnenland'
                            ||
                            $area->regionName === 'Kreis Dithmarschen'
                        ) {
                            $vorabinfo[] = [
                                'weathertype' => $this->getUnwetterHeadline($area->level),
                                'region' => $area->regionName,
                                'headline' => $this->makeReplaceHeadline($area->headline),
                                'event' => $area->event,
                                'start' => date('d.m.Y H:i', substr($area->start, 0, -3)),
                                'end' => date('d.m.Y H:i', substr($area->end, 0, -3)),
                                'description' => $area->description,
                                'instruction' => $this->makeWeatherTextReplace($area->instruction),
                                'type' => $area->type,
                                'icontype'=> Lang::get('weather.headline.' . ($area->type+1)),
                                'level' => $area->level,
                            ];
                        }
                    }
                }
            }
        }
        return [
            'warnungen' => (array)$warnungen,
            'vorabinfo' => (array)$vorabinfo,
            'copy'=>$copy,
            'time'=>$time
        ];
    }
    private function getUnwetterHeadline($nr)
    {
        $headline = Lang::get('weather.headline.' . $nr);
        return $headline;
    }

    private function makeReplaceHeadline($text)
    {
        return str_ireplace("Amtliche WARNUNG vor ", "", $text);
    }

    private function makeWeatherTextReplace($txt)
    {
        $txt = str_ireplace(
            'ACHTUNG! Hinweis auf mögliche Gefahren:',
            '<strong>ACHTUNG! Hinweis auf mögliche Gefahren:</strong>',
            $txt
        );
        return $txt;
    }
}
