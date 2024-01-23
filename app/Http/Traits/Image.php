<?php

namespace App\Http\Traits;

use App\Http\Controllers\TinyPngController;
use enshrined\svgSanitize\Sanitizer;

/*
 * Klasse zum Bearbeiten von Bildern
 * @version 1.0
 * @author Jörg-Marten Hoffmann
 * @copyright Jörg-Marten Hoffmann 2010
 *
 * Änderungen
 * 2011-11-17	Alle Image.php zusammengefasst
 * 2010-12-16	makeImageResize um eine Abfrage erweitert -> If Image breite/höhe = 0
 * 2010-11-02   Funktion checkSize eingebaut,
um den PHP Buffer zu schonen wenn die Bilder zu groß sind!
 *
 */

trait Image
{
    public $converted_files = [];
    private $filehash = '';

    public static function svg($content)
    {
        // Create a new sanitizer instance
        $sanitizer = new Sanitizer();
        $sanitizer->removeRemoteReferences(true);
        $sanitizer->minify(true);
        // Pass it to the sanitizer and get it back clean
        return $sanitizer->sanitize($content);
    }

    public static function makeImgLazy(
        $noretina,
        $retina = '',
        $class = '',
        $alt = '',
        $title = ''
    ) {
        $arr = [];
        $arr[] = 'src="data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///yH5BAEAAAAALAAAAAABAAEAAAIBRAA7"';
        $arr[] = 'data-src="' . $noretina . '"';
        if ('' !== $retina) {
            $arr[] = 'data-src-retina="' . $retina . '"';
        }
        $arr[] = 'alt="' . $alt . '"';
        $arr[] = 'title="' . $title . '"';
        if ('' !== $class) {
            $class = ' ' . $class;
        }
        $lazy_img = '<img ' . join(
            ' ',
            $arr
        ) . ' class="lazy' . $class . '" />';
        $lazy_img .= '<noscript>';
        $lazy_img .= '<img src="' . $noretina . '" />';
        $lazy_img .= '</noscript>';

        return $lazy_img;
    }

    public static function getStaticImagecheckSize($file)
    {
        $arrImgCheck = getimagesize($file);

        $dpi = 0;
        if ('2' === $arrImgCheck['2']) {
            $dpi = Image::dpi_jpg_auslesen($file);
            if (!is_numeric($dpi)) {
                $dpi = 0;
            }
        }

        $maxwidth = 3000;
        if (
            (
                strlen($arrImgCheck['0']) && $arrImgCheck['0'] > $maxwidth
            )
            || (strlen($arrImgCheck['1']) && $arrImgCheck['1'] > $maxwidth)
        ) {
            if (is_file($file)) {
                unlink($file);
            }
            if ((strlen($arrImgCheck['1']) && $arrImgCheck['1'] > $maxwidth)) {
                $fehler = 'hoch';
            }
            if (strlen($arrImgCheck['0']) && $arrImgCheck['0'] > $maxwidth) {
                $fehler = 'breit';
            }
            $errortext = '<p class="fehler">Das Bild ist zu ' . $fehler;
            $errortext .= ',
bitte die Bildgr&ouml;sse verkleinern!</p>';
            $errortext .= '<p class="fehler">Das Bild hat folgende Gr&ouml;sse: ';
            $errortext .= $arrImgCheck['0'] . 'x' . $arrImgCheck['1'] . ' Pixel</p>';
            $errortext .= '<p class="fehler">Es darf maximal ' . $maxwidth . 'x' . $maxwidth . ' Pixel haben</p>';
            echo $errortext;
            return false;
        }
        return true;
    }

    /**
     * @param $datei
     * @return mixed
     */
    private static function dpi_jpg_auslesen($datei)
    {
        $fh = fopen($datei, 'r');
        $header = fread($fh, 16);
        fclose($fh);
        $aufloesung = unpack('x14/ndpi', $header);
        return $aufloesung['dpi'];
    }

    public static function getStaticImageDpiJpgAuslesen($datei)
    {
        $fh = fopen(
            $datei,
            'r'
        );
        $header = fread(
            $fh,
            16
        );
        fclose($fh);
        $aufloesung = unpack(
            'x14/ndpi',
            $header
        );

        return $aufloesung['dpi'];
    }

