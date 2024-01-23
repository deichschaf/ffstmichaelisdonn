<?php

namespace App\Http\Traits;

use Illuminate\Support\Facades\DB;

trait ToolsTrait
{
    public static function compareTextPercent($a, $b)
    {
        return 1.0 - (levenshtein($a, $b) / max(strlen($a), strlen($b)));
    }

    public static function compareJSON($json1, $json2)
    {
        $it_1 = json_decode($json1, true);
        $it_2 = json_decode($json2, true);
        $result_array = array_diff($it_1, $it_2);

        if (empty($result_array[0])) {
            return true;
        }
        return $result_array[0];
    }

    /**
     * Undocumented function
     *
     * @param [type] $total
     * @param [type] $number
     * @return void
     */
    public static function getStaticPercentage($total, $number)
    {
        if ($total > 0) {
            return round(($number * 100) / $total, 2);
        } else {
            return 0;
        }
    }

    /**
     * @param array $dir
     * @param string $file
     *
     * @return mixed|string
     */
    public static function getStaticPublicFilePath($file, $folder = []): mixed
    {
        $path = '';
        if (count($folder) > 0) {
            $path = DIRECTORY_SEPARATOR . join(DIRECTORY_SEPARATOR, $folder);
        }
        $path .= DIRECTORY_SEPARATOR . $file;
        $path = public_path() . $path;
        $path = str_replace(
            DIRECTORY_SEPARATOR . 'laravel' . DIRECTORY_SEPARATOR . 'public',
            DIRECTORY_SEPARATOR . 'htdocs',
            $path
        );

        return $path;
    }

    public static function getStaticgetFacebookDescription($text)
    {
        $text = str_ireplace('<br>', "\n", $text);
        $text = str_ireplace('<p>', '', $text);
        $text = str_ireplace('</p>', "\n\n", $text);
        $text = strip_tags($text);

        return $text;
    }

    public static function SQLLogger()
    {
        DB::enableQueryLog();
    }

    public static function getStaticSQL(bool $all)
    {
        $queries = DB::getQueryLog();

        if (false === $all) {
            $last_query = end($queries);

            return $last_query;
        }

        return $queries;
    }

    public static function changeRowColor($old)
    {
        if ('green' === $old || 'darkgreen' === $old) {
            return 'white';
        } else {
            return 'green';
        }
    }

    /**
     * Function zum bauen des Tooltips.
     *
     * @param $word String
     * @param $text String
     *
     * @return string
     */
    public static function buildTolltip($word, $text)
    {
        if ('' === $word || '' === $text) {
            return $word;
        }
        $t = '<a href="javascript:void(0)" onmouseover="Tip(';
        $t .= "'" . $text . "'";
        $t .= ')" onmouseout="UnTip()">';
        $t .= $word;
        $t .= '</a>';

        return $t;
    }

    public static function getStaticShort($text, $limit = 10)
    {
        $monate = [
            'Januar',
            'Februar',
            'März',
            'April',
            'Mai',
            'Juni',
            'Juli',
            'August',
            'September',
            'Oktober',
            'November',
            'Dezember'
        ];
        $text = str_replace(' (pid).', ' (pid)', $text);
        $text = str_replace('."', '". ', $text);
        $text = str_replace(' Dr. ', ' Dr_ ', $text);
        $text = str_replace('St.Peter-Ording', 'St_Peter-Ording', $text);
        $text = str_replace('St. Peter-Ording', 'St_Peter-Ording', $text);
        /*
        * Das nicht einfach der Monat weggeschnitten wird!
        */
        foreach ($monate as $key => $monat) {
            $text = str_replace('. ' . $monat, '.' . $monat, $text);
        }
        $text = explode('. ', $text);
        $y = count($text);
        if (1 === $y) {
            $text = $text[0] . '.';
        } elseif ($y >= 2) {
            $pattern = '/<br>|<\/p>/';
            $text = $text[0] . '.' . $text[1] . '.';
        } else {
            $text = '';
        }

        /*
        * Das nicht einfach der Monat weggeschnitten wird!
        */
        foreach ($monate as $key => $monat) {
            $text = str_replace('.' . $monat, '. ' . $monat, $text);
        }
        $text = str_replace(' Dr_ ', ' Dr. ', $text);
        $text = str_replace(' d_R_ ', ' d.R. ', $text);
        $text = str_replace(' e_V_ ', ' e.V. ', $text);
        $text = str_replace(' e__V_ ', ' e. V. ', $text);
        $text = str_replace(' d__R_ ', ' d. R. ', $text);
        $text = str_replace('St_Peter-Ording', 'St. Peter-Ording', $text);
        $text = trim($text);
        if ('.' === $text) {
            $text = '';
        }

        return $text;
    }

