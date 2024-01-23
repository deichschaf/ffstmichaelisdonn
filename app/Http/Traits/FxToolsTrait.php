<?php

/** @noinspection PhpMissingReturnTypeInspection */

namespace App\Http\Traits;

/**
 * Klasse wo die wichtigen Tools zu finden sind.
 *
 * @version 1.9
 *
 * @author Jörg-Marten Hoffmann
 * @copyright Jörg-Marten Hoffmann 2010-2019
 *
 * @todo Alle Zeit und Datums Funktionen in die Class Time verschieben und Per Time:: aufrufen
 * @todo lassen von dieser Klasse aus
 *
 *  Änderungen
 *  2012-06-02  Funktion makeFileChar um den Parameter $lower erweitert, damit nicht immer alles Kleingeschrieben wird
 *  2012-06-02  Funktion Titel_Link hinzugefügt
 *  2012-05-18  Alle FX-Basics wieder zusammengeführt zu dieser Dateiversion
 *  2012-05-18  Funktion makeInternetFileName erstellt und auf makeFileChar umgeleitet (alt von KLV)
 *  2012-05-18  Funktion makeCharReplace um & -> &amp; erweitert
 *  2012-05-10  Function buildTrs() Abfrage auf ID hinzugefügt
 *  2012-02-07  Function makeRoemischeZahlen($zahl) hinzugefügt
 *  2012-01-31  Function getDatumDe erweitert mit einer Abfrage, ob man das deutsche Datumsformat übergeben hat.
 *  2012-01-11  Function buildTrs um 1 Test erweitert
 *  2012-01-09  Function checkCheckbox um 2 Tests erweitert
 *  2011-09-19  Function makeCsvReplace hinzugefügt
 *  2011-09-19  Fuction getActiontxt hinzugefügt
 *  2011-09-16  Function buildSelect um ID und onChange erweitert und die Felder nun als dynamischees Array gebaut
 *  2011-09-10  Funktion checkCheckbox($i,$j) erweitert auf eine Array abfrage
 *  2011-06-09  SystemTools::makeThumbNail($file,$thumb,$w,$h) um eine weite Abfrage erweitert, damit das Bild gekürzt
 *              wird, wenn es sich nicht verkleiner läßt
 *  2011-06-09  Bei einigen Funktionen trim() eingebaut
 *  2011-06-09  monat($datum) - Fehlerabfangen eingebaut
 *  2011-06-09  buildShortUrl() - Function_exists Curl angepasst
 *  2011-06-09  buildSelect($values, $select, $name, $size='') hinzugefügt
 *  2011-05-19  buildTable geändert
 *  2011-05-05  password($txt, $verschlüsselung) Sicheres Passwort erstellen
 *  2011-03-01  makeDateDayMonthDe($datum) eingebaut um das Datum mit nur Tag und Monat zu erhalten
 *  2011-03-01  Cache des CMS verbessert und hier eingebaut
 *  2011-02-25  generateChiffre($length=8, $strong='') erweitert auf die Passwort stärke (switch..)
 *  2011-02-25  Klasse SimpleBBCode hinzugefügt
 *  2011-02-25  check_text($txt) Checkt ob der Text leer ist ansonsten zeige den Text an.
 *  2011-02-25  make_zahl_stellen($zahl, $len=2, $max='') - Kontrolliert ob eingegebene Zahl eine Zahl ist und
 *              im Max Rahmen bleibt
 *  2011-02-18  check_is_file($file) - Checkt ob die Datei vorhanden ist
 *  2011-02-13  Make Latain1 to UTF-8
 *  2011-02-11  Gedankenstrich bei makeCharReplace eingebaut
 *  2011-01-31  Systemtools::makeThumbNail($file,$thumb,$w,$h) hinzugefügt, um mit IM Bilder on the Fly
 *              runterzurechnen
 *  2011-01-24  FX-Basic aufgeräumt und auskommentiere Funktionen entfernt
 *  2011-01-21  Time::check_datum() hinzugefügt, um zu prüfen ob das angegebene Datum existiert
 *  2011-01-20  Tools::check_zahlen($zahl, $len) eingebaut, um zu prüfen ob die länge entspricht beim Datum
 *  2011-01-12  FX-Basic wieder zusammengefasst aus allen neuen Versionen
 *  2010-12-16  Beim Datum hinzugefügt was verkehrt übermittelt wurde.
 *  2010-11-30  Abfrage ob MYSQL Befehle eingegeben werden check_mysql_exit($text)
 *  2010-11-26  Zeitdifferenzen berechnen Time::zeitspanne
 *  2010-11-26  Beim Datum und der Zeit das Komma in ein richtigs Format bringen
 *  2010-11-19  Funktion makeWysiwygReplace erweitert - Abfrage ob <br> am Ende und ob Leer - Löschen bzw. Beenden
 *  2010-11-19  PDF to JPG eingebaut (Systemtools) Um aus einer PDF eine JPG zu machen
 *  2010-11-10  Funktion makeWysiwygReplace erweitert, um aus (c) und (r) die Sonderzeichen &copy; und &reg; zu machen!
 *  2010-09-15  Funktion buildShortUrl eingebaut, damit man eine TinyUrl erstellen kann on-the-fly
 *  2010-09-14  Funktion Zeit um eine Schleife erweitert, wenn Zeit nur Stunde, dann automatisch 00 bei Minuten
 *  2010-09-06  &shy; - Silbentrennungsstrich entfernen
 *  2010-09-06  FX-Basics zusammengefasst aus allen Versionen eine aktuelle Fassung
 *  2010-05-28  Makiere Wort erneuert
 *  2009-11-24  Trim in fast jeder Funktion eingebaut
 *  2009-11-24  UPLOAD über FTP Zugang
 */
trait FxToolsTrait
{
    public static function makegetFacebookDescription($text)
    {
        $text = str_ireplace('<br>', "\n", $text);
        $text = str_ireplace('<p>', "", $text);
        $text = str_ireplace('</p>', "\n\n", $text);
        $text = strip_tags($text);
        return $text;
    }

    public static function SQLLogger()
    {
        DB::enableQueryLog();
    }

    public static function getStaticSQL($all = false)
    {
        $queries = DB::getQueryLog();

        if ($all === false) {
            $last_query = end($queries);
            return $last_query;
        }

        return $queries;
    }

    /**
     * Function zum bauen des Tooltips
     * @param $word String
     * @param $text String
     * @return String
     */
    public static function getStaticBuildToolTipStatic($word, $text)
    {
        if ($word == '' || $text == '') {
            return $word;
        }
        $t = '<a href="javascript:void(0)" onmouseover="Tip(';
        $t .= "'" . $text . "'";
        $t .= ')" onmouseout="UnTip()">';
        $t .= $word;
        $t .= '</a>';
        return $t;
    }

    public static function makeToolsBuildUrl($link)
    {
        $link = trim($link);
        if ($link === '' || $link === 'NULL' || $link === null) {
            return '';
        }
        if (substr($link, 0, 5) === 'index') {
            return '/' . $link;
        }
        if (!preg_match("/http:/", $link)) {
            if (!preg_match("/http:/", $link) && preg_match("/www/", $link)) {
                $link = "http://" . $link;
            }
            if (!preg_match("/http:\/\/www./", $link)) {
                $link = "http://www." . $link;
            }
        }
        return $link;
    }

