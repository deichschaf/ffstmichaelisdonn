<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Config;

class DashboardController extends GroundController
{
    public function dashboardOverview()
    {
        $data = Cache::remember(
            __CLASS__ . '_' . __FUNCTION__,
            Config::get('CacheConfig.cache_navi_timeout'),
            function () {
                $data = [];
                $data['todos'] = $this->getToDoStatistic();
                $data['changelog'] = $this->getLastChangeLog(4);
                $data['todos_list'] = $this->getLastOpenToDoStatistic(4);
                return $data;
            }
        );
        return response()->json($data, 200);
    }
}