    public static function getStaticToolsBuildUrl($link)
    {
        $link = trim($link);
        if ('' === $link || 'NULL' === $link || null === $link) {
            return '';
        }
        if ('index' === substr($link, 0, 5)) {
            return '/' . $link;
        }
        if (!preg_match('/http:/', $link)) {
            if (!preg_match('/http:/', $link) && preg_match('/www/', $link)) {
                $link = 'http://' . $link;
            }
            if (!preg_match("/http:\/\/www./", $link)) {
                $link = 'http://www.' . $link;
            }
        }

        return $link;
    }

    public static function buildRows($trs, $class_change = 0)
    {
        if (!is_array($trs)) {
            return;
        }
        if (0 === count($trs)) {
            return;
        }

        $build = '';
        $class = 'green';

        foreach ($trs as $key => $tr) {
            if (is_array($tr)) {
                if (count($tr) > 0) {
                    if (array_key_exists('title', $tr)) {
                        $build .= '<div class="row clearfix">';
                        $build .= '<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 column darkgreen">' .
                            $tr['title'] . '</div>';
                        $build .= '</div>';

                        $class = 'green';
                    } else {
                        $i = 0;
                        $build .= '<div class="row clearfix';
                        if ('1' === $class_change) {
                            if ('green' === $class) {
                                $class = 'white';
                            } else {
                                $class = 'green';
                            }
                            $build .= ' ' . $class;
                        }
                        $build .= '"';
                        if (array_key_exists('id', $tr)) {
                            $build .= ' id="' . $tr['id'] . '"';
                            unset($tr['id']);
                        }
                        $build .= '>';
                        $c = count($tr);
                        $rowsize = 12 / $c;
                        $build .= '<div class="col-lg-' . $rowsize . ' col-md-' . $rowsize . ' col-sm-' . $rowsize . '
                        col-xs-' . $rowsize . '
                        column">' . join('</div><div
                        class="col-lg-' . $rowsize . ' col-md-' . $rowsize . ' col-sm-' . $rowsize . '
                        col-xs-' . $rowsize . '
                        column">', $tr) . '</div>';
                        $build .= '</div>';
                    }
                }
            } else {
                $build .= '<div class="row clearfix';
                if ('1' === $class_change) {
                    if ('1' === $class_change) {
                        if ('green' === $class) {
                            $class = 'white';
                        } else {
                            $class = 'green';
                        }
                        $build .= ' ' . $class;
                    }
                }
                $build .= '">';
                $build .= '<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 column">' . $tr . '</div>';
                $build .= '</div>';
            }
        }

        return $build;
    }

    /**
     * Ab hier Dateibehandlung.
     */
    public static function filesize($URL)
    {
        $URL = trim($URL);
        if ('' === $URL) {
            return '';
        }
        if (!is_file($URL)) {
            return '';
        }
        $Groesse = filesize($URL);

        if ($Groesse < 1000) {
            return number_format($Groesse, 0, ',', '.') . ' Bytes';
        } elseif ($Groesse < 1000000) {
            return number_format($Groesse / 1024, 0, ',', '.') . ' kB';
        } else {
            return number_format($Groesse / 1048576, 1, ',', '.') . ' MB';
        }
    }

    /*   public static function getStaticFileType($filename)
       {
           $filename = trim($filename);
           if ('' === $filename) {
               return '';
           }
           $result = explode('.', $filename);
           $endung = strtolower($result[(count($result) - 1)]);

           return $endung;
       }*/

