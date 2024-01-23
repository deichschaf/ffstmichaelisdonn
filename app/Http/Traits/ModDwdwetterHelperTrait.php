<?php

namespace App\Http\Traits;

use App\Http\Models\CriticalSender;
use App\Http\Models\DWDWeather;
use App\Http\Models\Tides;
use DOMDocument;
use DOMXPath;
use Exception;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

/***
 * Trait ModDwdwetterHelperTrait
 * @package App\Http\Traits
 * @todo Change all Links from DWD GDS to DWD Opendata!!!
 * @todo Save WeatherData in Database
 * @todo Save Stations in Database
 * @todo Make Profiles for the difference Units
 * @todo Make AdminPanal for adding new CriticalWarnings
 * @todo Löschen der Unwettermitteilungen wenn diese Älter als 30 Min sind
 */
trait ModDwdwetterHelperTrait
{
    public static $params;
    public static $ftp;

    public static function getStaticBftfromWind($wind)
    {
        $bft = 0;
        if ($wind < 1) {
            $bft = 0;
        } elseif ($wind >= 1 && $wind <= 5) {
            $bft = 1;
        }
    }

    public static function MondPhase()
    {
        try {
            $ursprung = mktime(18, 31, 18, 12, 22, 1999);
            $akt_date = time();
            define('ZYCLUS', floor(29.530588861 * 86400));
            $mondphase = round(((($akt_date - $ursprung) / ZYCLUS) - floor(($akt_date - $ursprung) / ZYCLUS)) * 100, 0);

            $mondphasen_img = round(($mondphase / 50), 1) * 50;
            if ($mondphasen_img == 100) {
                $mondphasen_img == 0;
            }

            if ($mondphase <= 1 || $mondphase >= 99) {
                $phase_text = 'Vollmond';
            } elseif ($mondphase > 1 && $mondphase < 49) {
                $phase_text = 'abnehmender Mond';
            } elseif ($mondphase >= 49 && $mondphase <= 51) {
                $phase_text = 'Neumond';
            } else {
                $phase_text = 'zunehmender Mond';
            }
            echo $phase_text;
        } catch (Exception $e) {
            self::WriteMail(__CLASS__, __LINE__, __FUNCTION__, $e->getCode(), $e->getMessage());
        }
    }

    private static function WriteMail($class, $line, $function, $error, $errormessage, $message2 = '')
    {
        $subject = 'TEL Fehler!';
        $message = "Class: " . $class . "\n\r";
        $message .= "Funktion: " . $function . "\n\r";
        $message .= "Line: " . $line . "\n\r";
        $message .= "Errorcode: " . $error . "\n\r";
        $message .= "Errormessage" . $errormessage . "\n\r";
        $message .= $message2 . "\n\r";
        try {
            Log::info(__CLASS__, ['message' => $message]);
            //mail(env('HOMEPAGE_EMAIL'), $subject, $message, "from: " . env('MAILER_SENDER_OWNER') . ' <' . env('MAILER_SENDER') . '>');
        } catch (Exception $e) {
            Log::info($e->getCode() . ' : ' . $e->getMessage());
        }
    }

    public static function getStaticDWDFTP()
    {
        try {
            self::OpenFTPConnect();
            $days = [];
            $days[] = 'wheater_today';
            $days[] = 0;
            $days[] = 1;
            $days[] = 2;
            $days[] = 3;
            $days[] = 4;
            $days[] = 5;
            $days[] = 6;
            $days[] = 7;
            foreach ($days as $day) {
                $filedata = self::getFile($day);
                self::SaveContent($day, $filedata);
            }
        } catch (Exception $e) {
            self::WriteMail(__CLASS__, __LINE__, __FUNCTION__, $e->getCode(), $e->getMessage());
        }
    }

    private static function OpenFTPConnect()
    {
        $ftp_user = "gds17613";
        $ftp_pass = "ftimvuSo";

        if (!self::$ftp) {
            try {
                $host = 'ftp-outgoing2.dwd.de';
                $conn_id = ftp_connect($host) or die("Couldn't connect to $host");
                // Anmeldung versuchen
                if (@ftp_login($conn_id, $ftp_user, $ftp_pass)) {
                    echo "Angemeldet als $ftp_user@$host\n";
                    self::$ftp = $conn_id;
                    ftp_pasv(self::$ftp, true);
                } else {
                    echo "Anmeldung als $ftp_user nicht möglich\n";
                }
            } catch (Exception $e) {
                self::WriteMail(__CLASS__, __LINE__, __FUNCTION__, $e->getCode(), $e->getMessage());
            }
        }
    }

    /**
     * Fetchs the file from the DWD FTP server
     *
     * @param $day  integer  Day to fetch
     *
     * @return string  file content
     *
     * @since 1.0
     */
    private static function getFile($day)
    {
        try {
            if (!$day || $day == 'wheater_today' || $day == 1) {
                $folder = '/gds/gds/specials/observations/tables/germany/';
                $files = self::GetFolderList($folder);
                sort($files);

                // Take the raw one
                $file = array_pop($files);

                if (strpos($file, '_0645_') !== false) {
                    $file = array_pop($files);
                }

                unset($files);
            } else {
                $folder = '/gds/gds/specials/forecasts/tables/germany/';
                $file = $folder . 'Daten_Deutschland';

                switch ($day) {
                    case 0:
                        $file .= '_heute_frueh';
                        break;
                    case 1:
                        $file .= '_morgen_spaet';
                        break;
                    case 2:
                        $file .= '_uebermorgen_spaet';
                        break;
                    case 3:
                        $file .= '_Tag4_spaet';
                        break;
                    case 4:
                        $file .= '_heute_mittag';
                        break;
                    case 5:
                        $file .= '_heute_spaet';
                        break;
                    case 6:
                        $file .= '_heute_nacht';
                        break;
                    case 7:
                        $file .= '_heute_frueh';
                        break;
                }

                $file .= '_HTML';
            }

            // Read file
            $filedata = self::FTPReadFile($file);

            return utf8_encode($filedata);
        } catch (Exception $e) {
            self::WriteMail(__CLASS__, __LINE__, __FUNCTION__, $e->getCode(), $e->getMessage(), $day . ' > ', $file);
        }
        return '';
    }

    private static function GetFolderList($folder)
    {
        try {
            return ftp_nlist(self::$ftp, $folder);
        } catch (Exception $e) {
            self::WriteMail(__CLASS__, __LINE__, __FUNCTION__, $e->getCode(), $e->getMessage());
        }
        return false;
    }

    private static function FTPReadFile($remote_file, $mode = FTP_ASCII)
    {
        try {
            ob_start();
            $result = ftp_get(self::$ftp, "php://output", $remote_file, $mode, 0);
            $data = ob_get_contents();
            ob_end_clean();
            return $data;
        } catch (Exception $e) {
            self::WriteMail(__CLASS__, __LINE__, __FUNCTION__, $e->getCode(), $e->getMessage());
        }
        return '';
    }

