<?php

namespace App\Http\Traits;

use App\Http\Models\CriticalSenderList;
use App\Http\Models\CriticalSenderUrls;
use App\Http\Models\DWDWeather;
use DB;
use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Config;
use Log;

trait CriticalTrait
{
    public function readCriticalSender()
    {
        try {
            $urls = $this->getCriticalSenderUrls();
            foreach ($urls as $k => $v) {
                $this->deleteContent($v['title'], $v['deletedays'], $v['deletehours']);
                $this->getCriticalContent($v['url'], $v['title']);
            }
            Cache::forget('getWarningsApi');
        } catch (Exception $e) {
            Log::error('Error CriticalTrait', ['class' => __CLASS__, 'line' => __LINE__, 'function' => __FUNCTION__, 'code' => $e->getCode(), 'message' => $e->getMessage()]);
        }
    }

    /**
     * @return array
     */
    private function getCriticalSenderUrls(): array
    {
        $data = Cache::remember(
            __CLASS__ . '_' . __FUNCTION__,
            Config::get('CacheConfig.cache_content_timeout'),
            function () {
                $urls = [];
                $Sender = CriticalSenderUrls::where('critical_area_name', '!=', 'alertURLConfig')
                    ->where('critical_area_name', '!=', 'certa_server_url')
                    ->where('critical_area_name', '!=', 'dwdwarnungen')->get();
                $Sender->each(function ($s) use (&$urls) {
                    $urls[] = [
                        'url' => $s->critical_area_url,
                        'title' => $s->critical_area,
                        'deletedays' => $s->deletedays,
                        'deletehours' => $s->deletehours,
                    ];
                });
                return $urls;
            }
        );
        return (array)$data;
    }

    /**
     * @param string $area
     * @param bool|int $maxdaysbefore
     * @param bool|int $maxhoursbefore
     * @return void
     */
    private function deleteContent(string $area, bool|int $maxdaysbefore = false, bool|int $maxhoursbefore = false)
    {
        try {
            if ($maxdaysbefore !== false && $maxhoursbefore === false) {
                DWDWeather::where('area', $area)
                    ->where('created_at', '<', date('Y-m-d H:i:s', strtotime('-' . $maxdaysbefore . ' days')))
                    ->delete();
            } else {
                DWDWeather::where('area', $area)
                    ->where('created_at', '<', date('Y-m-d H:i:s', strtotime('-' . $maxhoursbefore . ' hours')))
                    ->delete();
            }
        } catch (Exception $e) {
            Log::error('Error CriticalTrait', ['class' => __CLASS__, 'line' => __LINE__, 'function' => __FUNCTION__, 'code' => $e->getCode(), 'message' => $e->getMessage()]);
        }
    }

    /**
     * @param string $url
     * @param string $area
     * @return string|void
     */
    private function getCriticalContent(string $url = '', string $area = '')
    {
        try {
            $content = $this->getExternalContent($url);

            if (strtolower($area) === 'dwdwarnungen') {
                $content = str_ireplace('warnWetter.loadWarnings(', '', $content);
                if (substr($content, -2) == ');') {
                    $content = substr($content, 0, -2);
                }
            }

            $content = trim($content);
            if ($content === '' || $content === '[]') {
                return '';
            }
            $this->setContent($area, $content);
        } catch (Exception $e) {
            Log::error('Error CriticalTrait', ['class' => __CLASS__, 'line' => __LINE__, 'function' => __FUNCTION__, 'code' => $e->getCode(), 'message' => $e->getMessage()]);
        }
    }

    private function getExternalContent(string $url = ''): string
    {
        try {

            $client = new Client();
            $res = $client->request('GET', $url, ['connect_timeout' => 2, 'verify' => false]);
            $httpcode = $res->getStatusCode();
            if ($httpcode >= 200 && $httpcode < 302) {
                $content = $res->getBody();

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
                $buffer = preg_replace($search, $replace, $content);
                if (substr($buffer, 0, 9) === '<!DOCTYPE') {
                    return '';
                }
                return $buffer;
            }
            return '';
        } catch (ClientException $e) { // > 302 errors
            #echo Psr7\Message::toString($e->getRequest());
            #echo Psr7\Message::toString($e->getResponse());
            return '';
        } catch (Exception $e) {
            Log::error('Error CriticalTrait', ['class' => __CLASS__, 'line' => __LINE__, 'function' => __FUNCTION__, 'code' => $e->getCode(), 'message' => $e->getMessage()]);
        }
        return '';
    }

    /**
     * @param string $area
     * @param string $content
     * @return string|void
     */
    private function setContent(string $area = '', string $content = '')
    {
        try {
            $area = trim($area);
            $content = trim($content);
            if ($area === '' || $content === '') {
                return '';
            }
            $save = new DWDWeather();
            $save->area = $area;
            $save->content = $content;
            $save->save();
        } catch (Exception $e) {
            Log::error('Error CriticalTrait', ['class' => __CLASS__, 'line' => __LINE__, 'function' => __FUNCTION__, 'code' => $e->getCode(), 'message' => $e->getMessage()]);
        }
    }

