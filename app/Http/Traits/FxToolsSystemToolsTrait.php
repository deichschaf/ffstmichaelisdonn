<?php

namespace App\Http\Traits;

use App\Http\Controllers\GitController;
use Illuminate\Support\Facades\Config;

/**
 * Trait FxToolsSystemToolsTrait
 * @package App\Http\Traits
 */
trait FxToolsSystemToolsTrait
{
    /**
     * @var string
     */
    private static $function_active = '';
    /**
     * @var string
     */
    private static $function_deactive = '';

    /**
     * @todo Speichern der ausgelesenen Konfiguration und ändern laut admin
     */
    public static function show()
    {
        $data = self::getSystemInformation();
        $phpinfo = self::getPHPInfo();

        $content = view('admin.systeminfo')->with('data', $data)->with('phpinfo', $phpinfo)->render();

        return ['content' => $content, 'title' => 'Systeminformationen'];
    }

    private static function getPHPInfo()
    {
        ob_start();
        phpinfo();
        $phpinfo = ob_get_contents();
        ob_end_clean();
        $phpinfo = (
            str_replace(
                "module_Zend Optimizer",
                "module_Zend_Optimizer",
                preg_replace(
                    '%^.*<body>(.*)</body>.*$%ms',
                    '$1',
                    $phpinfo
                )
            )
        );

        $phpinfo = str_ireplace('<table>', '', $phpinfo);
        $phpinfo = str_ireplace('</table>', '', $phpinfo);
        $phpinfo = str_ireplace('<tbody>', '', $phpinfo);
        $phpinfo = str_ireplace('</tbody>', '', $phpinfo);
        $phpinfo = str_ireplace('<tr>', '<div class="row clearfix">', $phpinfo);
        $phpinfo = str_ireplace('<tr class="h">', '<div class="row clearfix bgheadline">', $phpinfo);
        $phpinfo = str_ireplace('<tr class="v">', '<div class="row clearfix bgheadline">', $phpinfo);
        $phpinfo = str_ireplace('</tr>', '</div>', $phpinfo);
        $phpinfo = str_ireplace('</td>', '</div>', $phpinfo);
        $phpinfo = str_ireplace(
            '<td>',
            '<div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 column">',
            $phpinfo
        );
        $phpinfo = str_ireplace(
            '<td class="e">',
            '<div class="col-xxl-4 col-xl-4 col-lg-4 col-md-4 col-sm-4 col-4 column">',
            $phpinfo
        );
        $phpinfo = str_ireplace(
            '<td class="v">',
            '<div class="col-xxl-4 col-xl-4 col-lg-4 col-md-4 col-sm-4 col-4 column">',
            $phpinfo
        );
        $phpinfo = str_ireplace(
            '<h2>',
            '<div class="row clearfix bgheadline">
            <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 column">',
            $phpinfo
        )
        ;
        $phpinfo = str_ireplace('</h2>', '</div></div>', $phpinfo);

        return $phpinfo;
    }

    /**
     *
     */
    public static function checkIM()
    {
    }

    /**
     * @return array
     */
    public static function getStaticSystemInformation()
    {
        $data = [];
        $data['PHP Version'] = phpversion();
        $laravel = app();
        $data['Laravel Version'] = $laravel::VERSION; //self::json_reader('composer.lock', 'Laravel/Framework');
        $data['Git'] = GitController::getGit();
        $data['GD-Lib'] = self::getGDLibVersion();
        $data['Serversoftware'] = self::checkServer();
        //$data['aktivierte PHP Funktionen'] = self::makeToolCheckSystem();
        $data['Schreibrechte'] = self::checkFolderRights();
        $data['ImageMagick'] = self::checkImageMagick();
        $data['IMagick'] = self::checkIMagick();
        $data['ImageMagick Version'] = self::getImageMagick();
        self::makeToolCheckSystem();
        $data['PHP Funktionen aktiviert'] = self::$function_active;
        $data['PHP Funktionen deaktiviert'] = self::$function_deactive;

        return $data;
    }