    public static function getStaticFileIcon($filename)
    {
        $filetype = self::getStaticFileType($filename);
        $filetype = trim($filetype);
        if ('' === $filetype) {
            return '';
        }
        $filetype = strtolower($filetype);
        switch ($filetype) {
            /* Word + Texte */
            case 'doc':
            case 'txt':
            case 'dot':
                $image = 'word.png';
                $alt = 'Word-Dokument';
                break;
                /* Word 2007/2010 + Texte */
            case 'docx':
                $image = 'docx.png';
                $alt = 'Word 2007-Dokument';
                break;
                /* Webseiten */
            case 'htm':
            case 'html':
                $image = 'html.png';
                $alt = 'Online-Dokument';
                break;
                /* Musik + Audio Dateien */
            case 'wav':
            case 'mp3':
                $image = 'sound.png';
                $alt = 'Audio-Datei';
                break;
                /* Video */
            case 'avi':
            case 'asf':
            case 'mpg':
            case 'swf':
            case 'mpeg':
                $image = 'film.png';
                $alt = 'Film-Datei';
                break;
                /* PDF */
            case 'pdf':
                $image = 'pdf.png';
                $alt = 'PDF-Dokument';
                break;
                /* PowerPoint */
            case 'ppt':
            case 'pps':
            case 'ppz':
            case 'pcb':
            case 'pot':
            case 'pcs':
            case 'pot':
            case 'ppa':
            case 'ppi':
                $image = 'powerpoint.png';
                $alt = 'PowerPoint-Präsentation';
                break;
                /* PowerPoint 2007 */
            case 'pptx':
                $image = 'pptx.png';
                $alt = 'PowerPoint 2007 -Präsentation';
                break;
                /* Excel */
            case 'xls':
            case 'xlt':
                $image = 'excel.png';
                $alt = 'Excel-Dokument';
                break;
                /* Excel 2007 */
            case 'xlsx':
                $image = 'xlsx.png';
                $alt = 'Excel 2007 -Dokument';
                break;
                /* Komprimierte Dateien */
            case 'rar':
            case 'gzip':
            case 'tar':
            case 'zip':
            case 'gz':
            case 'z':
                $image = 'zip.png';
                $alt = 'Komprimierte-Datei';
                break;
                /* Bilder und Sonstige */
            default:
                $image = 'picture.png';
                $alt = 'Bild';
                break;
        }
        $file = '<img src="/grfx/' . $image . '" border="0" class="icon" title="' . $alt . '" alt="' . $alt . '">';

        return $file;
    }

    public static function checkFileDelete($path, $file, $delete = 0)
    {
        if ('' === $file || 'NULL' === $file || null === $file) {
            return '';
        }

        $url = str_replace('/', DIRECTORY_SEPARATOR, $path);

        $url = public_path() . $url . $file;
        $url = str_replace('laravel' . DIRECTORY_SEPARATOR . 'public', 'htdocs', $url);
        //$url = str_replace('/laravel/htdocs', '/htdocs', $url);
        //$url = str_replace('\laravel\htdocs', '\htdocs', $url);
        //self::debug($url, 1);
        /*
        if (!is_file($url)){
            echo '<pre>';
            echo 'Class: '.__CLASS__.'<br>';
            echo 'Function: '.__FUNCTION__.'<br>';
            echo 'Function: '.__FUNCTION__.'<br>';
            echo 'LINE: '.__LINE__.'<br>';
            echo 'Ist keine Datei';
            echo '</pre>';
            return '';
        }*/
        if (1 === $delete) {
            unlink($url);

            return 'gelöscht';
        }

        return $path . $file;
    }

    public static function debug($debug, $exit = 0)
    {
        echo '<pre>';
        print_r($debug);
        echo '</pre>';
        if (1 === $exit) {
            exit();
        }
    }

    /**
     * Gibt das Datum als dd.mm.YY HH:ii zurück.
     *
     * @param string $datum
     *
     * @return string
     */
    public static function getStaticDatumZeit($datum)
    {
        $datum = trim($datum);
        if ('' === $datum || null === $datum) {
            return;
        }
        $datum = explode(' ', $datum);
        $tag = explode('-', $datum[0]);
        if (3 !== count($tag)) {
            echo "<p class='fehler'>";
            echo "Datum wurde falsch eingeben! Bitte folgendes Format nutzen: 0000-00-00 00:00:00</p>";

            return '00.00.0000 00:00';
        }
        $tag = $tag[2] . '.' . $tag[1] . '.' . $tag[0];
        $zeit = explode(':', $datum[1]);
        if (3 !== count($zeit)) {
            echo "<p class='fehler'>";
            echo "Datum wurde falsch eingeben! Bitte folgendes Format nutzen: 0000-00-00 00:00:00</p>";

            return '00.00.0000 00:00';
        }
        $zeit = $zeit[0] . ':' . $zeit[1];

        return $tag . ' ' . $zeit;
    }

    public static function makeGermanDateTime($datetime)
    {
        if ('0000-00-00 00:00:00' === $datetime) {
            return '';
        }
        $datetime = explode(' ', $datetime);
        $date = explode('-', $datetime['0']);
        $time = explode(':', $datetime['1']);

        return $date['2'] . '.' . $date['1'] . '.' . $date['0'] . ' ' . $time['0'] . ':' . $time['1'];
    }

    public static function getStaticDatumEn($datum)
    {
        $datum = trim($datum);
        if ('' === $datum) {
            return '';
        }
        $date = explode('.', $datum);

        return $date['2'] . '-' . $date['1'] . '-' . $date['0'];
    }