    public static function makePdfToImage(
        $file,
        $width = 585,
        $height = 3000
    ) {
        $grafik = str_replace(
            '.pdf',
            '.jpg',
            $file
        );
        $temp = storage_path('/images/') . rand(
            0,
            999999999999999999999999999999999999
        ) . '.png';
        $convert = 'convert -profile ' . LIBpublic_path('/fileadmin/fahrzeuge/cache/');
        $convert .= 'icc/cmyk/USWebCoatedSWOP.icc -profile ' . LIBpublic_path('/fileadmin/fahrzeuge/cache/');
        $convert .= 'icc/rgb/AppleRGB.icc -density 72x72 ' . $file . '[0] ' . $temp;
        SystemTools::Console($convert);
        $convert = 'convert -density 72x72 ' . $temp . ' ' . $grafik;
        ToolsTrait::Console($convert);
        if (is_file($temp)) {
            unlink($temp);
        }
        if (is_file($grafik)) {
            SystemTools::makeResizeImage(
                $grafik,
                $width,
                $height
            );
            chmod(
                $grafik,
                0644
            );
        }
    }

    public static function makeImageResize(
        $bild,
        $path,
        $img_width = 400,
        $img_height = 400,
        $wasserzeichen = 0
    ) {
        $filename = $bild;
        $bild = storage_path('/images/') . $bild;
        if (false === Image::checkSize($bild)) {
            return '';
        }
        $types = ['jpg',
            'jpeg',
            'gif',
            'png'];
        list($src_width,
            $src_height,
            $type) = getimagesize($bild);

        $ext = strtolower(substr(
            $filename,
            strpos(
                $filename,
                '.'
            ) + 1,
            strlen($filename)
        ));
        $image_aspectratio = $src_width / $src_height;

        if (
            !in_array(
                $ext,
                $types
            )
        ) {
            if (is_file($bild)) {
                unlink($bild);
            }
            $errortext = "<p class='fehler'>Bildformat '" . $ext . "' wird nicht unterst&uuml;tzt!</p>";
            $errortext .= "<p class='fehler'>Bitte nur folgende Formate '" . strtoupper(join(
                ',
',
                $types
            ));
            $errortext .= "' verwenden!</p>";
            echo $errortext;

            return 'NULL';
        }
        if (0 === $src_width) {
            if (is_file($bild)) {
                unlink($bild);
            }
            $errortext = "<p class='fehler'>Die Breite des Bildes betr&auml;gt nur 0 Pixel!</p>";
            $errortext .= "<p class='fehler'>Bild kontrollieren!</p>";
            echo $errortext;
            return 'NULL';
        }
        if (0 === $src_height) {
            if (is_file($bild)) {
                unlink($bild);
            }
            echo "<p class='fehler'>Die H&ouml;he des Bildes betr&auml;gt nur 0 Pixel!</p>";
            echo "<p class='fehler'>Bild kontrollieren!</p>";

            return 'NULL';
        }
        if ($src_width >= $src_height) {
            if ($src_width <= $img_width) {
                $img_width = $src_width;
            }
            $new_image_width = $img_width;
            $new_image_height = $src_height * $img_width / $src_width;
        }
        if ($src_width === $src_height) {
            $new_image_width = $img_width;
            $new_image_height = $img_height;
        }
        if ($src_height > $src_width) {
            if ($src_height >= $img_height) {
                $new_image_height = $img_height;
                $new_image_width = round($img_height * $image_aspectratio);
            } else {
                $new_image_height = $img_height;
                $new_image_width = ceil($src_width * $src_height / $src_height);
            }
        }
        if ($src_width < $src_height) {
            $new_image_height = $img_height;
            $new_image_width = round($img_height * $image_aspectratio);
        }
        if ($src_width <= $img_width && $src_height <= $img_height) {
            $new_image_width = $src_width;
            $new_image_height = $src_height;
        }

        $winkel = 0;
        $size = 8;
        $schriftfarbe_rot = 255;
        $schriftfarbe_blau = 255;
        $schriftfarbe_gruen = 255;
        $schriftart = CMS_FONT_public_path('/fileadmin/fahrzeuge/cache/') . 'ariblk.ttf';

        $im = imagecreatetruecolor(
            $new_image_width,
            $new_image_height
        );

        if (1 === $type) {
            $src = imagecreatefromgif($bild);
            if (is_file($bild)) {
                unlink($bild);
            }
            imagealphablending(
                $im,
                true
            );
            imagefilledrectangle(
                $im,
                0,
                0,
                $new_image_width,
                $new_image_height,
                imagecolorallocate(
                    $im,
                    255,
                    255,
                    255
                )
            );
            imagecopyresampled(
                $im,
                $src,
                0,
                0,
                0,
                0,
                $new_image_width,
                $new_image_height,
                $src_width,
                $src_height
            );

            if (1 === $wasserzeichen) {
                $text_color = imagecolorallocate(
                    $im,
                    255,
                    255,
                    255
                );
                $size = 10;
                $winkel = 0;
                $x = 10;
                $y = $new_image_height - 10;
                imagettftext(
                    $im,
                    $size,
                    $winkel,
                    $x,
                    $y,
                    $text_color,
                    CMS_FONT_public_path('/fahrzeuge/cache/') . '/ariblk.ttf',
                    WASSERZEICHEN
                );
            }
            $bild = public_path('/fileadmin/fahrzeuge/cache/') . '/' . $path . '/' . $filename;
            $bild = str_replace(
                '//',
                '/',
                $bild
            );
            imagegif(
                $im,
                $bild,
                100
            ); // imagepng = Wegen Lizenzproblemen bei PHP
            chmod(
                $bild,
                FILE_RIGHT
            );
            imagedestroy($im);

            return $filename;
        } elseif (2 === $type) {
            $src = imagecreatefromjpeg($bild);
            if (is_file($bild)) {
                unlink($bild);
            }
            imagecopyresampled(
                $im,
                $src,
                0,
                0,
                0,
                0,
                $new_image_width,
                $new_image_height,
                $src_width,
                $src_height
            );
            if (1 === $wasserzeichen) {
                $text_color = imagecolorallocate(
                    $im,
                    255,
                    255,
                    255
                );
                $size = 10;
                $winkel = 0;
                $x = 10;
                $y = $new_image_height - 10;
                imagettftext(
                    $im,
                    $size,
                    $winkel,
                    $x,
                    $y,
                    $text_color,
                    CMS_FONT_public_path('/fahrzeuge/cache/') . '/ariblk.ttf',
                    WASSERZEICHEN
                );
            }
            $bild = public_path('/fileadmin/fahrzeuge/cache/') . '/' . $path . '/' . $filename;
            $bild = str_replace(
                '//',
                '/',
                $bild
            );
            imagejpeg(
                $im,
                $bild,
                100
            );
            chmod(
                $bild,
                FILE_RIGHT
            );
            imagedestroy($im);

            return $filename;
        } elseif (3 === $type) {
            $src = imagecreatefrompng($bild);
            if (is_file($bild)) {
                unlink($bild);
            }
            imagealphablending(
                $im,
                true
            );
            imagefilledrectangle(
                $im,
                0,
                0,
                $new_image_width,
                $new_image_height,
                imagecolorallocate(
                    $im,
                    255,
                    255,
                    255
                )
            );
            imagecopyresampled(
                $im,
                $src,
                0,
                0,
                0,
                0,
                $new_image_width,
                $new_image_height,
                $src_width,
                $src_height
            );
            if (1 === $wasserzeichen) {
                $text_color = imagecolorallocate(
                    $im,
                    255,
                    255,
                    255
                );
                $size = 10;
                $winkel = 0;
                $x = 10;
                $y = $new_image_height - 10;
                imagettftext(
                    $im,
                    $size,
                    $winkel,
                    $x,
                    $y,
                    $text_color,
                    CMS_FONT_public_path('/fahrzeuge/cache/') . '/ariblk.ttf',
                    WASSERZEICHEN
                );
            }
            $bild = public_path('/fileadmin/fahrzeuge/cache/') . '/' . $path . '/' . $filename;
            $bild = str_replace(
                '//',
                '/',
                $bild
            );
            $quality = 100;
            if (phpversion() >= 5.1) {
                $quality = 9 - (int)(9 / 100 * $quality);
            }
            imagepng(
                $im,
                $bild,
                $quality
            );
            chmod(
                $bild,
                FILE_RIGHT
            );
            imagedestroy($im);

            return $filename;
        } else {
            echo "<p class='fehler'>Dieses Format wird nicht unterst&uuml;zt!</p>";

            return '';
        }
    }

