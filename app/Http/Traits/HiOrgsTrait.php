<?php

namespace App\Http\Traits;

use Anouar\Fpdf\Facades\Fpdf;
use App\Http\Models\Funkrufnamen;
use App\Http\Controllers\PDF;

trait HiOrgsTrait
{
    public static function getStaticHiOrgsSmall()
    {
        $org = array();
        $org[] = 'fd';
        $org[] = 'kd';
        $org[] = 'hb';
        $org[] = 'hh';
        $org[] = 'hm';
        $org[] = 'td';
        $org[] = 'ch';
        $org[] = 'knuo_sh';
        $org[] = 'rd';
        $org[] = 'rsh';
        $org[] = 'rk';
        $org[] = 'akd';
        return $org;
    }

    public static function getStaticHiOrgs()
    {
        $org_lang = array();
        $org_lang['fd'] = 'Florian Dithmarschen';
        $org_lang['kd'] = 'Kater Dithmarschen';
        $org_lang['hb'] = 'Heros Burg';
        $org_lang['hh'] = 'Heros Heide';
        $org_lang['hm'] = 'Heros Meldorf';
        $org_lang['rd'] = 'Rettung Dithmarschen';
        $org_lang['rsh'] = 'Rettung Schleswig-Holstein';
        $org_lang['akd'] = 'Akkon Dithmarschen';
        $org_lang['rk'] = 'Rotkreuz Dithmarschen';
        $org_lang['td'] = 'Triton Dithmarschen';
        $org_lang['ch'] = 'Christoph';
        $org_lang['kuno_sh'] = 'KUNO-SH';
        return $org_lang;
    }
}
