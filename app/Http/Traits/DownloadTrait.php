<?php

namespace App\Http\Traits;

use App\Http\Models\Download;
use App\Http\Models\DownloadKategorie;

trait DownloadTrait
{
    private static function getFilePath()
    {
        $url = public_path() . DIRECTORY_SEPARATOR . 'fileadmin' . DIRECTORY_SEPARATOR . 'download' . DIRECTORY_SEPARATOR;
        return $url;
    }

    public static function getStaticDownloads()
    {
        $downloads = array();
        $Downloads = Download::orderBy('download_title', 'ASC')->get();
        $Downloads->each(function ($d) use (&$downloads) {
            $file = DownloadTrait::getFilePath() . $d->download_file;
            $downloads[] = array(
                'datum_zeit' => $this->makeDatumZeitStatic($d->download_datum_zeit),
                'icon' => FxToolsFilesTrait::fileicon($d->download_file),
                'titel' => $d->download_title,
                'beschreibung' => $d->download_text,
                'download' => $d->download_file,
                'key' => $d->download_key,
                'kategorie_id' => $d->download_kategorie_id,
                'size' => FxToolsFilesTrait::getFilesize($file)
            );
        });
        return $downloads;
    }

    public static function getStaticDownloadKategorien()
    {
        $kategorien = array();
        //$kategorien['0'] = 'Keine Kategorie zugeordnet';
        $Kategorien = DownloadKategorie::get();
        $Kategorien->each(function ($k) use (&$kategorien) {
            $kategorien[$k->id] = $k->download_kategorie;
        });
        return $kategorien;
    }

    public function getDownloadFile(array $file)
    {
        $filetype = strtolower($this->getFileType($file['file']));
    }

    /**
     * Get Download
     *
     * @param Text $name
     * @param String $file
     * @param String $path
     * @param String $titel
     */
    public static function getStaticDownload($title, $file, $intern = false)
    {
        //Begin writing headers
        $filetype = strtolower(FxToolsFilesTrait::getfiletype($file));
        $name = $title . "." . $filetype;
        if ($intern !== false) {
            $datei = DownloadTrait::getFilePath() . '..' . DIRECTORY_SEPARATOR . 'intern' . DIRECTORY_SEPARATOR . $file;
        } else {
            $datei = DownloadTrait::getFilePath() . $file;
        }

        header("Pragma: public");
        header("Expires: 0");
        header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
        header("Cache-Control: public");
        header("Content-Description: File Transfer");

        //Use the switch-generated Content-Type
        $ctype = FxToolsFilesTrait::getFileHeaderType($filetype);
        header("Content-Type: $ctype");

        // Alle Sonderzeichen rausfiltern
        $name = str_replace(array(' ', '&quot;', '&apos;'), '_', $name);

        //Force the download
        $header = "Content-Disposition: attachment; filename=" . $name . ";";
        header($header);
        $len = filesize($datei);
        header("Content-Transfer-Encoding: binary");
        header("Content-Length: " . $len);
        @readfile($datei);
        exit;
    }
}
