<?php

namespace App\Http\Traits;

trait FxToolsStatusTrait
{
    /**
    *   // Hier muss die Funktion Status::getHttpStatus() am anfang der Seite eingebaut werden auf der alten Seite.
    *   < ?php
    *   Status::getHttpStatus(301);
    *   header('Location: http://domain.com/Neue_Seite.php');?>.
    */
    public function getHttpStatus($num)
    {
        $num = trim($num);
        static $http = [
            100 => 'HTTP/1.1 100 Continue',
            101 => 'HTTP/1.1 101 Switching Protocols',
            200 => 'HTTP/1.1 200 OK',
            201 => 'HTTP/1.1 201 Created',
            202 => 'HTTP/1.1 202 Accepted',
            203 => 'HTTP/1.1 203 Non-Authoritative Information',
            204 => 'HTTP/1.1 204 No Content',
            205 => 'HTTP/1.1 205 Reset Content',
            206 => 'HTTP/1.1 206 Partial Content',
            300 => 'HTTP/1.1 300 Multiple Choices',
            301 => 'HTTP/1.1 301 Moved Permanently',
            302 => 'HTTP/1.1 302 Found',
            303 => 'HTTP/1.1 303 See Other',
            304 => 'HTTP/1.1 304 Not Modified',
            305 => 'HTTP/1.1 305 Use Proxy',
            307 => 'HTTP/1.1 307 Temporary Redirect',
            400 => 'HTTP/1.1 400 Bad Request',
            401 => 'HTTP/1.1 401 Unauthorized',
            402 => 'HTTP/1.1 402 Payment Required',
            403 => 'HTTP/1.1 403 Forbidden',
            404 => 'HTTP/1.1 404 Not Found',
            405 => 'HTTP/1.1 405 Method Not Allowed',
            406 => 'HTTP/1.1 406 Not Acceptable',
            407 => 'HTTP/1.1 407 Proxy Authentication Required',
            408 => 'HTTP/1.1 408 Request Time-out',
            409 => 'HTTP/1.1 409 Conflict',
            410 => 'HTTP/1.1 410 Gone',
            411 => 'HTTP/1.1 411 Length Required',
            412 => 'HTTP/1.1 412 Precondition Failed',
            413 => 'HTTP/1.1 413 Request Entity Too Large',
            414 => 'HTTP/1.1 414 Request-URI Too Large',
            415 => 'HTTP/1.1 415 Unsupported Media Type',
            416 => 'HTTP/1.1 416 Requested range not satisfiable',
            417 => 'HTTP/1.1 417 Expectation Failed',
            500 => 'HTTP/1.1 500 Internal Server Error',
            501 => 'HTTP/1.1 501 Not Implemented',
            502 => 'HTTP/1.1 502 Bad Gateway',
            503 => 'HTTP/1.1 503 Service Unavailable',
            504 => 'HTTP/1.1 504 Gateway Time-out',
        ];
        header($http[$num]);
    }

    /**
     * @param $check
     * @return string
     *
     * public function error($error = 404)
    {
    $text = 'Not Found';

    if ($error !== null) {
    switch ($error) {
    case 100:
    $text = 'Continue';
    break;
    case 101:
    $text = 'Switching Protocols';
    break;
    case 200:
    $text = 'OK';
    break;
    case 201:
    $text = 'Created';
    break;
    case 202:
    $text = 'Accepted';
    break;
    case 203:
    $text = 'Non-Authoritative Information';
    break;
    case 204:
    $text = 'No Content';
    break;
    case 205:
    $text = 'Reset Content';
    break;
    case 206:
    $text = 'Partial Content';
    break;
    case 300:
    $text = 'Multiple Choices';
    break;
    case 301:
    $text = 'Moved Permanently';
    break;
    case 302:
    $text = 'Moved Temporarily';
    break;
    case 303:
    $text = 'See Other';
    break;
    case 304:
    $text = 'Not Modified';
    break;
    case 305:
    $text = 'Use Proxy';
    break;
    case 400:
    $text = 'Bad Request';
    break;
    case 401:
    $text = 'Unauthorized';
    break;
    case 402:
    $text = 'Payment Required';
    break;
    case 403:
    $text = 'Forbidden';
    break;
    case 404:
    $text = 'Not Found';
    break;
    case 405:
    $text = 'Method Not Allowed';
    break;
    case 406:
    $text = 'Not Acceptable';
    break;
    case 407:
    $text = 'Proxy Authentication Required';
    break;
    case 408:
    $text = 'Request Time-out';
    break;
    case 409:
    $text = 'Conflict';
    break;
    case 410:
    $text = 'Gone';
    break;
    case 411:
    $text = 'Length Required';
    break;
    case 412:
    $text = 'Precondition Failed';
    break;
    case 413:
    $text = 'Request Entity Too Large';
    break;
    case 414:
    $text = 'Request-URI Too Large';
    break;
    case 415:
    $text = 'Unsupported Media Type';
    break;
    case 500:
    $text = 'Internal Server Error';
    break;
    case 501:
    $text = 'Not Implemented';
    break;
    case 502:
    $text = 'Bad Gateway';
    break;
    case 503:
    $text = 'Service Unavailable';
    break;
    case 504:
    $text = 'Gateway Time-out';
    break;
    case 505:
    $text = 'HTTP Version not supported';
    break;
    default:
    $text = 'Not Found';
    $error = 404;
    }
    }
    header("HTTP/1.1 " . $error . " " . $text);
    header("Status: " . $error . " " . $text);
    session(['errorpage' => '1']);
    session(['errorcontentcode' => $error]);
    session(['errorcontent' => $text]);
    return $this->content($error);
    }
     */

    public function getIUploadError($check)
    {
        $check = trim($check);
        switch ($check) {
            case '0':
                $check = 'Es liegt kein Fehler vor, die Datei wurde erfolgreich hochgeladen.';
                break;
            case '1':
                $check = 'Die hochgeladene Datei &uuml;berschreitet die in der Anweisung upload_max_filesize in ';
                $check .= 'php.ini festgelegte Gr&ouml;sse: ' . MAXUPLOADSIZE;
                break;
            case '2':
                $check = 'Die hochgeladene Datei &uuml;berschreitet die in dem HTML Formular mittels der Anweisung ';
                $check .= 'MAX_FILE_SIZE angegebene maximale Dateigr&ouml;sse.';
                break;
            case '3':
                $check = 'Die Datei wurde nur teilweise hochgeladen.';
                break;
            case '4':
                $check = 'Es wurde keine Datei hochgeladen.';
                break;
            default:
                $check = 'Es liegt kein Fehler vor, die Datei wurde erfolgreich hochgeladen.';
        }

        return $check;
    }
}
