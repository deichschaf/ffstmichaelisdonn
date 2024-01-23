<?php

namespace App\Console\Commands;

use App\Http\Models\Einsaetze;
use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ConnectException;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class GoogleEmergencyPosition extends Command
{
    protected $signature='google:emergencyposition';
    protected $description='Holt die richtige Position vom Einsatzort';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        try {
            $this->checkDB();
        } catch(Exception $e) {
            Log::info($e->getCode() . ' : ' . $e->getMessage());
        }
    }

    private function checkDB()
    {
        try {
            $db=Einsaetze::get();
            $db->each(function ($e) {
                if ($e->einsatz_ort !== '' && $e->einsatz_ort !== null) {
                    if ($e->einsatz_ort_lon === '' || $e->einsatz_ort_lon === null) {
                        $koordinaten = $this->makeGoogleCall($e->einsatz_ort);
                        if (count($koordinaten) > 0) {
                            $save = Einsaetze::find($e->id);
                            $save->einsatz_ort_lon = $koordinaten['lat'];
                            $save->einsatz_ort_lat = $koordinaten['lng'];
                            $save->save();
                        }
                    }
                }
            });
        } catch(Exception $e) {
            Log::info($e->getCode() . ' : ' . $e->getMessage());
        }
    }

    private function makeGoogleCall(string $place = '')
    {
        try {
            $client = new Client();
            $place = trim($place);
            $place = str_ireplace('ä', 'ae', $place);
            $place = str_ireplace('ö', 'oe', $place);
            $place = str_ireplace('ü', 'ue', $place);
            $place = str_ireplace('ß', 'ss', $place);
            $place = str_ireplace(' ', '+', $place);
            $place .= '+DE'; // Setzt Deutschland ans Ende.
            try {
                $res = $client->request(
                    'GET',
                    'https://maps.googleapis.com/maps/api/geocode/json?address='.$place.
                    '&key='.env('GOOGLE_API_KEY').'&language=de',
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
                if (!array_key_exists('results', $response)) {
                    Log::info(__FUNCTION__, ['StatusCode' => $res->getStatusCode(), 'Body' => $res->getBody()]);
                    return '';
                }
                foreach ($response as $key => $value) {
                    if ($key === 'results') {
                        $results = (array)$value;
                        $geometry = (array)$results['0']->geometry;
                        return (array)$geometry['location'];
                    }
                }
                return [];
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
