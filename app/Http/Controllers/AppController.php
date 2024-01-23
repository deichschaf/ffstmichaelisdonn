<?php

namespace App\Http\Controllers;

use App\Http\Traits\ModDwdwetterHelperTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Config;

class AppController extends GroundController
{
    public function ShowEmergencyDoc(Request $request)
    {
        $inputs = $request->all();
        $dwd_weather = $this->loadDWD();
        $content = view('app.parts.wheather')->with('dwd_weather', $dwd_weather)->render();
        $scripts = view('app.parts.wheather_header')->render();
        #return $content;
        return $this->LoadTemplate($content, $scripts);
    }

    public function UpdateWheaterData()
    {
        $data = [];

        return \Response::json($data);
    }

    public function CronOverview()
    {
        $data = [];
        $data['cronjobs'] = [
            [
                'value' => "Geburtstagsmail",
                'src' => "/intern/api/cronjob_birthday"
            ],
            [
                'value' => "DelTemp",
                'src' => "/intern/api/cronjob_deltemp",
            ],
            [
                'value' => "Dropbox Sync",
                'src' => "/intern/api/dropbox_sync",
            ],
            [
                'value' => "Dropbox ISOs Sync",
                'src' => "/intern/api/dropbox_iso_sync",
            ],
            [
                'value' => "DWD",
                'src' => "/cron/dwd",
            ],
            [
                'value' => "DWD Warnungen",
                'src' => "/cron/dwdWarn",
            ],
            [
                'value' => "DWD Maps",
                'src' => "/cron/dwdmaps",
            ],
            [
                'value' => "DWD Radar",
                'src' => "/cron/dwdradar",
            ],
            [
                'value' => "SunriseDown",
                'src' => "/cron/SunriseDown",
            ],
            [
                'value' => "GetWeatherText",
                'src' => "/cron/GetWeatherText",
            ],
            [
                'value' => "GetSeaWeatherText",
                'src' => "/cron/GetSeaWeatherText",
            ],
            [
                'value' => "ReadCriticalGermany",
                'src' => "/cron/ReadCriticalGermany",
            ],
            [
                'value' => "AddNewCriticalSender",
                'src' => "/cron/AddNewCriticalSender",
            ],
            [
                'value' => "CronGetTides",
                'src' => "/cron/CronGetTides",
            ],

        ];

        $content = view('cronjob.cronjobs')->with('data', $data)->render();
        return $this->LoadTemplate($content);
    }

    public function apiSunRiseDown()
    {
        ModDwdwetterHelperTrait::ApiGetSunRiseDown();
    }

    public function GetDWDWarn()
    {
        ModDwdwetterHelperTrait::cronDWDWarn();
    }

    public function getDWDRadar()
    {
        ModDwdwetterHelperTrait::getDWDRadar();
    }

    public function GetDWDContent()
    {
        ModDwdwetterHelperTrait::GetDWDFTP();
    }

    public function GetDWDWeatherImage()
    {
        ModDwdwetterHelperTrait::GetWeatherMaps();
    }

    public function GetWeatherText()
    {
        ModDwdwetterHelperTrait::GetWeatherText();
    }

    public function GetSeaWeatherText()
    {
        ModDwdwetterHelperTrait::GetSeaWeatherText();
    }

    public function ReadCriticalGermany()
    {
        ModDwdwetterHelperTrait::ReadCriticalGermany();
    }

    public function AddNewCriticalSender()
    {
        ModDwdwetterHelperTrait::AddNewCriticalSender();
    }

    public function CriticalSender()
    {
        $content = ModDwdwetterHelperTrait::CriticalSender();
        return view('app.parts.criticalsender')->with('content', $content)->render();
    }

    public function CronGetTides()
    {
        ModDwdwetterHelperTrait::CronGetTides();
    }

    public function GetTides()
    {
        $content = ModDwdwetterHelperTrait::GetTides();
        return view('app.parts.tides')->with('content', $content)->render();
    }

    public function GetMoon()
    {
        $moon = ModDwdwetterHelperTrait::getMoon();
        return view('app.parts.moon')->with('moon', $moon)->render();
    }

    private function loadDWD()
    {
        $dwd = Cache::remember(
            __CLASS__ . '_' . __FUNCTION__,
            Config::get('CacheConfig.cache_navi_timeout'),
            function () {
                $params = [];
                return ModDwdwetterHelperTrait::getList($params);
            }
        );
        return $dwd;
    }
}
