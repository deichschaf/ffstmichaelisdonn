<?php

namespace App\Http\Controllers;

use App\Http\Models\DWDWeather;
use Illuminate\Support\Facades\Lang;

class WetterController extends GroundController
{
    private function getUnwetterHeadline($nr)
    {
        $headline = Lang::get('weather.headline.' . $nr);
        return $headline;
    }

    private function TextReplace($txt)
    {
        $txt = str_ireplace('ACHTUNG! Hinweis auf mögliche Gefahren:', '<strong>ACHTUNG! Hinweis auf mögliche Gefahren:</strong>', $txt);
        return $txt;
    }

    public function wetter()
    {
        exit();
    }

    public function unwetter()
    {
        #$link = 'http://www.dwd.de/DWD/warnungen/warnapp/json/warnings.json';
        #$link = 'http://www.ffstmichaelisdonn.localhost/test/warnings.json';
        //$data = @file_get_contents($link);
        #$data = $this->GetUrl($link);
        #if ($data === ''){
        #    exit();
        #}

        #$data = str_ireplace('warnWetter.loadWarnings(', '', $data);
        #if (substr($data, -2) === ');') {
        #    $data = substr($data, 0, -2);
        #}

        $data = '';
        $DWDWeather = DWDWeather::where('area', 'DWDWarnungen')->orderBy('created_at', 'desc')->take(1)->get();
        $DWDWeather->each(function ($dwd) use (&$data) {
            $data = $dwd->content;
        });

        $data = (json_decode($data));
        /*
        if (is_object($data) && $_SERVER['REMOTE_ADDR'] !== '109.47.2.28')
        {
            exit();
        }
        echo '<pre>';
        print_r($data);
        echo '</pre>';
        exit();
        */

        $time = date('d.m.Y H:i:s', substr($data->time, 0, -3));
        $copy = str_ireplace('copyright', '&copy;', $data->copyright);
        $warnungen = [];


        if ($data->warnings !== null && $data->warnings !== false) {
            if (is_object($data->warnings)) {
                foreach ($data->warnings as $key => $values) {
                    foreach ($values as $key2 => $area) {
                        /*
                        if ($area->regionName === 'Kreis Steinburg' || $area->regionName === 'Kreis Dithmarschen - Küste' ||
                        $area->regionName === 'Kreis Dithmarschen - Binnenland' || $area->regionName === 'Kreis Dithmarschen') {
                        */

                        if (
                            $area->regionName === 'Kreis Dithmarschen - Küste' ||
                            $area->regionName === 'Kreis Dithmarschen - Binnenland' || $area->regionName === 'Kreis Dithmarschen'
                        ) {
                            $warnungen[] = [
                                'weathertype' => $this->getUnwetterHeadline($area->level),
                                'region' => $area->regionName,
                                'headline' => $area->headline,
                                'event' => $area->event,
                                'start' => date('d.m.Y H:i', substr($area->start, 0, -3)),
                                'end' => date('d.m.Y H:i', substr($area->end, 0, -3)),
                                'description' => $area->description,
                                'instruction' => $this->TextReplace($area->instruction), /*nicht immer gefüllt*/
                                'type' => $area->type,
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
                        if ($area->regionName === 'Kreis Dithmarschen - Küste' || $area->regionName === 'Kreis Dithmarschen - Binnenland' || $area->regionName === 'Kreis Dithmarschen') {
                            $vorabinfo[] = [
                                'weathertype' => $this->getUnwetterHeadline($area->level),
                                'region' => $area->regionName,
                                'headline' => $area->headline,
                                'event' => $area->event,
                                'start' => date('d.m.Y H:i', substr($area->start, 0, -3)),
                                'end' => date('d.m.Y H:i', substr($area->end, 0, -3)),
                                'description' => $area->description,
                                'instruction' => $this->TextReplace($area->instruction), /*nicht immer gefüllt*/
                                'type' => $area->type,
                                'level' => $area->level,
                            ];
                        }
                    }
                }
            }
        }
        $warnungen = view('unwetter.meldung')->with(['warnungen' => $warnungen])->render();
        $vorabinfo = view('unwetter.meldung')->with(['warnungen' => $vorabinfo])->render();

        if (strlen($warnungen) === '' && strlen($vorabinfo) == '') {
            exit();
        }
        if (strlen($warnungen) != '') {
            $warnungen = '<h3>Wetterwarnung</h3>' . $warnungen;
        }
        if (strlen($vorabinfo) != '') {
            $vorabinfo = '<h3>Vorabinformation</h3>' . $vorabinfo;
        }
        #header('Content-Type: text/javascript');
        echo view('unwetter.index')->with(['warnungen' => $warnungen, 'vorabinfo' => $vorabinfo, 'copy' => $copy, 'stand' => $time])->render();
        exit();
    }

    private function GetUrl($url)
    {
        $curlSession = curl_init();
        curl_setopt($curlSession, CURLOPT_URL, $url);
        curl_setopt($curlSession, CURLOPT_BINARYTRANSFER, true);
        curl_setopt($curlSession, CURLOPT_RETURNTRANSFER, true);

        $return = curl_exec($curlSession);
        #Log::info($url);
        $httpcode = curl_getinfo($curlSession, CURLINFO_HTTP_CODE);
        curl_close($curlSession);
        $search = array(
            '/\[^\S]+/s', // strip whitespaces after tags, except space
            '/[^\S]+\</s', // strip whitespaces before tags, except spaces
            '/(\s)+/s' // shorten multiple whitespace sequences
        );
        $replace = array(
            '>',
            '<',
            '\\1'
        );
        $buffer = preg_replace($search, $replace, $return);
        return ($httpcode >= 200 && $httpcode < 300) ? $buffer : '';
    }

    private function DWDTypes()
    {
        $types = [
            '1' => 'wind',
            '2' => 'regen',
            '3' => 'schnee',
            '4' => 'nebel',
            '5' => 'frost',
            '6' => 'glaette',
        ];
    }
}
