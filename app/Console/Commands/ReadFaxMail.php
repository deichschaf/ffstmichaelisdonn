<?php

namespace App\Console\Commands;

use App\Http\Models\AlarmEmail;
use App\Http\Traits\FxToolsTrait;
use ErrorException;
use Exception;
use Illuminate\Console\Command;
use Log;

class ReadFaxMail extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'alarm:reademail';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Read Alarm EMail';

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
        $mbox = $this->connection();
        $this->readHeaderBody($mbox);
    }

    private function connection()
    {
        $server = "{imap.ionos.de:993/imap/ssl}INBOX";
        $adresse = 'einsatzfax_datenmail_website@ff-st-michel.de';
        $password = 'dp2yfjpEH2ghvNw';
        try {
            $mbox = imap_open($server, $adresse, $password, OP_READONLY);
        } catch (ErrorException $e) {
            echo $e->getCode() . ': >' . $e->getMessage();
            Log::critical('AlarmEmail', ['code' => $e->getCode(), 'message' => $e->getMessage()]);
            exit();
        }
        return $mbox;
    }

    private function readHeaderBody($mbox)
    {
        $no = 1;
        $headers = imap_headers($mbox);
        $max = count($headers);
        for ($i = 0; $i < $max; ++$i) {
            $this->getMsg($mbox, ($i + 1));
        }
    }

    private function getMsg($mbox, $mid)
    {
        $mailcontent = [];
        $mailcontent['charset'] = '';
        $mailcontent['htmlmsg'] = '';
        $mailcontent['plainmsg'] = '';
        $mailcontent['attachments'] = [];

        // HEADER
        $h = imap_headerinfo($mbox, $mid);
        $mailcontent['header'] = [];
        $mailcontent['header']['message_id'] = $h->message_id;
        $mailcontent['header']['date'] = $h->date;
        $mailcontent['header']['from_address'] = $h->fromaddress;
        $mailcontent['header']['to_address'] = $h->toaddress;
        $mailcontent['header']['subject'] = imap_utf8($h->subject);

        $AlarmEmail = AlarmEmail::where('message_id', '=', $h->message_id)->count();
        if ($AlarmEmail === 0) {
            $mailcontent = $this->getContent($mbox, $mid, $mailcontent);
            $save = $this->saveEmergency($mailcontent);
        }
    }

    private function getContent($mbox, $mid, $mailcontent)
    {
        // BODY
        $s = imap_fetchstructure($mbox, $mid);
        if (!property_exists($s, 'parts')) {  // simple
            $mailcontent = $this->getpart($mbox, $mid, $s, 0, $mailcontent);  // pass 0 as part-number
        } else {  // multipart: cycle through each part
            foreach ($s->parts as $partno0 => $p) {
                $mailcontent = $this->getpart($mbox, $mid, $p, $partno0 + 1, $mailcontent);
            }
        }

        $plain = $mailcontent['plainmsg'];
        if (trim($plain) === '') {
            $plain = strip_tags($mailcontent['htmlmsg']);
            $plain = str_replace('&nbsp;', ' ', $plain);
        }

        $mailcontent['readable_plain_msg'] = $this->cutTxt($plain);
        $hinweis = $this->getHinweis($plain);
        $einheiten = $this->getEinheiten($plain);
        $mailcontent['emergencydata'] = $this->getEmergencyData(
            $mailcontent['readable_plain_msg'],
            $hinweis,
            $einheiten
        );
        //$mailcontent = $this->getCoordinate($mailcontent);
        return $mailcontent;
    }

    private function getpart($mbox, $mid, $p, $partno, $mailcontent)
    {
        $data = ($partno) ?
            imap_fetchbody($mbox, $mid, $partno) : // multipart
            imap_body($mbox, $mid);  // simple
        if ($p->encoding === 4) {
            $data = quoted_printable_decode($data);
        } elseif ($p->encoding === 3) {
            $data = base64_decode($data);
        }
        $params = [];
        if ($p->parameters) {
            foreach ($p->parameters as $x) {
                $params[strtolower($x->attribute)] = $x->value;
            }
        }
        if (array_key_exists('filename', $params)) {
            if ($params['filename'] || $params['name']) {
                // filename may be given as 'Filename' or 'Name' or both
                $filename = ($params['filename']) ? $params['filename'] : $params['name'];
                // filename may be encoded, so see imap_mime_header_decode()
                $mailcontent['attachments'][$filename] = $data;  // this is a problem if two files have same name
            }
        }

        // TEXT
        if ($p->type === 0 && $data) {
            // Messages may be split in different parts because of inline attachments,
            // so append parts together with blank row.
            if (strtolower($p->subtype) === 'plain') {
                $mailcontent['plainmsg'] .= trim($data) . "\n\n";
            } else {
                $mailcontent['htmlmsg'] .= $data . "<br><br>";
                $mailcontent['charset'] = $params['charset'];  // assume all parts are same charset
            }
        }

        // EMBEDDED MESSAGE
        // Many bounce notifications embed the original message as type 2,
        // but AOL uses type 1 (multipart), which is not handled here.
        // There are no PHP functions to parse embedded messages,
        // so this just appends the raw source to the main message.
        elseif ($p->type === 2 && $data) {
            $mailcontent['plainmsg'] .= $data . "\n\n";
        }

        // SUBPART RECURSION
        if (property_exists($p, 'parts')) {
            if ($p->parts) {
                foreach ($p->parts as $partno0 => $p2) {
                    $mailcontent = $this->getpart(
                        $mbox,
                        $mid,
                        $p2,
                        $partno . '.' . ($partno0 + 1),
                        $mailcontent
                    );  // 1.2, 1.2.1, etc.
                }
            }
        }
        return $mailcontent;
    }

    private function cutTxt($txt)
    {
        $txt = str_replace("\r", "", $txt);
        $txt = explode("\n", $txt);
        $data = [];
        foreach ($txt as $k => $row) {
            if ($row !== '') {
                $data[] = $row;
            }
        }
        return $data;
    }

    private function getHinweis($txt)
    {
        $txt = str_replace("\r", "", $txt);
        preg_match('/EinsatzHinweiseStart(.*)EinsatzHinweiseEnde/s', $txt, $output);
        $data = [];
        if (count($output) > 0) {
            $txt = explode("\n", $output[1]);
            foreach ($txt as $k => $row) {
                $row = trim($row);
                if ($row !== '') {
                    $data[] = $row;
                }
            }
        }
        return $data;
    }

    private function getEinheiten($txt)
    {
        $txt = str_replace("\r", "", $txt);
        preg_match('/AlarmierteEinheitenStart(.*)AlarmierteEinheitenEnde/s', $txt, $output);
        $data = [];
        if (count($output) > 0) {
            $txt = explode("\n", $output[1]);
            foreach ($txt as $k => $row) {
                $row = trim($row);
                if ($row !== '') {
                    $data[] = $row;
                }
            }
        }
        return $data;
    }

    private function getEmergencyData($raw_data, $hinweise, $einheiten)
    {
        $data = [];
        $data['emergency_priority'] = '0';
        $place = '';
        $street = '';
        $city = '';
        foreach ($raw_data as $k => $line) {
            $content = $this->getEmerencyContent('Einsatznr:', $line);
            if ($content !== false) {
                $data['emergency_number'] = $content;
            }
            $content = $this->getEmerencyContent('Alarmzeit:', $line);
            if ($content !== false) {
                $data['emergency_date_time'] = $content;
            }
            $content = $this->getEmerencyContent('ELP-Platz:', $line);
            if ($content !== false) {
                $data['emergency_workstation'] = $content;
            }
            $content = $this->getEmerencyContent('EinsatzSzenario:', $line);
            if ($content !== false) {
                $data['emergency_scenario'] = $content;
            }
            $content = $this->getEmerencyContent('EinsatzInfo:', $line);
            if ($content !== false) {
                $data['emergency_info'] = $content;
            }
            $content = $this->getEmerencyContent('SoSi:', $line);
            if ($content !== false) {
                if (strtolower($content) === 'ja') {
                    $data['emergency_priority'] = '1';
                }
            }
            $content = $this->getEmerencyContent('EO-KoordY:', $line);
            if ($content !== false) {
                $data['emergency_place_lat'] = $content;
            }
            $content = $this->getEmerencyContent('EO-KoordX:', $line);
            if ($content !== false) {
                $data['emergency_place_lng'] = $content;
            }
            $content = $this->getEmerencyContent('EO-Zusatzinfo:', $line);
            if ($content !== false) {
                $data['emergency_place_info'] = $content;
            }

            $content = $this->getEmerencyContent('EO-Str:', $line);
            if ($content !== false) {
                $street = $content;
            }
            $content = $this->getEmerencyContent('EO-Ort:', $line);
            if ($content !== false) {
                $city = $content;
            }
            $data['emergency_information'] = trim(implode(',', $hinweise));
            $data['emergency_stations'] = implode(',', $einheiten);
        }
        $place = $city;
        if ($street !== '') {
            $place = $street . ', ' . $city;
        }
        $data['emergency_place'] = $place;
        return $data;
    }

    private function getEmerencyContent($searchtxt, $txt)
    {
        $txt = trim($txt);
        if (str_starts_with($txt, $searchtxt)) {
            return trim(str_replace($searchtxt, '', $txt));
        }
        return false;
    }

    private function saveEmergency($mailcontent)
    {
        $oldMessages = $this->getAllMessages();
        $originalID = 0;
        if (array_key_exists($mailcontent['emergencydata']['emergency_number'], $oldMessages)) {
            $originalID = $oldMessages[$mailcontent['emergencydata']['emergency_number']];
        }
        $save = new AlarmEmail();
        $save->original_id = $originalID; // Schaut ob es eine erneute Alarmierung zu dem Alarm gab.
        $save->from_address = $mailcontent['header']['from_address'];
        $save->to_address = $mailcontent['header']['to_address'];
        $save->message_id = $mailcontent['header']['message_id'];
        $save->mail_date = $mailcontent['header']['date'];
        $save->mail_subject = $mailcontent['header']['subject'];
        if (array_key_exists('emergency_date_time', $mailcontent['emergencydata'])) {
            $save->emergency_date_time = FxToolsTrait::makeENGDateTime(
                $mailcontent['emergencydata']['emergency_date_time']
            );
        }
        $save->emergency_priority = $mailcontent['emergencydata']['emergency_priority'];
        if (array_key_exists('emergency_number', $mailcontent['emergencydata'])) {
            $save->emergency_number = $mailcontent['emergencydata']['emergency_number'];
        }
        if (array_key_exists('emergency_workstation', $mailcontent['emergencydata'])) {
            $save->emergency_workstation = $mailcontent['emergencydata']['emergency_workstation'];
        }
        if (array_key_exists('emergency_scenario', $mailcontent['emergencydata'])) {
            $save->emergency_scenario = $mailcontent['emergencydata']['emergency_scenario'];
        }
        if (array_key_exists('emergency_info', $mailcontent['emergencydata'])) {
            $save->emergency_info = $mailcontent['emergencydata']['emergency_info'];
        }

        if (array_key_exists('emergency_place', $mailcontent['emergencydata'])) {
            $save->emergency_place = $mailcontent['emergencydata']['emergency_place'];
        }

        if (array_key_exists('emergency_place_info', $mailcontent['emergencydata'])) {
            $save->emergency_place_info = $mailcontent['emergencydata']['emergency_place_info'];
        }

        if (array_key_exists('emergency_place_lat', $mailcontent['emergencydata'])) {
            $save->emergency_place_lat = $mailcontent['emergencydata']['emergency_place_lat'];
        }

        if (array_key_exists('emergency_place_lng', $mailcontent['emergencydata'])) {
            $save->emergency_place_lng = $mailcontent['emergencydata']['emergency_place_lng'];
        }

        if (array_key_exists('emergency_stations', $mailcontent['emergencydata'])) {
            $save->emergency_stations = $mailcontent['emergencydata']['emergency_stations'];
        }

        if (array_key_exists('emergency_information', $mailcontent['emergencydata'])) {
            $save->emergency_information = $mailcontent['emergencydata']['emergency_information'];
        }
        $save->charset = $mailcontent['charset'];
        $save->htmlmsg = $mailcontent['htmlmsg'];
        $save->plainmsg = $mailcontent['plainmsg'];
        $save->attachments = json_encode($mailcontent['attachments']);
        $save->save();
    }

    private function getAllMessages()
    {
        $data = [];
        $Messages = AlarmEmail::where('original_id', '=', 0)->get();
        $Messages->each(function ($m) use (&$data) {
            $data[$m->emergency_number] = $m->id;
        });
        return $data;
    }

    private function pushEmergency($mailcontent)
    {
        $accesskey = 'xdD5DwAM3dtRJfhmhR-WnsX1fniNRANieuMKdTdSA11N5-hMKWRAVcQ4BZyop7vF'; // TEL Dith
        $url = 'https://www.divera247.com/api/alarm?accesskey=' . $accesskey;

        /*
        $data = [
            'type' => $mailcontent['emergencydata']['emergency_scenario_short'],
            'text' => $mailcontent['emergencydata']['emergency_info'],
            'priority' => $mailcontent['emergencydata']['emergency_priority'],
            'address' => $mailcontent['emergencydata']['emergency_place']
            .' '.$mailcontent['emergencydata']['emergency_place_info'],
        ];
        */
        $data = [
            'type' => $mailcontent['emergencydata']['emergency_scenario_short']
                . ' | ' . $mailcontent['emergencydata']['emergency_info']
                . ' | ' . $mailcontent['emergencydata']['emergency_place']
                . ' ' . $mailcontent['emergencydata']['emergency_place_info'],
            'text' => $mailcontent['emergencydata']['emergency_info'],
            'priority' => $mailcontent['emergencydata']['emergency_priority'],
            'address' => $mailcontent['emergencydata']['emergency_place']
                . ' '
                . $mailcontent['emergencydata']['emergency_place_info'],
        ];

        $mailcontent['emergencydata']['alarmtext'] = $data;

        //return $mailcontent;
        try {
            $curlSession = curl_init();
            curl_setopt($curlSession, CURLOPT_URL, $url);
            curl_setopt($curlSession, CURLOPT_POSTFIELDS, json_encode($data));
            curl_setopt($curlSession, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
            curl_setopt($curlSession, CURLOPT_BINARYTRANSFER, true);
            curl_setopt($curlSession, CURLOPT_RETURNTRANSFER, true);
            //Tell cURL that it should only spend 10 seconds
            //trying to connect to the URL in question.
            curl_setopt($curlSession, CURLOPT_CONNECTTIMEOUT, 10);

            //A given cURL operation should only take
            //30 seconds max.
            curl_setopt($curlSession, CURLOPT_TIMEOUT, 30);
            $response = curl_exec($curlSession);
            $httpcode = curl_getinfo($curlSession, CURLINFO_HTTP_CODE);
            curl_close($curlSession);

            echo "<pre>\n";
            print_r($response);
            echo "</pre>\n";
        } catch (Exception $e) {
            Log::critical('AlarmEmail', ['code' => $e->getCode(), 'message' => $e->getMessage()]);
        }
        return $mailcontent;
    }
}