    /**
     * Gibt das deutsche Datum zurück.
     *
     * @param
     *           englisch
     *
     * @return deutsch
     */
    public static function getStaticDatumDe($datum)
    {
        $datum = trim($datum);
        $alt = $datum;

        /**
         * Überprüft ob es schon das deutsche Datumsformat ist, wenn ja -> ausgeben.
         */
        $date = explode('.', $datum);
        if ((2 === strlen($date['0'])) || ((1 === strlen($date['0'])))) {
            if ((1 === strlen($date['1'])) || (2 === strlen($date['1']))) {
                if ((2 === strlen($date['2'])) || (4 === strlen($date['2']))) {
                    return $datum;
                }
            }
        }

        if ('' === $datum || null === $datum || 'NULL' === $datum || '0000-00-00' === $datum) {
            return '';
        }
        $datum = explode('-', $datum);
        if (3 !== count($datum)) {
            echo "<p class='fehler'>Datum wurde falsch eingeben! Bitte folgendes Format nutzen: 0000-00-00</p>";
            echo '<p class="fehler">Es wurde <i>' . $alt . '</i> eingegeben!</p>';

            return '00.00.0000';
        }
        $datum = $datum[2] . '.' . $datum[1] . '.' . $datum[0];

        return $datum;
    }

    public static function getStaticWochentag($Datum)
    {
        $Datum = trim($Datum);
        if ('' === $Datum) {
            return '-1';
        }
        $Tage = ['So', 'Mo', 'Di', 'Mi', 'Do', 'Fr', 'Sa'];
        if (is_string($Datum)) {
            $Tag = (int)substr($Datum, 0, 2);
            $Monat = (int)substr($Datum, 3, 2);
            $Jahr = (int)substr($Datum, 6, 4);
            if (checkdate($Monat, $Tag, $Jahr)) {
                $Datum = mktime(0, 0, 0, $Monat, $Tag, $Jahr);
                $Tag = date('w', $Datum);
                $Datum_komplett = $Tage[$Tag];

                return $Datum_komplett;
            } else {
                return -1;
            }
        }
    }

    public static function makeDatum($beginn, $end)
    {
        $datum = self::getDatumDe($beginn);
        $datum = self::getWochentag($datum) . ', ' . $datum;
        if ('0000-00-00' !== $end && $end !== $beginn) {
            $datum2 = self::getDatumDe($end);
            $datum .= ' - ' . self::getWochentag($datum2) . ', ' . $datum2;
        }

        return $datum;
    }

    public static function makeZeit($beginn, $end)
    {
        $zeit = self::zeit($beginn);
        if ('55:55:55' !== $end && $end !== $beginn) {
            $zeit .= ' - ' . self::zeit($end);
        }

        return $zeit;
    }

    public static function zeit($zeit, $default = '55:55:55')
    {
        $zeit = trim($zeit);
        $zeit = str_replace(',', '.', $zeit);
        $zeit = str_replace(' ', '', $zeit);
        $zeit = str_replace('.', ':', $zeit);
        if ('' === $zeit || null === $zeit || 'NULL' === $zeit || '55:55:55' === $zeit) {
            return '';
        }
        $zeit = explode(':', $zeit);
        if (1 === strlen($zeit['0'])) {
            $zeit['0'] = '0' . $zeit['0'];
        }
        if (count($zeit) > 1) {
            if (1 === strlen($zeit['1'])) {
                $zeit['1'] = '0' . $zeit['1'];
            }
        } else {
            $zeit['1'] = '00';
        }
        $zeit = $zeit['0'] . ':' . $zeit['1'];

        return $zeit;
    }

    public static function getStaticGeburtstag($geburtstag, $sichtbar)
    {
        $geburtstag = self::getDatumDe($geburtstag);
        if ('' !== $geburtstag && '1' === $sichtbar) {
            $bday = explode('.', $geburtstag);
            $geburtstag = $bday['0'] . '.' . $bday['1'] . '.';
        } else {
            $geburtstag = '&nbsp;';
        }

        return $geburtstag;
    }

    public static function getStaticSkype($skype)
    {
        if ('' !== $skype) {
            $skype = '<a href="skype:' . $skype . '?userinfo">' . $skype . '</a>';
        } else {
            $skype = '&nbsp;';
        }

        return $skype;
    }