    /**
     * -1: $image_dimension wird als neue Breite des Bildes aufgefasst; die Höhe wird so angepasst,
     * dass das Seitenverhältnis des Bildes erhalten bleibt. Ideal,
     * wenn das Bild in eine Spalte mit fester Breite eingefügt werden soll.
     * -2: $image_dimension wird als neue Höhe des Bildes aufgefasst; die Breite wird so angepasst,
     * dass das Seitenverhältnis des Bildes erhalten bleibt. Ideal,
     * wenn das Bild in eine Zeile mit fester Höhe eingefügt werden soll.
     * 0: [Standardwert] $image_dimension wird als neue längste Seite des Bildes aufgefasst.
     * Die andere Seite wird entsprechend verkleinert,
     * damit das Seitenverhältnis des Bildes erhalten bleibt. Ideal,
     * wenn das Bild in eine quadratische Box mit fester Größe eingepasst werden soll (typisch für eine
     * Thumbnail-Übersicht).
     * 1: $image_dimension wird als neue kürzeste Seite des Bildes aufgefasst.
     * Die andere Seite wird entsprechend vergrößert,damit das Seitenverhältnis des Bildes erhalten bleibt. Ideal,
     * wenn das Bild eine Mindestgröße nicht unterschreiten soll.
     *
     * @var string
     * @var Sting
     * @var int
     * @var int
     *
     * @example thumbnail($bild, $path, 150, -1);
     */
    public static function makeImagethumbnail(
        $bild,
        $path,
        $image_dimension,
        $scale_mode = 0
    ) {
        $filename = $bild;
        $bild = public_path('/fileadmin/fahrzeuge/') . $bild;
        list($src_width,
            $src_height,
            $type) = getimagesize($bild);

        if ($src_width <= 0 || $src_height <= 0) {
            return false;
        }
        $image_aspectratio = $src_width / $src_height;

        if (0 === $scale_mode) {
            $scale_mode = ($image_aspectratio > 1 ? -1 : -2);
        } elseif (1 === $scale_mode) {
            $scale_mode = ($image_aspectratio > 1 ? -2 : -1);
        }

        if (-1 === $scale_mode) {
            $new_image_width = $image_dimension;
            $new_image_height = round($image_dimension / $image_aspectratio);
        } elseif (-2 === $scale_mode) {
            $new_image_height = $image_dimension;
            $new_image_width = round($image_dimension * $image_aspectratio);
        } else {
            return false;
        }

        $im = imagecreatetruecolor(
            $new_image_width,
            $new_image_height
        );

        if (1 === $type) {
            $src = imagecreatefromgif($bild);

            imagealphablending(
                $im,
                true
            );
            imagefilledrectangle(
                $im,
                0,
                0,
                $new_image_width,
                $new_image_height,
                imagecolorallocate(
                    $im,
                    255,
                    255,
                    255
                )
            );
            imagecopyresampled(
                $im,
                $src,
                0,
                0,
                0,
                0,
                $new_image_width,
                $new_image_height,
                $src_width,
                $src_height
            );
            $bild = public_path('/fileadmin/fahrzeuge/cache/') . $image_dimension . 'px_' . $filename;
            imagegif(
                $im,
                $bild,
                100
            ); // imagepng = Wegen Lizenzproblemen bei PHP
            chmod(
                $bild,
                0644
            );
            imagedestroy($im);

            return $image_dimension . 'px_' . $filename;
        } elseif (2 === $type) {
            $src = imagecreatefromjpeg($bild);
            imagecopyresampled(
                $im,
                $src,
                0,
                0,
                0,
                0,
                $new_image_width,
                $new_image_height,
                $src_width,
                $src_height
            );
            $bild = public_path('/fileadmin/fahrzeuge/cache/') . $image_dimension . 'px_' . $filename;
            imagejpeg(
                $im,
                $bild,
                100
            );
            chmod(
                $bild,
                0644
            );
            imagedestroy($im);

            return $image_dimension . 'px_' . $filename;
        } elseif (3 === $type) {
            $src = imagecreatefrompng($bild);
            imagealphablending(
                $im,
                true
            );
            imagefilledrectangle(
                $im,
                0,
                0,
                $new_image_width,
                $new_image_height,
                imagecolorallocate(
                    $im,
                    255,
                    255,
                    255
                )
            );
            imagecopyresampled(
                $im,
                $src,
                0,
                0,
                0,
                0,
                $new_image_width,
                $new_image_height,
                $src_width,
                $src_height
            );
            $bild = public_path('/fileadmin/fahrzeuge/cache/') . $image_dimension . 'px_' . $filename;
            $quality = 100;
            if (phpversion() >= 5.1) {
                $quality = 9 - (int)(9 / 100 * $quality);
            }
            imagepng(
                $im,
                $bild,
                $quality
            );
            chmod(
                $bild,
                0644
            );
            imagedestroy($im);

            return $image_dimension . 'px_' . $filename;
        } else {
            echo "<p class='fehler'>Dieses Format wird nicht unterst&uuml;zt!</p>";

            return '';
        }
    }

