<?php
namespace App\Http\Traits;

use App\Http\Models\Blackday;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Config;

trait BlackdayTrait
{
    private function getBlackDayNow()
    {
        return date('Y-m-d');
    }

    public function getIsBlackday()
    {
        $heute = $this->getBlackDayNow();
        $count = Cache::remember(
            __CLASS__ . '_' . __FUNCTION__ . 'blackday.' . $heute,
            Config::get('CacheConfig.cache_content_timeout'),
            function () use ($heute) {
                $c = Blackday::where('blackday', '=', $heute)->count();
                $c = $c + Blackday::where('datum_von', '<=', $heute)
                        ->where('datum_bis', '>=', $heute)->count();
                return $c;
            }
        );
        return $count;
    }

    public function getBlackdayContent()
    {
        $heute = $this->getBlackDayNow();
        $blackday = Cache::remember(
            __CLASS__ . '_' . __FUNCTION__ . 'blackday.' . $heute,
            Config::get('CacheConfig.cache_content_timeout'),
            function () use ($heute) {
                $blackday = [];
                $getBlackday = Blackday::where('blackday', '=', $heute)->get();
                $getBlackdayBetween = Blackday::where('datum_von', '<=', $heute)
                    ->where('datum_bis', '>=', $heute)->get();
                $getBlackday->each(function ($b) use (&$blackday) {
                    $blackday[] = [
                        'title' => $b->title,
                        'text' => $this->ReplacePlaceholder($b->text),
                        'homepage_owner'=> $this->ReplacePlaceholder('[CONTACT_FACTORY]')
                    ];
                });
                $getBlackdayBetween->each(function ($b) use (&$blackday, $heute) {
                    if ($b->blackday !== $heute) {
                        $blackday[] = [
                            'title' => $b->title,
                            'text' => $this->ReplacePlaceholder($b->text2),
                            'homepage_owner'=> $this->ReplacePlaceholder('[CONTACT_FACTORY]')
                        ];
                    }
                });
                return $blackday;
            }
        );
        return $blackday;
    }
}
