<?php

namespace App\Http\Traits;

trait FxToolsFilesTrait
{
    /***
     * @param array $dir
     * @param $file
     * @return array|string|string[]
     */
    public static function getStaticPublicFilePath($dir = [], $file)
    {
        $path = '';
        if (count($dir) > 0) {
            $path = DIRECTORY_SEPARATOR . join(DIRECTORY_SEPARATOR, $dir);
        }
        $path .= DIRECTORY_SEPARATOR . $file;
        $path = public_path() . $path;
        $path = str_replace(DIRECTORY_SEPARATOR . 'laravel' . DIRECTORY_SEPARATOR . 'public', DIRECTORY_SEPARATOR . 'htdocs', $path);
        return $path;
    }

    /**
     * Ab hier Dateibehandlung
     */
    public static function getStaticFilesize($URL)
    {
        $URL = trim($URL);
        if ($URL === '') {
            return '';
        }
        if (!is_file($URL)) {
            return '';
        }
        $size = filesize($URL);
        return self::FileSizeFormat($size);
    }

    private static function FileSizeFormat($size)
    {
        if ($size < 1000) {
            return number_format($size, 0, ",", ".") . " Bytes";
        } elseif ($size < 1000000) {
            return number_format($size / 1024, 0, ",", ".") . " kB";
        } else {
            return number_format($size / 1048576, 1, ",", ".") . " MB";
        }
    }

    public static function getStaticFileUploadMaxSize()
    {
        return self::FileSizeFormat(self::getMaximumFileUploadSize());
    }

    public static function check_file_delete($path, $file, $delete = 0)
    {
        if ($file === '' || $file === 'NULL' || $file === null) {
            return '';
        }

        $url = str_replace('/', DIRECTORY_SEPARATOR, $path);

        $url = public_path() . $url . $file;
        $url = str_replace('laravel' . DIRECTORY_SEPARATOR . 'public', 'htdocs', $url);
        if ($delete === 1) {
            unlink($url);
            return 'gelöscht';
        }
        return $path . $file;
    }

    /**
     * @param $filename
     * @return string
     */
    public static function getStaticfiletype($filename)
    {
        $filename = trim($filename);
        if ('' === $filename) {
            return '';
        }
        $result = explode('.', $filename);
        $endung = strtolower($result[(count($result) - 1)]);

        return $endung;
    }

    /**
     * @param string $filename
     * @return string
     */
    public function getFileType(string $filename):string
    {
        $filename = trim($filename);
        if ('' === $filename) {
            return '';
        }
        $result = explode('.', $filename);
        return strtolower($result[(count($result) - 1)]);
    }

    /**
     * @param $filetype
     * @return string
     */
    public static function fileicon($filename)
    {
        $filetype = FxToolsFilesTrait::getfiletype($filename);
        $filetype = trim($filetype);
        if ($filetype === '') {
            return '';
        }
        $filetype = strtolower($filetype);
        switch ($filetype) {
            /* Word + Texte */
            case 'doc':
            case 'txt':
            case 'dot':
                $image = 'word.png';
                $alt = 'Word-Dokument';
                break;
                /* Word 2007/2010 + Texte */
            case 'docx':
                $image = 'docx.png';
                $alt = 'Word 2007-Dokument';
                break;
                /* Webseiten */
            case 'htm':
            case 'html':
                $image = 'html.png';
                $alt = 'Online-Dokument';
                break;
                /* Musik + Audio Dateien */
            case 'wav':
            case 'mp3':
                $image = 'sound.png';
                $alt = 'Audio-Datei';
                break;
                /* Video */
            case 'avi':
            case 'asf':
            case 'mpg':
            case 'swf':
            case 'mpeg':
                $image = 'film.png';
                $alt = 'Film-Datei';
                break;
                /* PDF */
            case 'pdf':
                $image = 'pdf.png';
                $alt = 'PDF-Dokument';
                break;
                /* PowerPoint */
            case 'ppt':
            case 'pps':
            case 'ppz':
            case 'pcb':
            case 'pot':
            case 'pcs':
            case 'ppa':
            case 'ppi':
                $image = 'powerpoint.png';
                $alt = 'PowerPoint-Präsentation';
                break;
                /* PowerPoint 2007 */
            case 'pptx':
                $image = 'pptx.png';
                $alt = 'PowerPoint 2007 -Präsentation';
                break;
                /* Excel */
            case 'xls':
            case 'xlt':
                $image = 'excel.png';
                $alt = 'Excel-Dokument';
                break;
                /* Excel 2007 */
            case 'xlsx':
                $image = 'xlsx.png';
                $alt = 'Excel 2007 -Dokument';
                break;
                /* Komprimierte Dateien */
            case 'rar':
            case 'gzip':
            case 'tar':
            case 'zip':
            case 'gz':
            case 'z':
                $image = 'zip.png';
                $alt = 'Komprimierte-Datei';
                break;
                /* Bilder und Sonstige */
            default:
                $image = 'picture.png';
                $alt = 'Bild';
                break;
        }
        $file = '<img src="/grfx/' . $image . '" border="0" class="icon" title="' . $alt . '" alt="' . $alt . '">';
        return $file;
    }