    public static function makeImageDown($bild)
    {
        $bild = storage_path('/images/') . $bild;
        $img_width = 300;
        $img_height = 300;
        $image = imagecreatefromjpeg($bild);
        list($src_width,
            $src_height) = getimagesize($bild);
        if ($src_width >= $src_height) {
            $new_image_width = $img_width;
            $new_image_height = $src_height * $img_width / $src_width;
        }
        if ($src_width < $src_height) {
            $new_image_height = $img_width;
            $new_image_width = $src_width * $img_height / $src_height;
            if ($new_image_width < $img_width) {
                $new_image_width = $img_height;
            }
        }

        $new_image = imagecreatetruecolor(
            $new_image_width,
            $new_image_height
        );
        imagecopyresampled(
            $new_image,
            $image,
            0,
            0,
            0,
            0,
            $new_image_width,
            $new_image_height,
            $src_width,
            $src_height
        );
        imagejpeg(
            $new_image,
            $bild,
            100
        ); //Die Zahl bestimmt die DPI-Zahl 0=schlecht 100=Beste Qualität 72=Standart im Web
    }

    public static function moveImagePositionTo(
        $bild,
        $nr
    ) {
        $verz1 = 'temp/';
        $verz2 = '../foto/';
        $alt = $verz1 . $bild;
        //$neu=$verz2.$bild;
        $timestamp = time();
        $neu = $verz2 . $timestamp . $nr . '.jpg';
        copy(
            $alt,
            $neu
        );
        $filepath = 'temp/' . $bild;
        unlink($filepath);
        $bild = $timestamp . $nr . '.jpg';

        return $bild;
    }

