<?php

namespace App\Http\Traits;

use App\Http\Models\HappyHoliday;
use App\Http\Models\HappyHolidayContent;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Config;

trait HolidayTrait
{
    public function getWidgetHoliday()
    {
        $heute = date('Y-m-d');
        $data = Cache::remember(
            'holiday.' . $heute,
            Config::get('CacheConfig.cache_content_timeout'),
            function () use ($heute) {
                $holiday = [];
                $content_id = 0;
                $getHoliday = HappyHoliday::where('beginn', '<=', $heute)
                    ->where('end', '>=', $heute)->get();
                $getHoliday->each(function ($h) use (&$content_id) {
                    $content_id = $h->content_id;
                });
                if ($content_id !== 0) {
                    $getHolidayContent = HappyHolidayContent::where('id', '=', $content_id)->get();
                    $getHolidayContent->each(function ($hhc) use (&$holiday) {
                        $holiday = [
                            'picture' => $hhc->picture,
                            'text' => $hhc->text,
                            'content' => $this->ReplacePlaceholder($hhc->content)
                        ];
                    });
                }
                return $holiday;
            }
        );
        return $data;
    }

    public function getTemplates()
    {
        return [
            'christmas' => 'Weihnachten',
            'christmas_new_year' => 'Weihnachten und Silvester',
            'happy_new_year' => 'Frohes neues Jahr',
            'happy_eastern' => 'Frohe Ostern',
        ];
    }
}