    /**
     * Script zum Testen ob bestimmte Funktionen auf dem Server existieren.
     *
     * @author Jörg-Marten Hoffmann 2012
     *
     * @version 1.0
     *
     * @var unknown_type
     */
    public static function getStaticToolsCheckSystem()
    {
        $functionen = get_defined_functions();
        $aktiv = [];
        $deaktiviert = [];
        foreach ($functionen as $key => $val) {
            if (function_exists($val)) {
                $aktiv[] = $val;
            } else {
                $deaktiviert[] = $val;
            }
        }
        $on = 'Sind verfügbar:' . join(', ', $aktiv);
        $off = 'Sind nicht verfügbar:' . join(', ', $deaktiviert);

        return $on . '<br />' . $off;
    }

    /**
     * Generiert ein Passwort.
     *
     * @example echo generatePW(10); // 10stelliges Passwort ausgeben...
     *
     * @param int $length
     * @param int $strong
     *                    // Wie schwer soll das Passwort sein?
     *
     * @return string
     */
    public static function generateChiffre($length = 8, $strong = '')
    {
        $length = trim($length);
        if (!is_numeric($length)) {
            $length = 8;
        }
        $strong = trim($strong);
        switch ($strong) {
            case '1':
                $dummy = array_merge(range('0', '9'), range('a', 'z'), range('A', 'Z'));
                break;
            case '2':
                $dummy = array_merge(range('0', '9'), range('a', 'z'), range('A', 'Z'), [
                    '#',
                    '&',
                    '@',
                    '$',
                    '_',
                    '%',
                    '?',
                    '+',
                    '!',
                ]);
                break;
            default:
                $dummy = array_merge(range('0', '9'), range('A', 'Z'));
        }

        mt_srand((float)microtime() * 1000000);
        for ($i = 1; $i <= (count($dummy) * 2); ++$i) {
            $swap = mt_rand(0, count($dummy) - 1);
            $tmp = $dummy[$swap];
            $dummy[$swap] = $dummy[0];
            $dummy[0] = $tmp;
        }

        return substr(implode('', $dummy), 0, $length);
    }

    public static function createRandAdminKey($benutzer, $password, $admin_id)
    {
        $benutzer = trim($benutzer);
        $password = trim($password);
        $admin_id = trim($admin_id);
        $password = $benutzer . $password . $admin_id;
        $password = self::hashPassword($password);

        return $password;
    }

    public static function hashPassword($password)
    {
        $password = trim($password);
        $salt = 'adminpassword';
        // encrypt the password, rotate characters by length of original password
        $len = strlen($password);
        $password = md5($password);
        $password = self::rotateHEX($password, $len);

        return md5($salt . $password);
    }

    public static function rotateHEX($string, $n)
    {
        $string = trim($string);
        $n = trim($n);
        $chars = 'abcdefghijkmnopqrstuvwxyz023456789';
        $str = '';
        for ($i = 0; $i < strlen($string); ++$i) {
            $pos = strpos($chars, $string[$i]);
            $pos += $n;
            if ($pos >= strlen($chars)) {
                $pos = $pos % strlen($chars);
            }
            $str .= $chars[$pos];
        }

        return $str;
    }

    /**
     * Funktion zum Generieren eines sicheren Passwortes
     * Es wird überprüft ob der String leer ist oder nicht
     * Es wird auch überprüft ob die gewünschte Verschlüsselung vorhanden ist.
     *
     * @param $txt String
     * @param $verschluesselung String
     *
     * @return $txt String
     */
    public static function password($txt, $verschluesselung = 'md5')
    {
        $txt = trim($txt);
        if ('' === $txt) {
            echo '<p class="fehler">Es wurde kein Passwort eingegeben!<p>';

            return '';
        }

        if ('md5' === $verschluesselung) {
            if (!function_exists('md5')) {
                $verschluesselung = 'sha1';
            }
        }
        if ('sha1' === $verschluesselung) {
            if (!function_exists('sha1')) {
                if (!function_exists('md5')) {
                    return $txt;
                }
                $verschluesselung = 'md5';
            }
        }

        switch ($verschluesselung) {
            case 'sha1':
                $txt = sha1($txt);
                break;
            case 'md5':
                $txt = md5($txt);
                break;
            default:
                $txt = md5($txt);
        }

        return $txt;
    }

    /***
     * @param $txt
     * @return  string
     */
    public static function checkChar($txt)
    {
        $txt = trim($txt);

        return $txt;
    }

    /**
     * Undocumented function
     *
     * @param [type] $total
     * @param [type] $number
     * @return void
     */
    public function getPercentage($total, $number)
    {
        if ($total > 0) {
            return round(($number * 100) / $total, 2);
        } else {
            return 0;
        }
    }
}