    /**
     * Abfrage ob der Ordner Schreibrechte hat
     * Rekursiv.
     */
    private static function checkFolderRights()
    {
        $folder = [];
        $folder[] = '/app/database';
        $folder[] = '/app/storage';
        $folder[] = '../htdocs/img';

        return '';
    }

    /**
     * @return mixed|string
     */
    private static function getGDLibVersion()
    {
        if (function_exists('gd_info')) {
            $ver_info = gd_info();

            return $ver_info['GD Version'];
        }

        return 'Nicht Installiert';
    }

    /**
     * @return string
     */
    private static function checkIMagick()
    {
        if (function_exists('imagick')) {
            return 'Installiert';
        }

        return 'Nicht Installiert';
    }

    /**
     * @return string
     */
    public static function getStaticImageMagick()
    {
        $cmd = 'convert -version';
        $check = self::makeConsoleStatic($cmd);
        $list = '';
        if (is_array($check)) {
            if (count($check) > 0) {
                $list = '<ul>';
                foreach ($check as $key => $value) {
                    $content = nl2br($value);
                    $content = explode('<br />', $content);
                    foreach ($content as $k => $val) {
                        if ('' != trim($val)) {
                            $list .= '<li>' . trim($val) . '</li>';
                        }
                    }
                }
                $list .= '</ul>';
            }
        }

        return $list;
    }

    /**
     * @param $output
     * @return string
     */
    private static function buildstring($output)
    {
        $txt = '';
        if (is_array($output)) {
            foreach ($output as $key => $val) {
                if (!is_string($val)) {
                    $txt .= self::buildstring($val);
                } else {
                    if ('' != $txt) {
                        $txt .= '<br>';
                    }
                    $txt .= $val;
                }
            }
        } elseif (is_object($output)) {
        } else {
            $txt .= $output;
        }

        return $txt;
    }

    /**
     *
     */
    private static function getImageMagickVersion()
    {
        /*
        // This file will run a test on your server to determine the location and versions of ImageMagick.
        // It will look in the most commonly found locations.
        // The last two are where most popular hosts (including "Godaddy") install ImageMagick.
        //
        // Upload this script to your server and run it for a breakdown of where ImageMagick is.
        //
        */
        /*
        echo '<h2>Test for versions and locations of ImageMagick</h2>';
        echo '<b>Path: </b> convert<br>';

        function alist ($array) {  //This function prints a text array as an html list.
            $alist = "<ul>";
            for ($i = 0; $i < sizeof($array); $i++) {
                $alist .= "<li>$array[$i]";
            }
            $alist .= "</ul>";
            return $alist;
        }

        exec("convert -version", $out, $rcode); //Try to get ImageMagick "convert" program version number.
        echo "Version return code is $rcode <br>"; //Print the return code: 0 if OK, nonzero if error.
        echo alist($out); //Print the output of "convert -version"
        echo '<br>';
        echo '<b>This should test for ImageMagick version 5.x</b><br>';
        echo '<b>Path: </b> /usr/bin/convert<br>';

        exec("/usr/bin/convert -version", $out, $rcode); //Try to get ImageMagick "convert" program version number.
        echo "Version return code is $rcode <br>"; //Print the return code: 0 if OK, nonzero if error.
        echo alist($out); //Print the output of "convert -version"

        echo '<br>';
        echo '<b>This should test for ImageMagick version 6.x</b><br>';
        echo '<b>Path: </b> /usr/local/bin/convert<br>';
        */
    }

