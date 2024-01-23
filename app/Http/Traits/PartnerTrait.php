<?php

namespace App\Http\Traits;

use App\Http\Models\Partner;
use Illuminate\Html\FormFacade;
use Illuminate\Html\HtmlFacade;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Config;

trait PartnerTrait
{
    public static function showPartner()
    {
        $heute = date('Y-m-d');
        $partner = Cache::remember('partner' . $heute, Config::get('CacheConfig.cache_content_timeout'), function () use ($heute) {
            $partner = array();
            $Partner = Partner::where('partner_start', '<=', $heute)->where('partner_ende', '>=', $heute)->where('aktiv', '=', '1')->orderBy('pos', 'ASC')->orderBy('partner_start', 'ASC')->get();
            $Partner->each(function ($p) use (&$partner) {
                $p_t = '';
                if ($p->partner_logo !== '' && $p->partner_logo !== null) {
                    $p_t = '<img src="/fileadmin/partner/' . $p->partner_logo . '" border="0" alt="' . $p->partner . '" title="' . $p->partner . '">';
                    #$p_t = HtmlFacade::image('/fileadmin/partner/' . $p->partner_logo, $p->partner, array('title' => $p->partner));

                    if ($p->show_partner_name === '1') {
                        $p_t .= '<br>' . $p->partner;
                    }
                } else {
                    $p_t = $p->partner;
                }

                if ($p->partner_link !== '' && $p->partner_link !== null) {
                    //$text = 'HTML Class NEED!!';
                    //$text = HtmlFacade::decode(HtmlFacade::link($p->partner_link, $p_t, array('target' => '_blank')));
                    $text = '<a href="' . $this->Tools_buildUrl($p->partner_link) . '" target="_blank" style="text-decoration:none;">' . $p_t . '</a>';
                } else {
                    $text = $p_t;
                }
                $partner[] = $text;
            });

            if (count($partner) > 0) {
                return view('widget.partner')->with('data', $partner)->render();
            }
            return '';
        });
        return $partner;
    }
}