    private static function SaveContent($area, $content)
    {
        /***
         * @ToDo: Hier muss das Löschen Rein!
         */

        self::DeleteContent($area, 1, false);

        if ($area == 'DWDWarnungen') {
            $content = str_ireplace('warnWetter.loadWarnings(', '', $content);
            if (substr($content, -2) == ');') {
                $content = substr($content, 0, -2);
            }
            #$content = (json_decode($content));
        }

        /*
        echo '<pre>';
        var_dump($content);
        echo '</pre>';
        exit();
        */


        try {
            $save = new DWDWeather();
            $save->area = $area;
            $save->content = $content;
            $save->save();
            echo 'Neuer Content gespeichert: ' . $area . '<br>';
        } catch (Exception $e) {
            echo 'Neuer Content wurde nicht gespeichert: ' . $area . '<br>Fehler: ' . $e->getCode() . ' - ' . $e->getMessage() . '<br>';
            self::WriteMail(__CLASS__, __LINE__, __FUNCTION__, $e->getCode(), $e->getMessage(), $area);
        }
    }

    private static function DeleteContent($area, $maxdaysbefore = false, $maxhoursbefore = false)
    {
        #ToolsTrait::SQLLogger();
        try {
            if ($maxdaysbefore !== false || $maxhoursbefore !== false) {
                if ($maxdaysbefore !== false) {
                    DWDWeather::where('area', $area)
                        ->where('created_at', '<', date('Y-m-d H:i:s', strtotime('-' . $maxdaysbefore . ' days')))
                        ->forceDelete();
                }
                if ($maxhoursbefore !== false) {
                    DWDWeather::where('area', $area)
                        ->where('created_at', '<', date('Y-m-d H:i:s', strtotime('-' . $maxhoursbefore . ' hours')))
                        ->forceDelete();
                }
            } else {
                $latestId = 0;
                $Content = DWDWeather::where('area', $area)->orderBy('created_at', 'DESC')->take(1)->get();
                $Content->each(function ($c) use (&$latestId) {
                    $latestId = $c->id;
                });
                DWDWeather::where('area', $area)
                    ->where('id', '!=', $latestId)
                    ->forceDelete();
            }
        } catch (Exception $e) {
            self::WriteMail(__CLASS__, __LINE__, __FUNCTION__, $e->getCode(), $e->getMessage(), $area);
        }
        #echo '<pre>';
        #print_r( ToolsTrait::getSQL() );
        #echo '</pre>';
    }

    public static function getStaticMoon()
    {
        try {
            $filedata = json_decode(self::getContent('sunrise_down'));
            $moon = $filedata->moon_phase;
            return $moon->ageOfMoon;
        } catch (Exception $e) {
            self::WriteMail(__CLASS__, __LINE__, __FUNCTION__, $e->getCode(), $e->getMessage());
        }
        return '';
    }

    private static function GetContent($area, $maxdaysbefore = false, $maxhoursbefore = false)
    {
        $content = '';
        try {
            if ($maxdaysbefore === false && $maxhoursbefore === false) {
                $DWDWeather = DWDWeather::where('area', $area)->orderBy('created_at', 'desc')->take(1)->get();
            } elseif ($maxdaysbefore !== false && $maxhoursbefore === false) {
                $DWDWeather = DWDWeather::where('area', $area)
                    ->where('created_at', '>=', strtotime('-' . $maxdaysbefore . ' days'))
                    ->orderBy('created_at', 'desc')
                    ->take(1)
                    ->get();
            } else {
                $DWDWeather = DWDWeather::where('area', $area)
                    ->where('created_at', '>=', strtotime('-' . $maxhoursbefore . ' hours'))
                    ->orderBy('created_at', 'desc')
                    ->take(1)
                    ->get();
            }
            $DWDWeather->each(function ($dwd) use (&$content) {
                $content = $dwd->content;
            });
            return $content;
        } catch (Exception $e) {
            self::WriteMail(__CLASS__, __LINE__, __FUNCTION__, $e->getCode(), $e->getMessage(), $area);
        }
        return $content;
    }

    public static function getStaticList($params)
    {
        self::$params = $params;


        $data_sun = self::getSunRiseDown();

        $days = array();
        $days[] = 'wheater_today';
        $days[] = 5;
        $days[] = 1;
        $days[] = 2;
        $days[] = 3;

        $data = array();

        foreach ($days as $day) {
            // Get filedata
            //$filedata = self::getFile($day);
            /*echo '<pre>';
            print_r($day);
            echo '</pre>';*/
            $filedata = self::GetContent($day);
            $filedata = html_entity_decode($filedata);

            // Process filedata
            if (!$day || $day == 'wheater_today') {
                $content = '';
                if ($filedata != '') {
                    $content = self::parseFiledataCurrent($filedata);
                }
                $data[0] = $content;
            } else {
                $content = '';
                if ($filedata != '') {
                    $content = self::parseFiledataFuture($filedata);
                }
                $data[$day] = $content;
            }
        }

        $data = array_merge($data_sun, $data);
        return $data;
    }

    private static function getSunRiseDown()
    {
        try {
            $filedata = json_decode(self::getContent('sunrise_down'));
            $prognose = $filedata->forecast->txt_forecast->forecastday;
            $data = [
                'today_prognose' => $prognose['0']->fcttext_metric,
                'tomorrow_prognose' => $prognose['1']->fcttext_metric,
                'sunrise' => $filedata->sun_phase->sunrise->hour . ':' . $filedata->sun_phase->sunrise->minute,
                'sunset' => $filedata->sun_phase->sunset->hour . ':' . $filedata->sun_phase->sunset->minute,
                #'moon' => self::MondPhase($filedata->moon_phase->phaseofMoon),
            ];
            return $data;
        } catch (Exception $e) {
            self::WriteMail(__CLASS__, __LINE__, __FUNCTION__, $e->getCode(), $e->getMessage());
        }
        return [];
    }