    /**
     * Gibt das Bildformat zurück.
     *
     * @param string $format
     *
     * @return string
     */
    public static function getStaticImageCheckFormat($format)
    {
        if ('' === $format || !is_numeric($format)) {
            return '';
        }
        switch ($format) {
            case '1':
                $format = 'GIF';
                break;
            case '2':
                $format = 'JPG';
                break;
            case '3':
                $format = 'PNG';
                break;
            case '4':
                $format = 'SWF';
                break;
            case '5':
                $format = 'PSD';
                break;
            case '6':
                $format = 'BMP';
                break;
            case '7':
                $format = 'TIFF'; //(intel byte order)
                break;
            case '8':
                $format = 'TIFF'; //(motorola byte order)
                break;
            case '9':
                $format = 'JPC';
                break;
            case '10':
                $format = 'JP2';
                break;
            case '11':
                $format = 'JPX';
                break;
            default:
                $format = '';
        }

        return $format;
    }

    /**
     * Gibt an,
     * in welchem Farbenmodus das Bild ist.
     *
     * @param string $channel
     *
     * @return string
     */
    public static function getStaticImageColorType($channel)
    {
        switch ($channel) {
            case '1':
                $farben = 'S/W';
                break;
            case '2':
                $farben = '??';
                break;
            case '3':
                $farben = 'RGB';
                break;
            case '4':
                $farben = 'CMYK';
                break;
            default:
                $farben = '';
        }

        return $farben;
    }

    /**
     * Umwandeln von Bmp in Jpg.
     *
     * @param string $file
     *
     * @return string
     */
    public static function makeImageBmpToJpg(
        $file,
        $verz = null
    ) {
        if (null === $verz) {
            $verz = storage_path('/images/');
        }
        $old = $file;
        $len = '-' . strlen(Tools::getFileType($file));
        $file = substr(
            $file,
            0,
            $len
        );
        $file = $file . 'jpg';
        $exec = 'convert ' . $verz . $old . ' ' . $verz . $file;
        exec($exec);
        chmod(
            $file,
            '0666'
        );

        return $file;
    }

    /**
     * Lese die DPI Zahl aus.
     *
     * @param $datei Absoluter Pfad
     *
     * @return string
     */
    public static function getStaticImageDpiJpgRead($datei)
    {
        $pics = ['jpeg',
            'jpg',
            'tif',
            'tiff'];
        $filetype = strtolower(Tools::getFileType($datei));
        if (
            !in_array(
                $filetype,
                $pics
            )
        ) {
            return '&nbsp;';
        }
        $read = file_get_contents($datei);
        preg_match(
            '/Exif/',
            $read,
            $array
        );
        if (0 === count($array)) {
            return '&nbsp;';
        }
        $header = exif_read_data(
            $datei,
            0,
            true
        );
        if (
            array_key_exists(
                'XResolution',
                $header
            )
        ) {
            $tmp = explode(
                '/',
                $header['XResolution']
            );
            if ('' !== $tmp[1]) {
                return $tmp[0] / $tmp[1];
            } elseif ('' !== $tmp[0]) {
                return $tmp[0];
            } else {
                return 'keine Angaben zu';
            }
        } else {
            return '&nbsp;';
        }
    }

