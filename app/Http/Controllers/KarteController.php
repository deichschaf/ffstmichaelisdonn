<?php

namespace App\Http\Controllers;

use App\Http\Models\Einsaetze;
use App\Http\Models\Layout;
use App\Http\Traits\EinsaetzeTrait;

class KarteController extends GroundController
{
    public function show_position($lat = false, $lng = false)
    {
        $data = [];
        $data['title'] = '';
        if ($lat === false) {
            $koordinaten = self::getKoordinaten();
            $lat = $koordinaten['lat'];
            $lng = $koordinaten['lng'];
        }
        $data['lat'] = $lat;
        $data['lng'] = $lng;
        $data['googlekey'] = env('GOOGLE_GEOCODE_KEY');
        return view('karte.karte')->with('data', $data)->render();
    }

    public function karte_show($lat = false, $lng = false)
    {
        $data = [];
        $data['title'] = '';
        if ($lat === false) {
            $koordinaten = self::getKoordinaten();
            $lat = $koordinaten['lat'];
            $lng = $koordinaten['lng'];
        }
        $data['lat'] = $lat;
        $data['lng'] = $lng;
        $data['googlekey'] = env('GOOGLE_GEOCODE_KEY');
        return view('karte.karte')->with('data', $data)->render();
    }

    public function einsatzgebiet()
    {
        $data = [];
        $data['title'] = 'Unser Einsatzgebiet';
        $areas = EinsaetzeTrait::getEinsatzArea(1);
        $data['areas'] = $areas['areas'];
        $content = view('einsaetze.einsatz_gebiet')->with('data', $data)->render();
        $l = new Layout();
        return $l->layout_content($content, $data['title'], false, false);
    }

    public function show_einsatz($id)
    {
        //$card = Cache::remember(md5('emergency_'.$id), Config::get('CacheConfig.cache_timeout'), function() use ($id) {
        $data = EinsaetzeTrait::show_koordinaten($id);
        if (count($data) === 0) {
            return redirect('home');
        }
        $data['title'] = 'Einsatzkarte';
        $data['googlekey'] = env('GOOGLE_GEOCODE_KEY');
        return view('karte.karte')->with('data', $data)->render();
        #});
        #return $card;
        return $data;
    }

    public function show_ort($id)
    {
    }

    private static function getKoordinaten()
    {
        return array('lat' => '53.96616603176082', 'lng' => '9.062365041000362');
    }

    public function admin_einsatz($id = false)
    {
        $koordinaten = self::getKoordinaten();
        $lat = $koordinaten['lat'];
        $lng = $koordinaten['lng'];
        if ($id !== false) {
            $Einsaetze = Einsaetze::where('id', '=', $id)->get();
            $Einsaetze->each(function ($e) use (&$lat, &$lng) {
                $lat = $e->einsatz_ort_lon;
                $lng = $e->einsatz_ort_lat;
            });
        }
        return $this->admin_karte($lat, $lng);
    }

    private function admin_karte($lat, $lng, $adresse = '')
    {
        $data = [];
        $data['title'] = '';
        $data['lat'] = $lat;
        $data['lng'] = $lng;
        $data['adresse'] = $adresse;
        $data['googlekey'] = env('GOOGLE_GEOCODE_KEY');

        return view('karte.karte_admin')->with('data', $data)->render();
    }

    private static function BuildStaticMap($data)
    {
        $paths = '';
        $markers = '';
        $colors = [
            '0' => '#FF0000',
            '1' => '#0000FF',
            '2' => '#FFFF00',
        ];
        $i = 0;
        foreach ($data['areas'] as $area => $row) {
            $properties = [];
            $properties['stroke'] = $colors[$i];
            $properties['stroke_width'] = 1;
            $properties['fill'] = $colors[$i];
            $properties['fill_opacity'] = 1;
            $paths .= '&path=color:0x' . $properties['stroke'] . '|weight:' . $properties['stroke_width'] . '|fillcolor:0x' . $properties['fill'] . $properties['fill_opacity'];
            foreach ($row as $k2 => $coordinate) {
                $paths .= '|' . $coordinate['lng'] . ',' . $coordinate['lat'];
            }
            $i++;
        }
        $markers .= '&markers=scale:' . '1';
        $markers .= '|' . env('GOOGLE_GEOCODE_LAT') . ',' . env('GOOGLE_GEOCODE_LNG');

        $params = [
            'key' => env('GOOGLE_GEOCODE_KEY'),
            'zoom' => 12,
            'size' => '300x300',
            'format' => 'png32',
            'scale' => '2',
            'sensor' => 'false',
        ];

        return 'http://maps.googleapis.com/maps/api/staticmap?' . http_build_query($params) . $markers . $paths;
    }

    /***
     * https://stackoverflow.com/questions/24165873/how-to-generate-a-google-static-map-from-geojson
     */
    private static function MapBox()
    {
        $url = 'https://a.tiles.mapbox.com/v3/jeitnier.icm51ajc/markers.geojson';
        $response = \Utility::curl($url); // This is just a standard cURL function that returns the contents of the JSON
        $geojson = json_decode($response);
        $paths = '';
        $markers = '';

        foreach ($geojson->features as $feature) {
            $properties = array();

            if ('LineString' === $feature->geometry->type or 'Polygon' === $feature->geometry->type) {
                $properties['stroke'] = substr($feature->properties->stroke, 1, 7);
                $properties['stroke_width'] = $feature->properties->{'stroke-width'} - 1;
            }

            if ('LineString' === $feature->geometry->type) {
                $paths .= '&path=color:0x' . $properties['stroke'] . '99|weight:' . $properties['stroke_width'];

                foreach ($feature->geometry->coordinates as $set) {
                    // put them in reverse order (lat/long) and convert to string
                    $paths .= '|' . $set[1] . ',' . $set[0];
                }
            } elseif ('Polygon' === $feature->geometry->type) {
                $properties['fill'] = substr($feature->properties->fill, 1, 7);
                $properties['fill_opacity'] = $feature->properties->{'fill-opacity'} * 100;

                $paths .= '&path=color:0x' . $properties['stroke'] . '|weight:' . $properties['stroke_width'] . '|fillcolor:0x' . $properties['fill'] . $properties['fill_opacity'];

                foreach ($feature->geometry->coordinates as $coordinate) {
                    // iterate over individual coordinate set
                    foreach ($coordinate as $set) {
                        // put them in reverse order (lat/long) and convert to string
                        $paths .= '|' . $set[1] . ',' . $set[0];
                    }
                }
            } elseif ('Point' === $feature->geometry->type) {
                $markers .= '&markers=scale:' . $this->scale;
                $markers .= '|' . $feature->geometry->coordinates[1] . ',' . $feature->geometry->coordinates[0];
            }
        }

        // set map parameters
        $params = array(
            'key' => Config::get('custom.google_map_api_key'),
            'zoom' => 16,
            'size' => '300x300',
            'format' => 'png32',
            'scale' => '2',
            'sensor' => 'false',
        );

        $url = 'http://maps.googleapis.com/maps/api/staticmap?' . http_build_query($params) . $markers . $paths;
    }
}