    /**
     * @param string $filedata The file content to parse
     *
     * @return array  $data  Array of data
     *
     * @since 4.0
     */
    private static function parseFiledataCurrent($filedata)
    {
        try {
            $position = array();
            $data = array();
            $glieder = self::FetchHeaders($filedata);

            $k = 0;

            for ($count = 1; $count < 21; $count++) {
                $position[$count] = 20;
            }

            foreach ($glieder as $j) {
                switch (mb_strtolower($j)) {
                    case 'höhe':
                        $position[0] = $k;
                        break;
                    case 'luftd.':
                        $position[1] = $k;
                        break;
                    case 'temp.':
                        $position[2] = $k;
                        break;
                    case 'rr1':
                    case 'rr30':
                        $position[3] = $k;
                        break;
                    case 'dd':
                        $position[4] = $k;
                        break;
                    case 'ff':
                        $position[5] = $k;
                        break;
                    case 'fx':
                        $position[6] = $k;
                        break;
                    case 'wetter+wolken':
                        $position[7] = $k;
                        $position[8] = $k + 1;
                        break;
                }

                $k++;
            }

            $parts = self::FetchRow($filedata, '<td>' . self::getObservationPattern());
            $parts[20] = '-';
            $data['hohe'] = $parts[$position[0]] . ' m';
            $data['luft'] = $parts[$position[1]] . ' hPa';
            $data['temp'] = $parts[$position[2]] . ' &deg;C';

            if ($parts[$position[2]] !== null) {
                $data['temp'] = $parts[$position[2]] . ' &deg;C';
            } else {
                $data['temp'] = '-- &deg;C';
            }

            if ($parts[$position[3]] == '----') {
                $parts[$position[3]] = '0.0';
            }

            $data['regen'] = $parts[$position[3]] . ' mm';
            $data['richtung'] = $parts[$position[4]] . '';
            $grad = self::SaveWind($data['richtung']);
            $data['richtung_grad'] = $grad . '°';
            $data['wind'] = $parts[$position[5]] . ' km/h';
            $data['spitze'] = $parts[$position[6]] . ' km/h';


            if ($parts[$position[7]] == 'kein') {
                $parts[$position[7]] = 'heiter';
            }

            $check = array('gering', 'leichter', 'starker', 'stark', 'kräftiger', 'vereinzelt', 'gefrierender', 'in', 'schweres', 'starkes');
            if (in_array($parts[$position[7]], $check)) {
                $parts[$position[7]] = $parts[$position[7]] . ' ' . $parts[$position[7]];
            }

            $data['himmel'] = self::getIcon($parts[$position[7]], date('G'));

            $data['beschreibung'] = $parts[$position[7]];

            return $data;
        } catch (Exception $e) {
            echo '<pre>';
            echo __METHOD__ . ' > ' . __FUNCTION__ . ' > Line: ' . __LINE__;
            echo '</pre>';
            echo '<pre>';
            var_dump($filedata);
            echo '</pre>';

            self::WriteMail(__CLASS__, __LINE__, __FUNCTION__, $e->getCode(), $e->getMessage(), '');
        }
        return [];
    }

    /**
     * Fetchs the header row from the table
     *
     * @param string $filedata The raw file string
     *
     * @return array
     *
     * @since 4.1
     */
    private static function FetchHeaders($filedata)
    {
        preg_match_all('/<th (.*)/', $filedata, $glieder);
        $glieder = $glieder[0];
        $glieder = array_map('strip_tags', $glieder);
        $glieder = array_map('trim', $glieder);

        return $glieder;
    }

    /**
     * @param string $filedata The raw file string
     * @param string $needle The row to find
     *
     * @return array
     *
     * @since 4.1
     */
    private static function FetchRow($filedata, $needle)
    {
        $row = strstr($filedata, $needle);
        $row = strstr($row, '</tr>', true);
        $row = trim(strip_tags($row));

        // Remove non-breaking spaces
        $row = htmlentities($row, null, 'utf-8');
        $row = str_replace('&nbsp;', '', $row);
        $row = html_entity_decode($row);

        //$parts = explode("\r\n", $row);
        $parts = explode("\n", $row);
        foreach ($parts as $k => $v) {
            $parts[$k] = trim($v);
        }

        //$parts = array_map('trim', $parts);

        return $parts;
    }

    /**
     * Returns the station name of the selected observation station
     *
     * @return string
     *
     * @since 4.1
     */
    private static function getObservationPattern()
    {
        $stations = array(
            82 => 'UFS TW Ems',
            83 => 'UFS Deutsche Bucht',
            2 => 'Helgoland',
            3 => 'List/Sylt',
            4 => 'Schleswig',
            6 => 'Leuchtturm Kiel',
            7 => 'Kiel',
            8 => 'Fehmarn',
            9 => 'Arkona',
            10 => 'Norderney',
            11 => 'Leuchtt. Alte Weser',
            12 => 'Cuxhaven',
            13 => 'Hamburg-Flh.',
            14 => 'Schwerin',
            15 => 'Rostock',
            16 => 'Greifswald',
            17 => 'Emden',
            18 => 'Bremen-Flh.',
            78 => 'Lüchow',
            19 => 'Marnitz',
            79 => 'Waren',
            20 => 'Neuruppin',
            21 => 'Angermünde',
            22 => 'Münster/Osnabr.-Flh.',
            23 => 'Hannover-Flh.',
            24 => 'Magdeburg',
            25 => 'Potsdam',
            26 => 'Berlin-Tegel',
            27 => 'Berlin-Tempelhof',
            80 => 'Berlin-Dahlem',
            28 => 'Lindenberg',
            29 => 'Düsseldorf-Flh.',
            81 => 'Essen',
            30 => 'Kahler Asten',
            31 => 'Bad Lippspringe',
            33 => 'Fritzlar',
            34 => 'Brocken',
            35 => 'Leipzig-Flh.',
            36 => 'Dresden-Flh.',
            37 => 'Cottbus',
            38 => 'Görlitz',
            39 => 'Aachen',
            40 => 'Nürburg',
            41 => 'Köln/Bonn-Flh.',
            42 => 'Gießen/Wettenberg',
            43 => 'Wasserkuppe',
            44 => 'Meiningen',
            45 => 'Erfurt',
            46 => 'Gera',
            47 => 'Fichtelberg',
            48 => 'Trier',
            49 => 'Hahn-Flh.',
            50 => 'Frankfurt/M-Flh.',
            51 => 'OF-Wetterpark',
            52 => 'Würzburg',
            53 => 'Bamberg',
            54 => 'Hof',
            55 => 'Weiden',
            56 => 'Saarbrücken-Flh.',
            57 => 'Karlsruhe-Rheinst.',
            58 => 'Mannheim',
            59 => 'Stuttgart-Flh.',
            60 => 'Öhringen',
            61 => 'Nürnberg-Flh.',
            62 => 'Regensburg',
            63 => 'Straubing',
            64 => 'Großer Arber',
            65 => 'Lahr',
            66 => 'Freudenstadt',
            67 => 'Stötten',
            68 => 'Augsburg',
            69 => 'München-Flh.',
            70 => 'Fürstenzell',
            71 => 'Feldberg/Schw.',
            72 => 'Konstanz',
            73 => 'Kempten',
            74 => 'Oberstdorf',
            75 => 'Zugspitze',
            76 => 'Hohenpeißenberg',
        );

        #$station = self::$params->get('daten', 13);
        $station = 12;

        return !empty($stations[$station]) ? $stations[$station] : $stations[13];
    }