    public static function makeFolderName($dateiname, $lower = 0)
    {
        $dateiname = trim($dateiname);
        if ($dateiname === '') {
            return '';
        }
        if ($lower === 1) {
            $dateiname = strtolower($dateiname);
        }
        $dateiname = str_replace("&shy;", "", $dateiname);
        $dateiname = str_replace(' ', '_', $dateiname);
        $dateiname = str_replace('.', '_', $dateiname);
        $dateiname = str_replace('&quot;', '_', $dateiname);
        $dateiname = str_replace('&apos;', '_', $dateiname);
        $dateiname = str_replace(",", '_', $dateiname);
        $dateiname = str_replace('?', '_', $dateiname);
        $dateiname = str_replace('!', '_', $dateiname);
        $dateiname = str_replace('#', '_', $dateiname);
        $dateiname = str_replace('?', '_', $dateiname);
        $dateiname = str_replace('$', '_', $dateiname);
        $dateiname = str_replace('%', '_', $dateiname);
        $dateiname = str_replace("&Auml;", "Ae", $dateiname);
        $dateiname = str_replace("&auml;", "ae", $dateiname);
        $dateiname = str_replace("&Ouml;", "Oe", $dateiname);
        $dateiname = str_replace("&ouml;", "oe", $dateiname);
        $dateiname = str_replace("&Uuml;", "Ue", $dateiname);
        $dateiname = str_replace("&uuml;", "ue", $dateiname);
        $dateiname = str_replace('&oacute;', 'o', $dateiname);
        $dateiname = str_replace('&Oacute;', 'O', $dateiname);
        $dateiname = str_replace("&szlig;", "ss", $dateiname);
        $dateiname = str_replace("&euro;", "Euro", $dateiname);
        $dateiname = str_replace('&eacute;', 'e', $dateiname);
        $dateiname = str_replace('&Eacute;', 'E', $dateiname);
        $dateiname = str_replace('&egrave;', 'e', $dateiname);
        $dateiname = str_replace('&Egrave;', 'E', $dateiname);
        $dateiname = str_replace('&bdquo;', '_', $dateiname);
        $dateiname = str_replace('&ldquo;', '_', $dateiname);
        $dateiname = str_replace("Ä", "Ae", $dateiname);
        $dateiname = str_replace("ä", "ae", $dateiname);
        $dateiname = str_replace("Ö", "Oe", $dateiname);
        $dateiname = str_replace("ö", "oe", $dateiname);
        $dateiname = str_replace("Ü", "Ue", $dateiname);
        $dateiname = str_replace("ü", "ue", $dateiname);
        $dateiname = str_replace("ß", "ss", $dateiname);
        $dateiname = str_replace("€", "Euro", $dateiname);
        $dateiname = str_replace('é', 'e', $dateiname); //?
        $dateiname = str_replace('È', 'E', $dateiname); //?
        $dateiname = str_replace('é', 'e', $dateiname); //?
        $dateiname = str_replace('É', 'E', $dateiname); //?
        $dateiname = str_replace('ò', 'o', $dateiname); //?
        $dateiname = str_replace('Ó', 'O', $dateiname); //?
        $dateiname = str_replace('"', "_", $dateiname);
        $dateiname = str_replace("'", "_", $dateiname);
        $dateiname = str_replace('?', '_', $dateiname);
        $dateiname = str_replace('?', '_', $dateiname);
        $dateiname = str_replace('?', '_', $dateiname);
        $dateiname = str_replace('ä', 'ae', $dateiname); //?
        $dateiname = str_replace('?', 'ae', $dateiname);
        $dateiname = str_replace('Ä', 'Ae', $dateiname); //?
        $dateiname = str_replace('?_', 'Ae', $dateiname); //?
        $dateiname = str_replace('ö', 'oe', $dateiname); //?
        $dateiname = str_replace('Ö', 'Oe', $dateiname); //?
        $dateiname = str_replace('?', 'Oe', $dateiname);
        $dateiname = str_replace('?', 'oe', $dateiname);
        $dateiname = str_replace('ü', 'ue', $dateiname); //?
        $dateiname = str_replace('Ü', 'Ue', $dateiname); //?
        $dateiname = str_replace('?', 'Ue', $dateiname); //?
        $dateiname = str_replace('?', 'ue', $dateiname);
        $dateiname = str_replace('?', 'ue', $dateiname);
        $dateiname = str_replace('ß', 'ss', $dateiname); //?
        $dateiname = str_replace('?', 'ss', $dateiname);
        $dateiname = str_replace('é', 'e', $dateiname); //?
        $dateiname = str_replace('è', 'E', $dateiname); //?
        $dateiname = str_replace('?', 'e', $dateiname);
        $dateiname = str_replace('É', 'e', $dateiname); //?
        $dateiname = str_replace('È', 'E', $dateiname); //?
        $dateiname = str_replace('?', 'e', $dateiname);
        $dateiname = str_replace('&amp;', 'und', $dateiname);
        $dateiname = str_replace('/', '_', $dateiname);
        $dateiname = str_replace('\'', '_', $dateiname);
        $dateiname = str_replace('*', '_', $dateiname);
        $dateiname = str_replace('+', '_', $dateiname);
        $dateiname = str_replace('|', '_', $dateiname);
        $dateiname = str_replace('>', '_', $dateiname);
        $dateiname = str_replace('<', '_', $dateiname);
        $dateiname = str_replace('?', '_', $dateiname);
        $dateiname = str_replace('^', '_', $dateiname);
        $dateiname = str_replace('?', '2', $dateiname);
        $dateiname = str_replace('?', '3', $dateiname);
        $dateiname = str_replace('{', '_', $dateiname);
        $dateiname = str_replace('}', '_', $dateiname);
        $dateiname = str_replace('[', '_', $dateiname);
        $dateiname = str_replace(']', '_', $dateiname);
        $dateiname = str_replace('(', '_', $dateiname);
        $dateiname = str_replace(')', '_', $dateiname);
        $dateiname = str_replace('?', '_', $dateiname);
        $dateiname = str_replace('`', '_', $dateiname);
        $dateiname = str_replace("'", '_', $dateiname);
        $dateiname = str_replace('~', '_', $dateiname);
        $dateiname = str_replace('@', '_', $dateiname);
        $dateiname = str_replace('?', '_', $dateiname);
        $dateiname = str_replace('=', '_', $dateiname);
        $dateiname = str_replace('&', '_', $dateiname);
        return $dateiname;
    }


