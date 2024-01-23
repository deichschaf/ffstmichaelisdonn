<?php

namespace App\Http\Traits;

use App\Http\Models\DWDWeather;
use Exception;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Log;

trait BloodDonationTrait
{
    private static string $blood_url_static = 'https://www.blutspende-nordost.de/blutspendetermine/termine.rss?last_donation=01.01.2022&radius=15&term=25693';
    private $blood_url = 'https://www.blutspende-nordost.de/blutspendetermine/termine.rss?last_donation=01.01.2022&radius=15&term=25693';

    public static function setBloodDonationTermineCron()
    {
        try {
            $url = self::$blood_url_static;
            $simpleXml = simplexml_load_string(file_get_contents($url), "SimpleXMLElement", LIBXML_NOCDATA);
            $json = json_encode($simpleXml);
            $json = self::makeBloodDonatonReplace($json);
            $json = json_encode($json);
            if (strlen($json) > 0) {
                $save = new DWDWeather();
                $save->area = 'blooddonationtermine';
                $save->content = $json;
                $save->save();
                $id = $save->id;
                echo 'Neuer Content gespeichert: BloodDonationTermine';
                $count = DWDWeather::where('area', '=', 'blooddonationtermine')->count();
                if ($count > 3) {
                    DWDWeather::where('area', '=', 'blooddonationtermine')->where('id', '!=', $id)->forceDelete();
                }
            }
        } catch (Exception $e) {
            Log::info(__CLASS__, ['code' => $e->getCode(), 'message' => $e->getMessage()]);
        }
    }

    private static function makeBloodDonatonReplace(string $json): array
    {
        $data = [];
        $json = json_decode($json);
        if (property_exists($json, 'channel')) {
            if (property_exists($json->channel, 'item')) {
                if (count($json->channel->item) > 0) {
                    foreach ($json->channel->item as $k => $row) {
                        $titel = (string)$row->title;
                        $titel = trim($titel);
                        $titel = explode(' am ', $titel);
                        $datum = explode(', ', $titel['1']);
                        $plz = substr($titel['0'], 0, 5);
                        $titel = substr($titel['0'], 6);
                        $titel = self::replaceRSSFeed($titel);
                        $uhrzeit = $datum['1'];
                        #$datum= $this->getDayofWeek($datum['0']).', '.$datum['0'];
                        $datum = $datum['0'];
                        $description = (string)$row->description;
                        $description = trim($description);
                        #$description=str_replace("\t",' ',$description);
                        $desc = explode(' ', $description);
                        foreach ($desc as $key => $value) {
                            if ($value == '') {
                                unset($key);
                            }
                        }
                        $description = join(' ', $desc);
                        $description = self::replaceRSSFeed($description);
                        $street = $description['0'];
                        $street_addition = [];
                        if (count($description) > 1) {
                            unset($description['0']);
                            foreach ($description as $key => $value) {
                                $street_addition[] = $value;
                            }
                        }
                        $street_addition = implode(' ', $street_addition);
                        $data[] = [
                            'link' => $row->link,
                            'day' => $datum,
                            'time' => $uhrzeit,
                            'city' => implode(' ', $titel),
                            'zipcode' => $plz,
                            'street' => $street,
                            'street_addition' => $street_addition,
                        ];
                    }
                }
            }
        }
        return $data;
    }

    private static function replaceRSSFeed(string $text): string|array
    {
        if (substr($text, 0, 2) === '- ') {
            $text = substr($text, 2);
        }
        $text = str_replace(" - ", "<br>", $text);
        preg_replace("/ +/", " ", $text);
        $text = str_replace(array("AE", "OE", "UE", "&#039;", "'"), array('Ä', 'Ö', 'Ü', '', ''), $text);
        $text = str_replace(",", '<br>', $text);
        $text = str_replace('Drk-a', 'DRK-A', $text);
        $text = str_replace('Drk-b', 'DRK-B', $text);
        $text = str_replace(" Grundschule", " Grundschule<br>", $text);
        $text = str_replace("In Der Grundschule<br>", "Grundschule<br>", $text);
        $text = str_replace("<br><br>", "<br>", $text);
        $text = str_replace("Michälisdonn", "Michaelisdonn", $text);
        $text = str_replace("In Der Waldorfschule", "Waldorfschule", $text);
        $text = str_replace("Neü", "Neue", $text);
        $text = str_replace("Feürwehr", "Feuerwehr", $text);
        $text = str_replace("Grundschule Wilhelmstr", "Grundschule<br>Wilhelmstr", $text);
        $text = str_replace("/d", "/D", $text);
        $text = preg_replace("/\s+/", " ", $text);
        $text = str_replace("Ev. Gemeindehaus ", "Ev. Gemeindehaus<br>", $text);
        $text = str_replace("<br> ", "<br>", $text);
        $text = str_replace("Lohe-rickelshof", "Lohe-Rickelshof", $text);
        $text = str_replace("Neocorus-schule", "Neocorus-Schule", $text);
        $text = str_replace(" - ", "<br>", $text);
        $text = explode('<br>', $text);
        return $text;
    }

    /**
     * @return string
     */
    public function getBloodDonationTermine(): string
    {
        $data = Cache::remember(
            __CLASS__ . '_' . __FUNCTION__,
            Config::get('CacheConfig.cache_content_timeout'),
            function () {
                $DWDWeather = DWDWeather::where('area', 'blooddonationtermine')->orderBy('created_at', 'desc')->take(1)->get();
                $DWDWeather->each(function ($dwd) use (&$content) {
                    $content = $dwd->content;
                });
                return $content;
            }
        );
        return $data;
    }

    public function setBloodDonationTermine()
    {
        try {
            $url = $this->blood_url;
            $simpleXml = simplexml_load_string(file_get_contents($url), "SimpleXMLElement", LIBXML_NOCDATA);
            $json = json_encode($simpleXml);
            $json = self::makeBloodDonatonReplace($json);
            $json = json_encode($json);
            if (strlen($json) > 0) {
                $DWDWeather = DWDWeather::where('area', 'blooddonationtermine')->orderBy('created_at', 'desc')->take(1)->get();
                $DWDWeather->each(function ($dwd) use ($json) {
                    if ($json !== $dwd->content) {
                        $save = new DWDWeather();
                        $save->area = 'blooddonationtermine';
                        $save->content = $json;
                        $save->save();
                        echo 'Neuer Content gespeichert: BloodDonationTermine';
                    }
                });
            }
        } catch (Exception $e) {
            Log::info(__CLASS__, ['code' => $e->getCode(), 'message' => $e->getMessage()]);
        }
    }
}