    /**
     * Script zum Testen ob bestimmte Funktionen auf dem Server existieren.
     *
     * @return string
     * @version 1.0
     *
     * @var unknown_type
     *
     * @author Jörg-Marten Hoffmann 2012
     *
     */
    private static function makeToolCheckSystem()
    {
        $functionen = get_defined_functions();

        return '';
        /*$aktiv = array();
        $deaktiviert = array();
        #if (array_key_exists('internal', $functionen)){
        #    $functionen = $functionen[''];
        #}

        foreach ($functionen as $key => $val) {
            #echo '<pre>';
            #print_r($val);
            #echo '</pre>';

            if (function_exists($val)) {
                $aktiv[] = $val;
            } else {
                $deaktiviert[] = $val;
            }
        }
        self::$function_active = $aktiv;
        self::$function_deactive = $deaktiviert;
        return '';
        #return 'Sind verfügbar:'.join(', ', $aktiv).'<br />'.'Sind nicht verfügbar:'.join(', ', $deaktiviert);*/
    }

    /**
    * Funktion zum Checken ob die Datei vorhanden ist.
    *
    * @param string $file
    * @param string $path
    * @param string $url
    *
    * @return string
    */
    public function makeCheckIsFile($file, $path, $url = '')
    {
        if ('' != $file && null != $file && 'NULL' != $file) {
            if (is_file($path . $file)) {
                if ('' != $url) {
                    return $url . $file;
                }

                return $file;
            }

            return '';
        }

        return '';
    }

    /**
    * Führt Befehle auf der Konsole aus. Probiert welche Consolen Variante verfügbar ist,
     * ansonsten gibts eine Fehlermeldung.
    *
    * @param string $link
    *
    * @return string
    */
    public function loadConsole($link)
    {
        $output = [];
        if (function_exists('system')) {
            ob_start();
            system($link, $lastline);
            $output[] = $lastline;
            $output[] = ob_get_contents();
            ob_end_clean();
        } elseif (function_exists('shell_exec')) {
            ob_start();
            $output[] = shell_exec($link);
            $output[] = ob_get_contents();
            ob_end_clean();
        } elseif (function_exists('exec')) {
            ob_start();
            exec($link, $output);
            $output[] = ob_get_contents();
            ob_end_clean();
        } else {
            return CONSOLEFEHLER;
        }

        return $output;
    }

    /**
     * @param $link
     * @return array
     */
    public static function makeConsoleStatic($link)
    {
        $output = [];
        if (function_exists('system')) {
            ob_start();
            $line = system($link, $lastline);
            $output[] = ob_get_contents();
            ob_end_clean();
        } elseif (function_exists('shell_exec')) {
            ob_start();
            $output[] = shell_exec($link);
            $output[] = ob_get_contents();
            ob_end_clean();
        } elseif (function_exists('exec')) {
            ob_start();
            $line = exec($link, $output);
            $output[] = ob_get_contents();
            ob_end_clean();
        } else {
            return CONSOLEFEHLER;
        }

        return $output;
    }

    /***
     * @example execPrint("git pull https://user:password@bitbucket.org/user/repo.git master");
     * @example execPrint("git status");
     * @param string $command
     * @param int $export
     * @return array
     *
     */
    public static function execPrint(string $command = '', int $export = 0)
    {
        $result = [];
        if (!function_exists('exec')) {
            return $result;
        }
        exec($command, $result);
        if ($export == 0) {
            echo("<pre>");
            foreach ($result as $line) {
                print_r($line . "\n");
            }
            echo("</pre>");
        } else {
            return $result;
        }
    }


    /**
    * Funktion überprüft ob auf dem Server Imagemagick verfügbar ist, und gibt dann den Pfad zurück.
    *
    * @return string
    */
    public function checkImageMagick()
    {
        $cmd = 'whereis convert';
        $check = $this->loadConsole($cmd);
        $link = '';
        if (count($check) > 0) {
            foreach ($check as $key => $value) {
                $value = str_replace('convert: ', '', $value);
                $value = explode(' ', $value);
                $link .= $value['0'];
            }
        }

        return $link;
    }

    public function checkServerVersion()
    {
        echo $_SERVER['SERVER_SOFTWARE'];
    }

