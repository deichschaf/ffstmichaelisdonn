<?php

namespace App\Console\Commands;

use App\Http\Models\Einsaetze;
use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ConnectException;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class GoogleDistanceCommand extends Command
{
    protected $signature = 'google:getemergencydistance';
    protected $description = 'Get Emergency Distance from Firestation';
    private $firestationLocation = 'Johannßenstraße 21, 25693 Sankt Michaelisdonn, Deutschland';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        try {
            $this->checkDB();
        } catch (Exception $e) {
            Log::info($e->getCode() . ' : ' . $e->getMessage());
        }
    }

    private function checkDB()
    {
        try {
            $db = Einsaetze::where('access_road', '=', '')->orWhereNull('access_road')->get();
            $db->each(function ($e) {
                if ($e->einsatz_ort !== '' && $e->einsatz_ort !== null) {
                    $access_road = $this->makeGoogleCall($e->einsatz_ort);
                    if ($access_road !== '') {
                        $save = Einsaetze::find($e->id);
                        $save->access_road = $access_road;
                        $save->save();
                    }
                }
            });
        } catch (Exception $e) {
            Log::info($e->getCode() . ' : ' . $e->getMessage());
        }
    }

    private function makeGoogleCall(string $location = '')
    {
        try {
            $client = new Client();
            try {
                $res = $client->request(
                    'GET',
                    'https://maps.googleapis.com/maps/api/distancematrix/json?'.
                    'origins='.urlencode($this->firestationLocation).
                    '&destinations='.urlencode($location).
                    '&units=metric&key='.env('GOOGLE_API_KEY').'&language=de',
                    [
                        'connect_timeout' => 1,
                        'verify' => false
                    ]
                );
                if ($res->getStatusCode() !== 200) {
                    Log::info(__FUNCTION__, ['StatusCode' => $res->getStatusCode(), 'Body' => $res->getBody()]);
                    return '';
                }
                $response = $res->getBody();
                $response = (array)json_decode($response);
                if (!array_key_exists('rows', $response)) {
                    Log::info(__FUNCTION__, ['StatusCode' => $res->getStatusCode(), 'Body' => $res->getBody()]);
                    return '';
                }
                foreach ($response as $key => $value) {
                    if ($key === 'rows') {
                        $rows = (array)$value['0'];
                        if (array_key_exists('elements', $rows)) {
                            foreach ($rows['elements'] as $k2 => $v2) {
                                $row = (array)$v2;
                                if (array_key_exists('distance', $row)) {
                                    $distance = (array)$row['distance'];
                                    return $distance['text'];
                                }
                            }
                        }
                    }
                }
                return '';
            } catch (ConnectException $e) {
                Log::info($e->getCode() . ' : ' . $e->getMessage());
                return '';
            }
        } catch (Exception $e) {
            Log::info($e->getCode() . ' : ' . $e->getMessage());
            return '';
        }
    }
}