    /**
     * Because latest Adobe Photoshop (CS) does not embed EXIF data to images any more,
     * but embeds EXIF into XMP instead,
     * I wrote this function to read those SMP tags back to EXIF for further use.
     * I specifically intended to write this without using PHP's XML parser functions.
     *
     * @param $filename string
     * @param $printout boolean
     *
     * @return array
     *
     * @example $xmp_parsed = ee_extract_exif_from_pscs_xmp ("CRW_0016b_preview.jpg",1);
     */
    public static function getStaticImageExtractExifFromPscsXmp(
        $filename,
        $printout = 0
    ) {
        // very straightforward one-purpose utility function which
        // reads image data and gets some EXIF data (what I needed) out from its XMP tags (by Adobe Photoshop CS)
        // returns an array with values
        // code by Pekka Saarinen http://photography-on-the.net

        ob_start();
        readfile($filename);
        $source = ob_get_contents();
        ob_end_clean();

        $xmpdata_start = strpos(
            $source,
            '<x:xmpmeta'
        );
        $xmpdata_end = strpos(
            $source,
            '</x:xmpmeta>'
        );
        $xmplenght = $xmpdata_end - $xmpdata_start;
        $xmpdata = substr(
            $source,
            $xmpdata_start,
            $xmplenght + 12
        );

        $xmp_parsed = [];

        $regexps = [
            ['name' => 'DC creator',
                'regexp' => "/<dc:creator>\s*<rdf:Seq>\s*<rdf:li>.+<\/rdf:li>\s*<\/rdf:Seq>\s*<\/dc:creator>/"],
            ['name' => 'TIFF camera model',
                'regexp' => "/<tiff:Model>.+<\/tiff:Model>/"],
            ['name' => 'TIFF maker',
                'regexp' => "/<tiff:Make>.+<\/tiff:Make>/"],
            ['name' => 'EXIF exposure time',
                'regexp' => "/<exif:ExposureTime>.+<\/exif:ExposureTime>/"],
            ['name' => 'EXIF f number',
                'regexp' => "/<exif:FNumber>.+<\/exif:FNumber>/"],
            ['name' => 'EXIF aperture value',
                'regexp' => "/<exif:ApertureValue>.+<\/exif:ApertureValue>/"],
            ['name' => 'EXIF exposure program',
                'regexp' => "/<exif:ExposureProgram>.+<\/exif:ExposureProgram>/"],
            ['name' => 'EXIF iso speed ratings',
                'regexp' => "/<exif:ISOSpeedRatings>\s*<rdf:Seq>\s*<rdf:li>."
                    . "+<\/rdf:li>\s*<\/rdf:Seq>\s*<\/exif:ISOSpeedRatings>/"],
            ['name' => 'EXIF datetime original',
                'regexp' => "/<exif:DateTimeOriginal>.+<\/exif:DateTimeOriginal>/"],
            ['name' => 'EXIF exposure bias value',
                'regexp' => "/<exif:ExposureBiasValue>.+<\/exif:ExposureBiasValue>/"],
            ['name' => 'EXIF metering mode',
                'regexp' => "/<exif:MeteringMode>.+<\/exif:MeteringMode>/"],
            ['name' => 'EXIF focal lenght',
                'regexp' => "/<exif:FocalLength>.+<\/exif:FocalLength>/"],
            ['name' => 'AUX lens',
                'regexp' => "/<aux:Lens>.+<\/aux:Lens>/"],
        ];

        foreach ($regexps as $key => $k) {
            $name = $k['name'];
            $regexp = $k['regexp'];
            unset($r);
            preg_match(
                $regexp,
                $xmpdata,
                $r
            );
            $xmp_item = '';
            $xmp_item = @$r[0];
            array_push(
                $xmp_parsed,
                [
                    'item' => $name,
                    'value' => $xmp_item
                ]
            );
        }

        if (1 === $printout) {
            foreach ($xmp_parsed as $key => $k) {
                $item = $k['item'];
                $value = $k['value'];
                echo '<br><b>' . $item . ':</b> ' . $value;
            }
        }

        return $xmp_parsed;
    }

