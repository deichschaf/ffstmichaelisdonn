<?php

namespace App\Console\Commands;

use App\Http\Models\MitgliedCardEhrenamtskarte;
use App\Http\Models\MitgliedCardUrlChecker;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class ReadFirecardSpecialOffers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'firecard:offers';

    protected $mitgliedcard_url_id = 0;
    protected $herausgeber_id = 0;

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->readUrls();
    }

    public function readUrls()
    {
        try {
            $urls = [];
            $urls[] = [
                'url' => 'https://ehrenamtskarte.de/wp-admin/admin-ajax.php?action=getBonusangebote',
                'type' => 'Ehrenamtskarte'
            ];
            $urls[] = [
                'url' => 'https://www.lfv-sh.de/fileadmin/download/Feuerwehrdienstausweis/20190523_UEbersicht_Rabatte_Feuerwehrdienstausweis.pdf',
                'type' => 'pdf'
            ];
            $urls[] = [
              'url' => 'https://www.kfv-steinburg.de/index.php/mitgliederaktion-2',
                'type' => 'website'
            ];
            foreach ($urls as $key => $row) {
                $content = $this->getContent($row['url']);
                $new  = $this->checkContentHash($row['url'], $content);
                if ($new === true) {
                    if ($row['type'] === 'Ehrenamtskarte') {
                        $this->getEhrenamtskarte($content);
                    }
                }
            }
        } catch (\Exception $e) {
            Log::error(__FUNCTION__, [
                'code' => $e->getCode(),
                'message' => $e->getMessage(),
            ]);
            echo 'Fehler beim readlURL';
            exit();
        }
    }

    private function getContent($url)
    {
        try {
            $curlSession = curl_init();
            curl_setopt($curlSession, CURLOPT_URL, $url);
            curl_setopt($curlSession, CURLOPT_BINARYTRANSFER, true);
            curl_setopt($curlSession, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curlSession, CURLOPT_CONNECTTIMEOUT, 10);
            curl_setopt($curlSession, CURLOPT_TIMEOUT, 20);
            $return = curl_exec($curlSession);
            $httpcode = curl_getinfo($curlSession, CURLINFO_HTTP_CODE);
            curl_close($curlSession);
            Log::info(__FUNCTION__, ['httpcode' => $httpcode]);
            return ($httpcode >= 200 && $httpcode < 300) ? $return : '';
        } catch (\Exception $e) {
            Log::error('getContent', ['code' => $e->getCode(), 'message' => $e->getMessage()]);
            echo 'Fehler beim getContent';
            exit();
        }
    }

    /***
     * @param $url string
     * @param $content string
     * @return bool
     */
    private function checkContentHash($url, $content)
    {
        $hash = Hash::make($content);
        $count = MitgliedCardUrlChecker::where('url', '=', $url)->count();
        $new = false;
        if ($count === 0) {
            $save = new MitgliedCardUrlChecker();
            $save->url = $url;
            $save->hash = $hash;
            $save->save();
            $new = true;
            $this->mitgliedcard_url_id = $save->id;
        } else {
            $Check = MitgliedCardUrlChecker::where('url', '=', $url)->get();
            $Check->each(function ($c) use (&$new, $hash) {
                if ($hash !== $c->hash) {
                    $new = true;
                    $save = MitgliedCardUrlChecker::find($c->id);
                    $save->hash = $hash;
                    $save->save();
                    $this->mitgliedcard_url_id = $save->id;
                    $this->herausgeber_id = $c->herausgeber_id;
                }
            });
        }
        return $new;
    }

    private function getEhrenamtskarte($content)
    {
        try {
            $json = json_decode($content, true);
            if ($json === false) {
                Log::error(__FUNCTION__, ['json' => $json, 'content' => $content]);
                echo $json;
                exit();
            }

            foreach ($json['result'] as $key => $row) {
                $save = $this->saveEhrenamtskarte($row);
            }
        } catch (\Exception $e) {
            Log::error('getEhrenamtskarte', ['code' => $e->getCode(), 'message' => $e->getMessage()]);
            exit();
        }
    }

    private function saveEhrenamtskarte($row)
    {
        $id = 0;
        $last_change = '';
        $Ehrenamtskarte = MitgliedCardEhrenamtskarte::where('origin_id', '=', $row['ID'])->get();
        $Ehrenamtskarte->each(function ($c) use (&$id, &$last_change) {
            $id = $c->id;
            $last_change = $c->post_modified_gmt;
        });

        if ($last_change === $row['post_modified_gmt'] && $id !== 0) {
            return '';
        }

        if ($id === 0) {
            $save = new MitgliedCardEhrenamtskarte();
            $save->herausgeber_id = $this->herausgeber_id;
            $save->mitgliedcard_url_id = $this->mitgliedcard_url_id;
            $save->origin_id = $row['ID'];
            $save->post_author = $row['post_author'];
            $save->post_date = $row['post_date'];
            $save->post_date_gmt = $row['post_date_gmt'];
            $save->post_content = $row['post_content'];
            $save->post_title = $row['post_title'];
            $save->post_excerpt = $row['post_excerpt'];
            $save->post_status = $row['post_status'];
            $save->comment_status = $row['comment_status'];
            $save->ping_status = $row['ping_status'];
            $save->post_password = $row['post_password'];
            $save->post_name = $row['post_name'];
            $save->to_ping = $row['to_ping'];
            $save->pinged = $row['pinged'];
            $save->post_modified = $row['post_modified'];
            $save->post_modified_gmt = $row['post_modified_gmt'];
            $save->post_content_filtered = $row['post_content_filtered'];
            $save->post_parent = $row['post_parent'];
            $save->guid = $row['guid'];
            $save->menu_order = $row['menu_order'];
            $save->post_type = $row['post_type'];
            $save->post_mime_type = $row['post_mime_type'];
            $save->comment_count = $row['comment_count'];
            $save->filter = $row['filter'];
            $save->termids = $row['termids'];
            $save->new_post = $row['new_post'];
            $save->position_lat = $row['position']['0'];
            $save->position_lon = $row['position']['1'];
            $save->permalink = $row['permalink'];
            $save->firma_name = $row['firma_name'];
            $save->firma_link = $row['firma_link'];
            $save->firma_link_short = $row['firma_link_short'];
            $save->firma_street = $row['firma_street'];
            $save->firma_zip = $row['firma_zip'];
            $save->firma_city = $row['firma_city'];
            $save->ansprechpartner_anrede = $row['ansprechpartner_anrede'];
            $save->ansprechpartner_vorname = $row['ansprechpartner_vorname'];
            $save->ansprechpartner_nachname = $row['ansprechpartner_nachname'];
            $save->ansprechpartner_telefon = $row['ansprechpartner_telefon'];
            $save->ansprechpartner_email = $row['ansprechpartner_email'];
            $save->bonus_region = $row['bonus_region'];
            $save->bonus_link = $row['bonus_link'];
            $save->bonus_link_short = $row['bonus_link_short'];
            $save->bonus_street = $row['bonus_street'];
            $save->bonus_zip = $row['bonus_zip'];
            $save->bonus_city = $row['bonus_city'];
            $save->bonus_logo = $row['bonus_logo'];
            $save->bonus_logo_map = $row['bonus_logo_map'];
            $save->bonus_bild = $row['bonus_bild'];
            $save->bonus_bild_resized = $row['bonus_bild_resized'];
            $save->bonus_img_on_overview = $row['bonus_img_on_overview'];
            $save->bonus_title = $row['bonus_title'];
            $save->bonus_kurzbeschreibung = $row['bonus_kurzbeschreibung'];
            $save->bonus_kurzbeschreibung_excerpt = $row['bonus_kurzbeschreibung_excerpt'];
            $save->bonus_anmeldemodus = $row['bonus_anmeldemodus'];
            $save->bonus_anzahl = $row['bonus_anzahl'];
            $save->bonus_start = $row['bonus_start'];
            $save->bonus_ende = $row['bonus_ende'];
            $save->bonus_erganzungen = $row['bonus_erganzungen'];
            $save->partner_str_nr = $row['partner_str_nr'];
            $save->partner_plz = $row['partner_plz'];
            $save->partner_ort = $row['partner_ort'];
            $save->npo_categories = json_encode($row['npo_categories']);
            $save->filtered = $row['filtered'];
            $save->save();
        } else {
            $save = MitgliedCardEhrenamtskarte::find($id);
            $save->origin_id = $row['ID'];
            $save->post_author = $row['post_author'];
            $save->post_date = $row['post_date'];
            $save->post_date_gmt = $row['post_date_gmt'];
            $save->post_content = $row['post_content'];
            $save->post_title = $row['post_title'];
            $save->post_excerpt = $row['post_excerpt'];
            $save->post_status = $row['post_status'];
            $save->comment_status = $row['comment_status'];
            $save->ping_status = $row['ping_status'];
            $save->post_password = $row['post_password'];
            $save->post_name = $row['post_name'];
            $save->to_ping = $row['to_ping'];
            $save->pinged = $row['pinged'];
            $save->post_modified = $row['post_modified'];
            $save->post_modified_gmt = $row['post_modified_gmt'];
            $save->post_content_filtered = $row['post_content_filtered'];
            $save->post_parent = $row['post_parent'];
            $save->guid = $row['guid'];
            $save->menu_order = $row['menu_order'];
            $save->post_type = $row['post_type'];
            $save->post_mime_type = $row['post_mime_type'];
            $save->comment_count = $row['comment_count'];
            $save->filter = $row['filter'];
            $save->termids = $row['termids'];
            $save->new_post = $row['new_post'];
            $save->position_lat = $row['position']['0'];
            $save->position_lon = $row['position']['1'];
            $save->permalink = $row['permalink'];
            $save->firma_name = $row['firma_name'];
            $save->firma_link = $row['firma_link'];
            $save->firma_link_short = $row['firma_link_short'];
            $save->firma_street = $row['firma_street'];
            $save->firma_zip = $row['firma_zip'];
            $save->firma_city = $row['firma_city'];
            $save->ansprechpartner_anrede = $row['ansprechpartner_anrede'];
            $save->ansprechpartner_vorname = $row['ansprechpartner_vorname'];
            $save->ansprechpartner_nachname = $row['ansprechpartner_nachname'];
            $save->ansprechpartner_telefon = $row['ansprechpartner_telefon'];
            $save->ansprechpartner_email = $row['ansprechpartner_email'];
            $save->bonus_region = $row['bonus_region'];
            $save->bonus_link = $row['bonus_link'];
            $save->bonus_link_short = $row['bonus_link_short'];
            $save->bonus_street = $row['bonus_street'];
            $save->bonus_zip = $row['bonus_zip'];
            $save->bonus_city = $row['bonus_city'];
            $save->bonus_logo = $row['bonus_logo'];
            $save->bonus_logo_map = $row['bonus_logo_map'];
            $save->bonus_bild = $row['bonus_bild'];
            $save->bonus_bild_resized = $row['bonus_bild_resized'];
            $save->bonus_img_on_overview = $row['bonus_img_on_overview'];
            $save->bonus_title = $row['bonus_title'];
            $save->bonus_kurzbeschreibung = $row['bonus_kurzbeschreibung'];
            $save->bonus_kurzbeschreibung_excerpt = $row['bonus_kurzbeschreibung_excerpt'];
            $save->bonus_anmeldemodus = $row['bonus_anmeldemodus'];
            $save->bonus_anzahl = $row['bonus_anzahl'];
            $save->bonus_start = $row['bonus_start'];
            $save->bonus_ende = $row['bonus_ende'];
            $save->bonus_erganzungen = $row['bonus_erganzungen'];
            $save->partner_str_nr = $row['partner_str_nr'];
            $save->partner_plz = $row['partner_plz'];
            $save->partner_ort = $row['partner_ort'];
            $save->npo_categories = json_encode($row['npo_categories']);
            $save->filtered = $row['filtered'];
            $save->save();
        }
    }
}