    public function getImageMagickNoStatic()
    {
        $cmd = 'convert -version';
        $check = $this->loadConsole($cmd);
        $list = '';
        if (is_array($check)) {
            if (count($check) > 0) {
                $list = '<ul>';
                foreach ($check as $key => $value) {
                    $list .= '<li>' . $value . '</li>';
                }
                $list .= '</ul>';
            }
        }

        return $list;
    }

    /**
    * Erstelle aus dem aktuellen Bild ein Thumb.
    *
    * @param string $file
    * @param string $thumb
    * @param string $w
    * @param string $h
    *
    *   $width>$w eingebaut, falls Ein Bild zum Beispiel 500x1px hat und man aber 100x100 haben möchte,
     * dann wird automatisch 500 abgeschnitten auf 100px breite
    */
    public function makeThumbNail($file, $thumb, $w, $h)
    {
        ob_start();
        $cmd = 'whereis convert';
        $check = $this->loadConsole($cmd);
        $link = '';
        if (0 === count($check)) {
            echo '<p class="fehler">ImageMagick ist auf diesem Server nicht verf&uuml;gbar.</p>';
            exit();
        }
        $cmd = 'convert -resize ' . $w . 'x' . $w . ' ' . $file . ' ' . $thumb;
        $check = $this->loadConsole($cmd);
        $txt = ob_get_contents();
        ob_end_clean();
        list($width, $height) = getimagesize($thumb);
        if ($width > $w) {
            $alt = $thumb . 'alt';
            rename($thumb, $alt);
            $cmd = 'convert -crop ' . $w . 'x' . $height . '+0+0 ' . $alt . ' ' . $thumb;
            $check = $this->loadConsole($cmd);
            unlink($alt);
        }
    }

    /**
    * Erstelle aus einer PDF ein Bild.
    *
    * @param $file String
    *
    * @example $_SERVER['']
    */
    public function makePdfToJpg($file, $width = 585, $height = 3000)
    {
        $grafik = str_replace('.pdf', '.jpg', $file);
        $temp = TEMP . rand(0, 999999999999999999999999999999999999) . '.png';
        $convert = 'convert -profile ' . LIBPATH . 'icc/cmyk/USWebCoatedSWOP.icc -profile ' . LIBPATH;
        $convert .= 'icc/rgb/AppleRGB.icc -density 72x72 ' . $file . '[0] ' . $temp;
        $this->loadConsole($convert);
        $convert = 'convert -density 72x72 ' . $temp . ' ' . $grafik;
        $this->loadConsole($convert);
        if (is_file($temp)) {
            unlink($temp);
        }
        if (is_file($grafik)) {
            $this->makeResizeImage($grafik, $width, $height);
            chmod($grafik, 0644);
        }
    }

    /**
     * @param $source
     * @param int $maxwidth
     * @param int $maxheight
     * @return bool
     */
    public function makeResizeImage($source, $maxwidth = 585, $maxheight = 3000)
    {
        list($width, $height) = getimagesize($source);

        /**
        * We need to get both ratios so we can
        * find which reduced height and width
        * will fix the max allowed dimensions.
        */
        $hRatio = $maxheight / $height;
        $wRatio = $maxwidth / $width;

        /**
        * Test Dimensions based on height reduction ratio.
        */
        $tHeightHR = $maxheight;
        $tWidthHR = ceil($hRatio * $width);

        /**
        * Test dimenstions based on width reduction ratio.
        */
        $tWidthWR = $maxwidth;
        $tHeightWR = ceil($wRatio * $height);
        if ($width < $maxwidth and $height < $maxheight) {
            echo 'Source already below maximum dimensions: ' . $source . " {$width}x{$height}\n";

            return false;
        }
        if ($tWidthHR <= $maxwidth) {
            $height = $tHeightHR;
            $width = $tWidthHR;
        }
        if ($tHeightWR <= $maxheight) {
            $height = $tHeightWR;
            $width = $tWidthWR;
        }
        $temp = TEMP . rand(0, 1000000);
        $cmd = 'mv ' . $source . ' ' . $temp;
        @exec($cmd);
        $cmd = "convert -resize {$width}x{$height} " . "\"{$temp}\" \"{$source}\" 2>&1";
        @exec($cmd, $output, $retvar);
        unlink($temp);
        if (0 != $retvar) {
            echo implode(' -- ', $output);

            return false;
        }

        return true;
    }