    public static function fbReadWriteExifData($post_ID)
    {
        $image = '/pfad/bild.jpg';

        if ('' !== $image) {
            error_reporting(0);

            $exif = exif_read_data(
                $image,
                0,
                true
            );

            if (isset($exif['EXIF']['DateTimeOriginal'])) {
                $fbdateoriginal = str_replace(
                    ':',
                    '-',
                    substr(
                        $exif['EXIF']['DateTimeOriginal'],
                        0,
                        10
                    )
                );
                $fbtimeoriginal = substr(
                    $exif['EXIF']['DateTimeOriginal'],
                    10
                );
                echo __(
                    'Datum:',
                    'photoblogfb'
                ) . " {$fbdateoriginal}";
                echo __(
                    'Uhrzeit:',
                    'photoblogfb'
                ) . " {$fbtimeoriginal}";
                echo "\n";
            }

            if (isset($exif['EXIF']['FNumber'])) {
                list($num,
                    $den) = explode(
                        '/',
                        $exif['EXIF']['FNumber']
                    );
                $fbaperture = 'F/' . ($num / $den);
                echo __(
                    'Blende:',
                    'photoblogfb'
                ) . " {$fbaperture}";
            }

            if (isset($exif['EXIF']['ExposureTime'])) {
                list($num,
                    $den) = explode(
                        '/',
                        $exif['EXIF']['ExposureTime']
                    );
                if ($num > $den) {
                    $fbexposure = "{$num}s";
                    echo __(
                        'Belichtungsdauer:',
                        'photoblogfb'
                    ) . " {$fbexposure}";
                } else {
                    $den = round($den / $num);
                    $fbexposure = "1/{$den}s";
                    echo __(
                        'Belichtungsdauer:',
                        'photoblogfb'
                    ) . " {$fbexposure}";
                }
            }

            if (isset($exif['EXIF']['FocalLength'])) {
                list($num,
                    $den) = explode(
                        '/',
                        $exif['EXIF']['FocalLength']
                    );
                $fbfocallength = ($num / $den) . 'mm';
                echo __(
                    'Brennweite:',
                    'photoblogfb'
                ) . " {$fbfocallength}";
            }

            if (isset($exif['EXIF']['FocalLengthIn35mmFilm'])) {
                $fbfbfocallength35 = $exif['EXIF']['FocalLengthIn35mmFilm'];
                echo __(
                    ', (KB-Format entsprechend:',
                    'photoblogfb'
                ) . " {$fbfbfocallength35}" . __('mm)');
            }

            echo "\n";

            if (isset($exif['EXIF']['ISOSpeedRatings'])) {
                echo __(
                    'ISO:',
                    'photoblogfb'
                ) . " {$exif['EXIF']['ISOSpeedRatings']}";
            }

            if (isset($exif['EXIF']['WhiteBalance'])) {
                switch ($exif['EXIF']['WhiteBalance']) {
                    case 0:
                        $fbwhitebalance = 'Auto';
                        break;
                    case 1:
                        $fbwhitebalance = 'Daylight';
                        break;
                    case 2:
                        $fbwhitebalance = 'Fluorescent';
                        break;
                    case 3:
                        $fbwhitebalance = 'Incandescent';
                        break;
                    case 4:
                        $fbwhitebalance = 'Flash';
                        break;
                    case 9:
                        $fbwhitebalance = 'Fine Weather';
                        break;
                    case 10:
                        $fbwhitebalance = 'Cloudy';
                        break;
                    case 11:
                        $fbwhitebalance = 'Shade';
                        break;
                    default:
                        $fbwhitebalance = '';
                        break;
                }
                echo __(
                    'Weißabgleich:',
                    'photoblogfb'
                ) . " {$fbwhitebalance}";
            }

            if (isset($exif['EXIF']['Flash'])) {
                switch ($exif['EXIF']['Flash']) {
                    case 0:
                        $fbexif_flash = 'Flash did not fire';
                        break;
                    case 1:
                        $fbexif_flash = 'Flash fired';
                        break;
                    case 5:
                        $fbexif_flash = 'Strobe return light not detected';
                        break;
                    case 7:
                        $fbexif_flash = 'Strobe return light detected';
                        break;
                    case 9:
                        $fbexif_flash = 'Flash fired, compulsory flash mode';
                        break;
                    case 13:
                        $fbexif_flash = 'Flash fired, compulsory flash mode, return light not detected';
                        break;
                    case 15:
                        $fbexif_flash = 'Flash fired, compulsory flash mode, return light detected';
                        break;
                    case 16:
                        $fbexif_flash = 'Flash did not fire, compulsory flash mode';
                        break;
                    case 24:
                        $fbexif_flash = 'Flash did not fire, auto mode';
                        break;
                    case 25:
                        $fbexif_flash = 'Flash fired, auto mode';
                        break;
                    case 29:
                        $fbexif_flash = 'Flash fired, auto mode, return light not detected';
                        break;
                    case 31:
                        $fbexif_flash = 'Flash fired, auto mode, return light detected';
                        break;
                    case 32:
                        $fbexif_flash = 'No flash function';
                        break;
                    case 65:
                        $fbexif_flash = 'Flash fired, red-eye reduction mode';
                        break;
                    case 69:
                        $fbexif_flash = 'Flash fired, red-eye reduction mode, return light not detected';
                        break;
                    case 71:
                        $fbexif_flash = 'Flash fired, red-eye reduction mode, return light detected';
                        break;
                    case 73:
                        $fbexif_flash = 'Flash fired, compulsory flash mode, red-eye reduction mode';
                        break;
                    case 77:
                        $fbexif_flash = 'Flash fired, compulsory flash mode, red-eye reduction mode,
                            return light not detected';
                        break;
                    case 79:
                        $fbexif_flash = 'Flash fired, compulsory flash mode, red-eye reduction mode,
                            return light detected';
                        break;
                    case 89:
                        $fbexif_flash = 'Flash fired, auto mode, red-eye reduction mode';
                        break;
                    case 93:
                        $fbexif_flash = 'Flash fired, auto mode, return light not detected, red-eye reduction mode';
                        break;
                    case 95:
                        $fbexif_flash = 'Flash fired, auto mode, return light detected, red-eye reduction mode';
                        break;
                    default:
                        $fbexif_flash = '';
                        break;
                }
                echo __(
                    'Blitz:',
                    'photoblogfb'
                ) . " {$fbexif_flash}";
            }
            echo "\n";

            if (isset($exif['IFD0']['Make']) && isset($exif['IFD0']['Model'])) {
                $fbmake = ucwords(strtolower($exif['IFD0']['Make']));
                $fbmodel = ucwords($exif['IFD0']['Model']);
                echo __(
                    'Kamera o. DIA-Scanner:',
                    'photoblogfb'
                ) . " {$fbmake}";
                echo __(
                    ',',
                    'photoblogfb'
                ) . " {$fbmodel}";
            }
        }
    }