    private static function SaveWind($wind)
    {
        try {
            switch ($wind) {
                case 'N':
                    $grad = 0;
                    break;
                case 'NNO':
                    $grad = 22;
                    break;
                case 'NO':
                    $grad = 45;
                    break;
                case 'ONO':
                    $grad = 68;
                    break;
                case 'O':
                    $grad = 90;
                    break;
                case 'OSO':
                    $grad = 112;
                    break;
                case 'SO':
                    $grad = 135;
                    break;
                case 'SOS':
                    $grad = 158;
                    break;
                case 'S':
                    $grad = 180;
                    break;
                case 'SWS':
                    $grad = 212;
                    break;
                case 'SW':
                    $grad = 225;
                    break;
                case 'WSW':
                    $grad = 248;
                    break;
                case 'W':
                    $grad = 270;
                    break;
                case 'WNW':
                    $grad = 292;
                    break;
                case 'NW':
                    $grad = 315;
                    break;
                case 'NNW':
                    $grad = 338;
                    break;
                default:
                    $grad = 0;
            }
            $formdata = [
                'WIND' => $grad,
            ];

            $arr_data[] = $formdata;
            $jsondata = json_encode($arr_data, JSON_PRETTY_PRINT);
            // schreibe json string in  "windrichtung.dat" (im verzeichniss)
            // fehler nachricht ausgeben
            $file = public_path('js' . DIRECTORY_SEPARATOR . 'windrose' . DIRECTORY_SEPARATOR) . 'windrichtung.dat';
            file_put_contents($file, $jsondata);
            return $grad;
        } catch (Exception $e) {
            self::WriteMail(__CLASS__, __LINE__, __FUNCTION__, $e->getCode(), $e->getMessage(), 'wind');
        }
        return '';
    }

    /**
     * @param string $string
     * @param int $hour
     *
     * @return string
     *
     * @since 1.0
     */
    private static function getIcon($string, $hour = 12)
    {
        $day = ($hour > 4 && $hour < 19);

        switch ($string) {
            case 'heiter':
            case 'Heiter':
            case 'gering bewölkt':
            case 'gering Bewölkt':
                $icon = ($day) ? 'heiter.png' : 'nheiter.png';
                break;
            case 'bedeckt':
            case 'Bedeckt':
                $icon = 'bedeckt.png';
                break;
            case 'Sonne':
            case 'wolkenlos':
            case 'Wolkenlos':
                $icon = ($day) ? 'sonne.png' : 'nsonne.png';
                break;
            case 'Regen':
            case 'leichter Regen':
            case 'leichter Regen oder Schneegriesel':
            case 'Schauer':
            case 'Regenschauer':
            case 'Schneeregen':
            case 'leichter Schneeregen':
            case 'Niederschlag':
                $icon = 'leichtregen.png';
                break;
            case 'kräftiger Regen':
            case 'kräftiger Regenschauer':
                $icon = 'starkregen.png';
                break;
            case 'Schnee':
            case 'Schneefall':
            case 'leichter Schneefall':
            case 'starker Schneefall':
            case 'kräftiger Schneefall':
            case 'kräftiger Schneeregen':
            case 'Schneeregenschauer':
            case 'kräftiger Schneeregenschauer':
            case 'Schneeschauer':
            case 'kräftiger Schneeschauer':
            case 'Schneefegen':
            case 'Schneegriesel':
            case 'Schneetreiben':
            case 'Glatteisbildung':
                $icon = 'schnee.png';
                break;
            case 'Graupelschauer':
            case 'kräftiger Graupelschauer':
            case 'Hagelschauer':
            case 'kräftiger Hagelschauer':
                $icon = 'hagel.png';
                break;
            case 'Gewitter':
            case 'schweres Gewitter':
            case 'starkes Gewitter':
                $icon = 'gewitter.png';
                break;
            case 'Nebel':
            case 'gefrierender Nebel':
            case 'Dunst':
            case 'Dunst oder flacher Nebel':
            case 'in Wolken':
            case 'Sandsturm':
            case 'Sandsturm oder Schneefegen':
                $icon = 'nebel.png';
                break;
            case 'bewölkt':
            case 'Bewölkt':
            case 'stark bewölkt':
            case 'stark Bewölkt':
            default:
                $icon = ($day) ? 'bewolkt.png' : 'nbewolkt.png';
                break;
        }

        return $icon;
    }

    /**
     * @param string $filedata The file content to parse
     *
     * @return array  $data  Array of data
     *
     * @since 4.0
     */
    private static function parseFiledataFuture($filedata)
    {
        try {
            $glieder = self::FetchHeaders($filedata);
            $parts = self::FetchRow($filedata, '<td>' . self::getForecastPattern());
            $dataFtp = array();
            $data = array();

            foreach ($glieder as $key => $value) {
                $dataFtp[$value] = $parts[$key];
            }

            if ($dataFtp['Tmax'] !== null) {
                $data['temp'] = $dataFtp['Tmax'] . ' &deg;C';
            } else {
                $data['temp'] = '-- &deg;C';
            }

            if (!$dataFtp['Wetter/Wolken']) {
                $dataFtp['Wetter/Wolken'] = 'heiter';
            }

            $data['himmel'] = self::getIcon($dataFtp['Wetter/Wolken']);
            $data['beschreibung'] = $dataFtp['Wetter/Wolken'];

            return $data;
        } catch (Exception $e) {
            self::WriteMail(__CLASS__, __LINE__, __FUNCTION__, $e->getCode(), $e->getMessage(), '');
        }
        return [];
    }

    /**
     * Returns the station name of the selected forecast station
     *
     * @return string
     *
     * @since 4.1
     */
    private static function getForecastPattern()
    {
        $stations = array(
            2 => 'Helgoland',
            1 => 'List/Sylt',
            3 => 'Schleswig',
            4 => 'Kiel',
            5 => 'Fehmarn',
            27 => 'Arkona',
            6 => 'Norderney',
            7 => 'Cuxhaven',
            8 => 'Hamburg-Flh.',
            9 => 'Schwerin',
            28 => 'Rostock',
            29 => 'Greifswald',
            10 => 'Emden',
            11 => 'Bremen-Flh.',
            73 => 'Lüchow',
            31 => 'Marnitz',
            74 => 'Waren',
            32 => 'Neuruppin',
            33 => 'Angermünde',
            12 => 'Münster/Osnabr.-Flh.',
            13 => 'Hannover-Flh.',
            16 => 'Magdeburg',
            34 => 'Potsdam',
            25 => 'Berlin-Tegel',
            75 => 'Berlin-Tempelhof',
            76 => 'Berlin-Dahlem',
            26 => 'Lindenberg',
            35 => 'Düsseldorf-Flh.',
            77 => 'Essen',
            36 => 'Kahler Asten',
            14 => 'Bad Lippspringe',
            37 => 'Fritzlar',
            15 => 'Brocken',
            18 => 'Leipzig-Flh.',
            19 => 'Dresden-Flh.',
            17 => 'Cottbus',
            20 => 'Görlitz',
            50 => 'Aachen',
            40 => 'Nürburg',
            38 => 'Köln/Bonn-Flh.',
            39 => 'Gießen/Wettenberg',
            41 => 'Wasserkuppe',
            21 => 'Meiningen',
            22 => 'Erfurt',
            23 => 'Gera',
            24 => 'Fichtelberg',
            42 => 'Trier',
            43 => 'Hahn-Flh.',
            44 => 'Frankfurt/M-Flh.',
            78 => 'OF-Wetterpark',
            45 => 'Würzburg',
            58 => 'Bamberg',
            59 => 'Hof',
            60 => 'Weiden',
            48 => 'Saarbrücken-Flh.',
            49 => 'Karlsruhe-Rheinst.',
            46 => 'Mannheim',
            52 => 'Stuttgart-Flh.',
            51 => 'Öhringen',
            61 => 'Nürnberg-Flh.',
            62 => 'Regensburg',
            63 => 'Straubing',
            64 => 'Großer Arber',
            54 => 'Lahr',
            55 => 'Freudenstadt',
            53 => 'Stötten',
            66 => 'Augsburg',
            67 => 'München-Flh.',
            65 => 'Fürstenzell',
            56 => 'Feldberg/Schw.',
            57 => 'Konstanz',
            68 => 'Kempten',
            69 => 'Oberstdorf',
            71 => 'Zugspitze',
            70 => 'Hohenpeißenberg',
        );

        #$station = self::$params->get('datenvorhersage', 8);
        $station = 7;

        return !empty($stations[$station]) ? $stations[$station] : $stations[8];
    }