    public function getCritical(): array
    {
        $search = $this->getCriticalSenderList();
        return $this->getDatabaseContent($search);
    }

    private function getCriticalSenderList(): array
    {
        $data = Cache::remember(
            __CLASS__ . '_' . __FUNCTION__,
            Config::get('CacheConfig.cache_content_timeout'),
            function () {
                $search = [];
                $Sender = CriticalSenderList::where('isactive', '=', '1')->get();
                $Sender->each(function ($s) use (&$search) {
                    $search[] = $s->senderid;
                });
                return $search;
            }
        );
        return (array)$data;
    }

    /**
     * @param array $search
     * @return array
     */
    private function getDatabaseContent(array $search = []): array
    {
        $warnings = [];
        try {
            $urls = $this->getCriticalSenderUrls();
            $criticalSender = (array)$this->getCriticalSenderList();
            $contents = [];
            $identifier = [];
            foreach ($urls as $k => $v) {
                if ($v['title'] !== 'warnungen_bund.config') {
                    $content = $this->GetContent($v['title'], false, 3);
                    if ($content !== '') {
                        $objData = json_decode($content);
                        $data = json_decode(json_encode($objData), true);
                        if (is_array($data)) {
                            foreach ($data as $key => $row) {
                                $row = (array)$row;
                                if (!in_array($row['identifier'], $identifier)) {
                                    foreach ($row['info'] as $i_key => $i_row) {
                                        foreach ($i_row['area'] as $a_key => $a_row) {
                                            if (array_key_exists('geocode', $a_row)) {
                                                foreach ($a_row['geocode'] as $geo_key => $geo_row) {
                                                    if (strtolower($geo_row['valueName']) === 'dithmarschen') {
                                                        // ONLY Dithmarschen
                                                        $sender = '';
                                                        if (array_key_exists('parameter', $i_row)) {
                                                            foreach ($i_row['parameter'] as $p_key => $p_row) {
                                                                if (strtolower($p_row['valueName']) === 'sender_signature') {
                                                                    $sender = $p_row['value'];
                                                                }
                                                            }
                                                        }
                                                        $identifier[] = $row['identifier'];
                                                        $warnings[] = [
                                                            'identifier' => $row['identifier'],
                                                            'headline' => $i_row['headline'],
                                                            'description' => $i_row['description'],
                                                            'sender' => nl2br($sender),
                                                            'event' => $i_row['event'],
                                                            'msgType' => $row['msgType'],
                                                            'send' => $row['sent'],
                                                        ];
                                                    }
                                                }
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
        } catch (Exception $e) {
            Log::error('Error CriticalTrait', ['class' => __CLASS__, 'line' => __LINE__, 'function' => __FUNCTION__, 'code' => $e->getCode(), 'message' => $e->getMessage()]);
        }
        return $warnings;
    }

    /**
     * @param string $area
     * @param number | boolean $maxdaysbefore
     * @param number | boolean $maxhoursbefore
     * @return string
     */
    private function GetContent(string $area = '', $maxdaysbefore = false, $maxhoursbefore = false): string
    {
        $content = '';
        try {
            $DWDWeather = DWDWeather::where('area', $area)->orderBy('created_at', 'desc')->take(1)->get();
            $DWDWeather->each(function ($dwd) use (&$content) {
                $content = $dwd->content;
            });
            return $content;
        } catch (Exception $e) {
            Log::error('Error CriticalTrait', ['class' => __CLASS__, 'line' => __LINE__, 'function' => __FUNCTION__, 'code' => $e->getCode(), 'message' => $e->getMessage()]);
        }
        return $content;
    }

    /**
     * @return array
     */
    private function getCriticalSenderConfigUrl(): array
    {
        $data = Cache::remember(
            __CLASS__ . '_' . __FUNCTION__,
            Config::get('CacheConfig.cache_content_timeout'),
            function () {
                $urls = [];
                $Sender = CriticalSenderUrls::where('critical_area_name', '=', 'alertURLConfig')->get();
                $Sender->each(function ($s) use (&$urls) {
                    $urls[] = [
                        'url' => $s->critical_area_url,
                        'title' => $s->critical_area,
                        'deletedays' => $s->deletedays,
                        'deletehours' => $s->deletehours,
                    ];
                });
                return $urls;
            }
        );
        return (array)$data;
    }

    /**
     * @param array $array
     * @return string
     */
    private function BuildContentSearch(array $array = []): string
    {
        return "/\b(" . implode("|", $array) . ")\b/i";
    }
}