    /**
     * Hole die passende Anwendung auf dem Client
     *
     * @param string $filetype
     * @return string
     */
    public static function getStaticFileHeaderType($filetype)
    {
        switch ($filetype) {
            case "669":
                $ctype = "audio/x-669";
                break;
            case "%":
                $ctype = "application/x-trash";
                break;
            case "*gf":
                $ctype = "application/x-tex-gf";
                break;
            case "~":
                $ctype = "application/x-trash";
                break;
            case "ai":
                $ctype = "application/postscript";
                break;
            case "aif":
                $ctype = "audio/x-aiff";
                break;
            case "aifc":
                $ctype = "audio/x-aiff";
                break;
            case "aiff":
                $ctype = "audio/x-aiff";
                break;
            case "arj":
                $ctype = "application/x-arj-compressed";
                break;
            case "asc":
                $ctype = "text/plain";
                break;
            case "asf":
                $ctype = "video/x-ms-asf";
                break;
            case "asx":
                $ctype = "video/x-ms-asf";
                break;
            case "au":
                $ctype = "audio/ulaw";
                break;
            case "avi":
                $ctype = "video/x-msvideo";
                break;
            case "bak":
                $ctype = "application/x-trash";
                break;
            case "bat":
                $ctype = "application/x-msdos-program";
                break;
            case "bcpio":
                $ctype = "application/x-bcpio";
                break;
            case "bin":
                $ctype = "application/octet-stream";
                break;
            case "bmp":
                $ctype = "image/x-ms-bmp";
                break;
            case "book":
                $ctype = "application/x-maker";
                break;
            case "bz2":
                $ctype = "application/x-bzip2";
                break;
            case "c":
                $ctype = "text/plain";
                break;
            case "cc":
                $ctype = "text/plain";
                break;
            case "ccad":
                $ctype = "application/clariscad";
                break;
            case "cdf":
                $ctype = "application/x-netcdf";
                break;
            case "cgi":
                $ctype = "application/x-httpd-cgi";
                break;
            case "class":
                $ctype = "application/x-java";
                break;
            case "cls":
                $ctype = "text/x-tex";
                break;
            case "com":
                $ctype = "application/x-msdos-program";
                break;
            case "cpio":
                $ctype = "application/x-cpio";
                break;
            case "cpt":
                $ctype = "application/mac-compactpro";
                break;
            case "csh":
                $ctype = "text/x-csh";
                break;
            case "csm":
                $ctype = "application/cu-seeme";
                break;
            case "csv":
                $ctype = "text/comma-separated-values";
                break;
            case "cu":
                $ctype = "application/cu-seeme";
                break;
            case "dat":
                $ctype = "application/xy";
                break;
            case "dcr":
                $ctype = "application/x-director";
                break;
            case "deb":
                $ctype = "application/x-debian-package";
                break;
            case "dir":
                $ctype = "application/x-director";
                break;
            case "dl":
                $ctype = "video/dl";
                break;
            case "doc":
                $ctype = "application/msword";
                break;
            case "dot":
                $ctype = "application/msword";
                break;
            case "drw":
                $ctype = "application/drw";
                break;
            case "dvi":
                $ctype = "application/x-dvi";
                break;
            case "dvi.gz":
                $ctype = "application/x-gzip-dvi";
                break;
            case "dwg":
                $ctype = "application/acad";
                break;
            case "dxf":
                $ctype = "application/dxf";
                break;
            case "dxr":
                $ctype = "application/x-director";
                break;
            case "eps":
                $ctype = "application/postscript";
                break;
            case "etx":
                $ctype = "text/x-setext";
                break;
            case "exe":
                $ctype = "application/x-msdos-program";
                break;
            case "ez":
                $ctype = "application/andrew-inset";
                break;
            case "f90":
                $ctype = "text/plain";
                break;
            case "fb":
                $ctype = "application/x-maker";
                break;
            case "fbdoc":
                $ctype = "application/x-maker";
                break;
            case "fig":
                $ctype = "application/x-xfig";
                break;
            case "fit":
                $ctype = "image/x-fits";
                break;
            case "fits":
                $ctype = "image/x-fits";
                break;
            case "flc":
                $ctype = "video/x-flc";
                break;
            case "fli":
                $ctype = "video/fli";
                break;
            case "flv":
                $ctype = "video/flv";
                break;
            case "fm":
                $ctype = "application/x-maker";
                break;
            case "frame":
                $ctype = "application/x-maker";
                break;
            case "frm":
                $ctype = "application/x-maker";
                break;
            case "fts":
                $ctype = "image/x-fits";
                break;
            case "g3":
                $ctype = "image/x-fax-g3";
                break;
            case "gif":
                $ctype = "image/gif";
                break;
            case "gl":
                $ctype = "video/gl";
                break;
            case "gsf":
                $ctype = "application/x-font";
                break;
            case "gtar":
                $ctype = "application/x-gtar";
                break;
            case "gz":
                $ctype = "application/x-gzip";
                break;
            case "h":
                $ctype = "text/plain";
                break;
            case "hdf":
                $ctype = "application/x-hdf";
                break;
            case "hh":
                $ctype = "text/plain";
                break;
            case "hqx":
                $ctype = "application/mac-binhex40";
                break;
            case "htm":
                $ctype = "text/html";
                break;
            case "html":
                $ctype = "text/html";
                break;
            case "html.gz":
                $ctype = "text/x-gzip-html";
                break;
            case "html.Z":
                $ctype = "text/x-compress-html";
                break;
            case "ice":
                $ctype = "x-conference/x-cooltalk";
                break;
            case "ief":
                $ctype = "image/ief";
                break;
            case "iges":
                $ctype = "application/iges";
                break;
            case "igs":
                $ctype = "application/iges";
                break;
            case "java":
                $ctype = "text/x-java";
                break;
            case "jpe":
                $ctype = "image/jpeg";
                break;
            case "jpeg":
                $ctype = "image/jpeg";
                break;
            case "jpg":
                $ctype = "image/jpeg";
                break;
            case "ltx":
                $ctype = "text/x-tex";
                break;
            case "m3u":
                $ctype = "audio/mpegurl";
                break;
            case "maker":
                $ctype = "application/x-maker";
                break;
            case "man":
                $ctype = "application/x-troff-man";
                break;
            case "me":
                $ctype = "application/x-troff-me";
                break;
            case "mesh":
                $ctype = "model/mesh";
                break;
            case "mid":
                $ctype = "audio/midi";
                break;
            case "midi":
                $ctype = "audio/midi";
                break;
            case "mif":
                $ctype = "application/x-mif";
                break;
            case "moc":
                $ctype = "text/x-moc";
                break;
            case "mod":
                $ctype = "audio/x-mod";
                break;
            case "mov":
                $ctype = "video/quicktime";
                break;
            case "movie":
                $ctype = "video/x-sgi-movie";
                break;
            case "mp2":
                $ctype = "audio/mpeg";
                break;
            case "mp3":
                $ctype = "audio/mpeg";
                break;
            case "mpe":
                $ctype = "video/mpeg";
                break;
            case "mpeg":
                $ctype = "video/mpeg";
                break;
            case "mpega":
                $ctype = "audio/mpeg";
                break;
            case "mpg":
                $ctype = "video/mpeg";
                break;
            case "mpga":
                $ctype = "audio/mpeg";
                break;
            case "ms":
                $ctype = "application/x-troff-ms";
                break;
            case "msh":
                $ctype = "model/mesh";
                break;
            case "mtm":
                $ctype = "audio/x-mtm";
                break;
            case "nc":
                $ctype = "application/x-netcdf";
                break;
            case "o":
                $ctype = "application/x-object";
                break;
            case "oda":
                $ctype = "application/oda";
                break;
            case "old":
                $ctype = "application/x-trash";
                break;
            case "p":
                $ctype = "text/x-pascal";
                break;
            case "pac":
                $ctype = "application/x-ns-proxy-autoconfig";
                break;
            case "pas":
                $ctype = "text/x-pascal";
                break;
            case "pbm":
                $ctype = "image/x-portable-bitmap";
                break;
            case "pcf":
                $ctype = "application/x-font";
                break;
            case "pcf.Z":
                $ctype = "application/x-font";
                break;
            case "pdb":
                $ctype = "chemical/x-pdb";
                break;
            case "pdf":
                $ctype = "application/pdf";
                break;
            case "perl":
                $ctype = "application/x-perl";
                break;
            case "pfa":
                $ctype = "application/x-font";
                break;
            case "pfb":
                $ctype = "application/x-font";
                break;
            case "pgm":
                $ctype = "image/x-portable-graymap";
                break;
            case "pgn":
                $ctype = "application/x-chess-pgn";
                break;
            case "pgp":
                $ctype = "application/pgp";
                break;
            case "php":
                $ctype = "application/x-httpd-php";
                break;
            case "php3":
                $ctype = "application/x-httpd-php3";
                break;
            case "php3p":
                $ctype = "application/x-httpd-php3-preprocessed";
                break;
            case "phps":
                $ctype = "application/x-httpd-php3-source";
                break;
            case "pht":
                $ctype = "application/x-httpd-php";
                break;
            case "phtml":
                $ctype = "application/x-httpd-php";
                break;
            case "pk":
                $ctype = "application/x-tex-pk";
                break;
            case "pl":
                $ctype = "application/x-perl";
                break;
            case "pm":
                $ctype = "application/x-perl";
                break;
            case "png":
                $ctype = "image/png";
                break;
            case "pnm":
                $ctype = "image/x-portable-anymap";
                break;
            case "ppm":
                $ctype = "image/x-portable-pixmap";
                break;
            case "ppt":
                $ctype = "application/powerpoint";
                break;
            case "prt":
                $ctype = "application/pro_eng";
                break;
            case "ps":
                $ctype = "application/postscript";
                break;
            case "ps.gz":
                $ctype = "application/x-gzip-postscript";
                break;
            case "qt":
                $ctype = "video/quicktime";
                break;
            case "ra":
                $ctype = "audio/x-pn-realaudio";
                break;
            case "ram":
                $ctype = "audio/x-pn-realaudio";
                break;
            case "rar":
                $ctype = "application/x-rar-compressed";
                break;
            case "ras":
                $ctype = "image/x-cmu-raster";
                break;
            case "rgb":
                $ctype = "image/x-rgb";
                break;
            case "rm":
                $ctype = "audio/x-pn-realaudio";
                break;
            case "roff":
                $ctype = "application/x-troff";
                break;
            case "rpm":
                $ctype = "audio/x-pn-realaudio-plugin";
                break;
            case "rtf":
                $ctype = "application/rtf";
                break;
            case "rtx":
                $ctype = "text/richtext";
                break;
            case "s3m":
                $ctype = "audio/x-s3m";
                break;
            case "sda":
                $ctype = "application/vnd.stardivision.draw";
                break;
            case "sdc":
                $ctype = "application/vnd.stardivision.calc";
                break;
            case "sdd":
                $ctype = "application/vnd.stardivision.impress";
                break;
            case "sdp":
                $ctype = "application/vnd.stardivision.impress";
                break;
            case "sdw":
                $ctype = "application/vnd.stardivision.writer";
                break;
            case "set":
                $ctype = "application/set";
                break;
            case "sgl":
                $ctype = "application/vnd.stardivision.writer-global";
                break;
            case "sgm":
                $ctype = "text/x-sgml";
                break;
            case "sgml":
                $ctype = "text/x-sgml";
                break;
            case "sh":
                $ctype = "text/x-sh";
                break;
            case "shar":
                $ctype = "application/x-shar";
                break;
            case "sik":
                $ctype = "application/x-trash";
                break;
            case "silo":
                $ctype = "model/mesh";
                break;
            case "sit":
                $ctype = "application/x-stuffit";
                break;
            case "skd":
                $ctype = "application/x-koan";
                break;
            case "skm":
                $ctype = "application/x-koan";
                break;
            case "skp":
                $ctype = "application/x-koan";
                break;
            case "skt":
                $ctype = "application/x-koan";
                break;
            case "smf":
                $ctype = "application/vnd.stardivision.math";
                break;
            case "snd":
                $ctype = "audio/basic";
                break;
            case "sol":
                $ctype = "application/solids";
                break;
            case "src":
                $ctype = "application/x-wais-source";
                break;
            case "stc":
                $ctype = "application/vnd.sun.xml.calc.template";
                break;
            case "std":
                $ctype = "application/vnd.sun.xml.draw.template";
                break;
            case "step":
                $ctype = "application/STEP";
                break;
            case "sti":
                $ctype = "application/vnd.sun.xml.impress.template";
                break;
            case "stl":
                $ctype = "appliaction/sla";
                break;
            case "stp":
                $ctype = "application/STEP";
                break;
            case "stw":
                $ctype = "application/vnd.sun.xml.writer.template";
                break;
            case "sty":
                $ctype = "text/x-tex";
                break;
            case "sv4cpio":
                $ctype = "application/x-sv4cpio";
                break;
            case "sv4crc":
                $ctype = "application/x-sv4crc";
                break;
            case "swf":
                $ctype = "application/x-shockwave-flash";
                break;
            case "swfl":
                $ctype = "application/x-shockwave-flash";
                break;
            case "sxc":
                $ctype = "application/vnd.sun.xml.calc";
                break;
            case "sxd":
                $ctype = "application/vnd.sun.xml.draw";
                break;
            case "sxg":
                $ctype = "application/vnd.sun.xml.writer.global";
                break;
            case "sxi":
                $ctype = "application/vnd.sun.xml.impress";
                break;
            case "sxw":
                $ctype = "application/vnd.sun.xml.writer";
                break;
            case "t":
                $ctype = "application/x-troff";
                break;
            case "tar":
                $ctype = "application/x-tar";
                break;
            case "tar.gz":
                $ctype = "application/x-tar-gz";
                break;
            case "tcl":
                $ctype = "text/x-tcl";
                break;
            case "tex":
                $ctype = "text/x-tex";
                break;
            case "texi":
                $ctype = "application/x-texinfo";
                break;
            case "texinfo":
                $ctype = "application/x-texinfo";
                break;
            case "tgz":
                $ctype = "application/x-tar-gz";
                break;
            case "tif":
                $ctype = "image/tiff";
                break;
            case "tiff":
                $ctype = "image/tiff";
                break;
            case "tk":
                $ctype = "text/x-tcl";
                break;
            case "tr":
                $ctype = "application/x-troff";
                break;
            case "tsp":
                $ctype = "application/dsptype";
                break;
            case "tsv":
                $ctype = "text/tab-separated-values";
                break;
            case "txt":
                $ctype = "text/plain";
                break;
            case "ustar":
                $ctype = "application/x-ustar";
                break;
            case "vcd":
                $ctype = "application/x-cdlink";
                break;
            case "vcf":
                $ctype = "text/x-vCard";
                break;
            case "vcs":
                $ctype = "text/x-vCalendar";
                break;
            case "vda":
                $ctype = "application/vda";
                break;
            case "voc":
                $ctype = "audio/x-voc";
                break;
            case "vor":
                $ctype = "application/vnd.stardivision.writer";
                break;
            case "vrm":
                $ctype = "x-world/x-vrml";
                break;
            case "vrml":
                $ctype = "x-world/x-vrml";
                break;
            case "wav":
                $ctype = "audio/x-wav";
                break;
            case "wk":
                $ctype = "application/x-123";
                break;
            case "wp5":
                $ctype = "application/wordperfect5.1";
                break;
            case "wrl":
                $ctype = "x-world/x-vrml";
                break;
            case "wz":
                $ctype = "application/x-Wingz";
                break;
            case "xbm":
                $ctype = "image/x-xbitmap";
                break;
            case "xls":
                $ctype = "application/excel";
                break;
            case "xm":
                $ctype = "audio/x-xm";
                break;
            case "xpm":
                $ctype = "image/x-xpixmap";
                break;
            case "xwd":
                $ctype = "image/x-xwindowdump";
                break;
            case "xyz":
                $ctype = "chemical/x-pdb";
                break;
            case "z":
                $ctype = "application/x-compress";
                break;
            case "zip":
                $ctype = "application/zip";
                break;
            default:
                $ctype = "application/force-download";
        }
        return $ctype;
    }

