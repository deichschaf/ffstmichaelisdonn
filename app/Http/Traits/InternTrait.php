<?php

namespace App\Http\Traits;

use App\Http\Models\InternDownload;
use App\Http\Models\InternDownloadKategorie;
use App\Http\Models\InternDownloadZuordnung;

trait InternTrait
{
    private static function getDownloads($kat)
    {
        $download = '';
        $files = [];
        $IDZ = InternDownloadZuordnung::where('cms_intern_download_kategorie_id', '=', $kat)->get();
        $IDZ->each(function ($idz) use (&$files) {
            $Download = InternDownload::where('id', '=', $idz->cms_intern_download_id)->get();
            $Download->each(function ($d) use (&$files) {
                $path = public_path() . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'htdocs' . DIRECTORY_SEPARATOR . 'fileadmin' . DIRECTORY_SEPARATOR . 'intern' . DIRECTORY_SEPARATOR;
                #echo 'PATH: '.$path.'<br>';
                if (is_file($path . $d->download)) {
                    $file = '<a href="' . route('intern.download') . '/' . $d->download_key . '" target="_blank">' . $d->titel . '</a>';
                    if ($d->beschreibung !== '') {
                        $file .= '<br><small>' . $d->beschreibung . '</small>';
                    }
                    $files [] = '<li>' . $file . '</li>';
                }
            });
        });
        if (count($files) > 0) {
            $download = '<ul>' . join('', $files) . '</ul>';
        }
        return $download;
    }
    private static function getDownloadKategorie($kat)
    {
        $kategorien = array();
        $Kat = InternDownloadKategorie::where('parent_id', '=', $kat)->get();
        $Kat->each(function ($k) use (&$kategorien) {
            $kategorie = '';
            $download = InternTrait::getDownloads($k->cms_intern_download_kategorie_id);
            if ($download !== '') {
                $kategorie = $download;
            }
            $kategorie .= InternTrait::getDownloadKategorie($k->cms_intern_download_kategorie_id);
            if ($kategorie !== '') {
                $kategorien[] = '<li>' . $k->kategorie . $kategorie . '</li>';
            }
        });
        $kat = '';
        if (count($kategorien) !== 0) {
            $kat = '<ul>' . join('', $kategorien) . '</ul>';
        }
        return $kat;
    }

    public static function getStaticInternDownload()
    {
        $download = InternTrait::getDownloadKategorie(0);
        if ($download !== '') {
            return $download;
        } else {
            return '<p class="fehler">Keine Downloads vorhanden.</p>';
        }
    }
}
