<?php

namespace App\Http\Traits;

trait FxToolsUrlTrait
{
    /**
    *   Check URL.
    */
    public function checkLink($url)
    {
        $url = trim($url);
        if (! isset($url)) {
            return false;
        }
        $url = trim($url);
        if (preg_match('=://=', $url)) {
            $url = substr($url, 7);
        }
        $fp = fsockopen($url, 80, $errno, $errstr, 10);
        if (! $fp) {
            echo "Errorcode: $errstr ($errno)<br>\n";
        } else {
            socket_set_blocking($fp, 0);
            socket_set_timeout($fp, 3);
            fputs($fp, "GET / HTTP/1.1\r\nHost: $url\r\n\r\n");
            while (! feof($fp)) {
                $x = fgets($fp, 128);
                if (preg_match('/HTTP/', $x)) {
                    if (preg_match('/200/', $x)) {
                        echo "Aktiv -- $url<br>";
                    } elseif (preg_match('/404/', $x)) {
                        echo "nicht verfügbar -- $url<br>";
                    } elseif (preg_match('/500/', $x)) {
                        echo "nicht verfügbar -- $url<br>";
                    } else {
                        echo "Status nicht festellbar -- $url -- $x<br>";
                    }
                    break;
                }
            }
            fclose($fp);
        }
    }

    /**
    *   Teststring behandelt mit nl2br() könnte auch noch einfach in die Funktion eingebaut werden ;).
    *
    *   $string = nl2br("www.cläudio.ch/verzeichniss/datei.inc.php
    *   <a href=\"http://www.dagobert_duck.ch\">Link</a>
    *   Der Folgende Link wird nicht ersetzt, da die Dateiendung \".datei\" nicht unterstützt wird =)
    *   http://www.domain.de/index.datei
    *   ftp://ftp.chbla.ch/
    *
    *   www.domain-hier.de
    *   www.domäin.ch
    *   www.ftp.domain.ch
    *
    *   Die Folgende Mail-Adresse wird nicht ersetzt, da die Domainendung \".ist\" nicht unterstützt wird =)
    *   dagobert_duck@domain.ist
    *   ftp.www.domain.ch
    *   ftp://www.domain.ch/dir/dir_again/this_file.php
    *   ftp.www.microsoft.com/scripting/default.htm?=&/scripting/vbscript/download/vbsdown.htm
    *   https://https.domain.de
    *   FTPS://THIS.DOMAIN.DE
    *   FTP://www.domain.de/das_dir/dieDatiei.php
    *   dagobert_duck@domain.de
    *   www.domain.de/verzeichniss_1/index.php?film=dieseDatei.swf");
    *
    *   //Funktion aufrufen und ausgeben ;)
    *   echo replace_url($string);
    */
    public function makeLink($string, $target)
    {
        $string = trim($string);
        $target = trim($target);
        //Alle Toplevel Domainendungen
        $tld_endings = 'com|net|org|biz|info|edu|eu|aero|coop|museum|al|as|vi|ai|ag|ar|am|';
        $tld_endings .= 'aw|ac|az|et|au|bh|by|be|bz|bj|ba|br|vg|io|bg|cl|cn|cc|dk|de|dj|ec|';
        $tld_endings .= 'ee|fo|fi|fr|tf|li|gm|gi|gr|gl|uk|gg|gy|hm|hk|in|id|ie|im|il|it|jp|';
        $tld_endings .= 'je|ca|kz|ke|ki|cg|hr|lv|lt|lu|mw|my|mt|mx|fm|md|mc|mn|ms|nz|ni|nl|';
        $tld_endings .= 'an|nu|nf|no|at|pk|pa|pe|ph|pn|pl|pt|pr|ro|ru|su|ch|yu|sc|sg|sk|si|';
        $tld_endings .= 'es|kn|sh|sf|za|gs|kr|sr|tw|tz|th|tk|to|tt|cz|tr|tm|tc|tv|ua|hu|uy|';
        $tld_endings .= 'us|uz|vu|ve|ae|vn|ws|cy';
        //alle erlaubten Dateiendungen
        $file_endings = 'php|htm|html|xml|xhtml|jpg|jpeg|gif|png|pdf|asp|js|swf';
        //alle Umlaute
        $umlaute = 'àáâãäåæçèéêëìíîïðñòóôöøùúûüýþÿ';

        //Die Ausdrücke um www.... oder Strings mit einem @ usw in Links ersetzt
        //Die zu erläutern vermag ich im Moment nicht, vielleicht folgt mal ein Tutorial dazu ;)
        $patterns['mail'] = "#(^|[^\"=\./a-z0-9]{1})([_a-z0-9-\." . $umlaute . ']+)' .
            "(\@)([a-z0-9_\-\." . $umlaute . "]+)(\.)(" . $tld_endings .
            ")(/)*([\s\r\t\n<>]|$)#msi";
        $replaces['mail'] = '\\1<a target="new" href="mailto:\\2\\3\\4\\5\\6\\7">' .
            '\\2\\3\\4\\5\\6\\7</a>\\8';

        $patterns['url'] = "#(^|[^\"=\./a-z0-9]{1})(http://|ftp://|news://|https://|ftps://)" .
            "([a-z0-9_\-\." . $umlaute . "]+)(\.)(" . $tld_endings . ')' .
            "(/([a-z0-9_\-/" . $umlaute . "]+)*)*([a-z0-9\._-]+\.(" .
            $file_endings . ")([^\s\n\r\t\(\)\[\]\{\}<>]+)*)*([\s\r\t\n<>]|$)#msi";
        $replaces['url'] = '\\1<a target="new" href="\\2\\3\\4\\5\\6\\8">' .
            '\\2\\3\\4\\5\\6\\8</a>\\11';

        $patterns['ftp'] = "#(^|[^\"=\./a-z0-9]{1})(ftp\.)([a-z0-9_\-\." . $umlaute .
            "]+)(\.)(" . $tld_endings . ")(/([a-z0-9_\-/" . $umlaute .
            "]+)*)*([a-z0-9\._-]+\.(" . $file_endings .
            ")([^\s\n\r\t\(\)\[\]\{\}<>]+)*)*([\s\r\t\n<>]|$)#msi";
        $replaces['ftp'] = '\\1<a target="new" href="ftp://\\2\\3\\4\\5\\6\\8">' .
            '\\2\\3\\4\\5\\6\\8</a>\\11';

        $patterns['www'] = "#(^|[^\"=\./a-z0-9]{1})(www\.)([a-z0-9_\-\." . $umlaute .
            "]+)(\.)(" . $tld_endings . ")(/([a-z0-9_\-/" . $umlaute .
            "]+)*)*([a-z0-9\._-]+\.(" . $file_endings .
            ")([^\s\n\r\t\(\)\[\]\{\}<>]+)*)*([\s\r\t\n<>]|$)#msi";
        $replaces['www'] = '\\1<a target="new" href="http://\\2\\3\\4\\5\\6\\8">' .
            '\\2\\3\\4\\5\\6\\8</a>\\11';
        //Den String ersetzen...
        $string = preg_replace($patterns, $replaces, $string);
        //...und zurückgeben.
        return $string;
    }
}