    /**
    * Checke ob es die Ordner gibt, und erstelle gegebenfalls den Ordner.
    *
    * @param $ordner array
    *
    * @return bool
    */
    public function checkFolder($ordner)
    {
        $fehler = [];
        $error = 0;
        foreach ($ordner as $key => $value) {
            $folder = PATH . '/' . $value;
            if (! is_dir($folder)) {
                $erstellt = @mkdir($folder, 0777);
                if (false === $erstellt) {
                    $fehler[] = $value;
                    $error = 1;
                }
            } else {
                $chmod = @chmod($folder, 0777);
                if (false === $chmod) {
                    echo '<p class="fehler">Kann im Ordner ' . $value . ' nicht schreiben!</p>';
                    $error = 1;
                }
            }
        }
        if (count($fehler) > 0) {
            echo '<p class="fehler">Konnte folgende Ordner nicht erstellen: ' . join(', ', $fehler) . '</p>';
        }

        return $error;
    }

    /**
    * Funktion zum Checken der Dateirechte.
    *
    * @param string $files
    *
    * @return string
    */
    public function checkFileChMod($files)
    {
        foreach ($files as $key => $value) {
            $file = PATH . '/' . trim($value);
            if (is_file($file)) {
                chmod($file, 0777);
            } else {
                $handle = fopen($file, 'a+');
                $text = '';
                if (false === fwrite($handle, $text)) {
                    echo '<p class="fehler">Kann Datei nicht erstellen!</p>';
                }
                fclose($handle);
                chmod($file, 0777);
            }
        }

        return false;
    }

    /**
    * Funktion zum löschen von Verzeichnissen rekusiv
    * Rueckgabewerte:
    * 0  - alles ok
    * -1 - kein Verzeichnis
    * -2 - Fehler beim Loeschen
    * -3 - Ein Eintrag eines Verzeichnisses war keine Datei und kein Verzeichnis und kein Link.
    */
    public function deleteFolder($path)
    {
        $path = trim($path);
        if (! is_dir($path)) {
            return -1;
        }
        $dir = @opendir($path);
        if (! $dir) {
            return -2;
        }
        while (($entry = @readdir($dir)) !== false) {
            if ('.' === $entry || '..' === $entry) {
                continue;
            }
            if (is_dir($path . '/' . $entry)) {
                $res = $this->deleteFolder($path . '/' . $entry);
                if (-1 === $res) {
                    @closedir($dir);

                    return -2; // normalen Fehler melden
                } elseif (-2 === $res) {
                    @closedir($dir);

                    return -2; // Fehler weitergeben
                } elseif (-3 === $res) {
                    // nicht unterstuetzer Dateityp?
                    @closedir($dir);

                    return -3; // Fehler weitergeben
                } elseif (0 != $res) {
                    // das duerfe auch nicht passieren...
                    @closedir($dir);

                    return -2; // Fehler zurueck
                }
            } elseif (is_file($path . '/' . $entry) || is_link($path . '/' . $entry)) {
                $res = @unlink($path . '/' . $entry);
                if (! $res) {
                    @closedir($dir);

                    return -2; // melde ihn
                }
            } else {
                @closedir($dir); // Verzeichnis schliessen

                return -3; // tut mir schrecklich leid...
            }
        }
        @closedir($dir);
        $res = @rmdir($path);
        if (! $res) {
            return -2;
        }

        return 0;
    }
}