    // Returns a file size limit in bytes based on the PHP upload_max_filesize
    // and post_max_size
    public static function file_upload_max_size()
    {
        static $max_size = -1;

        if ($max_size < 0) {
            // Start with post_max_size.
            $post_max_size = self::parse_size(ini_get('post_max_size'));
            if ($post_max_size > 0) {
                $max_size = $post_max_size;
            }

            // If upload_max_size is less, then reduce. Except if upload_max_size is
            // zero, which indicates no limit.
            $upload_max = self::parse_size(ini_get('upload_max_filesize'));
            if ($upload_max > 0 && $upload_max < $max_size) {
                $max_size = $upload_max;
            }
        }
        return $max_size;
    }

    public static function parse_size($size)
    {
        $unit = preg_replace('/[^bkmgtpezy]/i', '', $size); // Remove the non-unit characters from the size.
        $size = preg_replace('/[^0-9\.]/', '', $size); // Remove the non-numeric characters from the size.
        if ($unit) {
            // Find the position of the unit in the ordered string which is the power of magnitude to multiply a kilobyte by.
            return round($size * pow(1024, stripos('bkmgtpezy', $unit[0])));
        } else {
            return round($size);
        }
    }

    /**
     * This function returns the maximum files size that can be uploaded
     * in PHP
     * @returns int File size in bytes
     **/
    public static function getStaticMaximumFileUploadSize()
    {
        return min(self::convertPHPSizeToBytes(ini_get('post_max_size')), self::convertPHPSizeToBytes(ini_get('upload_max_filesize')));
    }

    /**
     * This function transforms the php.ini notation for numbers (like '2M') to an integer (2*1024*1024 in this case)
     *
     * @param string $sSize
     * @return integer The value in bytes
     */
    public static function convertPHPSizeToBytes($sSize)
    {
        //
        $sSuffix = strtoupper(substr($sSize, -1));
        if (!in_array($sSuffix, array('P', 'T', 'G', 'M', 'K'))) {
            return (int)$sSize;
        }
        $iValue = substr($sSize, 0, -1);
        switch ($sSuffix) {
            case 'P':
                $iValue *= 1024;
                // Fallthrough intended
                // no break
            case 'T':
                $iValue *= 1024;
                // Fallthrough intended
                // no break
            case 'G':
                $iValue *= 1024;
                // Fallthrough intended
                // no break
            case 'M':
                $iValue *= 1024;
                // Fallthrough intended
                // no break
            case 'K':
                $iValue *= 1024;
                break;
        }
        return (int)$iValue;
    }
}