    /***
     *
     */
    public static function KatAlarm()
    {
        $data[] = '';
        $data['katvoralarm'] = '';
        $data['katalarm'] = '';
    }

    public static function DWDWarn()
    {
    }

    public static function CronDWDWarn()
    {
        $v = [];
        $v['url'] = 'https://www.dwd.de/DWD/warnungen/warnapp/json/warnings.json';
        $v['title'] = 'DWDWarnungen';
        $v['deletedays'] = '';
        $v['deletehours'] = '1';


        self::DeleteContent($v['title'], $v['deletedays'], $v['deletehours']);
        self::getExternalDataAndSaveDB($v['url'], $v['title']);
        Cache::forget('getWarningsApi');
        echo 'Neue Warnungen in DB aufgenommen';
    }

    private static function getExternalDataAndSaveDB($url, $contenttitle, $onlycontent = 0)
    {
        try {
            $content = self::getExternalData($url);
            if ($content == '' || $content == '[]') {
                return '';
            }
            self::SaveContent($contenttitle, $content);
        } catch (Exception $e) {
            self::WriteMail(__CLASS__, __LINE__, __FUNCTION__, $e->getCode(), $e->getMessage());
        }
    }

    private static function getExternalData($url, $local_file = '')
    {
        $type = strtolower(pathinfo(basename($url), PATHINFO_EXTENSION));
        if ($type == 'jpg' || $type == 'jpeg' || $type == 'png' || $type == 'gif') {
            try {
                $filename = basename($url);
                $local_file = public_path('weather' . DIRECTORY_SEPARATOR) . $filename;
                self::getImageFromUrl($url, $type, $local_file);
            } catch (Exception $e) {
                echo "CODE: " . $e->getCode();
                echo '<br>;';
                print_r($e->getMessage());
                self::WriteMail(__CLASS__, __LINE__, __FUNCTION__, $e->getCode(), $e->getMessage(), $url);
                exit();
            }
        } else {
            try {
                $curlSession = curl_init();
                curl_setopt($curlSession, CURLOPT_URL, $url);
                curl_setopt($curlSession, CURLOPT_BINARYTRANSFER, true);
                curl_setopt($curlSession, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($curlSession, CURLOPT_SSL_VERIFYPEER, 0);
                curl_setopt($curlSession, CURLOPT_SSL_VERIFYHOST, 0);
                curl_setopt($curlSession, CURLOPT_FOLLOWLOCATION, true);

                $return = curl_exec($curlSession);
                #Log::info($url);
                $httpcode = curl_getinfo($curlSession, CURLINFO_HTTP_CODE);
                curl_close($curlSession);
                $search = array(
                    '/\[^\S]+/s', // strip whitespaces after tags, except space
                    '/[^\S]+\</s', // strip whitespaces before tags, except spaces
                    '/(\s)+/s' // shorten multiple whitespace sequences
                );
                $replace = array(
                    '>',
                    '<',
                    '\\1'
                );
                $buffer = preg_replace($search, $replace, $return);
                return ($httpcode >= 200 && $httpcode < 302) ? $buffer : '';
            } catch (Exception $e) {
                self::WriteMail(__CLASS__, __LINE__, __FUNCTION__, $e->getCode(), $e->getMessage(), $url);
            }
            echo 'ERROR';
            return '';
        }
    }

    private static function getImageFromUrl($url, $type = 'jpg', $localfile)
    {
        try {
            switch ($type) {
                case "jpg":
                case "jpeg":
                    $im = imagecreatefromjpeg($url); //jpeg file
                    break;
                case "gif":
                    #$im = imagecreatefromgif($url); //gif file
                    $im = 'gif';
                    break;
                case "png":
                    $im = imagecreatefrompng($url); //png file
                    break;
                default:
                    $im = false;
                    break;
            }
            if ($im === false) {
                return false;
            }

            if (is_file($localfile)) {
                unlink($localfile);
            }

            if ($im == 'gif') {
                file_put_contents($localfile, file_get_contents($url));
                /*
                $im = new Imagick();
                $content = imagecreatefromstring(file_get_contents($url));
                $im->setImageFormat ("gif");
                $imagecontent = $im->readImageBlob($content);
                $im->imageWriteFile (fopen ($localfile, "wb"));
                */
                return true;
            }

            switch ($type) {
                case "jpg":
                    imagejpeg($im, $localfile);
                    break;
                case "gif":
                    imagegif($im, $localfile); //gif file
                    break;
                case "png":
                    #$black = imagecolorallocate($im, 0, 0, 0);// Make the background transparent
                    #imagecolortransparent($im, $black);
                    imagealphablending($im, false);
                    imagesavealpha($im, true);
                    imagepng($im, $localfile); //png file
                    break;
                default:
                    $im = false;
                    break;
            }
            imagedestroy($im);
            if ($im === false) {
                return false;
            }
        } catch (Exception $e) {
            self::WriteMail(__CLASS__, __LINE__, __FUNCTION__, $e->getCode(), $e->getMessage(), $url);
        }
    }

    public static function ApiGetSunRiseDown()
    {
        try {
            #$url= 'http://api.wunderground.com/api/737ab0082a50db06/astronomy/lang:DL/q/54.27000046,8.97000027.json';
            $url = 'http://api.wunderground.com/api/737ab0082a50db06/alerts/forecast/astronomy/lang:DL/q/54.27000046,8.97000027.json';
            $filedata = self::getExternalData($url);
            if ($filedata == '') {
                return '';
            }
            self::DeleteContent('sunrise_down', 1, false);
            self::SaveContent('sunrise_down', $filedata);
        } catch (Exception $e) {
            self::WriteMail(__CLASS__, __LINE__, __FUNCTION__, $e->getCode(), $e->getMessage(), $url);
        }
    }

    public static function AddNewCriticalSender()
    {
        try {
            $urls = self::CriticalURLs();
            $sender = [];
            $newsender = [];
            $CriticalSender = CriticalSender::all();
            $CriticalSender->each(function ($cs) use (&$sender) {
                $sender[$cs->senderid] = $cs->sendername;
            });
            foreach ($urls as $key => $val) {
                $content = [];
                $DWDWeather = DWDWeather::where('area', $val['title'])->get();
                $DWDWeather->each(function ($dwd) use (&$newsender, $sender) {
                    $data = json_decode($dwd->content);
                    foreach ($data as $k => $row) {
                        $row = (array)$row;
                        if (array_key_exists('sender', $row)) {
                            if (!array_key_exists($row['sender'], $newsender)) {
                                if (array_key_exists('senderName', $row['info']['0'])) {
                                    $newsender[$row['sender']] = $row['info']['0']->senderName;
                                    /*
                                    $newsender[] = [
                                        'sender'=>$row['info']['0']->senderName,
                                        'key' => $row{'sender'}
                                        ];
                                    */
                                } else {
                                    $c = (array)$row['info']['0'];
                                    $newsender[$row['sender']] = $c['parameter']['0']->value;

                                    /*
                                    $newsender[] = [
                                        'sender'=>$c['parameter']['0']->value,
                                        'key' => $row{'sender'}
                                    ]; */
                                }
                            }
                        }
                    }
                });
            }

            if (count($newsender) > 0) {
                foreach ($newsender as $k => $v) {
                    $save = new CriticalSender();
                    $save->senderid = $k;
                    $save->sendername = $v;
                    $save->save();
                }
            }
            echo 'Es wurden ' . count($newsender) . ' in der Datenbank gespeichert!';
        } catch (Exception $e) {
            self::WriteMail(__CLASS__, __LINE__, __FUNCTION__, $e->getCode(), $e->getMessage());
        }
    }

    private static function CriticalURLs()
    {
        $urls = [];
        $urls[] = [
            'url' => 'https://warnung.bund.de/bbk.config/config.json',
            'title' => 'warnungen_bund.config',
            'deletedays' => '1',
            'deletehours' => '',
        ];
        $urls[] = [
            'url' => 'http://warnung.bund.de/bbk.dwd/unwetter.json',
            'title' => 'warnungen_bund.unwetter',
            'deletedays' => '',
            'deletehours' => '1',
        ];
        $urls[] = [
            'url' => 'http://warnung.bund.de/bbk.wsv/hochwasser.json',
            'title' => 'warnungen_bund.hochwasser',
            'deletedays' => '1',
            'deletehours' => '',
        ];
        $urls[] = [
            'url' => 'http://warnung.bund.de/bbk.lhp/hochwassermeldungen.json',
            'title' => 'warnungen_bund.hochwassermeldungen',
            'deletedays' => '1',
            'deletehours' => '',
        ];
        $urls[] = [
            'url' => 'http://warnung.bund.de/bbk.dwd/waldbrand.json',
            'title' => 'warnungen_bund.waldbrand',
            'deletedays' => '1',
            'deletehours' => '',
        ];
        $urls[] = [
            'url' => 'http://warnung.bund.de/bbk.bgr/erdbeben.json',
            'title' => 'warnungen_bund.erdbeben',
            'deletedays' => '1',
            'deletehours' => '',
        ];
        $urls[] = [
            'url' => 'http://warnung.bund.de/bbk.mowas/gefahrendurchsagen.json',
            'title' => 'warnungen_bund.gefahrendurchsage',
            'deletedays' => '1',
            'deletehours' => '',
        ];/*
        $urls[] = [
            'url' => 'http://warnung.bund.de/bbk.mowas/gefahrendurchsagen.json',
            'title' => 'warnungen_bund.gefahrendurchsage2',
            'deletedays' => '1',
            'deletehours' => '',
        ];*/
        $urls[] = [
            'url' => 'http://warnung.bund.de/bbk.mowas/changes.json',
            'title' => 'warnungen_bund.changes',
            'deletedays' => '1',
            'deletehours' => '',
        ];
        $urls[] = [
            'url' => 'http://warnung.bund.de/bbk.mowas/polygon',
            'title' => 'warnungen_bund.polygon',
            'deletedays' => '1',
            'deletehours' => '',
        ];
        $urls[] = [
            'url' => 'http://warnung.bund.de/bbk.mowas/geocode',
            'title' => 'warnungen_bund.geocode',
            'deletedays' => '1',
            'deletehours' => '',
        ];
        return $urls;
    }

    public static function mCriticalSender()
    {
        $warnings = self::ShowCriticalMessages();
        return $warnings;
    }

    private static function ShowCriticalMessages()
    {
        $warnings = [];
        try {
            $search = [];
            $search[] = 'DE-SH-EH-S028'; // Leitstelle West // Global Setzen lassen!
            $search[] = 'Dithmarschen';
            $search[] = 'DE-SH-KI-S014'; // Stab Innenministerium
            #$search[] = 'Steinburg';
            #$search[] = 'Nordfriesland';
            $preg_search = self::BuildContentSearch($search);
            $urls = self::CriticalURLs();
            $contents = [];
            foreach ($urls as $k => $v) {
                if ($v['title'] != 'warnungen_bund.config') {
                    $content = self::GetContent($v['title'], false, 3);
                    if ($content != '') {
                        $found = preg_match($preg_search, $content);
                        if ($found) {
                            $data = json_decode($content);
                            foreach ($data as $key => $row) {
                                $row = (array)$row;
                                if (!array_key_exists($row['identifier'], $warnings)) {
                                    $areadesc = '';
                                    if (array_key_exists('areadesc', $row['info'])) {
                                        $areadesc = $row['info']['areadesc'];
                                    }
                                    $warnings[] = [
                                        'warning_type' => $v['title'],
                                        'identifier' => $row['identifier'],
                                        'msgType' => $row['msgType'],
                                        'sender' => nl2br($row['sender']),
                                        'scope' => $row['scope'],
                                        'send' => $row['sent'],
                                        'status' => $row['status'],
                                        'info' => $row['info'],
                                        'area' => $areadesc,
                                    ];
                                }
                            }
                        }
                    }
                }
            }
        } catch (Exception $e) {
            self::WriteMail(__CLASS__, __LINE__, __FUNCTION__, $e->getCode(), $e->getMessage());
        }
        return $warnings;
    }

    private static function BuildContentSearch($array)
    {
        return "/\b(" . implode($array, "|") . ")\b/i";
    }

    public static function ReadCriticalGermany()
    {
        try {
            $urls = self::CriticalURLs();

            foreach ($urls as $k => $v) {
                self::DeleteContent($v['title'], $v['deletedays'], $v['deletehours']);
                self::getExternalDataAndSaveDB($v['url'], $v['title']);
            }
            Cache::forget('getWarningsApi');
        } catch (Exception $e) {
            self::WriteMail(__CLASS__, __LINE__, __FUNCTION__, $e->getCode(), $e->getMessage());
        }
    }

    public static function getStaticDWDRadar()
    {
        try {
            $urls = [];
            $urls[] = 'https://www.dwd.de/DWD/wetter/radar/radfilm_shh_akt.gif';
            $urls[] = 'https://www.dwd.de/DWD/warnungen/warnapp_gemeinden/json/warnungen_gemeinde_map_shh.png';
            $urls[] = 'https://www.wettergefahren.de/DWD/warnungen/agrar/glfi/glfi_stationen.png'; //Grasland - Feuerindex
            $urls[] = 'https://www.wettergefahren.de/DWD/warnungen/agrar/glfi/glfi_stationen1kl.png'; //Grasland - Feuerindex
            $urls[] = 'https://www.wettergefahren.de/DWD/warnungen/agrar/glfi/glfi_stationen2kl.png'; //Grasland - Feuerindex
            $urls[] = 'https://www.wettergefahren.de/DWD/warnungen/agrar/glfi/glfi_stationen3kl.png'; //Grasland - Feuerindex
            $urls[] = 'https://www.wettergefahren.de/DWD/warnungen/agrar/glfi/glfi_stationen4kl.png'; //Grasland - Feuerindex
            $urls[] = 'https://www.wettergefahren.de/DWD/warnungen/agrar/wbx/wbx_stationen.png'; //Waldbrand-Gefahrenindex WBI
            $urls[] = 'https://www.wettergefahren.de/DWD/warnungen/agrar/wbx/wbx_stationen1kl.png'; //Waldbrand-Gefahrenindex WBI
            $urls[] = 'https://www.wettergefahren.de/DWD/warnungen/agrar/wbx/wbx_stationen2kl.png';
            //Waldbrand-Gefahrenindex WBI
            $urls[] = 'https://www.wettergefahren.de/DWD/warnungen/agrar/wbx/wbx_stationen3kl.png';
            //Waldbrand-Gefahrenindex WBI
            $urls[] = 'https://www.wettergefahren.de/DWD/warnungen/agrar/wbx/wbx_stationen4kl.png';
            //Waldbrand-Gefahrenindex WBI

            foreach ($urls as $k => $v) {
                self::getSaveExternalData($v);
            }
        } catch (Exception $e) {
            self::WriteMail(__CLASS__, __LINE__, __FUNCTION__, $e->getCode(), $e->getMessage());
        }
    }

    private static function getSaveExternalData($url)
    {
        try {
            $filedata = self::getExternalData($url);
            if ($filedata == '') {
                return '';
            }
            $filename = basename($url);
            $local_file = public_path('weather' . DIRECTORY_SEPARATOR) . $filename;
            if (is_file($local_file)) {
                unlink($local_file);
            }
            $handle = fopen($local_file, 'w+');
            fwrite($handle, $filedata);
            fclose($handle);
        } catch (Exception $e) {
            self::WriteMail(__CLASS__, __LINE__, __FUNCTION__, $e->getCode(), $e->getMessage());
        }
    }

    /***
     * @todo Job repair!!!
     */
    public static function getStaticWeatherText()
    {
        try {
            #self::OpenFTPConnect();
            #$folder = '/gds/gds/specials/forecasts/text';
            #$file = 'VHDL30_DWHH_' . date('d');
            #$files = self::SearchOnServer($file, $folder);
            #$found = [];
            $folder = self::getDWDUrl() . '/alerts/txt/HA/';

            $files = [];

            $pattern = 'ber01-VHDL[0-9]{2}_DWHH_[0-9]{2}';
            #https://opendata.dwd.de/weather/text_forecasts/txt/pid-VHDL12_DWHH_240200-1807240200-dsw--0-ia5
            foreach ($files as $file) {
                if (preg_match('/' . $pattern . '/i', $file)) {
                    $found[] = $file;
                }
            }
            sort($found);
            $last_text = end($files);
            $content = self::FTPReadFile($last_text);
            self::SaveContent('dwd_weather_info', $content);
        } catch (Exception $e) {
            self::WriteMail(__CLASS__, __LINE__, __FUNCTION__, $e->getCode(), $e->getMessage(), 'dwd_weather_info');
        }
    }

    private static function getDWDUrl()
    {
        return 'https://opendata.dwd.de';
    }

    public static function getStaticSeaWeatherText()
    {
        try {
            #self::OpenFTPConnect();
            #$folder = '/gds/gds/specials/forecasts/text';
            #$file = 'VHDL30_DWHH_' . date('d');
            #$files = self::SearchOnServer($file, $folder);
            #$found = [];
            $folder = self::getDWDUrl() . '/weather/text_forecasts/txt/';

            $files = [];

            $pattern = 'pid-VHDL[0-9]{2}_DWHH_[0-9]{2}';
            #https://opendata.dwd.de/weather/text_forecasts/txt/pid-VHDL12_DWHH_240200-1807240200-dsw--0-ia5
            foreach ($files as $file) {
                if (preg_match('/' . $pattern . '/i', $file)) {
                    $found[] = $file;
                }
            }
            sort($found);
            $last_text = end($files);
            $content = self::FTPReadFile($last_text);
            self::SaveContent('dwd_seaweather_info', $content);
        } catch (Exception $e) {
            self::WriteMail(__CLASS__, __LINE__, __FUNCTION__, $e->getCode(), $e->getMessage(), 'dwd_weather_info');
        }
    }

    public static function getStaticWeatherMaps()
    {
        self::OpenFTPConnect();
        $folder = '/gds/gds/specials/forecasts/maps/germany/';
        $filename_pfx = 'Nordwest';
        $names = [];
        $names[] = '_heute_frueh';
        $names[] = '_heute_mittag';
        $names[] = '_heute_spaet';
        $names[] = '_heute_nacht';

        try {
            foreach ($names as $k => $v) {
                $file = $folder . $filename_pfx . $v . '.jpg';
                $filedata = self::FTPReadFile($file, FTP_BINARY);
                $local_file = public_path('weather' . DIRECTORY_SEPARATOR . 'maps' . DIRECTORY_SEPARATOR) . $filename_pfx . $v . '.jpg';
                if (is_file($local_file)) {
                    unlink($local_file);
                }
                $handle = fopen($local_file, 'w+');
                fwrite($handle, $filedata);
                fclose($handle);
            }
        } catch (Exception $e) {
            self::WriteMail(__CLASS__, __LINE__, __FUNCTION__, $e->getCode(), $e->getMessage(), $filename_pfx . $v . '.jpg');
        }
    }

    public static function CronGetTides($station = 'DE__505P')
    {
        $url = 'https://www2.bsh.de/cgi-bin/gezeiten/was_tab.pl?ort=' . $station . '&zone=Gesetzliche+Zeit+%B9&niveau=KN';
        //https://www2.bsh.de/cgi-bin/gezeiten/was_tab.pl?ort=DE__505P&zone=Gesetzliche+Zeit+%B9&niveau=KN
        $content = self::getExternalData($url);
        try {
            $doc = new DOMDocument();
            libxml_use_internal_errors(true);
            $doc->loadHTML($content); // loads your HTML
            $xpath = new DOMXPath($doc);
            $tables = $xpath->query('//table[@class="box3"]');
            $requiredTable = ''; // This will html of tables
            foreach ($tables as $table) {
                $requiredTable .= $doc->saveXML($table);
            }

            $dom = new DOMDocument();
            libxml_use_internal_errors(true);
            $dom->loadHTML($requiredTable);
            $rows = $dom->getElementsByTagName("tr");
            for ($i = 0; $i < $rows->length; $i++) {
                $cols = $rows->item($i)->getElementsbyTagName("td");
                if ($cols->length > 1) {
                    for ($j = 0; $j < $cols->length; $j++) {
                        if ($j == 1) {
                            $date = self::TideReplace($cols, $j);
                        } elseif ($j == 2) {
                            $tide = self::TideReplace($cols, $j);
                        } elseif ($j == 3) {
                            $time = self::TideReplace($cols, $j);
                        } elseif ($j == 4) {
                            $high = self::TideReplace($cols, $j);
                        }
                    }
                    self::SaveTideDB($date, $tide, $time, $high, $station);
                }
            }
            /***
             * @Todo Delete Old Content
             */
            //Tides::where('created_at', '<', date('Y-m-d H:i:s', strtotime("-1 day")))
        } catch (Exception $e) {
            self::WriteMail(__CLASS__, __LINE__, __FUNCTION__, $e->getCode(), $e->getMessage(), $url);
        }
    }

    private static function TideReplace($cols, $j)
    {
        try {
            return trim(str_replace('Â', '', $cols->item($j)->nodeValue));
        } catch (Exception $e) {
            self::WriteMail(__CLASS__, __LINE__, __FUNCTION__, $e->getCode(), $e->getMessage(), '');
        }
    }

    private static function SaveTideDB($date, $tide, $time, $high, $station)
    {
        $Tides = Tides::where('datum', '=', $date)->where('zeit', '=', $time)->get();
        if (Count($Tides) > 0) {
            return false;
        }
        try {
            $datetime = ToolsTrait::makeEnglishDateTime($date . ' ' . $time);
            $save = new Tides();
            $save->datetime = $datetime;
            $save->datum = $date;
            $save->zeit = $time;
            $save->tide = $tide;
            $save->high = $high;
            $save->station = $station;
            $save->save();
            return true;
        } catch (Exception $e) {
            self::WriteMail(
                __CLASS__,
                __LINE__,
                __FUNCTION__,
                $e->getCode(),
                $e->getMessage(),
                ''
            );
        }
    }

    public static function getStaticTides()
    {
        try {
            ToolsTrait::SQLLogger();
            $Tides = Tides::where('datetime', '>=', date('Y-m-d') . ' 00:00:00')
                ->where(
                    'datetime',
                    '<=',
                    date('Y-m-d H:i:s', mktime(23, 59, 59, date(
                        'm',
                        strtotime("+2 days")
                    ), date('d', strtotime("+2 days")), date('Y', strtotime("+2 days"))))
                )
                ->OrderBy('datetime', 'asc')
                ->get();
            $times = [];
            $Tides->each(function ($t) use (&$times) {
                $times [] = [
                    'datum' => $t->datum,
                    'zeit' => $t->zeit,
                    'tide' => $t->tide,
                    'high' => trim(str_replace('Â', '', $t->high)),
                ];
            });
            return $times;
        } catch (Exception $e) {
            self::WriteMail(__CLASS__, __LINE__, __FUNCTION__, $e->getCode(), $e->getMessage(), '');
        }
    }

    private static function MoonPhase($phase)
    {
        switch ($phase) {
            case '':
                $icon = '';
                break;
            default:
                $icon = '';
        }
        return $icon;
    }

    private static function GetFileFTP($remote_file, $local_file)
    {
        try {
            // Öffne eine Datei zum Schreiben
            $handle = fopen($local_file, 'w');
            if (ftp_fget(self::$ftp, $handle, $remote_file, FTP_ASCII, 0)) {
                echo "Erfolgreich in $local_file geschrieben\n";
            } else {
                echo "Download von $remote_file zu $local_file war nicht möglich\n";
            }
        } catch (Exception $e) {
            self::WriteMail(__CLASS__, __LINE__, __FUNCTION__, $e->getCode(), $e->getMessage());
        }
    }

    private static function GetUrl($url)
    {
        try {
            $curlSession = curl_init();
            curl_setopt($curlSession, CURLOPT_URL, $url);
            curl_setopt($curlSession, CURLOPT_BINARYTRANSFER, true);
            curl_setopt($curlSession, CURLOPT_RETURNTRANSFER, true);

            $return = curl_exec($curlSession);
            #Log::info($url);
            $httpcode = curl_getinfo($curlSession, CURLINFO_HTTP_CODE);
            curl_close($curlSession);
            $search = array(
                '/\[^\S]+/s', // strip whitespaces after tags, except space
                '/[^\S]+\</s', // strip whitespaces before tags, except spaces
                '/(\s)+/s' // shorten multiple whitespace sequences
            );
            $replace = array(
                '>',
                '<',
                '\\1'
            );
            $buffer = preg_replace($search, $replace, $return);
            return ($httpcode >= 200 && $httpcode < 300) ? $buffer : '';
        } catch (Exception $e) {
            self::WriteMail(__CLASS__, __LINE__, __FUNCTION__, $e->getCode(), $e->getMessage());
        }
        return '';
    }

    private static function SearchOnServer($filename, $folder)
    {
        try {
            $files = ftp_nlist(self::$ftp, $folder);
            return $files;
        } catch (Exception $e) {
            self::WriteMail(__CLASS__, __LINE__, __FUNCTION__, $e->getCode(), $e->getMessage(), $filename);
        }
    }

    /***
     * @param $file
     * @param string $accept
     *
     * -r für Rekursion
     * -l 1 für maximal 1 Ebene
     * -nd damit keine Verzeichnisse angelegt werden
     * -N damit nur neuere Dateien heruntergeladen werden
     * --accept-regex=VHDL30_DWSG.*" beschränkt die runtergeladenen Dateien auf VHDL30_DWSG*
     * -q falls du weniger Gequatsche von wget haben möchtest
     */
    private function getDataWithWget($file, $accept = '')
    {
        $cmd = 'wget -r -l 1 -nd -N "--accept-regex=VHDL30_DWSG.*" "https://opendata.dwd.de/weather/alerts/txt/SU/"';
    }
}