    public function BuildHash($filename)
    {
        $filename = $this->RepFilename($filename);
        $end = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
        $basename = basename($filename, '.' . $end);
        $name = $basename . '.' . $this->getHash() . '.' . $end;

        return $name;
    }

    public function getHash()
    {
        if ('' === $this->filehash) {
            $makehash = $this->MakeHash();
        }

        return $this->filehash;
    }

    public function MakeHash()
    {
        $this->filehash = substr(md5(rand(1000, 9999999)), 0, 6);
    }

    public function makeImageConverter($originfile, $tiny = 1)
    {
        $name = pathinfo($originfile, PATHINFO_FILENAME);
        #$endfile = public_path('/fileadmin/rezepte/').basename($name).'.'.$this->filehash;
        $endfile = public_path('/fileadmin/rezepte/') . basename($name);
        $this->converted_files = [];
        $data = [];
        $data = $this->ImageFileConverter($originfile, $endfile, 'png', $data, $tiny);
        $data = $this->ImageFileConverter($originfile, $endfile, 'webp', $data, $tiny);
        $data = $this->ImageFileConverter($originfile, $endfile, 'jpg', $data, $tiny);
        $data['files'] = [];

        if (count($this->converted_files) > 0) {
            foreach ($this->converted_files as $files => $file) {
                $data['files'][] = $file;
            }
        }
        return $data;
    }

    public function ImageFileConverter(
        $upload_file = '',
        $endfile = '',
        $filetype = 'webp',
        $data,
        $tiny = 1
    ) {
        $config = [];

        if ($filetype === 'webp') {
            $config[] = '-quality 100';
            $config[] = '-define webp:lossless=true';
        }

        $endfile = $endfile . '.' . $filetype;
        $cmd = 'convert ' . $upload_file . ' ' . implode(' ', $config) . ' ' . $endfile;
        exec($cmd, $output, $return_var);

        if (isset($output)) {
            if (count($output) > 0) {
                $data['error'][] = $output;
            }
        }
        $this->converted_files[] = $endfile;

        return $data;
    }

    /**
     * @param string $original_file
     * @return string
     */
    public function getNewFileName(string $original_file = ''): string
    {
        if ($original_file === '') {
            return '';
        }
        return date('YmdHis') . rand(11111, 99999) . '.' . ToolsTrait::getFileType($original_file);
    }
}