    public static function makeBuildUrl($trs, $class_change = 0)
    {
        if (!is_array($trs)) {
            return;
        }
        if (count($trs) === 0) {
            return;
        }

        $build = '';
        $class = 'green';

        foreach ($trs as $key => $tr) {
            if (is_array($tr)) {
                if (count($tr) > 0) {
                    if (array_key_exists('title', $tr)) {
                        $build .= '<div class="row clearfix">';
                        $build .= '<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 column darkgreen">';
                        $build .= $tr ['title'] . '</div>';
                        $build .= '</div>';

                        $class = 'green';
                    } else {
                        $i = 0;
                        $build .= '<div class="row clearfix';
                        if ($class_change === '1') {
                            if ($class === 'green') {
                                $class = 'white';
                            } else {
                                $class = 'green';
                            }
                            $build .= ' ' . $class;
                        }
                        $build .= '"';
                        if (array_key_exists('id', $tr)) {
                            $build .= ' id="' . $tr ['id'] . '"';
                            unset($tr ['id']);
                        }
                        $build .= '>';
                        $c = count($tr);
                        $rowsize = 12 / $c;
                        $build .= '<div class="col-lg-' . $rowsize . ' col-md-' . $rowsize . ' col-sm-' . $rowsize;
                        $build .= 'col-xs-' . $rowsize . ' column">';
                        $trenner = '</div><div class="col-lg-' . $rowsize . ' col-md-' . $rowsize . ' col-sm-'
                            . $rowsize . ' col-xs-' . $rowsize . ' column">';
                        $build .= implode($trenner, $tr) . '</div>';
                        $build .= '</div>';
                    }
                }
            } else {
                $build .= '<div class="row clearfix';
                if ($class_change === '1') {
                    if ($class_change === '1') {
                        if ($class === 'green') {
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
     * Datum ausgeschrieben.
     *
     * @param string $datum
     *
     * @return 01. September 2009
     */
    public static function getStaticDatumAusgeschrieben($datum)
    {
        $datum = trim($datum);
        $datum = str_replace(',', '.', $datum);
        if ('' === $datum || '00.00.0000' === $datum || 'NULL' === $datum || null === $datum) {
            return '';
        }
        $datum = explode('.', $datum);
        if (3 !== count($datum)) {
            echo "<p class='fehler'>Datum wurde falsch eingeben! Bitte folgendes Format nutzen: 00.00.0000</p>";

            return '';
        }
        $m = self::monat($datum['1']);
        $datum = $datum[0] . '. ' . $m . ' ' . $datum[2];

        return $datum;
    }

    /**
     * Gibt den Monatsnamen ausgeschrieben wieder.
     */
    public static function getStaticMonat($monat)
    {
        $monat = trim($monat);
        if (!is_numeric($monat)) {
            return '!!!! FEHLER !!!!';
        }
        if ($monat < 1 || $monat > 12) {
            return '!!!! FEHLER !!!!';
        }
        if (1 === strlen($monat)) {
            $monat = '0' . $monat;
        }
        switch ($monat) {
            case '01':
                $monat = 'Januar';
                break;
            case '02':
                $monat = 'Februar';
                break;
            case '03':
                $monat = 'M&auml;rz';
                break;
            case '04':
                $monat = 'April';
                break;
            case '05':
                $monat = 'Mai';
                break;
            case '06':
                $monat = 'Juni';
                break;
            case '07':
                $monat = 'Juli';
                break;
            case '08':
                $monat = 'August';
                break;
            case '09':
                $monat = 'September';
                break;
            case '10':
                $monat = 'Oktober';
                break;
            case '11':
                $monat = 'November';
                break;
            case '12':
                $monat = 'Dezember';
                break;
            default:
                $monat = '!!!! FEHLER !!!!';
                break;
        }

        return $monat;
    }

    public static function makeHighlightHtml($tmpCode)
    {
        if (!defined('HLH_TAG')) {
            # Highlight-Farben
            define('HLH_TAG', '#d02'); // HTML-Tag
            define('HLH_ATTR', '#00d'); // HTML-Tag-Attribut
            define('HLH_ATTR_VAL', '#090'); // HTML-Tag-Attribut-Wert
            define('HLH_JS', '#399'); // JavaScript
            define('HLH_PHP', '#970'); // PHP
            define('HLH_COMM', '#777'); // HTML-Kommentar
            define('HLH_ENT', '#e60'); // Entity
        }
        $tmpCode = htmlspecialchars($tmpCode);

        $tmpCode = str_replace("\t", '    ', $tmpCode);
        $tmpCode = str_replace(' ', '&nbsp;', $tmpCode);
        $tmpCode = str_replace('=', '&#61;', $tmpCode);
        # PHP-Code
        $tmpCode = preg_replace_callback('~&lt;\?(.*?)\?&gt;~is', 'self::makeHlhHtmlPhp', $tmpCode);
        # Javascript
        $tmpCode = preg_replace_callback(
            '~&lt;script(.*?)&gt;(.*?)&lt;/script&gt;~is',
            'self::makeHlhHtmlJs',
            $tmpCode
        );
        # Kommentar
        $tmpCode = preg_replace_callback('~&lt;!--(.*?)--&gt;~is', 'self::makeHlhHtmlComm', $tmpCode);
        # Start-Tag (ohne Attribute)
        $tmpCode = preg_replace(
            '~&lt;([a-z!]{1}[a-z0-9]{0,})&gt;~is',
            '<span style="color:' . HLH_TAG . '">&lt;$1&gt;</span>',
            $tmpCode
        );
        # Start-Tag
        $tmpCode = preg_replace_callback(
            '~&lt;([a-z!]{1}[a-z0-9]{0,})&nbsp;(.*?)&gt;~is',
            'self::makeHlhHtmlTag',
            $tmpCode
        );
        # End-Tag
        $tmpCode = preg_replace(
            '~&lt;\/([a-z]{1}[a-z0-9]{0,})&gt;~is',
            '<span style="color:' . HLH_TAG . '">&lt;/$1&gt;</span>',
            $tmpCode
        );
        # Entity
        $tmpCode = preg_replace(
            '~&amp;([#a-z0-9]{1,20});~i',
            '<span style="color:' . HLH_ENT . '">&amp;$1;</span>',
            $tmpCode
        );

        $tmpCode = nl2br($tmpCode);
        //return '<code>' . $tmpCode . '</code>';
        $tmpCode = str_replace('&amp;gt;', '>', $tmpCode);
        $tmpCode = str_replace('&amp;lt;', '<', $tmpCode);
        return $tmpCode;
    }

    public static function makeHlhHtmlTag($code)
    {
        # Callback für Start-Tags
        $tag_name = $code[1];
        $tag_fill = $code[2];
        $tmp_tag = '&lt;<span style="color:' . HLH_TAG . '">' . $tag_name . '</span>&nbsp;';
        $tmp_tag .= preg_replace_callback(
            '~([a-z-]+)&#61;([a-z0-9]{1,}|&quot;(.*?)&quot;|\'(.*?)\')~i',
            'self::makeHlhHtmlTagattr',
            $tag_fill
        );
        $tmp_tag .= '&gt;';
        return $tmp_tag;
    }

    public static function makeHlhHtmlTagattr($code)
    {
        # Callback für Attribute
        $attr_name = $code[1];
        $attr_valwq = $code[2];
        $string = '<span style="color:' . HLH_ATTR . '">' . $attr_name;
        $string .= '</span>&#61;<span style="color:' . HLH_ATTR_VAL . '">' . $attr_valwq . '</span>';
        return $string;
    }

    public static function makeHlhHtmlJs($code)
    {
        # Callback für Javascript
        $tag_fill = $code[1];
        $jsCode = $code[2];
        $jsCode = str_replace('&lt;', '&#60;', $jsCode);
        $jsCode = str_replace('&gt;', '&#62;', $jsCode);
        $jsCode = str_replace('&amp;', '&#38;', $jsCode);
        $string = '&lt;script' . $tag_fill . '<span style="color:' . HLH_JS . '">&gt;';
        $string .= $jsCode . '&lt;/script&gt;</span>';
        return $string;
    }

    public static function makeHlhHtmlPhp($code)
    {
        # Callback für PHP
        $phpCode = $code[1];
        $phpCode = str_replace('&lt;', '&#60;', $phpCode);
        $phpCode = str_replace('&gt;', '&#62;', $phpCode);
        $phpCode = str_replace('&amp;', '&#38;', $phpCode);
        $phpCode = str_replace('&quot;', '&#34;', $phpCode);
        $phpCode = str_replace("'", '&#39;', $phpCode);
        return '<span style="color:' . HLH_PHP . '">&#60;?' . $phpCode . '?&#62;</span>';
    }

    public static function makeHlhHtmlComm($code)
    {
        # Callback für Kommentare
        $phpCode = $code[1];
        $phpCode = str_replace('&lt;', '&#60;', $phpCode);
        $phpCode = str_replace('&gt;', '&#62;', $phpCode);
        $phpCode = str_replace('&amp;', '&#38;', $phpCode);
        return '<span style="color:' . HLH_COMM . '">&#60;!--' . $phpCode . '--&#62;</span>';
    }

    /**
     * @param $datum
     * @return string
     */
    public static function makeDatumDeStatic($datum)
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

    public static function makeGermanDateTime($datetime)
    {
        if ($datetime === '0000-00-00 00:00:00') {
            return '';
        }
        $datetime = explode(' ', $datetime);
        $date = explode('-', $datetime['0']);
        $time = explode(':', $datetime['1']);
        return $date['2'] . '.' . $date['1'] . '.' . $date['0'] . ' ' . $time['0'] . ':' . $time['1'];
    }

    public static function makeENGDateTime($datetime)
    {
        if ($datetime === '00.00.0000 00:00:00' || $datetime === '') {
            return '0000-00-00 00:00:00';
        }
        $datetime = explode(' ', $datetime);
        $date = explode('.', $datetime['0']);
        $time = explode(':', $datetime['1']);
        return $date['2'] . '-' . $date['1'] . '-' . $date['0'] . ' ' . $time['0'] . ':' . $time['1'] . ':00';
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
     * @param $number
     * @return array|string|string[]
     */
    public static function makeTrimPhoneNumber($number)
    {
        return str_replace(' ', '', $number);
    }

    public static function makeReadableFNNumber($number)
    {
        if (strlen($number) !== 9) {
            return $number;
        }
        $txt = substr($number, 0, 2) . '.';
        $txt .= substr($number, 2, 2) . '.' . substr($number, 5, 4);
        return $txt;
    }

    /***
     * @param $message
     * @return array|string|string[]
     */
    public static function makeCharReplaceOffStatic($message)
    {
        $message = trim($message);
        if ('' == $message) {
            return '';
        }
        $message = str_replace('&shy;', '', $message);
        $message = str_replace('<BR>', "\n", $message);
        $message = str_replace('<br>', "\n", $message);
        $message = str_replace('&sect;', '§', $message);
        $message = str_replace('&Auml;', 'Ä', $message);
        $message = str_replace('&auml;', 'ä', $message);
        $message = str_replace('&Ouml;', 'Ö', $message);
        $message = str_replace('&ouml;', 'ö', $message);
        $message = str_replace('&Uuml;', 'Ü', $message);
        $message = str_replace('&uuml;', 'ü', $message);
        $message = str_replace('&oacute;', 'ó', $message);
        $message = str_replace('&Oacute;', 'Ó', $message);
        $message = str_replace('&szlig;', 'ß', $message);
        $message = str_replace('&euro;', '€', $message);
        $message = str_replace('&eacute;', 'é', $message);
        $message = str_replace('&Eacute;', 'É', $message);
        $message = str_replace('&egrave;', 'è', $message); //è
        $message = str_replace('&Egrave;', 'È', $message);
        $message = str_replace('&quot;', '"', $message);
        $message = str_replace('&apos;', "'", $message);
        //$message	= str_replace('&#39;', "'", $message);
        $message = str_replace('&bdquo;', '„', $message);
        $message = str_replace('&ldquo;', '“', $message);
        $message = str_replace('&rsquo;', '’', $message);
        $message = str_replace('&frac14;', '¼', $message);
        $message = str_replace('&frac12;', '½', $message);
        $message = str_replace('&frac34;', '¾', $message);
        $message = str_replace('&amp;', '&', $message);
        $message = str_replace('&deg;', '°', $message);
        $message = str_replace('&agrave;', 'à', $message);
        $message = str_replace('&Agrave;', 'À', $message);
        $message = str_replace('&#09;', '', $message);

        return $message;
    }

    /**
     * @param $message
     * @return string
     */
    public static function makeWysiwygReplaceStatic($message): string
    {
        $message = trim($message);
        if ('' === $message) {
            return '';
        }
        $message = str_replace('&nbsp;', ' ', $message);
        $message = trim($message);
        if ('<br>' === substr($message, 0, 3) || '<BR>' === substr($message, 0, 3)) {
            $message = substr($message, 4);
        }
        $message = trim($message);
        if ('<br>' === substr($message, 0, 3) || '<BR>' === substr($message, 0, 3)) {
            $message = substr($message, 4);
        }
        $message = trim($message);
        if ('<br>' === substr($message, 0, 3) || '<BR>' === substr($message, 0, 3)) {
            $message = substr($message, 4);
        }
        $message = trim($message);
        if ('<br>' === $message || '<BR>' === $message) {
            return '';
        }

        $message = trim($message);
        if ('<br>' === $message) {
            return '';
        }
        if ('<br>' === substr($message, 0, 3)) {
            $message = substr($message, 4);
        }
        $message = str_replace('&shy;', '', $message);
        $message = str_replace('²', '&sup2;', $message);
        $message = str_replace('³', '&sup3;', $message);
        // Entferne alle MS Tags
        $pattern = '/mso-[^:]+:[^;"]+;/imsSUxu';
        $ersatz = '';
        preg_replace($pattern, $ersatz, $message);
        $pattern = '/<o:p>.*?<\/o:p>/imsSUxu';
        $ersatz = '';
        preg_replace($pattern, $ersatz, $message);
        $pattern = '/TEXT-INDENT: 0cm/imsSUxu';
        $ersatz = '';
        preg_replace($pattern, $ersatz, $message);
        $pattern = '/PAGE-BREAK-BEFORE: [^\s;]+;/imsSUxu';
        $ersatz = '';
        preg_replace($pattern, $ersatz, $message);
        $pattern = '/tab-stops:[^;"]/imsSUxu';
        $ersatz = '';
        preg_replace($pattern, $ersatz, $message);
        $pattern = '/<(\w[^>]*) class=([^ |>]*)([^>]*)/imsSUxu';
        $ersatz = '';
        preg_replace($pattern, $ersatz, $message);
        $pattern = '/<(\w[^>]*) style="([^\"]*)"([^>]*)/imsSUxu';
        $ersatz = '';
        preg_replace($pattern, $ersatz, $message);
        $pattern = '/<\\?\?xml[^>]*>/imsSUxu';
        $ersatz = '';
        preg_replace($pattern, $ersatz, $message);

        $message = str_replace('<em>', '<i>', $message);
        $message = str_replace('<EM>', '<i>', $message);
        $message = str_replace('</em>', '</i>', $message);
        $message = str_replace('</EM>', '</i>', $message);
        $message = strip_tags($message, '<span><table><tr><td><th><nobr><img><div><p><b><sup><sub>' .
            '<strong><font><i><u><a><h1><h2><h3><h4><h4><h5><h6><br><ul><li><ol><iframe><object><param><embed>' .
            '<script><noscript><font><span><div><br>');
        $message = str_replace(' class=MsoNormal', '', $message);
        $message = str_replace(' class="MsoNormal"', '', $message);
        $message = str_replace('<![if !supportEmptyParas]>&nbsp;<![endif]>', '', $message);
        $message = str_replace('style="border: 1px dashed #AAAAAA;"', '', $message);
        $message = str_replace('BORDER-RIGHT: #aaaaaa 1px dashed;', '', $message);
        $message = str_replace('BORDER-TOP: #aaaaaa 1px dashed;', '', $message);
        $message = str_replace('BORDER-LEFT: #aaaaaa 1px dashed;', '', $message);
        $message = str_replace('BORDER-BOTTOM: #aaaaaa 1px dashed;', '', $message);
        $message = str_replace('border: 1px dashed #AAAAAA', '', $message);
        $message = str_replace('BORDER-RIGHT: #aaaaaa 1px dashed', '', $message);
        $message = str_replace('BORDER-TOP: #aaaaaa 1px dashed', '', $message);
        $message = str_replace('BORDER-LEFT: #aaaaaa 1px dashed', '', $message);
        $message = str_replace('BORDER-BOTTOM: #aaaaaa 1px dashed', '', $message);
        $message = str_replace('BORDER-RIGHT: #aaaaaa 1px dashed;', '', $message);
        $message = str_replace('BORDER-TOP: #aaaaaa 1px dashed;', '', $message);
        $message = str_replace('BORDER-LEFT: #aaaaaa 1px dashed;', '', $message);
        $message = str_replace('BORDER-BOTTOM: #aaaaaa 1px dashed;', '', $message);
        $message = str_replace('MARGIN: auto 0cm', '', $message);
        $message = str_replace('MARGIN: 0pt 0pt 0pt 0pt', '', $message);
        $message = str_replace('MARGIN: 0cm 0cm 0cm 0cm', '', $message);
        $message = str_replace('MARGIN: 0cm 0cm 0cm 0pt', '', $message);
        $message = str_replace('MARGIN: 0cm 0cm 0pt 0pt', '', $message);
        $message = str_replace('MARGIN: 0cm 0pt 0pt', '', $message);
        $message = str_replace('MARGIN: 0pt 0pt 0pt', '', $message);
        $message = str_replace('MARGIN: 0cm 0cm 0pt', '', $message);
        $message = str_replace('MARGIN: 0cm -5.4pt 0pt 0cm', '', $message);
        $message = str_replace('class=MsoBodyText ', '', $message);
        $message = str_replace('prevstyle=" "', '', $message);
        $message = str_replace('border: 1px dashed #AAAAAA;', '', $message);
        $message = str_replace("'", '&#39;', $message);
        $message = str_replace('Ä', '&Auml;', $message);
        $message = str_replace('ä', '&auml;', $message);
        $message = str_replace('Ö', '&Ouml;', $message);
        $message = str_replace('ö', '&ouml;', $message);
        $message = str_replace('Ü', '&Uuml;', $message);
        $message = str_replace('ü', '&uuml;', $message);
        $message = str_replace('ß', '&szlig;', $message);
        $message = str_replace('€', '&euro;', $message);
        $message = str_replace('é', '&eacute;', $message); //é
        $message = str_replace('É', '&Eacute;', $message); //É
        $message = str_replace('è', '&egrave;', $message); //è
        $message = str_replace('È', '&Egrave;', $message); //È
        $message = str_replace('ó', '&oacute;', $message); //È
        $message = str_replace('Ó', '&Oacute;', $message); //È
        $message = str_replace('„', '&bdquo;', $message);
        $message = str_replace('“', '&ldquo;', $message);
        $message = str_replace('’', '&rsquo;', $message);
        $message = str_replace('(c)', '&copy;', $message);
        $message = str_replace('(C)', '&copy;', $message);
        $message = str_replace('(r)', '<sup>&reg;</sup>', $message);
        $message = str_replace('(R)', '<sup>&reg;</sup>', $message);
        $search = [
            chr(145),
            chr(146),
            chr(147),
            chr(148),
            chr(150),
            chr(151)
        ];
        $replace = ["'", "'", '&quot;', '&quot;', '&ndash;', '&ndash;'];
        $hold = str_replace($search[0], $replace[0], $message);
        $hold = str_replace($search[1], $replace[1], $hold);
        $hold = str_replace($search[2], $replace[2], $hold);
        $hold = str_replace($search[3], $replace[3], $hold);
        $hold = str_replace($search[4], $replace[4], $hold);
        $message = str_replace($search[5], $replace[5], $hold);
        $message = str_replace("'", '&#39;', $message);
        // Flash und Javascripts wieder als richtigen Quellcode darstellen
        $pattern = '/<script type="text\/javascript">(.*?)<\/script>/is';
        preg_match_all($pattern, $message, $array);
        if ('' !== $array['1']) {
            $ersetzen = $array['1'];
            $ersetzen = str_replace('&#39;', '"', $ersetzen);
            $message = str_replace($array['1'], $ersetzen, $message);
        }
        $message = str_replace('&quot;&quot;', "''", $message);
        while (preg_match('/<a#(.*)#a>/isU', $message, $pregMatch)) {
            $arrayString = explode('&quot;', $pregMatch[1]);
            $message = preg_replace('/<a#' . $pregMatch[1] . '#a>/isU', "'", $message);
        }

        return $message;
    }

    public static function getStaticGeburtstag($geburtstag, $sichtbar)
    {
        $geburtstag = FxToolsTrait::datum_de_static($geburtstag);
        if ($geburtstag != '' && $sichtbar == '1') {
            $bday = explode('.', $geburtstag);
            $geburtstag = $bday['0'] . '.' . $bday['1'] . '.';
        } else {
            $geburtstag = '&nbsp;';
        }
        return $geburtstag;
    }

    public static function getStaticSkype($skype)
    {
        if ($skype != '') {
            $skype = '<a href="skype:' . $skype . '?chat"><i class="fa skype"></i></a>';
        } else {
            $skype = '&nbsp;';
        }
        return $skype;
    }

    public static function ReadableFNNumber($number)
    {
        if (strlen($number) != 9) {
            return $number;
        }
    }

    public static function makeColorNameToHex($color_name)
    {
        $colors = self::getColorNameHex();

        $color_name = strtolower($color_name);
        if (isset($colors[$color_name])) {
            return ('#' . $colors[$color_name]);
        } else {
            return ($color_name);
        }
    }

    /**
     * Holt die Actiontexte und übergibt es als Array
     * @return Array
     */
    public function getActiontxt()
    {
        $data = array();
        $data['add'] = 'hinzuf&uuml;gen';
        $data['edit'] = '&auml;nderrn';
        $data['delete'] = 'l&ouml;schen';
        $data['save'] = 'speichern';
        return $data;
    }

    public function getShort($text, $limit = 10)
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
            'Dezember'];
        $text = str_replace(' (pid).', ' (pid)', $text);
        $text = str_replace('."', '". ', $text);
        $text = str_replace(' Dr. ', ' Dr_ ', $text);
        $text = str_replace('St.Peter-Ording', 'St_Peter-Ording', $text);
        $text = str_replace('St. Peter-Ording', 'St_Peter-Ording', $text);
        /**
         * Das nicht einfach der Monat weggeschnitten wird!
         */
        foreach ($monate as $key => $monat) {
            $text = str_replace('. ' . $monat, '.' . $monat, $text);
        }
        $text = explode('. ', $text);
        $y = count($text);
        if ($y === 1) {
            $text = $text[0] . '.';
        } elseif ($y >= 2) {
            $pattern = '/<br>|<\/p>/';
            $text = $text[0] . '.' . $text[1] . '.';
        } else {
            $text = '';
        }

        /**
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
        if ($text === '.') {
            $text = '';
        }
        return $text;
    }

    /**
     * @param $datum
     * @return string|void
     */
    public function makeDatumZeitStatic($datum)
    {
        $datum = trim($datum);
        if ('' === $datum || null === $datum) {
            return;
        }
        $datum = explode(' ', $datum);
        $tag = explode('-', $datum[0]);
        if (3 !== count($tag)) {
            $txt = "<p class='fehler'>";
            $txt .= "Datum wurde falsch eingeben! Bitte folgendes Format nutzen: 0000-00-00 00:00:00</p>";
            echo $txt;

            return '00.00.0000 00:00';
        }
        $tag = $tag[2] . '.' . $tag[1] . '.' . $tag[0];
        $zeit = explode(':', $datum[1]);
        if (3 !== count($zeit)) {
            $txt = "<p class='fehler'>";
            $txt .= "Datum wurde falsch eingeben! Bitte folgendes Format nutzen: 0000-00-00 00:00:00</p>";
            echo $txt;
            return '00.00.0000 00:00';
        }
        $zeit = $zeit[0] . ':' . $zeit[1];

        return $tag . ' ' . $zeit;
    }

    /**
     * Generiert ein Passwort.
     *
     * @example echo generatePW(10); // 10stelliges Passwort ausgeben...
     *
     * @param int $length
     *
     * @return string
     */
    public function generatePW($length = 8, $strong = 0)
    {
        $length = trim($length);
        if (!is_numeric($length)) {
            $length = 8;
        }
        switch ($strong) {
            case '2':
                $dummy = array_merge(
                    range('0', '9'),
                    range('a', 'z'),
                    range('A', 'Z'),
                    ['#', '&', '@', '$', '_', '%', '?', '+']
                );
                break;
            case '1':
                $dummy = array_merge(range('0', '9'), range('a', 'z'), range('A', 'Z'));
                break;
            default:
                $dummy = array_merge(range('0', '9'), range('a', 'z'));
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

    public function createRandomPassword($gen = 7)
    {
        $gen = trim($gen);
        if (!is_numeric($gen)) {
            $gen = 7;
        }
        $chars = 'abcdefghijkmnopqrstuvwxyz023456789';
        srand((float)microtime() * 1000000);
        $i = 0;
        $pass = '';
        while ($i <= $gen) {
            $num = rand() % 33;
            $tmp = substr($chars, $num, 1);
            $pass = $pass . $tmp;
            ++$i;
        }

        return $pass;
    }

    /**
     * Generiert ein Passwort.
     *
     * @example echo generatePW(10); // 10stelliges Passwort ausgeben...
     *
     * @param int $length
     * @param int $strong // Wie schwer soll das Passwort sein?
     *
     * @return string
     */
    public function generateChiffre($length = 8, $strong = '')
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
                $dummy = array_merge(
                    range('0', '9'),
                    range('a', 'z'),
                    range('A', 'Z'),
                    ['#', '&', '@', '$', '_', '%', '?', '+', '!', '§']
                );
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

    public function createRandAdminKey($benutzer, $password, $admin_id)
    {
        $benutzer = trim($benutzer);
        $password = trim($password);
        $admin_id = trim($admin_id);
        $password = $benutzer . $password . $admin_id;
        $password = $this->hashPassword($password);

        return $password;
    }

    public function hashPassword($password)
    {
        $password = trim($password);
        $salt = 'adminpassword';
        //encrypt the password, rotate characters by length of original password
        $len = strlen($password);
        $password = md5($password);
        $password = $this->rotateHEX($password, $len);

        return md5($salt . $password);
    }

    public function rotateHEX($string, $n)
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
    public function password($txt, $verschluesselung = 'md5')
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

    /**
     * Baue Link, kontrolliere ob http:// gesetzt ist
     * Kontrolliere auch ob vorab schon http:// war, dann überspringe diese Funktion.
     *
     * @param string $link
     *
     * @return string
     */
    public function buildUrl($link)
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

    /**
     * Funktion zum Umwandeln des Hexcodes in RGBcodes.
     *
     * @param string $hex
     *
     * @return string
     */
    public function makeHexToRgb($hex)
    {
        $hex = trim($hex);
        $hex_array = [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 'A' => 10, 'B' => 11, 'C' => 12, 'D' => 13, 'E' => 14, 'F' => 15];
        $hex = str_replace('#', '', strtoupper($hex));
        if (($length = strlen($hex)) === 3) {
            $hex = $hex[0] . $hex[0] . $hex[1] . $hex[1] . $hex[2] . $hex[2];
            $length = 6;
        }
        if (6 !== $length or strlen(str_replace(array_keys($hex_array), '', $hex))) {
            return null;
        }
        $rgb['r'] = $hex_array[$hex[0]] * 16 + $hex_array[$hex[1]];
        $rgb['g'] = $hex_array[$hex[2]] * 16 + $hex_array[$hex[3]];
        $rgb['b'] = $hex_array[$hex[4]] * 16 + $hex_array[$hex[5]];

        return $rgb['r'] . ',' . $rgb['g'] . ',' . $rgb['b'];
    }

    /**
     * Barriere Freiheit.
     *
     * @param string $text
     * @param string $filepath
     *
     * @return string
     */
    public function getBarriereFrei($text, $filepath)
    {
        $text = trim($text);
        $filepath = trim($filepath);
        $pos = strpos($text, '<img');
        while (false !== $pos) {
            $text = substr($text, 0, $pos) . substr($text, strpos($text, '>', $pos));
            $pos = strpos($text, '<img');
        }
        $regex = '#<img src=.+\.(jpg|png|gif)>#iU';
        $text = preg_replace($regex, '', $text);
        $regex = '/background=".+\.(jpg|png|gif)"/';
        $text = preg_replace($regex, '', $text);
        $regex = '/bgcolor="#.{6}"/';
        $text = preg_replace($regex, '', $text);
        if ('index.php' !== $filepath) {
            $regex = '#"index.php#iU';
            $text = preg_replace($regex, '"barriererfrei.php?datei=' . $filepath, $text);
        }

        return $text;
    }

    /**
     * Zeige alle gesendeten Variablen.
     *
     * @return string
     */
    public function showVars()
    {
        echo '<pre>';
        print_r($_SESSION);
        print_r($_SERVER);
        print_r($_ENV);
        print_r($_FILES);
        print_r($_GET);
        print_r($_POST);
        echo '</pre>';
    }

    /**
     * Überprüfen ob es die Domain wirklich gibt
     * $url="http://www.test.de/";.
     */
    public function checkUrlUeberPruefen($url)
    {
        $url = trim($url);
        if ($FilePointer = @fopen($url, 'r')) {
            @fclose($FilePointer);

            return true;
        } else {
            return false;
        }
    }

    /**
     * Funktion zum Checken ob der Text leer ist oder ansonsten zeige Ihn an.
     *
     * @param string $txt
     *
     * @return string
     */
    public function checkText($txt)
    {
        $txt = trim($txt);
        if ('' !== $txt && '<br>' !== $txt && null !== $txt && 'NULL' !== $txt) {
            return $txt;
        }

        return '';
    }

    public function checkNumberNull($value, $notzero = 0)
    {
        $value = trim($value);
        if ($notzero === 1) {
            if ($value <= 0 || $value === null) {
                return null;
            }
        }
        if ('' !== $value && null !== $value && 'NULL' !== $value) {
            return $value;
        }
        return null;
    }

    public function getBooleanInt($value)
    {
        if ($value === null) {
            return null;
        }
        if ($value === true || $value === 1) {
            return 1;
        }
        return 0;
    }

    /**
     * Checken von Eingaben und Entfernen von Spammailern.
     *
     * @param string $check
     *
     * @return string $check
     */
    public function checkTextTrim($check)
    {
        $check = trim($check);
        $check = nl2br(stripslashes(htmlspecialchars($check)));

        return $check;
    }

    /**
     * Domaincheck
     * - 1 = Alles OK
     * - 2 = Host leer oder falsch
     * - 3 = DNS nicht gefunden
     * - 4 = Spamverdacht.
     */
    public function makeDomainCheck($email)
    {
        $email = trim($email);
        if (
            (
                preg_match('/(@.*@)|(..)|(@.)|(.@)|(^.)/', $email)
            )
            ||
            (
                preg_match('^.+@([?)[a-zA-Z0-9-.]+.([a-zA-Z]{2,3}|[0-9]{1,3})(]?)$', $email)
            )
        ) {
            $host = explode('@', $email);
            if (!function_exists('checkdnsrr')) {
                function checkdnsrr($host, $type = '')
                {
                    if (!empty($host)) {
                        if ('' === $type) {
                            $type = 'MX';
                        }
                        @exec("nslookup -type=$type $host", $output);
                        foreach ($output as $line) {
                            if (preg_match("^$host", $line)) {
                                return '1';
                            }
                        }

                        return '2';
                    }
                }
            }
            if (checkdnsrr($host[1] . '.', 'MX')) {
                return '1';
            }
            if (checkdnsrr($host[1] . '.', 'A')) {
                return '1';
            }
            if (checkdnsrr($host[1] . '.', 'CNAME')) {
                return '1';
            }
        }
        echo "<table id='mitteilung_false'><tr><td><b>Da ging was schief!</b>";
        echo "<br/>Die von Ihnen eingebene Emailadresse ist <b>nicht</b> (mehr) vorhanden, oder <b>ung&uuml;ltig!</b>";
        echo "</td></tr></table>";
    }

    /**
     * Prüft ob es eine richtige E-Mailadresse ist.
     *
     * @param emailadress
     *
     * @return true / false
     *           Kann nun auch komplexe E-Mailadresse lesen (Lichtblick-e.V.-Brunsbuettel@t-online.de)
     */
    public function checkEmail($check)
    {
        $check = trim($check);
        //if(eregi("^[a-z0-9]+([-_\.]?[a-z0-9])+@[a-z0-9]+([-_\.]?[a-z0-9])+\.[a-z]{2,4}$", $check))
        if (preg_match("/^[a-zA-Z0-9_.!#$%&'*+-\/=?^`}{|~]{2,}@[a-z0-9_.-]+.[a-z]{2,5}$/", $check)) {
            return $check;
        } else {
            return '';
        }
    }

    /**
     * Prüft ob es eine richtige PLZ ist.
     *
     * @param plz
     *
     * @return true / false
     */
    public function checkPlz($check)
    {
        $check = trim($check);
        if (preg_match('/^[0-9]{5}$/', $check)) {
            return $check;
        } else {
            return '';
        }
    }

    /**
     * Prüft ob es nur Zahlen sind.
     */
    public function checkZiffern($check)
    {
        $check = trim($check);
        if (preg_match('/^[0-9]*$/', $check)) {
            return $check;
        } else {
            return '';
        }
    }

    /**
     * Prüft ob es eine richtige Telefonnummer ist.
     *
     * @param emailadress
     *
     * @return true / false
     */
    public function checkTelefon($check)
    {
        $check = trim($check);
        if (preg_match("/^[0-9-()\/+ .]*$/", $check)) {
            return $check;
        } else {
            return '';
        }
    }

    /**
     * Prüft ob es eine richtige Homepageadresse ist.
     *
     * @param emailadress
     *
     * @return true / false
     */
    public function checkHomepage($check)
    {
        $check = trim($check);
        if (preg_match("/^(http|https)\:\/\/([A-Za-z0-9-]+\.){0,}[A-Za-z0-9-]+\.[A-Za-z]{2,4}/", $check)) {
            return $check;
        } else {
            return '';
        }
    }

    /**
     * Untersuche ob die Zahlenlänge passt, ansonsten setzen 0x davor. Falls Größer als Max, dann gebe einen Fehler aus!
     *
     * @param string $zahl
     * @param string $len
     * @param string $max
     */
    public function makeZahlStellen($zahl, $len = 2, $max = '')
    {
        $zahl = trim($zahl);
        $len = trim($len);
        $max = trim($max);

        if (!is_numeric($len)) {
            $len = 2;
        }
        if (!is_numeric($max)) {
            $max = '';
        }

        if (!is_numeric($zahl)) {
            return '';
        }
        if ($zahl <= 0) {
            echo '<p class="fehler">Bitte nur positive Zahlen eingeben!</p>';

            return '';
        }
        if ('' !== $max) {
            if ($zahl > $max) {
                echo '<p class="fehler">Bitte nur Zahlen zwischen 1 und ' . $max . ' eingeben!</p>';

                return '';
            }
        }
        $zahl_len = strlen($zahl);
        if ($zahl_len > $len) {
            echo '<p class="fehler">Bitte nur bis ' . $len . '-stellige Zahlen eingeben!</p>';

            return '';
        }
        if ($zahl_len < $len) {
            $neu = '';
            for ($i = $zahl_len; $i < $len; ++$i) {
                $neu .= '0';
            }
            $zahl = $neu . $zahl;
        }

        return $zahl;
    }

    /**
     * Checkt ob es Zahlen sind mit 2 oder 4 Ziffern.
     *
     * @param string $zahl
     * @param string $len
     */
    public function checkZahlen($zahl, $len)
    {
        $zahl = trim($zahl);
        $len = trim($len);
        if (!is_numeric($zahl)) {
            return false;
        }

        if (1 === $len) {
            $zahl = '0' . $zahl;
        }

        if (2 === $len) {
            if (2 === strlen($zahl)) {
                if (0 === substr($zahl, 0, 1)) {
                    $zahl = substr($zahl, 1);
                }
            }
        }
        if (4 === $len) {
            if (4 !== strlen($zahl)) {
                return false;
            }
        }

        return $zahl;
    }

    /**
     * Enter description here...
     *
     * @param string $url
     *
     * @return bool
     *
     * @example Tools::httpFileExists('http://www.example.com/dir/file.html');
     */
    public function httpFileExists($url)
    {
        $url = trim($url);
        if ('' === $url) {
            return false;
        }
        $url_p = parse_url($url);
        $host = $url_p['host'];
        $port = isset($url_p['port']) ? $url_p['port'] : 80;
        $fp = fsockopen($url_p['host'], $port, $errno, $errstr, 3);
        if (!$fp) {
            return false;
        }
        fputs($fp, 'GET ' . $url_p['path'] . ' HTTP/1.1' . chr(10));
        fputs($fp, 'HOST: ' . $url_p['host'] . chr(10));
        fputs($fp, 'Connection: close' . chr(10) . chr(10));
        $response = fgets($fp, 1024); //nur 1. zeile holen...
        fclose($fp);
        if (!stristr($response, 'HTTP 404')) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Gibt das genaue Alter zurück.
     *
     * @param string $date
     *
     * @return string $age
     */
    public function checkAge($date)
    {
        $date = trim($date);
        if ('' === $date) {
            return '-1';
        }
        $date = str_replace(',', '.', $date);
        $date = explode('.', $date);
        $jetzt = mktime(0, 0, 0, date('m'), date('d'), date('Y'));
        $gebur = mktime(0, 0, 0, $date[1], $date[0], $date[2]);
        $age = intval(($jetzt - $gebur) / (3600 * 24 * 365));

        return $age;
    }

    public function emailDecoder($text)
    {
        $text = trim($text);
        $text = preg_replace("/[^a-z0-9 !?:;,.\/_\-=+@#$&\*\(\)]/im", '', $text);
        $text = preg_replace('/(content-type:|bcc:|cc:|to:|from:)/im', '', $text);

        return $text;
    }

    public function textDecoder($text)
    {
        $text = trim($text);
        $text = preg_replace('/(content-type:|bcc:|cc:|to:|from:)/im', '', $text);
        $text = strip_tags($text);

        return $text;
    }

    /**
     * Suche im Text nach Hacking versuch.
     *
     * @param string $text
     */
    public function checkMysqlExit($text)
    {
        $text = trim($text);
        if ('' === $text) {
            return '';
        }
        $bad = [];
        $bad[] = 'select';
        $bad[] = 'drop';
        $bad[] = 'delete';
        $bad[] = 'show tables';
        $bad[] = 'show table';
        $text_check = strtolower($text);

        $bads = '/' . join('|', $bad) . '/';
        if (preg_match($bads, $text_check)) {
            echo '<p class="color:#FF0000; font-weight:bold;font-size:14px;">Hacking versuch!!!</p>';

            return '';
        }

        return $text;
    }

    public function checkUrl($link)
    {
        $link = trim($link);
        if ('' === $link) {
            return '';
        }
        if ('/index' !== substr($link, 0, 6)) {
            if (!preg_match('/http:/', $link) && preg_match('/www/', $link)) {
                $link = 'http://' . $link;
            }
            if (!preg_match("/http:\/\/www./", $link)) {
                $link = 'http://www.' . $link;
            }
        }

        return $link;
    }

    /**
     * Function zum Import von CSV Dateien.
     *
     * @param string $txt
     *
     * @return string
     */
    public function makeCsvReplace($txt)
    {
        if ('"' === substr($txt, 0, 1)) {
            $txt = substr($txt, 1);
        }
        if ('"' === substr($txt, -1, 1)) {
            $txt = substr($txt, 0, -1);
        }
        $txt = str_replace('#', '', $txt);
        $txt = $this->makeCharReplace($txt);

        return $txt;
    }

    /**
     * Ersetze Umlaute in HTML Tags.
     *
     * @param string $message
     *
     * @return string
     */
    public function makeCharReplace($message)
    {
        $message = trim($message);
        if ('' === $message) {
            return '';
        }
        $message = str_replace('&shy;', '', $message);
        $search = [chr(145), chr(146), chr(147), chr(148), chr(150), chr(151)];
        $replace = ["'", "'", '&quot;', '&quot;', '&ndash;', '&ndash;'];
        $message = str_replace(' & ', '&amp;', $message);
        $message = str_replace('Ä', '&Auml;', $message);
        $message = str_replace('ä', '&auml;', $message);
        $message = str_replace('Ö', '&Ouml;', $message);
        $message = str_replace('ö', '&ouml;', $message);
        $message = str_replace('Ü', '&Uuml;', $message);
        $message = str_replace('ü', '&uuml;', $message);
        $message = str_replace('ß', '&szlig;', $message);
        $message = str_replace('€', '&euro;', $message);
        $message = str_replace('§', '&sect;', $message);
        $message = str_replace('é', '&eacute;', $message); //é
        $message = str_replace('É', '&Eacute;', $message); //É
        $message = str_replace('è', '&egrave;', $message); //è
        $message = str_replace('È', '&Egrave;', $message); //È
        $message = str_replace('ó', '&oacute;', $message); //È
        $message = str_replace('Ó', '&Oacute;', $message); //È
        $message = str_replace('"', '&quot;', $message);
        $message = str_replace("'", '&#39;', $message);
        $message = str_replace('style=&quot;', 'style="', $message);
        $message = str_replace('&quot;>', '">', $message);
        $message = str_replace('„', '&bdquo;', $message);
        $message = str_replace('“', '&ldquo;', $message);
        $message = str_replace('’', '&rsquo;', $message);
        $message = str_replace('Ã¤', '&auml;', $message); //ä
        $message = str_replace('Ã„', '&Auml;', $message); //Ä
        $message = str_replace('Ã¶', '&ouml;', $message); //ö
        $message = str_replace('Ã–', '&Ouml;', $message); //Ö
        $message = str_replace('Ã¼', '&uuml;', $message); //ü
        $message = str_replace('Ãœ', '&Uuml;', $message); //Ü
        $message = str_replace('ÃŸ', '&szlig;', $message); //ß
        $message = str_replace('Ã©', '&eacute;', $message); //é
        $message = str_replace('Ã¨', '&Eacute;', $message); //É
        $message = str_replace('Ã‰', '&egrave;', $message); //è
        $message = str_replace('Ãˆ', '&Egrave;', $message); //È
        $message = str_replace('¼', '&frac14;', $message);
        $message = str_replace('½', '&frac12;', $message);
        $message = str_replace('¾', '&frac34;', $message);
        $message = str_replace('http://www.', 'www.', $message);
        $message = str_replace('www.', 'http://www.', $message);
        while (preg_match('/<a#(.*)#a>/isU', $message, $pregMatch)) {
            $arrayString = explode('&quot;', $pregMatch[1]);
            $message = preg_replace('/<a#' . $pregMatch[1] . '#a>/isU', "'", $message);
        }
        $message = str_replace("\n\r", '<br>', $message);
        $message = str_replace("\n", '<br>', $message);
        $message = str_replace(' <br>', '<br>', $message);
        $message = str_replace('°', '&deg;', $message);
        $message = trim($message);

        return $message;
    }

    /**
     * Dateinamen Klein und Umlaute umschreiben.
     */
    public function makeInternetFileName($name)
    {
        $name = trim($name);
        if ('' === $name) {
            return '';
        }
        $message = str_replace('Ä', 'Ae', $name);
        $message = str_replace('ä', 'ae', $message);
        $message = str_replace('Ö', 'Oe', $message);
        $message = str_replace('ö', 'oe', $message);
        $message = str_replace('Ü', 'Ue', $message);
        $message = str_replace('ü', 'ue', $message);
        $message = str_replace('ß', 'ss', $message);
        $message = str_replace('é', 'e', $message); //é
        $message = str_replace('É', 'E', $message); //É
        $message = str_replace('è', 'e', $message); //è
        $message = str_replace('È', 'E', $message); //È
        $message = str_replace('ó', 'o', $message); //È
        $message = str_replace('Ó', 'O', $message); //È
        $message = str_replace("'", '', $message);
        $message = str_replace('’', '', $message);
        $message = str_replace('Ã¤', 'ae', $message); //ä
        $message = str_replace('Ã„', 'Ae', $message); //Ä
        $message = str_replace('Ã¶', 'oe', $message); //ö
        $message = str_replace('Ã–', 'Oe', $message); //Ö
        $message = str_replace('Ã¼', 'ue', $message); //ü
        $message = str_replace('Ãœ', 'Ue', $message); //Ü
        $message = str_replace('ÃŸ', 'ss', $message); //ß
        $message = str_replace('Ã©', 'e', $message); //é
        $message = str_replace('Ã¨', 'E', $message); //É
        $message = str_replace('Ã‰', 'e', $message); //è
        $message = str_replace('Ãˆ', 'E', $message); //È
        $message = strtolower($message);

        return $message;
    }

    /**
     * Ersetze Begriffe um evtl auch andere Formen abzufragen.
     *
     * @param unknown_type $text
     *
     * @return unknown
     */
    public function makeAlternativSearch($text)
    {
        $text = trim($text);
        if ('' === $text) {
            return '';
        }
        $text = str_replace('&shy;', '', $text);
        $text = str_replace('u', '&uuml;', $text);
        $text = str_replace('U', '&Uuml;', $text);
        $text = str_replace('a', '&auml;', $text);
        $text = str_replace('A', '&Auml;', $text);
        $text = str_replace('o', '&ouml;', $text);
        $text = str_replace('O', '&Ouml;', $text);
        $text = str_replace('sz', '&szlig;', $text);
        $text = str_replace('ss', '&szlig;', $text);
        $text = str_replace('s', '&szlig;', $text);

        return $text;
    }

    public function makePdfCharReplace($text)
    {
        $text = trim($text);
        if ('' === $text) {
            return '';
        }
        $text = str_replace('&shy;', '', $text);
        $text = str_replace('\n\r', '', $text);
        $text = str_replace('\n', '', $text);
        $text = str_replace('\r', '', $text);
        $text = $this->makeCharReplaceOff($text);
        $text = str_replace('<p>', '', $text);
        $text = str_replace('</p>', "\n", $text);
        $text = str_replace('\r\n', '', $text);
        $text = str_replace('\n\r', "\n", $text);
        $text = str_replace('<br>', "\n", $text);
        $text = str_replace('<BR>', "\n", $text);
        $text = str_replace('<br \>', "\n", $text);
        $text = str_replace('<BR \>', "\n", $text);
        $text = str_replace('&nbsp;', '', $text);
        $text = strip_tags($text);
        $text = str_replace('&lt;', '<', $text);
        $text = str_replace('&gt;', '>', $text);
        $text = str_replace('\n\n\n', "\n\n", $text);
        $text = str_replace('\n\n\n', "\n\n", $text);
        $text = str_replace('\n\n', "\n", $text);
        $text = str_replace('\n \n \n', "\n\n", $text);
        $text = str_replace('\r\n', '', $text);
        $text = str_replace("\r", '', $text);
        $text = str_replace("\n", '<br>', $text);
        $text = str_replace('<br><br>', '<br>', $text);
        $text = str_replace('<br><br>', '<br>', $text);
        $text = str_replace('<br><br>', '<br>', $text);
        $text = str_replace('<br><br>', '<br>', $text);
        $text = str_replace('<br><br>', '<br>', $text);
        $text = str_replace('<br><br>', '<br>', $text);
        $text = str_replace('<br><br>', '<br>', $text);
        $text = str_replace('<br><br>', '<br>', $text);
        $text = str_replace('<br><br>', '<br>', $text);
        $text = str_replace('<br><br>', '<br>', $text);
        $text = str_replace('<br><br>', '<br>', $text);
        $text = str_replace('<br>', "\n", $text);
        $text = str_replace("\n", '|', $text);
        $text = str_replace('||', '|', $text);
        $text = str_replace('||', '|', $text);
        $text = str_replace('|', "\n", $text);
        $text = str_replace("\n \n", "\n", $text);

        return $text;
    }

    /**
     * makeCharReplace aus.
     *
     * @param string $message
     *
     * @return string
     */
    public function makeCharReplaceOff($message)
    {
        $message = trim($message);
        if ('' == $message) {
            return '';
        }
        $message = str_replace('&shy;', '', $message);
        $message = str_replace('<BR>', "\n", $message);
        $message = str_replace('<br>', "\n", $message);
        $message = str_replace('&sect;', '§', $message);
        $message = str_replace('&Auml;', 'Ä', $message);
        $message = str_replace('&auml;', 'ä', $message);
        $message = str_replace('&Ouml;', 'Ö', $message);
        $message = str_replace('&ouml;', 'ö', $message);
        $message = str_replace('&Uuml;', 'Ü', $message);
        $message = str_replace('&uuml;', 'ü', $message);
        $message = str_replace('&oacute;', 'ó', $message);
        $message = str_replace('&Oacute;', 'Ó', $message);
        $message = str_replace('&szlig;', 'ß', $message);
        $message = str_replace('&euro;', '€', $message);
        $message = str_replace('&eacute;', 'é', $message);
        $message = str_replace('&Eacute;', 'É', $message);
        $message = str_replace('&egrave;', 'è', $message); //è
        $message = str_replace('&Egrave;', 'È', $message);
        $message = str_replace('&quot;', '"', $message);
        $message = str_replace('&apos;', "'", $message);
        //$message	= str_replace('&#39;', "'", $message);
        $message = str_replace('&bdquo;', '„', $message);
        $message = str_replace('&ldquo;', '“', $message);
        $message = str_replace('&rsquo;', '’', $message);
        $message = str_replace('&frac14;', '¼', $message);
        $message = str_replace('&frac12;', '½', $message);
        $message = str_replace('&frac34;', '¾', $message);
        $message = str_replace('&amp;', '&', $message);
        $message = str_replace('&deg;', '°', $message);
        $message = str_replace('&agrave;', 'à', $message);
        $message = str_replace('&Agrave;', 'À', $message);
        $message = str_replace('&#09;', '', $message);

        return $message;
    }

    /**
     * Wandelt UTF-8 und Latain-1 in Googlefreundliche Umlaute um, damit die bei Google Maps richtig angezeigt werden.
     *
     * @param string $text
     *
     * @return string
     */
    public function makeGoogleXmlChanger($text)
    {
        $text = trim($text);
        if ('' === $text) {
            return '';
        }
        $text = str_replace('&shy;', '', $text);
        $text = str_replace('<br>', '&lt;br&gt;', $text);
        $text = str_replace('<BR>', '&lt;br&gt;', $text);
        $text = str_replace('Ä', '&amp;#196;', $text);
        $text = str_replace('&Auml;', '&amp;#196;', $text);
        $text = str_replace('Ö', '&amp;#214;', $text);
        $text = str_replace('&Ouml;', '&amp;#214;', $text);
        $text = str_replace('Ü', '&amp;#214;', $text);
        $text = str_replace('&Uuml;', '&amp;#214;', $text);
        $text = str_replace('ä', '&amp;#228;', $text);
        $text = str_replace('&auml;', '&amp;#228;', $text);
        $text = str_replace('ö', '&amp;#246;', $text);
        $text = str_replace('&ouml;', '&amp;#246;', $text);
        $text = str_replace('ü', '&amp;#252;', $text);
        $text = str_replace('&uuml;', '&amp;#252;', $text);
        $text = str_replace('ß', '&amp;#223;', $text);
        $text = str_replace('&szlig;', '&amp;#223;', $text);
        $text = utf8_encode($text);

        return $text;
    }

    public function buildGoogleSearch($text)
    {
        $text = trim($text);
        if ('' === $text) {
            return '';
        }
        $text = str_replace('<br>', '', $text);
        $text = str_replace('<br />', '', $text);
        $text = str_replace('<BR>', '', $text);
        $text = str_replace('<BR />', '', $text);
        $text = str_replace('&shy;', '', $text);
        $text = str_replace('&quot;', '_', $text);
        $text = str_replace('&apos;', '_', $text);
        $text = str_replace('&Auml;', 'Ae', $text);
        $text = str_replace('&auml;', 'ae', $text);
        $text = str_replace('&Ouml;', 'Oe', $text);
        $text = str_replace('&ouml;', 'oe', $text);
        $text = str_replace('&Uuml;', 'Ue', $text);
        $text = str_replace('&uuml;', 'ue', $text);
        $text = str_replace('&oacute;', 'o', $text);
        $text = str_replace('&Oacute;', 'O', $text);
        $text = str_replace('&szlig;', 'ss', $text);
        $text = str_replace('&euro;', 'Euro', $text);
        $text = str_replace('&eacute;', 'e', $text);
        $text = str_replace('&Eacute;', 'E', $text);
        $text = str_replace('&egrave;', 'e', $text);
        $text = str_replace('&Egrave;', 'E', $text);
        $text = str_replace('&bdquo;', '_', $text);
        $text = str_replace('&ldquo;', '_', $text);
        $text = str_replace('Ä', 'Ae', $text);
        $text = str_replace('ä', 'ae', $text);
        $text = str_replace('Ö', 'Oe', $text);
        $text = str_replace('ö', 'oe', $text);
        $text = str_replace('Ü', 'Ue', $text);
        $text = str_replace('ü', 'ue', $text);
        $text = str_replace('ß', 'ss', $text);
        $text = str_replace('€', 'Euro', $text);
        $text = str_replace('é', 'e', $text); //é
        $text = str_replace('É', 'E', $text); //É
        $text = str_replace('è', 'e', $text); //è
        $text = str_replace('È', 'E', $text); //È
        $text = str_replace('ó', 'o', $text); //È
        $text = str_replace('Ó', 'O', $text); //È
        $text = str_replace('"', '_', $text);
        $text = str_replace("'", '_', $text);
        $text = str_replace('„', '_', $text);
        $text = str_replace('“', '_', $text);
        $text = str_replace('’', '_', $text);
        $text = str_replace('Ã¤', 'ae', $text); //ä
        $text = str_replace('Ã„', 'Ae', $text); //Ä
        $text = str_replace('Ã¶', 'oe', $text); //ö
        $text = str_replace('Ã–', 'Oe', $text); //Ö
        $text = str_replace('Ã¼', 'ue', $text); //ü
        $text = str_replace('Ãœ', 'Ue', $text); //Ü
        $text = str_replace('ÃŸ', 'ss', $text); //ß
        $text = str_replace('Ã©', 'e', $text); //é
        $text = str_replace('Ã¨', 'E', $text); //É
        $text = str_replace('Ã‰', 'e', $text); //è
        $text = str_replace('Ãˆ', 'E', $text); //È
        $text = str_replace('_', ' ', $text);

        return $text;
    }

    /**
     * Ersetzt alle Umlaute in normale Zeichen.
     *
     * @param string $dateiname
     *
     * @return string
     */
    public function makeFileChar($dateiname, $lower = 1)
    {
        $dateiname = trim($dateiname);
        if ('' === $dateiname) {
            return '';
        }
        if (1 === $lower) {
            $dateiname = strtolower($dateiname);
        }
        $dateiname = str_replace('&shy;', '', $dateiname);
        $dateiname = str_replace(' ', '_', $dateiname);
        $dateiname = str_replace('.', '_', $dateiname);
        $dateiname = str_replace('&quot;', '_', $dateiname);
        $dateiname = str_replace('&apos;', '_', $dateiname);
        $dateiname = str_replace(',', '_', $dateiname);
        $dateiname = str_replace('?', '_', $dateiname);
        $dateiname = str_replace('!', '_', $dateiname);
        $dateiname = str_replace('#', '_', $dateiname);
        $dateiname = str_replace('§', '_', $dateiname);
        $dateiname = str_replace('$', '_', $dateiname);
        $dateiname = str_replace('%', '_', $dateiname);
        $dateiname = str_replace('&Auml;', 'Ae', $dateiname);
        $dateiname = str_replace('&auml;', 'ae', $dateiname);
        $dateiname = str_replace('&Ouml;', 'Oe', $dateiname);
        $dateiname = str_replace('&ouml;', 'oe', $dateiname);
        $dateiname = str_replace('&Uuml;', 'Ue', $dateiname);
        $dateiname = str_replace('&uuml;', 'ue', $dateiname);
        $dateiname = str_replace('&oacute;', 'o', $dateiname);
        $dateiname = str_replace('&Oacute;', 'O', $dateiname);
        $dateiname = str_replace('&szlig;', 'ss', $dateiname);
        $dateiname = str_replace('&euro;', 'Euro', $dateiname);
        $dateiname = str_replace('&eacute;', 'e', $dateiname);
        $dateiname = str_replace('&Eacute;', 'E', $dateiname);
        $dateiname = str_replace('&egrave;', 'e', $dateiname);
        $dateiname = str_replace('&Egrave;', 'E', $dateiname);
        $dateiname = str_replace('&bdquo;', '_', $dateiname);
        $dateiname = str_replace('&ldquo;', '_', $dateiname);
        $dateiname = str_replace('Ä', 'Ae', $dateiname);
        $dateiname = str_replace('ä', 'ae', $dateiname);
        $dateiname = str_replace('Ö', 'Oe', $dateiname);
        $dateiname = str_replace('ö', 'oe', $dateiname);
        $dateiname = str_replace('Ü', 'Ue', $dateiname);
        $dateiname = str_replace('ü', 'ue', $dateiname);
        $dateiname = str_replace('ß', 'ss', $dateiname);
        $dateiname = str_replace('€', 'Euro', $dateiname);
        $dateiname = str_replace('é', 'e', $dateiname); //é
        $dateiname = str_replace('É', 'E', $dateiname); //É
        $dateiname = str_replace('è', 'e', $dateiname); //è
        $dateiname = str_replace('È', 'E', $dateiname); //È
        $dateiname = str_replace('ó', 'o', $dateiname); //È
        $dateiname = str_replace('Ó', 'O', $dateiname); //È
        $dateiname = str_replace('"', '_', $dateiname);
        $dateiname = str_replace("'", '_', $dateiname);
        $dateiname = str_replace('„', '_', $dateiname);
        $dateiname = str_replace('“', '_', $dateiname);
        $dateiname = str_replace('’', '_', $dateiname);
        $dateiname = str_replace('Ã¤', 'ae', $dateiname); //ä
        $dateiname = str_replace('ã¤', 'ae', $dateiname);
        $dateiname = str_replace('Ã„', 'Ae', $dateiname); //Ä
        $dateiname = str_replace('ã_', 'Ae', $dateiname); //Ä
        $dateiname = str_replace('Ã¶', 'oe', $dateiname); //ö
        $dateiname = str_replace('Ã–', 'Oe', $dateiname); //Ö
        $dateiname = str_replace('ã–', 'Oe', $dateiname);
        $dateiname = str_replace('ã¶', 'oe', $dateiname);
        $dateiname = str_replace('Ã¼', 'ue', $dateiname); //ü
        $dateiname = str_replace('Ãœ', 'Ue', $dateiname); //Ü
        $dateiname = str_replace('ãœ', 'Ue', $dateiname); //Ü
        $dateiname = str_replace('ãœ', 'ue', $dateiname);
        $dateiname = str_replace('ã¼', 'ue', $dateiname);
        $dateiname = str_replace('ÃŸ', 'ss', $dateiname); //ß
        $dateiname = str_replace('ãŸ', 'ss', $dateiname);
        $dateiname = str_replace('Ã©', 'e', $dateiname); //é
        $dateiname = str_replace('Ã¨', 'E', $dateiname); //É
        $dateiname = str_replace('ã©', 'e', $dateiname);
        $dateiname = str_replace('Ã‰', 'e', $dateiname); //è
        $dateiname = str_replace('Ãˆ', 'E', $dateiname); //È
        $dateiname = str_replace('ã¨', 'e', $dateiname);
        $dateiname = str_replace('&amp;', 'und', $dateiname);
        $dateiname = str_replace('/', '_', $dateiname);
        $dateiname = str_replace('\'', '_', $dateiname);
        $dateiname = str_replace('*', '_', $dateiname);
        $dateiname = str_replace('+', '_', $dateiname);
        $dateiname = str_replace('|', '_', $dateiname);
        $dateiname = str_replace('>', '_', $dateiname);
        $dateiname = str_replace('<', '_', $dateiname);
        $dateiname = str_replace('°', '_', $dateiname);
        $dateiname = str_replace('^', '_', $dateiname);
        $dateiname = str_replace('²', '2', $dateiname);
        $dateiname = str_replace('³', '3', $dateiname);
        $dateiname = str_replace('{', '_', $dateiname);
        $dateiname = str_replace('}', '_', $dateiname);
        $dateiname = str_replace('[', '_', $dateiname);
        $dateiname = str_replace(']', '_', $dateiname);
        $dateiname = str_replace('(', '_', $dateiname);
        $dateiname = str_replace(')', '_', $dateiname);
        $dateiname = str_replace('´', '_', $dateiname);
        $dateiname = str_replace('`', '_', $dateiname);
        $dateiname = str_replace("'", '_', $dateiname);
        $dateiname = str_replace('~', '_', $dateiname);
        $dateiname = str_replace('@', '_', $dateiname);
        $dateiname = str_replace('µ', '_', $dateiname);
        $dateiname = str_replace('=', '_', $dateiname);
        $dateiname = str_replace('&', '_', $dateiname);

        return $dateiname;
    }

    /**
     * htmlentities() does not support Mac Roman, so this is a workaround. It requires the below table.
     * This public function runs on a Mac OSX machine, where text is stored in the Mac Roman character
     * set inside a Mac OSX MySQL table.
     * @param $title
     * @return string
     */
    public function makeTitleLink($title): string
    {
        $title = str_replace('#', 'sharp', $title);
        $title = str_replace('/', 'or', $title);
        $title = str_replace('$', '', $title);
        $title = str_replace('&amp;', 'and', $title);
        $title = str_replace('&', 'and', $title);
        $title = str_replace('+', 'plus', $title);
        $title = str_replace(',', '', $title);
        $title = str_replace(':', '', $title);
        $title = str_replace(';', '', $title);
        $title = str_replace('=', 'equals', $title);
        $title = str_replace('?', '', $title);
        $title = str_replace('@', 'at', $title);
        $title = str_replace('<', '', $title);
        $title = str_replace('>', '', $title);
        $title = str_replace('%', '', $title);
        $title = str_replace('{', '', $title);
        $title = str_replace('}', '', $title);
        $title = str_replace('|', '', $title);
        $title = str_replace('\\', '', $title);
        $title = str_replace('^', '', $title);
        $title = str_replace('~', '', $title);
        $title = str_replace('[', '', $title);
        $title = str_replace(']', '', $title);
        $title = str_replace('`', '', $title);
        $title = str_replace("'", '', $title);
        $title = str_replace('"', '', $title);
        $title = str_replace(' ', '', $title);

        return $title;
    }

    /**
     * @param $message
     * @return string
     */
    public function makeWysiwygReplace($message): string
    {
        $message = trim($message);
        if ('' === $message) {
            return '';
        }
        $message = str_replace('&nbsp;', ' ', $message);
        $message = trim($message);
        if ('<br>' === substr($message, 0, 3) || '<BR>' === substr($message, 0, 3)) {
            $message = substr($message, 4);
        }
        $message = trim($message);
        if ('<br>' === substr($message, 0, 3) || '<BR>' === substr($message, 0, 3)) {
            $message = substr($message, 4);
        }
        $message = trim($message);
        if ('<br>' === substr($message, 0, 3) || '<BR>' === substr($message, 0, 3)) {
            $message = substr($message, 4);
        }
        $message = trim($message);
        if ('<br>' === $message || '<BR>' === $message) {
            return '';
        }

        $message = trim($message);
        if ('<br>' === $message) {
            return '';
        }
        if ('<br>' === substr($message, 0, 3)) {
            $message = substr($message, 4);
        }
        $message = str_replace('&shy;', '', $message);
        $message = str_replace('²', '&sup2;', $message);
        $message = str_replace('³', '&sup3;', $message);
        // Entferne alle MS Tags
        $pattern = '/mso-[^:]+:[^;"]+;/imsSUxu';
        $ersatz = '';
        preg_replace($pattern, $ersatz, $message);
        $pattern = '/<o:p>.*?<\/o:p>/imsSUxu';
        $ersatz = '';
        preg_replace($pattern, $ersatz, $message);
        $pattern = '/TEXT-INDENT: 0cm/imsSUxu';
        $ersatz = '';
        preg_replace($pattern, $ersatz, $message);
        $pattern = '/PAGE-BREAK-BEFORE: [^\s;]+;/imsSUxu';
        $ersatz = '';
        preg_replace($pattern, $ersatz, $message);
        $pattern = '/tab-stops:[^;"]/imsSUxu';
        $ersatz = '';
        preg_replace($pattern, $ersatz, $message);
        $pattern = '/<(\w[^>]*) class=([^ |>]*)([^>]*)/imsSUxu';
        $ersatz = '';
        preg_replace($pattern, $ersatz, $message);
        $pattern = '/<(\w[^>]*) style="([^\"]*)"([^>]*)/imsSUxu';
        $ersatz = '';
        preg_replace($pattern, $ersatz, $message);
        $pattern = '/<\\?\?xml[^>]*>/imsSUxu';
        $ersatz = '';
        preg_replace($pattern, $ersatz, $message);

        $message = str_replace('<em>', '<i>', $message);
        $message = str_replace('<EM>', '<i>', $message);
        $message = str_replace('</em>', '</i>', $message);
        $message = str_replace('</EM>', '</i>', $message);
        $message = strip_tags($message, '<span><table><tr><td><th><nobr><img><div><p><b><sup><sub>' .
            '<strong><font><i><u><a><h1><h2><h3><h4><h4><h5><h6><br><ul><li><ol><iframe><object><param><embed>' .
            '<script><noscript><font><span><div><br>');
        $message = str_replace(' class=MsoNormal', '', $message);
        $message = str_replace(' class="MsoNormal"', '', $message);
        $message = str_replace('<![if !supportEmptyParas]>&nbsp;<![endif]>', '', $message);
        $message = str_replace('style="border: 1px dashed #AAAAAA;"', '', $message);
        $message = str_replace('BORDER-RIGHT: #aaaaaa 1px dashed;', '', $message);
        $message = str_replace('BORDER-TOP: #aaaaaa 1px dashed;', '', $message);
        $message = str_replace('BORDER-LEFT: #aaaaaa 1px dashed;', '', $message);
        $message = str_replace('BORDER-BOTTOM: #aaaaaa 1px dashed;', '', $message);
        $message = str_replace('border: 1px dashed #AAAAAA', '', $message);
        $message = str_replace('BORDER-RIGHT: #aaaaaa 1px dashed', '', $message);
        $message = str_replace('BORDER-TOP: #aaaaaa 1px dashed', '', $message);
        $message = str_replace('BORDER-LEFT: #aaaaaa 1px dashed', '', $message);
        $message = str_replace('BORDER-BOTTOM: #aaaaaa 1px dashed', '', $message);
        $message = str_replace('BORDER-RIGHT: #aaaaaa 1px dashed;', '', $message);
        $message = str_replace('BORDER-TOP: #aaaaaa 1px dashed;', '', $message);
        $message = str_replace('BORDER-LEFT: #aaaaaa 1px dashed;', '', $message);
        $message = str_replace('BORDER-BOTTOM: #aaaaaa 1px dashed;', '', $message);
        $message = str_replace('MARGIN: auto 0cm', '', $message);
        $message = str_replace('MARGIN: 0pt 0pt 0pt 0pt', '', $message);
        $message = str_replace('MARGIN: 0cm 0cm 0cm 0cm', '', $message);
        $message = str_replace('MARGIN: 0cm 0cm 0cm 0pt', '', $message);
        $message = str_replace('MARGIN: 0cm 0cm 0pt 0pt', '', $message);
        $message = str_replace('MARGIN: 0cm 0pt 0pt', '', $message);
        $message = str_replace('MARGIN: 0pt 0pt 0pt', '', $message);
        $message = str_replace('MARGIN: 0cm 0cm 0pt', '', $message);
        $message = str_replace('MARGIN: 0cm -5.4pt 0pt 0cm', '', $message);
        $message = str_replace('class=MsoBodyText ', '', $message);
        $message = str_replace('prevstyle=" "', '', $message);
        $message = str_replace('border: 1px dashed #AAAAAA;', '', $message);
        $message = str_replace("'", '&#39;', $message);
        $message = str_replace('Ä', '&Auml;', $message);
        $message = str_replace('ä', '&auml;', $message);
        $message = str_replace('Ö', '&Ouml;', $message);
        $message = str_replace('ö', '&ouml;', $message);
        $message = str_replace('Ü', '&Uuml;', $message);
        $message = str_replace('ü', '&uuml;', $message);
        $message = str_replace('ß', '&szlig;', $message);
        $message = str_replace('€', '&euro;', $message);
        $message = str_replace('é', '&eacute;', $message); //é
        $message = str_replace('É', '&Eacute;', $message); //É
        $message = str_replace('è', '&egrave;', $message); //è
        $message = str_replace('È', '&Egrave;', $message); //È
        $message = str_replace('ó', '&oacute;', $message); //È
        $message = str_replace('Ó', '&Oacute;', $message); //È
        $message = str_replace('„', '&bdquo;', $message);
        $message = str_replace('“', '&ldquo;', $message);
        $message = str_replace('’', '&rsquo;', $message);
        $message = str_replace('(c)', '&copy;', $message);
        $message = str_replace('(C)', '&copy;', $message);
        $message = str_replace('(r)', '<sup>&reg;</sup>', $message);
        $message = str_replace('(R)', '<sup>&reg;</sup>', $message);
        $search = [
            chr(145),
            chr(146),
            chr(147),
            chr(148),
            chr(150),
            chr(151)
        ];
        $replace = ["'", "'", '&quot;', '&quot;', '&ndash;', '&ndash;'];
        $hold = str_replace($search[0], $replace[0], $message);
        $hold = str_replace($search[1], $replace[1], $hold);
        $hold = str_replace($search[2], $replace[2], $hold);
        $hold = str_replace($search[3], $replace[3], $hold);
        $hold = str_replace($search[4], $replace[4], $hold);
        $message = str_replace($search[5], $replace[5], $hold);
        $message = str_replace("'", '&#39;', $message);
        // Flash und Javascripts wieder als richtigen Quellcode darstellen
        $pattern = '/<script type="text\/javascript">(.*?)<\/script>/is';
        preg_match_all($pattern, $message, $array);
        if ('' !== $array['1']) {
            $ersetzen = $array['1'];
            $ersetzen = str_replace('&#39;', '"', $ersetzen);
            $message = str_replace($array['1'], $ersetzen, $message);
        }
        $message = str_replace('&quot;&quot;', "''", $message);
        while (preg_match('/<a#(.*)#a>/isU', $message, $pregMatch)) {
            $arrayString = explode('&quot;', $pregMatch[1]);
            $message = preg_replace('/<a#' . $pregMatch[1] . '#a>/isU', "'", $message);
        }

        return $message;
    }

    public function makeCustomHtmlentities($string, $table)
    {
        // Loop throught the array, replacing each ocurrance
        $max = count($table);
        for ($n = 0; $n < $max; ++$n) {
            $table_line = each($table);
            // use the chrpublic function to get the one character string for each ascii decimal code
            $find_char = chr($table_line[key]);
            $replace_string = $table_line[value];
            $string = str_replace($find_char, $replace_string, $string);
        }

        return $string;
    }

    public function changeIsoToMac($text)
    {
        $text = iconv('UTF-8', 'macintosh', $text);
    }

    public function makeReplaceUtf($text)
    {
        $text = trim($text);
        if ('' === $text) {
            return '';
        }
        preg_replace('/ +/', ' ', $text);
        $text = str_replace('&shy;', '', $text);
        $text = str_replace('AE', 'Ä', $text);
        $text = str_replace('OE', 'Ö', $text);
        $text = str_replace('UE', 'Ü', $text);
        $text = str_replace('&#039;', '', $text);
        $text = str_replace("'", '', $text);
        $text = str_replace(',', '<br>', $text);
        $text = ucwords(strtolower($text));
        $text = str_replace('Drk-a', 'DRK-A', $text);
        $text = str_replace('Drk-b', 'DRK-B', $text);
        $text = str_replace(' Grundschule', ' Grundschule<br>', $text);
        $text = str_replace('In Der Grundschule<br>', 'Grundschule<br>', $text);
        $text = str_replace('<br><br>', '<br>', $text);
        $text = str_replace('Michälisdonn', 'Michaelisdonn', $text);
        $text = str_replace('In Der Waldorfschule', 'Waldorfschule', $text);
        $text = str_replace('Neü', 'Neue', $text);
        $text = str_replace('Feürwehr', 'Feuerwehr', $text);
        $text = str_replace('Grundschule Wilhelmstr', 'Grundschule<br>Wilhelmstr', $text);
        $text = str_replace('/d', '/D', $text);
        $text = preg_replace("/\s+/", ' ', $text);
        $text = str_replace('Ev. Gemeindehaus ', 'Ev. Gemeindehaus<br>', $text);
        $text = str_replace('<br> ', '<br>', $text);
        $text = str_replace('Lohe-rickelshof', 'Lohe-Rickelshof', $text);
        $text = str_replace('Neocorus-schule', 'Neocorus-Schule', $text);

        return $text;
    }

    public function makeLatin1ToUtf($txt)
    {
        $txt = str_replace('ö', 'à¶', $txt);
        $txt = str_replace('ü', 'à¼', $txt);
        $txt = str_replace('ß', 'àY', $txt);
        $txt = str_replace('ä', 'à¤', $txt);
        $txt = str_replace('Ä', 'à', $txt);
        $txt = str_replace('Ü', 'ào', $txt);
        $txt = str_replace('Ö', 'à-', $txt);
        $txt = str_replace('Ë', 'è', $txt);

        return $txt;
    }

    /**
     * Markiert ein Suchwort in einem Text.
     *
     * @param string $suchwort
     * @param string $text
     *
     * @return string
     *             2010-05-28 JM Erneuert, da split veraltet war und dadurch Fehler produziert wurden
     */
    public function makeMarkerForWord($suchwort, $text)
    {
        $text = trim($text);
        if ('' === $text) {
            return '';
        }
        //$suchwort = split(" ",$suchwort);
        $suchwort = preg_split("/[\s,]+/", $suchwort);
        foreach ($suchwort as $key => $search) {
            $search = trim($search);
            if ('' !== $search) {
                $search_str = '/' . $search . '/isU';
                $text = preg_replace($search_str, '<font class=suchwort>\0</font>', $text);
            }
        }

        return $text;
    }

    public function searchText($text, $suchwort)
    {
        $text = trim($text);
        if ('' === $text) {
            return '';
        }
        $suchwort = $this->makeCharReplace($suchwort);
        //$suchwort = split(" ",$suchwort);
        $suchwort = preg_split("/[\s,]+/", $suchwort);
        $ergebnis = [];
        foreach ($suchwort as $testw) {
            $textstring = '';
            $part = $this->makeTextCut($text, $testw);
            if (strncmp($part, $text, 15)) {
                $textstring = '... ';
            }
            $textstring .= $part;
            if (strcmp(substr($part, -15), substr($text, -15))) {
                $textstring .= ' ...';
            }
            $textstring .= '';
            $ergebnis[] = $textstring;
        }

        return $ergebnis;
    }

    public function makeTextCut($text, $wort)
    {
        $text = trim($text);
        $text = strip_tags($text);
        if ('' === $text) {
            return '';
        }
        if (preg_match("/(^.{0,70}| .{70,90}|.{50})$wort(.{70,90} |.{0,70}$|.{70})/Um", $text, $found)) {
            return $found[0];
        } else {
            preg_match('/^(.{140,170} |.{0,170}$|.{170})/Um', $text, $found);

            return $found[0];
        }
    }

    /**
     * Ab hier Datum / Zeit.
     */

    public function makeXmlExportChar($text)
    {
        $text = trim($text);
        if ('' === $text) {
            return '';
        }
        $text = urldecode($text);
        $text = str_replace('Ã¤', '&auml;', $text); //ä
        $text = str_replace('Ã„', '&Auml;', $text); //Ä
        $text = str_replace('Ã¶', '&ouml;', $text); //ö
        $text = str_replace('Ã–', '&Ouml;', $text); //Ö
        $text = str_replace('Ã¼', '&uuml;', $text); //ü
        $text = str_replace('Ãœ', '&Uuml;', $text); //Ü
        $text = str_replace('ÃŸ', '&szlig;', $text); //ß
        $text = str_replace('Ã©', '&eacute;', $text); //é
        $text = str_replace('Ã¨', '&Eacute;', $text); //É
        $text = str_replace('Ã‰', '&egrave;', $text); //è
        $text = str_replace('Ãˆ', '&Egrave;', $text); //È
        $text = str_replace('&bdquo;', '"', $text);
        $text = str_replace('&ldquo;', '"', $text);
        $text = $this->makeCharReplaceOff(stripslashes($text));
        $text = strip_tags($text, '<br><a>');
        $text = str_replace("\n\r", '', $text);
        $text = str_replace("\n", '', $text);
        $text = str_replace("\r", '', $text);
        $text = str_replace("\t", '', $text);
        $text = str_replace('&ndash;', '-', $text);
        $text = str_replace('<br>', '<br />', $text);
        $text = str_replace('<', '&lt;', $text);
        $text = str_replace('>', '&gt;', $text);
        $text = nl2br($text);
        $text = utf8_encode($text);

        return $text;
    }

    /**
     * Function zum bauen des Tooltips.
     *
     * @param $word String
     * @param $text String
     *
     * @return string
     */
    public function buildTolltip($word, $text)
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

    /**
     * Erstelle eine TinyUrl.
     *
     * @param $url string
     */
    public function buildShortUrl($url)
    {
        $url = trim($url);
        if ('' === $url) {
            return '';
        }
        $link = '';
        if (function_exists('file_get_contents')) {
            $link = file_get_contents('http://tinyurl.com/api-create.php?url=' . $url);
        } elseif (function_exists('curl_init')) {
            $ch = curl_init();
            $timeout = 5;
            curl_setopt($ch, CURLOPT_URL, 'http://tinyurl.com/api-create.php?url=' . $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
            $link = curl_exec($ch);
            curl_close($ch);
        }

        return $link;
    }

    public function buildTrs($trs, $class_change = 0)
    {
        if (!is_array($trs)) {
            return;
        }
        if (0 === count($trs)) {
            return;
        }

        $build = '';
        $class = 'bgdunkel';

        foreach ($trs as $key => $tr) {
            if (is_array($tr)) {
                if (array_key_exists('title', $tr)) {
                    $build .= '<tr class="bgueberschrift"><td colspan="20">' . $tr['title'] . '</td></tr>';
                    $class = 'bgdunkel';
                } else {
                    $i = 0;
                    $build .= '<tr';
                    if ('1' === $class_change) {
                        if ('bgdunkel' === $class) {
                            $class = 'bghell';
                        } else {
                            $class = 'bgdunkel';
                        }
                        $build .= ' class="' . $class . '"';
                    }
                    if (array_key_exists('id', $tr)) {
                        $build .= ' id="' . $tr['id'] . '"';
                        unset($tr['id']);
                    }
                    $build .= '>';
                    $build .= '<td valign="top">' . join('</td><td valign="top">', $tr) . '</td>';
                    $build .= '</tr>';
                }
            } else {
                $build .= '<tr';
                if ('1' === $class_change) {
                    if ('bgdunkel' === $class) {
                        $class = 'bghell';
                    } else {
                        $class = 'bgdunkel';
                    }
                    $build .= ' class="' . $class . '"';
                }
                $build .= '>';
                $build .= '<td valign="top">' . $tr . '</td>';
                $build .= '</tr>';
            }
        }

        return $build;
    }

    /**
     *  Baue Abwechsler.
     *
     * @variable $trs ARRAY
     * @variable $class_change Boolean
     *
     * @return string
     */
    public function buildTable($trs, $class_change = 0, $class = '')
    {
        $build = '';
        if (0 === count($trs)) {
            return '';
        }
        if (1 === $class_change) {
            $class = 'bgdunkel';
            foreach ($trs as $key => $tr) {
                if ('bgdunkel' === $class) {
                    $class = 'bghell';
                } else {
                    $class = 'bgdunkel';
                }
                $build .= '<tr class="' . $class . '"';
                if (array_key_exists('title', $tr)) {
                    $build .= ' title="' . $tr['title'] . '"';
                }
                $build .= '>';
                $build .= '<td valign="top">' . $tr['links'] . '</td>';
                $build .= '<td valign="top">' . $tr['rechts'] . '</td>';
                $build .= '</tr>';
            }
        } else {
            foreach ($trs as $key => $tr) {
                $build .= '<tr';
                if (array_key_exists('title', $tr)) {
                    $build .= ' title="' . $tr['title'] . '"';
                }
                $build .= '>';
                $build .= '<td valign="top">' . $tr['links'] . '</td>';
                $build .= '<td valign="top">' . $tr['rechts'] . '</td>';
                $build .= '</tr>';
            }
        }

        return $build;
    }

    /**
     * Baue Selectbox, abfrage ob Array oder normale Value.
     *
     * @param $values Array
     * @param $select String
     * @param $name String
     * @param $size String
     */
    public function buildSelect($values, $selected, $name, $size = '', $id = '', $onchange = '', $class = '')
    {
        if (0 === count($values)) {
            return '';
        }
        $select = [];
        $select['name'] = $name;
        $size = trim($size);
        $id = trim($id);
        $onchanhge = trim($onchange);
        if ('' !== $size) {
            $select['size'] = $size;
        }
        if ('' !== $id) {
            $select['id'] = $id;
        }
        if ('' !== $onchange) {
            $select['onChange'] = $onchange;
        }
        if ('' !== $class) {
            $select['class'] = $class;
        }

        $sel = '';
        foreach ($select as $key => $val) {
            if ('' !== $sel) {
                $sel .= ' ';
            }
            $sel .= $key . '="' . $val . '"';
        }

        $tx = '<select ' . $sel . '>';
        foreach ($values as $key => $val) {
            $value = $val;
            $label = $val;
            if (is_array($val)) {
                $value = $val['value'];
                $label = $val['label'];
            }
            $tx .= '<option value="' . $value . '"' . $this->checkSelected($value, $selected);
            $tx .= '>' . $label . '</option>';
        }
        $tx .= '</select>';

        return $tx;
    }

    /**
     *  Check ob gleich, dann Selected den Bereich.
     */
    public function checkSelected($i, $j)
    {
        $i = trim($i);
        $j = trim($j);
        if ($i === $j) {
            return ' selected="selected"';
        }

        return '';
    }

    /**
     * Checkt ob der erste Wert mit dem 2 Übereinstimmt und gibt dann checked zurück.
     *
     * @param $i String
     * @param $j String/array
     */
    public function checkCheckbox($i, $j)
    {
        if (is_array($i) && is_array($j)) {
            echo '<p style="color:#FF0000; font-weight:bold;">';
            echo 'Es wurden 2 Arrays &uuml;bergeben beim Checkbox-Check!!!</p>';

            return '';
        }
        if (is_array($i) && (!is_array($j))) {
            $t = $j;
            $j = $i;
            $i = $t;
        }
        $i = trim($i);
        if (is_array($j)) {
            if (in_array($i, $j)) {
                return ' checked="checked"';
            }
        } else {
            $j = trim($j);
            if ($i === $j) {
                return ' checked="checked"';
            }
        }

        return '';
    }

    /**
     *  Check ob gleich, dann Selected den Bereich
     */
    public function check_selected($i, $j)
    {
        $i = trim($i);
        $j = trim($j);
        if ($i == $j) {
            return ' selected="selected"';
        }
        return '';
    }

    /**
     * Gibt das deutsche Datum zurück.
     *
     * @param englisch
     *
     * @return deutsch
     */
    public function getDatumDe($datum)
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

    /**
     * Gibt das deutsche Datum nur Tag und Monat zurück.
     *
     * @param englisch     *
     * @return deutsch
     */
    public function makeDateDayMonthDe($datum)
    {
        $datum = trim($datum);
        $alt = $datum;
        if ('' === $datum || null === $datum || 'NULL' === $datum || '0000-00-00' === $datum) {
            return '';
        }
        $datum = explode('-', $datum);
        if (3 !== count($datum)) {
            echo "<p class='fehler'>Datum wurde falsch eingeben! Bitte folgendes Format nutzen: 0000-00-00</p>";
            echo '<p class="fehler">Es wurde <i>' . $alt . '</i> eingegeben!</p>';

            return '00.00.';
        }
        $datum = $datum[2] . '.' . $datum[1] . '.';

        return $datum;
    }

    /**
     * Gibt das deutsche Datum 2 stellig zurück.
     *
     * @param englisch
     *
     * @return deutsch
     */
    public function getDateDeSmall($datum)
    {
        $datum = trim($datum);
        $alt = $datum;
        if ('' === $datum || null === $datum || 'NULL' === $datum || '0000-00-00' === $datum) {
            return;
        }
        $datum = explode('-', $datum);
        if (3 !== count($datum)) {
            echo "<p class='fehler'>Datum wurde falsch eingeben! Bitte folgendes Format nutzen: 0000-00-00</p>";
            echo '<p class="fehler">Es wurde <i>' . $alt . '</i> eingegeben!</p>';

            return '00.00.00';
        }
        $jahr = substr($datum[0], -2);
        $datum = $datum[2] . '.' . $datum[1] . '.' . $jahr;

        return $datum;
    }

    /**
     * Gibt das englische Datum zurück.
     *
     * @param deutsch
     *
     * @return englisch
     */
    public function getDatumEn($datum)
    {
        $datum = trim($datum);
        $alt = $datum;
        $datum = str_replace(',', '.', $datum);
        if ('' === $datum || null === $datum || '00.00.0000' === $datum) {
            return;
        }
        $datum = explode('.', $datum);
        if (3 !== count($datum)) {
            echo '<p class="fehler">Datum wurde falsch eingeben! Bitte folgendes Format nutzen: 00.00.0000</p>';
            echo '<p class="fehler">Es wurde <i>' . $alt . '</i> eingegeben!</p>';

            return '0000-00-00';
        }
        $datum = $datum[2] . '-' . $datum[1] . '-' . $datum[0];

        return $datum;
    }

    /**
     * Gibt das Datum als dd.mm.YY HH:ii zurück.
     *
     * @param string $datum
     *
     * @return string
     */
    public function getDatumZeit($datum)
    {
        $datum = trim($datum);
        if ('' === $datum || null === $datum) {
            return;
        }
        $datum = explode(' ', $datum);
        $tag = explode('-', $datum[0]);
        if (3 !== count($tag)) {
            echo "<p class='fehler'>Datum wurde falsch eingeben! Bitte folgendes Format nutzen: ";
            echo "0000-00-00 00:00:00</p>";

            return '00.00.0000 00:00';
        }
        $tag = $tag[2] . '.' . $tag[1] . '.' . $tag[0];
        $zeit = explode(':', $datum[1]);
        if (3 !== count($zeit)) {
            echo "<p class='fehler'>Datum wurde falsch eingeben! Bitte folgendes Format nutzen: ";
            echo "0000-00-00 00:00:00</p>";

            return '00.00.0000 00:00';
        }
        $zeit = $zeit[0] . ':' . $zeit[1];

        return $tag . ' ' . $zeit;
    }

    public function checkValidDate($date)
    {
        $date = trim($date);
        if ('' === $date) {
            return false;
        }
        $date = str_replace(',', '.', $date);
        if (10 !== strlen($date)) {
            return false;
        }
        preg_match('/[.]+/', $date, $array);
        if (count($array) > 0) {
            $date = explode('.', $date);
            $date = $date[1] . '-' . $date[0] . '-' . $date[2];
        }
        $date = str_replace(' ', '-', $date);
        $date = str_replace('/', '-', $date);
        $date = str_replace('--', '-', $date);
        preg_match('/^(\d{2})-(\d{2})-(\d{4})$/', $date, $xadBits);
        $check = checkdate($xadBits[1], $xadBits[2], $xadBits[3]);

        return $check;
    }

    public function makeDateTimeDe($datetime)
    {
        $datetime = trim($datetime);
        $string = explode(' ', $datetime);
        if (2 !== count($string)) {
            echo "<p class='fehler'>Datum wurde falsch eingeben! Bitte folgendes Format nutzen: ";
            echo "0000-00-00 00:00:00</p>";

            return '00.00.0000 00:00:00';
        }
        $datum = explode('-', $string[0]);
        $datum = $datum[2] . '.' . $datum[1] . '.' . $datum[0];

        return $datum . ' ' . $string[1];
    }

    /**
     * Überprüfe die Zeit ob es sich um eine Uhrzeit handelt.
     *
     * @param string $zeit
     *
     * @return string
     */
    public function makeTime($zeit): string
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

    /**
     * @param $monat
     * @return int|string
     */
    public function getQuartal($monat): int
    {
        $monat = trim($monat);
        if ('' === $monat || !is_numeric($monat)) {
            return 'FEHLER!!!!';
        }
        if ($monat < 1 || $monat > 12) {
            return 'FEHLER!!!!';
        }
        switch ($monat) {
            case '1':
            case '2':
            case '3':
                $monat = 1;
                break;

            case '4':
            case '5':
            case '6':
                $monat = 2;
                break;

            case '7':
            case '8':
            case '9':
                $monat = 3;
                break;

            case '10':
            case '11':
            case '12':
                $monat = 4;
                break;
        }

        return $monat;
    }

    /**
     * Gibt zurück wie viele Tage und Stunden es bis zu einem Datum sind
     * echo $Tools->makeDateCountdown("30.08.2008 21:30:00");.
     *
     * @param string $Datum
     *
     * @return string
     */
    public function makeDateCountdown($Datum)
    {
        $Datum = trim($Datum);
        if ('' === $Datum) {
            return '';
        }
        $Zieldatum = mktime(
            substr(
                $Datum,
                11,
                2
            ),
            substr(
                $Datum,
                14,
                2
            ),
            substr(
                $Datum,
                17,
                2
            ),
            substr(
                $Datum,
                3,
                2
            ),
            substr(
                $Datum,
                0,
                2
            ),
            substr(
                $Datum,
                6,
                4
            )
        );
        $Differenz = $Zieldatum - time();
        $Tage = floor($Differenz / 86400);
        $Wochen = floor($Tage / 7);
        $Tag = $Wochen * 7;
        $Noch = $Tage - $Tag;
        $Rest = $Differenz - ($Tage * 86400);
        $Stunden = floor($Rest / 3600);
        $Rest = $Rest - ($Stunden * 3600);
        $Minuten = floor($Rest / 60);
        $Rest = $Rest - ($Minuten * 60);
        if ($Wochen > '0') {
            $Zeit = "$Wochen Wochen, $Noch Tage, $Stunden Stunden, $Minuten Minuten und $Rest Sekunden";
        }
        if ('0' === $Wochen) {
            $Zeit = "$Noch Tage, $Stunden Stunden, $Minuten Minuten und $Rest Sekunden";
        }
        if (('0' === $Wochen) and ('0' === $Noch)) {
            $Zeit = "$Stunden Stunden, $Minuten Minuten und $Rest Sekunden";
        }
        if (('0' === $Wochen) and ('0' === $Noch) and ('0' === $Stunden)) {
            $Zeit = "$Minuten Minuten und $Rest Sekunden";
        }
        if (('0' === $Wochen) and ('0' === $Noch) and ('0' === $Stunden) and ('0' === $Minuten)) {
            $Zeit = "$Rest Sekunden";
        }

        return $Zeit;
    }

    /**
     * @param $Datum
     * @return int|string|void
     */
    public function getWochentag($Datum)
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

    /**
     * @param $Datum
     * @return int|string|void
     */
    public function getWochentagLang($Datum)
    {
        $Datum = trim($Datum);
        if ('' === $Datum) {
            return '-1';
        }
        $Tage = ['Sonntag', 'Montag', 'Dienstag', 'Mittwoch', 'Donnerstag', 'Freitag', 'Samstag'];
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

    /**
     * @param $begin
     * @param $end
     * @param $format
     * @param $sep
     * @return int
     */
    public function makeDateDays($begin, $end, $format, $sep)
    {
        $pos1 = strpos($format, 'd');
        $pos2 = strpos($format, 'm');
        $pos3 = strpos($format, 'Y');
        $begin = explode($sep, $begin);
        $end = explode($sep, $end);
        $first = gregoriantojd($end[$pos2], $end[$pos1], $end[$pos3]);
        $second = gregoriantojd($begin[$pos2], $begin[$pos1], $begin[$pos3]);
        if ($first > $second) {
            return $first - $second;
        } else {
            return $second - $first;
        }
    }

    /**
     * $days = array(
     * 2=>array('index.php?mod=kalender&termin=2','linked-day'),
     * 3=>array('index.php?mod=kalender&termin=3','linked-day'),
     * 8=>array('index.php?mod=kalender&termin=8','linked-day'),
     * 22=>array('index.php?mod=kalender&termin=22','linked-day'),
     * );
     * if (count($days)==0)
     * {
     *     $days=NULL;
     * }
     * $time = time();
     * $oldlocale = setlocale(LC_TIME, NULL); #save current locale
     * setlocale(LC_TIME, 'de_DE');
     * echo generateCalendar(date('Y', $time), date('n', $time), $days, 2, NULL, 1);
     * setlocale(LC_TIME, $oldlocale);.
     */
    public function generateCalendar(
        $year,
        $month,
        $days = [],
        $day_name_length = 3,
        $month_href = null,
        $first_day = 0,
        $pn = []
    ) {
        $first_of_month = gmmktime(0, 0, 0, $month, 1, $year);
        $day_names = [];
        for ($n = 0, $t = (3 + $first_day) * 86400; $n < 7; $n++, $t += 86400) {
            $day_names[$n] = ucfirst(gmstrftime('%A', $t)); //%A means full textual day name
        }

        list($month, $year, $month_name, $weekday) = explode(',', gmstrftime('%m,%Y,%B,%w', $first_of_month));
        $weekday = ($weekday + 7 - $first_day) % 7; //adjust for $first_day
        //note that some locales don't capitalize month and day names
        $title = htmlentities(ucfirst($month_name)) . '&nbsp;' . $year;

        @list($p, $pl) = each($pn);
        @list($n, $nl) = each($pn); //previous and next links, if applicable
        if ($p) {
            $p = '<span class="calendar-prev">' . ($pl ?
                    '<a href="' . htmlspecialchars($pl) . '">' . $p . '</a>' :
                    $p) . '</span>&nbsp;';
        }
        if ($n) {
            $n = '&nbsp;<span class="calendar-next">' . ($nl ?
                    '<a href="' . htmlspecialchars($nl) . '">' . $n . '</a>' :
                    $n) . '</span>';
        }
        $calendar = '<table class="calendar">' . "\n" .
            '<caption class="calendar-month">' . $p . ($month_href ?
                '<a href="' . htmlspecialchars($month_href) . '">' . $title . '</a>' :
                $title) . $n . "</caption>\n<tr>";

        if ($day_name_length) {    //if the day names should be shown ($day_name_length > 0)
            //if day_name_length is >3, the full name of the day will be printed
            foreach ($day_names as $d) {
                $style = 'padding:2px;';
                if ('So' === substr($d, 0, $day_name_length)) {
                    $style = ' color: #FF0000;';
                }
                $calendar .= '<th class="bgueberschrift" style="' . $style . '" abbr="' . htmlentities($d) . '">'
                    . htmlentities($day_name_length < 4 ? substr($d, 0, $day_name_length) : $d) . '</th>';
            }
            $calendar .= "</tr>\n<tr>";
        }

        if ($weekday > 0) {
            $calendar .= '<td colspan="' . $weekday . '">&nbsp;</td>'; //initial 'empty' days
        }
        for ($day = 1, $days_in_month = gmdate('t', $first_of_month); $day <= $days_in_month; $day++, $weekday++) {
            if (7 === $weekday) {
                $weekday = 0; //start a new week
                $calendar .= "</tr>\n<tr>";
            }
            if (isset($days[$day]) and is_array($days[$day])) {
                @list($link, $classes, $content) = $days[$day];
                if (is_null($content)) {
                    $content = $day;
                }
                $calendar .= '<td' . ($classes ? ' class="' . htmlspecialchars($classes) . '">' : '>') .
                    ($link ? '<a href="' . htmlspecialchars($link) . '">' . $content . '</a>' : $content) . '</td>';
            } else {
                $class = '';
                if (date('Y-m-d') === ($year . '-' . $month . '-' . $day)) {
                    $class = ' class="today"';
                }
                $calendar .= '<td' . $class . ">$day</td>";
            }
        }
        if (7 !== $weekday) {
            $calendar .= '<td colspan="' . (7 - $weekday) . '">&nbsp;</td>'; //remaining "empty" days
        }

        return $calendar . "</tr>\n</table>\n";
    }

    /**
     * Gibt das getSternzeichen zurück.
     *
     * @param datum $datum
     *
     * @return string
     */
    public function getSternzeichen($datum)
    {
        $datum = trim($datum);
        if ('' === $datum) {
            return '-1';
        }
        $datum = str_replace(',', '.', $datum);
        $date = explode('.', $datum);
        $day = $date[0];
        $month = $date[1];
        $zodiac = ['Steinbock', 'Steinbock', 'Wassermann', 'Fische', 'Widder',
            'Stier', 'Zwilling', 'Krebs', 'Löwe', 'Jungfrau', 'Waage',
            'Skorpion', 'Schütze',];

        $dates = [0 => [mktime(0, 0, 0, 12, 22), mktime(0, 0, 0, 12, 31)],
            1 => [mktime(0, 0, 0, 1, 01), mktime(0, 0, 0, 1, 19)],
            2 => [mktime(0, 0, 0, 1, 20), mktime(0, 0, 0, 2, 18)],
            3 => [mktime(0, 0, 0, 2, 19), mktime(0, 0, 0, 3, 20)],
            4 => [mktime(0, 0, 0, 3, 21), mktime(0, 0, 0, 4, 19)],
            5 => [mktime(0, 0, 0, 4, 20), mktime(0, 0, 0, 5, 20)],
            6 => [mktime(0, 0, 0, 5, 21), mktime(0, 0, 0, 6, 21)],
            7 => [mktime(0, 0, 0, 6, 22), mktime(0, 0, 0, 7, 22)],
            8 => [mktime(0, 0, 0, 7, 23), mktime(0, 0, 0, 8, 22)],
            9 => [mktime(0, 0, 0, 8, 23), mktime(0, 0, 0, 9, 22)],
            10 => [mktime(0, 0, 0, 9, 23), mktime(0, 0, 0, 10, 23)],
            11 => [mktime(0, 0, 0, 10, 24), mktime(0, 0, 0, 11, 21)],
            12 => [mktime(0, 0, 0, 11, 22), mktime(0, 0, 0, 12, 21)],];

        foreach ($dates as $k => $v) {
            if (mktime(0, 0, 0, $month, $day) >= $v[0] && mktime(0, 0, 0, $month, $day) <= $v[1]) {
                return $zodiac[$k];
            }
        }

        return '<p class="fehler">FEHLER</p>';
    }

    /**
     *  Wandelt Arabische in Römische Zahlen um.
     */
    public function makeRoemischeZahlen($zahl)
    {
        $roemisch = '';
        $RArray = ['M', 'CM', 'D', 'CD', 'C', 'XC', 'L', 'X', 'IX', 'V', 'IV', 'I'];
        $AArray = ['1000', '900', '500', '400', '100', '90', '50', '10', '9', '5', '4', '1'];
        $zahl = intval($zahl);

        if ($zahl <= 0) {
            return 'FEHLER!!';
        }
        for ($i = 0; $i < count($RArray); ++$i) {
            while ($zahl >= $AArray[$i]) {
                $roemisch .= $RArray[$i];
                $zahl -= $AArray[$i];
            }
        }

        return $roemisch;
    }

    /**
     * Ab hier Dateibehandlung.
     */
    public function getFileSize($URL)
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

    /**
     * @param $filename
     * @return string
     */
    public function getFileTypeTools($filename): string
    {
        $filename = trim($filename);
        if ('' === $filename) {
            return '';
        }
        $result = explode('.', $filename);
        return strtolower($result[(count($result) - 1)]);
    }

    public function getFileIcon($filetype)
    {
        $filetype = trim($filetype);
        if ('' === $filetype) {
            return '';
        }
        $filetype = strtolower($filetype);
        switch ($filetype) {
            /*Word + Texte*/
            case 'doc':
            case 'txt':
            case 'dot':
                $file = '<img src="grfx/word.png" border="0" class="icon" title="Word-Dokument" alt="Word-Dokument">';
                break;
                /*Word 2007/2010 + Texte*/
            case 'docx':
                $file = '<img src="grfx/docx.png" border="0" class="icon" title="Word 2007-Dokument" ';
                $file .= 'alt="Word 2007-Dokument">';
                break;
                /*Webseiten*/
            case 'htm':
            case 'html':
                $file = '<img src="grfx/html.png" border="0" class="icon" title="Online-Dokument" ';
                $file .= 'alt="Online-Dokument">';
                break;
                /*Musik + Audio Dateien*/
            case 'wav':
            case 'mp3':
                $file = '<img src="grfx/sound.png" border="0" class="icon" title="Audio-Datei" ';
                $file .= 'alt="Audio-Datei">';
                break;
                /*Video*/
            case 'avi':
            case 'asf':
            case 'mpg':
            case 'swf':
            case 'mpeg':
                $file = '<img src="grfx/film.png" border="0" class="icon" title="Film-Datei" ';
                $file .= 'alt="Film-Datei">';
                break;
                /*PDF*/
            case 'pdf':
                $file = '<img src="grfx/pdf.png" border="0" class="icon" title="PDF-Dokument" ';
                $file .= 'alt="PDF-Dokument">';
                break;
                /*PowerPoint*/
            case 'ppt':
            case 'pps':
            case 'ppz':
            case 'pcb':
            case 'pot':
            case 'pcs':
            case 'pot':
            case 'ppa':
            case 'ppi':
                $file = '<img src="grfx/powerpoint.png" border="0" class="icon" ';
                $file .= 'title="PowerPoint-Pr&auml;sentation" alt="PowerPoint-Pr&auml;sentation">';
                break;
                /*PowerPoint 2007*/
            case 'pptx':
                $file = '<img src="grfx/pptx.png" border="0" class="icon" ';
                $file .= 'title="PowerPoint 2007 -Pr&auml;sentation" alt="PowerPoint 2007 -Pr&auml;sentation">';
                break;
                /*Excel*/
            case 'xls':
            case 'xlt':
                $file = '<img src="grfx/excel.png" border="0" class="icon" ';
                $file .= 'title="Excel-Dokument" alt="Excel-Dokument">';
                break;
                /*Excel 2007*/
            case 'xlsx':
                $file = '<img src="grfx/xlsx.png" border="0" class="icon" ';
                $file .= 'title="Excel 2007 -Dokument" alt="Excel 2007 -Dokument">';
                break;
                /*Komprimierte Dateien*/
            case 'rar':
            case 'gzip':
            case 'tar':
            case 'zip':
                $file = '<img src="grfx/zip.png" border="0" class="icon" ';
                $file .= 'title="Komprimierte-Datei" alt="Komprimierte-Datei">';
                break;
                /*Bilder und Sonstige*/
            default:
                $file = '<img src="grfx/picture.png" border="0" class="icon" title="Bild" alt="Bild">';
                break;
        }

        return $file;
    }

    public function makeEuroToServer($preis)
    {
        $preis = trim($preis);
        if ('' === $preis || null === $preis) {
            return;
        }
        $preis = trim($preis);
        $preis = str_replace('.', '', $preis);
        $preis = str_replace(' ', '', $preis);
        $preis = str_replace(',', '.', $preis);
        $preis = sprintf('%01.2f', $preis);
        $preis = str_replace(',', '.', $preis);

        return $preis;
    }

    public function makeServerToEuro($preis)
    {
        $preis = trim($preis);
        if ('' === $preis || null === $preis) {
            return;
        }
        $preis = number_format($preis, 2, ',', '.');

        return $preis;
    }

    public function makeEnglishNumber($betrag)
    {
        $betrag = trim($betrag);
        if ('' === $betrag || null === $betrag) {
            return;
        }
        $betrag = str_replace(' ', '', $betrag);
        $betrag = str_replace('.', '', $betrag);
        $betrag = str_replace(',', '.', $betrag);
        $betrag = sprintf('%01.2f', $betrag);
        $betrag = str_replace(',', '.', $betrag);

        return $betrag;
    }

    /**
     * Text nach 75 Zeichen umbrechen.
     *
     * @param string $beitrag
     *
     * @return string
     */
    public function makeTextBreak($beitrag)
    {
        $beitrag = trim($beitrag);
        if ('' === $beitrag) {
            return '';
        }
        $Absaetze = explode("\n", $beitrag);
        $Umbruch = 75;
        for ($i = 0, $GewandelterText = ''; $i < count($Absaetze); ++$i) {
            $GewandelterText .= wordwrap($Absaetze[$i], $Umbruch, '<br>', 1);
            $GewandelterText .= "\n<br>";
        }

        return $GewandelterText;
    }

    /**
     * Texte nach X Zeichen umbrechen lassen, und vorher/nachher Über den Umwandler laufen lassen.
     *
     * @param string $text
     * @param string $len
     *
     * @return string $text
     */
    public function makeTextBreakLen($text, $len = 75)
    {
        $text = trim($text);
        if ('' === $text) {
            return '';
        }
        $text = $this->makeCharReplaceOff($text);
        $text = wordwrap($text, $len, "\n", true);
        $text = $this->makeCharReplace($text);

        return $text;
    }

    public function makeSearchWordMarked($wort, $text)
    {
        $text = trim($text);
        if ('' === $text) {
            return '';
        }
        $wort = trim($wort);
        if ('' === $wort) {
            return '';
        }
        $wort = $this->makeCharReplace($wort);
        $text = str_replace($wort, '<font color="red"><b>' . $wort . '</b></font>', $text);

        return $text;
    }

    public function makeCutString($text, $len, $pdf = 0)
    {
        $text = trim($text);
        if ('' === $text) {
            return '';
        }
        $len = trim($len);
        if ('' === $len) {
            return '';
        }
        if (!is_numeric($len)) {
            $len = 20;
        }
        if (strlen($text) > $len) {
            if (0 === $pdf) {
                $text = $this->makeCharReplaceOff($text);
            }
            $text = substr($text, 0, $len);
            if (0 === $pdf) {
                $text = $this->makeCharReplace($text);
            }
            $text = $text . '...';
        }

        return $text;
    }

    /**
     * Schneide den Text nach z.B. nach 2 Sätzen ab.
     *
     * @param string $txt
     * @param string $saetze
     */
    public function makeCutStringing($txt, $saetze = 2)
    {
        $txt = trim($txt);
        if ('' === $txt) {
            return '';
        }
        $saetze = trim($saetze);
        if ('' !== $saetze) {
            if (!is_numeric($saetze)) {
                $saetze = 2;
            }
        }
        $monate = [
            'Januar',
            'Februar',
            'M&auml;rz',
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
        $txt = str_replace(' (pid).', ' (pid)', $txt);
        $txt = str_replace(' e.V. ', ' e_V_ ', $txt);
        $txt = str_replace(' e. V. ', ' e__V_ ', $txt);
        $txt = str_replace(' d. R. ', ' d__R_ ', $txt);
        $txt = str_replace(' d.R. ', ' d_R_ ', $txt);
        $txt = str_replace('."', '". ', $txt);
        $txt = str_replace(' Dr. ', ' Dr_ ', $txt);
        $txt = str_replace('St.Peter-Ording', 'St_Peter-Ording', $txt);
        $txt = str_replace('St. Peter-Ording', 'St_Peter-Ording', $txt);
        /*
        * Das nicht einfach der Monat weggeschnitten wird!
        */
        foreach ($monate as $key => $monat) {
            $txt = str_replace('. ' . $monat, '.' . $monat, $txt);
        }
        $txt = explode('. ', $txt);
        $y = count($txt);
        if (1 === $y) {
            $txt = $txt[0] . '.';
        } elseif ($y >= 2) {
            $pattern = '/<br>|<\/p>/';
            $txt = $txt[0] . '.';
        } else {
            $txt = '';
        }

        /*
        * Das nicht einfach der Monat weggeschnitten wird!
        */
        foreach ($monate as $key => $monat) {
            $txt = str_replace('.' . $monat, '. ' . $monat, $txt);
        }
        $txt = str_replace(' Dr_ ', ' Dr. ', $txt);
        $txt = str_replace(' d_R_ ', ' d.R. ', $txt);
        $txt = str_replace(' e_V_ ', ' e.V. ', $txt);
        $txt = str_replace(' e__V_ ', ' e. V. ', $txt);
        $txt = str_replace(' d__R_ ', ' d. R. ', $txt);
        $txt = str_replace('St_Peter-Ording', 'St. Peter-Ording', $txt);

        return $txt;
    }

    public function makeToolTip($text)
    {
        $text = trim($text);
        $text = str_replace('<BR>', ' ', $text);
        $text = str_replace('<br>', ' ', $text);
        $text = str_replace("\n\r", ' ', $text);
        $text = str_replace("\n", ' ', $text);
        $text = str_replace("\0", ' ', $text);
        $text = str_replace("\b", ' ', $text);
        $text = str_replace("\r", ' ', $text);
        $text = str_replace("\Z", ' ', $text);

        return $text;
    }

    /**
     * UPLOAD über FTP Zugang.
     */
    public function makeUploadFile($passwort = '', $file_size = '', $file = '', $file_name = '', $path = 'fileadmin')
    {
        if (false === function_exists('ftp_connect')) {
            echo '<p class="fehler">Ihr Server unterstützt leider keine FTP Verbingungen.</p>';

            return false;
        }
        if (FTP_BENUTZER_HOST === '' || FTP_BENUTZER_BENUTZER === '') {
            echo '<p class="fehler">Sie haben keine FTP Zugangsdaten eingegeben in der Config Datei!</p>';

            return false;
        }

        if (file_exists(PATH . $path . '/' . $file_name)) {
            echo '<p class="fehler">Eine Datei mit gleichem Namen existiert schon.<br>';
            echo '<a href="javascript:history.back(1)">Zur&uuml;ck</a></p>';

            return false;
        }

        //Destination of the file
        $dest = PATH . $path . '/' . $file_name;

        //connect to Server via FTP
        $conn_id = ftp_connect(FTP_BENUTZER_HOST);
        $login_result = ftp_login($conn_id, FTP_BENUTZER_BENUTZER, FTP_BENUTZER_PASSWORT);

        // upload the file
        $upload = ftp_put($conn_id, $dest, $file, FTP_BINARY);

        if (file_exists(PATH . $path . '/' . $file_name)) {
            echo '<p class="erfolgreich">Datei erfolgreich hochgeladen!</p>';

            return true;
        } else {
            echo '<p class="fehler">Es ist ein Fehler aufgetreten. Datei nicht hochgeladen!</p>';

            return false;
        }
    }

    /**
     * Schau nach ob der Buchstabe gesetzt ist, ansonsten gib 'a' zurück.
     *
     * @param string $text
     *
     * @return string
     */
    public function getLexiconChar($show)
    {
        $show = trim($show);
        switch ($show) {
            case 'a':
            case 'A':
                $show = 'a';
                break;
            case 'b':
            case 'B':
                $show = 'b';
                break;
            case 'c':
            case 'C':
                $show = 'c';
                break;
            case 'd':
            case 'D':
                $show = 'd';
                break;
            case 'e':
            case 'E':
                $show = 'e';
                break;
            case 'f':
            case 'F':
                $show = 'f';
                break;
            case 'g':
            case 'G':
                $show = 'g';
                break;
            case 'h':
            case 'H':
                $show = 'h';
                break;
            case 'i':
            case 'I':
                $show = 'i';
                break;
            case 'j':
            case 'J':
                $show = 'j';
                break;
            case 'k':
            case 'K':
                $show = 'k';
                break;
            case 'l':
            case 'L':
                $show = 'l';
                break;
            case 'm':
            case 'M':
                $show = 'm';
                break;
            case 'n':
            case 'N':
                $show = 'n';
                break;
            case 'o':
            case 'O':
                $show = 'o';
                break;
            case 'p':
            case 'P':
                $show = 'p';
                break;
            case 'q':
            case 'Q':
                $show = 'q';
                break;
            case 'r':
            case 'R':
                $show = 'r';
                break;
            case 's':
            case 'S':
                $show = 's';
                break;
            case 't':
            case 'T':
                $show = 't';
                break;
            case 'u':
            case 'U':
                $show = 'u';
                break;
            case 'v':
            case 'V':
                $show = 'v';
                break;
            case 'w':
            case 'W':
                $show = 'w';
                break;
            case 'x':
            case 'X':
                $show = 'x';
                break;
            case 'y':
            case 'Y':
                $show = 'y';
                break;
            case 'z':
            case 'Z':
                $show = 'z';
                break;
            default:
                $show = 'a';
        }

        return $show;
    }

    /**
     * Einheitliches Mailprogramm geschrieben.
     *
     * @param string $to
     * @param string $subject
     * @param string $mailtext
     * @param string $header
     * @param string $good
     *
     * @return string
     */
    public function sendMail($to, $subject, $mailbody, $from, $frommail, $good = 'Mail erfolgreich versendet')
    {
        $header = 'From: ' . $from . ' <' . $frommail . ">\n";
        $header .= 'X-Mailer: PHP/' . phpversion() . "\n";
        $header .= "MIME-Version: 1.0\n";
        if (@mail($to, $subject, $mailbody, $header)) {
            return "<p class='erfolgreich'>" . $good . '</p>';
        } else {
            $fehler = 'Beim Senden der Email trat ein Fehler auf.<br>';
            $fehler .= 'Bitte wenden Sie sich direkt an den <a href="mailto:' . KONTAKTEMAIL . '">Webmaster</a>.';

            return "<p class='fehler'>" . $fehler . '</p>';
        }
    }

    /**
     * Sortiert eine Multi-Array.
     *
     * @param $array
     * @param $cols
     * $arr1 = array(
     *     array('id'=>1,'name'=>'aA','cat'=>'cc'),
     *     array('id'=>2,'name'=>'aa','cat'=>'dd'),
     * array('id'=>3,'name'=>'bb','cat'=>'cc'),
     *     array('id'=>4,'name'=>'bb','cat'=>'dd')
     * );
     *
     * @example $arr2 = Tools::makeArrayMultiSort($arr1, array('name'=>SORT_DESC, 'cat'=>SORT_ASC));
     */
    public function makeArrayMultiSort($array, $cols)
    {
        $colarr = [];
        foreach ($cols as $col => $order) {
            $colarr[$col] = [];
            foreach ($array as $k => $row) {
                $colarr[$col]['_' . $k] = strtolower($row[$col]);
            }
        }
        $eval = 'array_multisort(';
        foreach ($cols as $col => $order) {
            $eval .= '$colarr[\'' . $col . '\'],' . $order . ',';
        }
        $eval = substr($eval, 0, -1) . ');';
        eval($eval);
        $ret = [];
        foreach ($colarr as $col => $arr) {
            foreach ($arr as $k => $v) {
                $k = substr($k, 1);
                if (!isset($ret[$k])) {
                    $ret[$k] = $array[$k];
                }
                $ret[$k][$col] = $array[$k][$col];
            }
        }

        return $ret;
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

    /**
     * @param $text
     * @param string $allowed_tags
     * @return array|string|string[]|null
     */
    protected function makeStripWordHtml(
        $text,
        $allowed_tags = '<b><i><sup><sub><em><strong><u><br><p><table><tr><td><th><ul><ol><li>'
    ) {
        // if (strlen($text) > 100000) {
        //  return "Too big to process";
        // }
        mb_regex_encoding('UTF-8');
        //replace MS special characters first
        $search = array('/&lsquo;/u', '/&rsquo;/u', '/&ldquo;/u', '/&rdquo;/u', '/&mdash;/u');
        $replace = array('\'', '\'', '"', '"', '-');
        $text = preg_replace($search, $replace, $text);
        //make sure _all_ html entities are converted to the plain ascii equivalents - it appears
        //in some MS headers, some html entities are encoded and some aren't
        $text = html_entity_decode($text, ENT_QUOTES, 'UTF-8');
        //try to strip out any C style comments first, since these, embedded in html comments, seem to
        //prevent strip_tags from removing html comments (MS Word introduced combination)
        if (mb_stripos($text, '/*') !== false) {
            $text = mb_eregi_replace('#/\*.*?\*/#s', '', $text, 'm');
        }
        $text = str_replace(chr(194) . chr(160), ' ', $text);
        //introduce a space into any arithmetic expressions that could be caught by strip_tags so that they won't be
        //'<1' becomes '< 1'(note: somewhat application specific)
        $text = preg_replace(array('/<([0-9]+)/'), array('< $1'), $text);
        $text = strip_tags($text, $allowed_tags);
        // eliminate extraneous whitespace from start and end of line, or anywhere there are two or more spaces,
        // convert it to one
        $text = preg_replace(array('/^\s\s+/', '/\s\s+$/', '/\s\s+/u'), array('', '', ' '), $text);
        //strip out inline css and simplify style tags

        //on some of the ?newer MS Word exports, where you get conditionals of the form 'if gte mso 9', etc., it appears
        //that whatever is in one of the html comments prevents strip_tags from eradicating the html comment
        // that contains
        //some MS Style Definitions - this last bit gets rid of any leftover comments */
        // $num_matches = preg_match_all("/\<!--/u", $text, $matches);
        // if($num_matches){

        // }
        $text = preg_replace('/<p.*?>(.*?)<\/p>/isu', '<p>$1</p>', $text);
        $text = preg_replace(':<[^/>]*>\s*</[^>]*>:', '', $text);
        $search = [
            '#<(strong|b )[^>]*>(.*?)</(strong|b)>#isu',
            '#<(em|i)[^>]*>(.*?)</(em|i)>#isu',
            '#<u[^>]*>(.*?)</u>#isu'
        ];
        $replace = array('<strong>$2</strong>', '<i>$2</i>', '<u>$1</u>');
        $text = preg_replace($search, $replace, $text);
        $text = preg_replace('/<!--(.*?)-->/isu', '', $text);
        $text = preg_replace('/<br(.*?)\/>/isu', '<br/>', $text);
        return $text;
    }
}
