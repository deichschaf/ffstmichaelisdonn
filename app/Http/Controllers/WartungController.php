<?php

namespace App\Http\Controllers;

use App\Http\Models\Wartung;
use Illuminate\Support\Facades\DB;

class WartungController extends GroundController
{
    /**
     * Schaut in der Datenbank nach ob es ein Wartungsflag gibt, und soll dann die Seite sperren.
     *
     * @param object $mysql
     */
    public function getWartung(): string
    {
        $jetzt = date('Y-m-d H:i:s');
        $Wartung = Wartung::where('beginn', '<=', "'" . $jetzt . "'")
            ->where('ende', '>=', "'" . $jetzt . "'")
            ->where('aktiv', '=', '1')
            ->orderBy('ende', 'desc')
            ->get();
        if (count($Wartung) > 0) {
            $Wartung->each(function ($w) {
                $this->buildPage($w->titel, $w->beschreibung);
            });
        }
        return '';
    }

    /**
     * Hole Errormeldung und gib die Wartungsseite aus.
     *
     * @param string $data
     */
    public function errorWartung($data)
    {
        $fehler = 'MySql Server Down!!!';
        $this->send_error_mail($fehler);
        $this->writeLog($fehler);
        $titel = 'Wartungsarbeiten im Rechenzentrum';
        $beschreibung = 'Bitte versuchen Sie es in ein paar Minuten noch einmal.<br>';
        $beschreibung .= 'Wir bitte um verst&auml;ndnis.<br><br>Falls diese Seite l&auml;nger angezeigt wird, ';
        $beschreibung .= 'bitte Informieren Sie dann den Betreiber dieser Homepage: ';
        $this->buildPage($titel, $beschreibung);
    }

    /**
     * Schreibe Wartungsprotokoll.
     *
     * @param array $data
     */
    public function writeLog($data)
    {
        //$datei=$_SERVER['DOCUMENT_ROOT'].'/log/wartung.txt';
        $datei = ERRORLOG;
        $datei = @fopen($datei, 'a+');
        if (! $datei) {
            $fehler = 'Kontrolldatei konnte nicht geschrieben werden';
            $this->sendErrorMail($fehler);
        }
        $error = [];
        $error[] = date('Y-m-d H:i:s');
        $error[] = $_SERVER['REMOTE_ADDR'];
        $error[] = gethostbyaddr($_SERVER['REMOTE_ADDR']);
        $error[] = $_SERVER['HTTP_REFERER'];
        $error[] = '==============================================================';
        @rewind($datei);
        @fwrite($datei, join(';', $error) . "\n");
        @fclose($datei);
    }

    public function sendErrorMail($fehler)
    {
        $error = [];
        $error[] = 'Folgender Fehler ist auf dem Server passiert:';
        $error[] = $fehler;
        $error[] = 'Datum: ' . date('d.m.Y H:i:s');
        $error[] = 'Remolte Adresse: ' . $_SERVER['REMOTE_ADDR'];
        $error[] = 'Host by Adresse: ' . gethostbyaddr($_SERVER['REMOTE_ADDR']);
        $error[] = 'Http Referer: ' . $_SERVER['HTTP_REFERER'];
        $error[] = 'PHP-Version: ' . phpversion();

        $header = [];
        $header[] = 'From: ' . DEBUG_ABSENDER . ' <' . KONTAKTEMAIL . '>';
        $header[] = 'X-Mailer:PHP/' . phpversion();
        $header[] = 'Mime-Version: 1.0';
        $header[] = 'Content-Type: text/plain; charset=utf-8';
        $header[] = 'Content-Transfer-Encoding: 8bit';

        $header = join("\n", $header);
        $message = join("\n", $error);
        $subject = 'Serverproblem!!';
        @mail(ERROREMAIL, $subject, $message, $header);
    }

    public function buildPage($titel, $beschreibung): string
    {
        $robot = false;
        $botlist = [
            'googlebot',
            'ia_archive',
            'kit_fireball',
            'lycos_spider',
            'scooter',
            'mediapartners',
            'feedsfetcher'
        ];
        foreach ($botlist as $bot) {
            if (stristr($_SERVER['HTTP_USER_AGENT'], $bot)) {
                $robot = true;
                break;
            }
        }
        if ($robot) {
            @header('HTTP/1.1 503 Service Temporarily Unavailable');
            @header('Status: 503 Service Temporarily Unavailable');
            @header('Retry-After: 3600');
            exit;
        }

        $data = [];
        $data['title'] = $titel;
        $data['beschreibung'] = $beschreibung;
        $data['goto'] = 'http://' . $_SERVER['SERVER_NAME'] . '?' . $_SERVER['QUERY_STRING'];

        echo view('Wartung')
            ->with('data', $data);
        exit();
    }
}
