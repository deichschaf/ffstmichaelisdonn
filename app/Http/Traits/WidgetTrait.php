<?php

namespace App\Http\Traits;

use App\Http\Models\Widget;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Config;

trait WidgetTrait
{
    /**
     * @return array
     */
    public function getWidgets(): array
    {
        $data = Cache::remember(
            __CLASS__ . '_' . __FUNCTION__,
            Config::get('CacheConfig.cache_content_timeout'),
            function () {
                $data = [];
                $Widget = Widget::where('active', '=', '1')
                    ->orderBy('position', 'ASC')
                    ->orderBy('pos', 'ASC')->get();
                $Widget->each(function ($p) use (&$data) {
                    if (!array_key_exists($p->position, $data)) {
                        $data[$p->position] = [];
                    }
                    $data[$p->position][] = [
                        'element' => $p->WidgetName,
                        'params' => $p->param
                    ];
                });
                return $data;
            }
        );
        return $data;
    }
    public function getWidget($WidgetName, $param)
    {
        $Widget = Cache::remember(
            'widget.' . $WidgetName,
            Config::get('CacheConfig.cache_navi_timeout'),
            function () use ($WidgetName, $param) {
                $WidgetName = 'get' . $WidgetName;
                return $this->$WidgetName($param);
            }
        );

        return $Widget;
    }
}
