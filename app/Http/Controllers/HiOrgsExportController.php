<?php

namespace App\Http\Controllers;

use App\Http\Models\Funkrufnamen;
use App\Http\Traits\HiOrgsTrait;

class HiOrgsExportController extends GroundController
{
    public function hiorg_show()
    {
    }

    public function getRufnamenGemeinde($kreis = 'Dithmarschen')
    {
        $org = HiOrgsTrait::getHiOrgsSmall();
        $org_lang = HiOrgsTrait::getHiOrgs();
        $Export = array();

        foreach ($org as $key => $o) {
            $Rufnamen = Funkrufnamen::where($o, '=', '1')
                        ->where('kreis', '=', $kreis)
                        ->orderBy('amt', 'ASC')
                        ->orderBy('wache', 'ASC')
                        ->orderBy('gruppe', 'ASC')
                        ->orderBy('nr', 'ASC')
                        ->get();
            $Rufnamen->each(
                function ($rufname) use (&$Export, &$o, &$org_lang) {
                    $funk = array();
                    if ($rufname->wache != '') {
                        $funk[] = $rufname->wache;
                    }
                    if ($rufname->gruppe != '') {
                        $funk[] = $rufname->gruppe;
                    }
                    if ($rufname->nr != '') {
                        $funk[] = $rufname->nr;
                    }
                    if (count($funk) > 0) {
                        $funk = join('/', $funk);
                        if ($funk != '') {
                            $funk = ' ' . $funk;
                        }
                    } else {
                        $funk = '';
                    }

                    $Export[] = array(
                        $org_lang[$o],
                        $funk,
                        $rufname->ort,
                        $rufname->art,
                        $rufname->amt
                    );
                }
            );
        }
        $datei = 'Rufnamen_Gemeinde';
        return array( 'export' => $Export, 'datei' => $datei);
    }
}
