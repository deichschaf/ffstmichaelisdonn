<?php

namespace App\Http\Traits;

use App\Http\Models\Metatags;
use App\Http\Models\Seiten;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Session;

trait MetatagsTrait
{
    private function buildMetatag($title, $page_id = false, $admin = false): string
    {
        $content = Cache::remember(
            'metatag.' . $page_id . md5($title),
            Config::get('CacheConfig.cache_content_timeout'),
            function () use ($page_id, $title, $admin) {
                $metatags = [];
                $pagemeta = $this->getPageMetatag($page_id);
                $Metatags = Metatags::get();
                $Metatags->each(function ($m) use (&$metatags, &$pagemeta) {
                    if (array_key_exists($m->metatag, $pagemeta)) {
                        $meta = $m->metatag_text;
                        if ('' !== $pagemeta[$m->metatag]) {
                            $meta = $pagemeta[$m->metatag];
                        }
                        $metatags[] = ['tag' => $m->metatag, 'value' => $meta];
                        if ('description' === $m->metatag) {
                            Session::put('social_sharing.description', $meta);
                        }
                    } else {
                        $metatags[] = ['tag' => $m->metatag, 'value' => $m->metatag_text];
                        if ('description' === $m->metatag) {
                            Session::put('social_sharing.description', $m->metatag_text);
                        }
                    }
                });
                $datum = date('Y-m-d') . 'T' . date('H:i:s') . '+02:00';
                $metatags[] = ['tag' => 'date', 'value' => $datum];
                $metatags[] = ['tag' => 'generator', 'value' => env('GENERATOR')];
                $metatags[] = ['tag' => 'pragma', 'value' => 'no-cache'];
                $metatags[] = ['tag' => 'cache-control', 'value' => 'no-cache'];
                $metatags[] = ['tag' => 'expires', 'value' => '0'];
                $metatags[] = [
                    'tag' => 'created',
                    'value' => env('HOMEPAGE_ERSTELLUNGSMONAT') . ' ' . env('HOMEPAGE_ERSTELLUNGSJAHR')
                        . ', ' . env('HOMEPAGE_CREATEDBY')
                ];
                $metatags[] = ['tag' => 'publisher', 'value' => env('HOMEPAGE_PUBLISHER')];
                $metatags[] = ['tag' => 'language', 'value' => 'de'];
                if (1 === $admin) {
                    foreach ($metatags as $key => $value) {
                        if ('keywords' === $value['tag'] || 'description' === $value['tag']) {
                            unset($metatags[$key]);
                        }
                        if ('robots' === $value['tag']) {
                            $metatags[$key]['value'] = 'noindex, nofollow';
                        }
                    }
                }
                $meta = '';
                foreach ($metatags as $key) {
                    $meta .= '<meta name="' . $key['tag'] . '" content="' . $key['value'] . '" /> ';
                }
                $show = 1;

                if (array_key_exists('HTTP_USER_AGENT', $_SERVER)) {
                    if (preg_match('/Validator/i', $_SERVER['HTTP_USER_AGENT'])) {
                        $show = 0;
                    }
                }
                if (1 === $show) {
                    $meta .= '<meta http-equiv="imagetoolbar" content="false" /> ';
                }
                $meta .= '<link rel="canonical" href="' . \Request::fullUrl() . '" /> ';
                $meta .= '<meta name="DC.title" content="' . env('HOMEPAGE_TITLE') . ' - ' . $title . '" /> ';
                $meta .= '<meta name="geo.region" content="DE-SH" /> ';
                $meta .= '<meta name="geo.placename" content="Heide" /> ';
                $meta .= '<meta name="geo.position" content="54.19343;9.107334" /> ';
                $meta .= '<meta name="ICBM" content="54.19343, 9.107334" /> ';

                return $meta;
            }
        );

        return $content;
    }

    private function getPageMetatag($id): array
    {
        $metatags = [];
        if (false === $id) {
            return [];
        }
        $Metatags = Seiten::where('id', '=', $id)->get();
        $Metatags->each(function ($m) use (&$metatags) {
            $metatags['keywords'] = $m->keywords;
            $metatags['description'] = $m->description;
        });

        return $metatags;
    }
}
