<?php

namespace App\Http\Traits;

/**
 * Klasse zum Bearbeiten von Bildern
 * @version 1.0
 * @author Jörg-Marten Hoffmann
 * @copyright Jörg-Marten Hoffmann 2010
 *
 *  Änderungen
 * 2011-11-17   Alle Image.php zusammengefasst
 * 2010-12-16   Image_Resize um eine Abfrage erweitert -> If Image breite/höhe = 0
 * 2010-11-02 Funktion checkSize eingebaut, um den PHP Buffer zu schonen wenn die Bilder zu groß sind!
 *
 */

use Illuminate\Http\Request;

/**
 * Trait ImageTrait
 * @package App\Http\Traits
 */
trait ImageTrait
{
    /**
     * @param $folder
     * @param string $key
     * @param array $config
     * @param Request $request
     * @return array
     */
    public static function UploaderImage($folder, $key = 'image', $config = [], Request $request)
    {
        $extension = $request->file($key)->getClientOriginalExtension();
        $extension = strtolower($extension);
        switch ($extension) {
            case 'png':
                $new_extension = $extension;
                break;
            case 'jpeg':
                $new_extension = 'jpg';
                break;
            default:
                $new_extension = $extension;
        }
        $fileName = date('YmdHis') . '_' . rand(11111, 99999) . '.';
        $fileName_before = $fileName . $extension;
        $fileName_after = $fileName . $new_extension;
        if (array_key_exists('filename', $config)) {
            if (trim($config['filename']) !== '') {
                $fileName_after = trim($config['filename']) . '_' . date('YmdHis') . '.' . $new_extension;
            }
        }
        $upload_path = storage_path('/grfx/');
        $public = public_path($folder);
        $request->file($key)->move($upload_path, $fileName_before); // Speichere das Bild in TEMP

        $data = [];
        $data['error'] = [];
        $data['success'] = [];
        $data['image'] = $fileName_after;
        $data = ImageTrait::ImageMagick($upload_path . $fileName_before, $config, $public . $fileName_after, $data);
        return $data;
    }

    /**
     * @param $upload_file
     * @param $config
     * @param $endfile
     * @param $data
     * @return array
     */
    public static function ImageMagick($upload_file, $config, $endfile, $data)
    {
        $im_config = [];
        if (array_key_exists('strip', $config)) {
            $im_config[] = '-strip ';
        }
        if (array_key_exists('size', $config)) {
            $im_config[] = '-resize ' . $config['size'];
        }
        if (array_key_exists('quality', $config)) {
            $im_config[] = '-quality ' . $config['quality'];
        }
        if (array_key_exists('strip', $config)) {
            $im_config[] = '-strip ';
        }
        if (array_key_exists('colorspace', $config)) {
            // $config['colorspace'] = 'RGB';
            $im_config[] = '-colorspace ' . $config['colorspace'];
        }
        if (array_key_exists('sampling-factor', $config)) {
            // $config['sampling-factor'] = '4:2:0';
            $im_config[] = '-sampling-factor ' . $config['sampling-factor'];
        }

        $cmd = "convert " . $upload_file . " " . implode(" ", $im_config) . " " . $endfile;
        exec($cmd, $output, $return_var);

        if (isset($output)) {
            if (count($output) > 0) {
                $data['error'][] = $output;
            }
        }
        return $data;
    }

    /**
     * @param $noretina
     * @param string $retina
     * @param string $class
     * @param string $alt
     * @param string $title
     * @return string
     */
    public static function MakeImgLazy($noretina, $retina = '', $class = '', $alt = '', $title = '')
    {
        $arr = [];
        //$arr[] = 'src="data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///yH5BAEAAAAALAAAAAABAAEAAAIBRAA7"';
        $arr[] = 'src="' . $noretina . '"';
        //$arr[] = 'data-src="' . $noretina . '"';
        //if ($retina != '') {
        //    $arr[] = 'data-src-retina="' . $retina . '"';
        //}
        $arr[] = 'alt="' . $alt . '"';
        $arr[] = 'title="' . $title . '"';
        if ($class != '') {
            $class = ' ' . $class;
        }
        $lazy_img = '<img ' . implode(' ', $arr) . ' class="lazy' . $class . '" />';
        //$lazy_img .= '<noscript>';
        //$lazy_img .= '<img src="' . $noretina . '" />';
        //$lazy_img .= '</noscript>';
        return $lazy_img;
    }

    /**
     * @param $file
     * @return bool
     */
    public static function ImagecheckSize($file)
    {
        $arrImgCheck = getimagesize($file);

        $dpi = 0;
        if ($arrImgCheck['2'] == '2') {
            $dpi = ImageTrait::dpi_jpg_auslesen($file);
            if (!is_numeric($dpi)) {
                $dpi = 0;
            }
        }

        $maxwidth = 3000;
        if ((strlen($arrImgCheck['0']) && $arrImgCheck['0'] > $maxwidth) || (strlen($arrImgCheck['1']) && $arrImgCheck['1'] > $maxwidth)) {
            if (is_file($file)) {
                unlink($file);
            }
            if ((strlen($arrImgCheck['1']) && $arrImgCheck['1'] > $maxwidth)) {
                $fehler = 'hoch';
            }
            if (strlen($arrImgCheck['0']) && $arrImgCheck['0'] > $maxwidth) {
                $fehler = 'breit';
            }
            echo '<p class="fehler">Das Bild ist zu ' . $fehler . ', bitte die Bildgr&ouml;sse verkleinern!</p>';
            echo '<p class="fehler">Das Bild hat folgende Gr&ouml;sse: ' . $arrImgCheck['0'] . 'x' . $arrImgCheck['1'] . ' Pixel</p>';
            echo '<p class="fehler">Es darf maximal ' . $maxwidth . 'x' . $maxwidth . ' Pixel haben</p>';
            return false;
        }
        /*
        if ($dpi>100)
        {
            if (is_file($file))
            {
                unlink($file);
            }
            echo '<p class="fehler">Das DPI Zahl des Bildes ist zu hoch, bitte die DPI verkleinern!</p>';
            echo '<p class="fehler">Am besten ist 72 DPI.</p>';
            return false;
        }
        */
        return true;
    }

    /**
     * @param $datei
     * @return mixed
     */
    public static function ImagedpiJpgAuslesen($datei)
    {
        $fh = fopen($datei, 'r');
        $header = fread($fh, 16);
        fclose($fh);
        $aufloesung = unpack('x14/ndpi', $header);
        return $aufloesung['dpi'];
    }

    /**
     * @param $file
     * @param int $width
     * @param int $height
     */
    public static function pdf_to_image($file, $width = 585, $height = 3000)
    {
        $grafik = str_replace('.pdf', '.jpg', $file);
        $temp = TEMP . rand(0, 999999999999999999999999999999999999) . '.png';
        $convert = "convert -profile " . LIBPATH . "icc/cmyk/USWebCoatedSWOP.icc -profile " . LIBPATH . "icc/rgb/AppleRGB.icc -density 72x72 " . $file . "[0] " . $temp;
        FxToolsSystemToolsTrait::Consolestatic($convert);
        $convert = "convert -density 72x72 " . $temp . " " . $grafik;
        FxToolsSystemToolsTrait::Consolestatic($convert);
        if (is_file($temp)) {
            unlink($temp);
        }
        if (is_file($grafik)) {
            FxToolsSystemToolsTrait::resizeimage($grafik, $width, $height);
            chmod($grafik, 0644);
        }
    }


    /**
     * @param $bild
     * @param $path
     * @param int $img_width
     * @param int $img_height
     * @param int $wasserzeichen
     * @return mixed|string
     */
    public static function Image_Resize($bild, $path, $img_width = 400, $img_height = 400, $wasserzeichen = 0)
    {
        $filename = $bild;
        $bild = TEMP . $bild;
        if (ImageTrait::checkSize($bild) === false) {
            return '';
        }
        $types = array("jpg", "jpeg", "gif", "png");
        list($src_width, $src_height, $type) = getimagesize($bild);

        $ext = strtolower(substr($filename, strpos($filename, ".") + 1, strlen($filename)));
        $image_aspectratio = $src_width / $src_height;

        if (!in_array($ext, $types)) {
            if (is_file($bild)) {
                unlink($bild);
            }
            echo "<p class='fehler'>Bildformat '" . $ext . "' wird nicht unterst&uuml;tzt!</p>";
            echo "<p class='fehler'>Bitte nur folgende Formate '" . strtoupper(join(', ', $types)) . "' verwenden!</p>";
            return 'NULL';
        }
        if ($src_width == 0) {
            if (is_file($bild)) {
                unlink($bild);
            }
            echo "<p class='fehler'>Die Breite des Bildes betr&auml;gt nur 0 Pixel!</p>";
            echo "<p class='fehler'>Bild kontrollieren!</p>";
            return 'NULL';
        }
        if ($src_height == 0) {
            if (is_file($bild)) {
                unlink($bild);
            }
            echo "<p class='fehler'>Die H&ouml;he des Bildes betr&auml;gt nur 0 Pixel!</p>";
            echo "<p class='fehler'>Bild kontrollieren!</p>";
            return 'NULL';
        }
        if ($src_width >= $src_height) {
            /**
             * Prüfe ob die Quelle kleiner ist als das maximum
             */
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

        /**
         * Doppelt gemoppelt! Siehe nächste IF Abfrage!
         */
        /*
        if($src_width < $src_height)
        {
            $new_image_width = ($img_width / $src_height ) * $src_width;
            $new_image_height  = $img_height;
        }
        */
        if ($src_height > $src_width) {
            if ($src_height >= $img_height) {
                $new_image_height = $img_height;
                #$new_image_width=ceil($src_width*$img_height/$src_height);
                $new_image_width = round($img_height * $image_aspectratio);
            } else {
                $new_image_height = $img_height;
                $new_image_width = ceil($src_width * $src_height / $src_height);
            }
        }
        if ($src_width < $src_height) {
            /*
            $new_image_width=$img_width;
            $image_aspectratio = $src_width / $src_height;
            $new_image_heigt=round($img_width / $image_aspectratio);
            */
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
        $schriftart = CMS_FONT_PATH . "ariblk.ttf";


        $im = imagecreatetruecolor($new_image_width, $new_image_height);

        if ($type === 1) {
            $src = imagecreatefromgif($bild);
            if (is_file($bild)) {
                unlink($bild);
            }
            /*
            imagealphablending($im, false);
            imagesavealpha($im,true);
            $transparent = imagecolorallocatealpha($im, 255, 255, 255, 127);
            imagefilledrectangle($im, 0, 0, $new_image_width, $new_image_height, $transparent);
            */

            imagealphablending($im, true);
            imagefilledrectangle($im, 0, 0, $new_image_width, $new_image_height, imagecolorallocate($im, 255, 255, 255));
            imagecopyresampled($im, $src, 0, 0, 0, 0, $new_image_width, $new_image_height, $src_width, $src_height);

            if ($wasserzeichen == 1) {
                $text_color = ImageColorAllocate($im, 255, 255, 255);
                $size = 10;
                $winkel = 0;
                $x = 10;
                $y = $new_image_height - 10;
                ImageTTFText($im, $size, $winkel, $x, $y, $text_color, CMS_FONT_PATH . "/ariblk.ttf", WASSERZEICHEN);
            }
            $bild = PATH . '/' . $path . '/' . $filename;
            $bild = str_replace('//', '/', $bild);
            imagegif($im, $bild, 100); // imagepng = Wegen Lizenzproblemen bei PHP
            chmod($bild, FILE_RIGHT);
            imagedestroy($im);
            return $filename;
        } elseif ($type === 2) {
            $src = imagecreatefromjpeg($bild);
            if (is_file($bild)) {
                unlink($bild);
            }
            imagecopyresampled($im, $src, 0, 0, 0, 0, $new_image_width, $new_image_height, $src_width, $src_height);
            if ($wasserzeichen == 1) {
                $text_color = ImageColorAllocate($im, 255, 255, 255);
                $size = 10;
                $winkel = 0;
                $x = 10;
                $y = $new_image_height - 10;
                ImageTTFText($im, $size, $winkel, $x, $y, $text_color, CMS_FONT_PATH . "/ariblk.ttf", WASSERZEICHEN);
            }
            $bild = PATH . '/' . $path . '/' . $filename;
            $bild = str_replace('//', '/', $bild);
            imagejpeg($im, $bild, 100);
            chmod($bild, FILE_RIGHT);
            imagedestroy($im);
            return $filename;
        } elseif ($type === 3) {
            $src = imagecreatefrompng($bild);
            if (is_file($bild)) {
                unlink($bild);
            }
            /*
            imagealphablending($im, false);
            imagesavealpha($im,true);
            $transparent = imagecolorallocatealpha($im, 255, 255, 255, 127);
            imagefilledrectangle($im, 0, 0, $new_image_width, $new_image_height, $transparent);
            */

            imagealphablending($im, true);
            imagefilledrectangle($im, 0, 0, $new_image_width, $new_image_height, imagecolorallocate($im, 255, 255, 255));
            imagecopyresampled($im, $src, 0, 0, 0, 0, $new_image_width, $new_image_height, $src_width, $src_height);
            if ($wasserzeichen == 1) {
                $text_color = ImageColorAllocate($im, 255, 255, 255);
                $size = 10;
                $winkel = 0;
                $x = 10;
                $y = $new_image_height - 10;
                ImageTTFText($im, $size, $winkel, $x, $y, $text_color, CMS_FONT_PATH . "/ariblk.ttf", WASSERZEICHEN);
            }
            $bild = PATH . '/' . $path . '/' . $filename;
            $bild = str_replace('//', '/', $bild);
            $quality = 100;
            if (phpversion() >= 5.1) {
                $quality = 9 - (int)(9 / 100 * $quality);
            }
            imagepng($im, $bild, $quality);
            chmod($bild, FILE_RIGHT);
            imagedestroy($im);
            return $filename;
        } else {
            echo "<p class='fehler'>Dieses Format wird nicht unterst&uuml;zt!</p>";
            return '';
        }
    }


    /**
     *
     * -1: $image_dimension wird als neue Breite des Bildes aufgefasst; die Höhe wird so angepasst, dass das Seitenverhältnis des Bildes erhalten bleibt. Ideal, wenn das Bild in eine Spalte mit fester Breite eingefügt werden soll.
     * -2: $image_dimension wird als neue Höhe des Bildes aufgefasst; die Breite wird so angepasst, dass das Seitenverhältnis des Bildes erhalten bleibt. Ideal, wenn das Bild in eine Zeile mit fester Höhe eingefügt werden soll.
     * 0: [Standardwert] $image_dimension wird als neue längste Seite des Bildes aufgefasst. Die andere Seite wird entsprechend verkleinert, damit das Seitenverhältnis des Bildes erhalten bleibt. Ideal, wenn das Bild in eine quadratische Box mit fester Größe eingepasst werden soll (typisch für eine Thumbnail-Übersicht).
     * 1: $image_dimension wird als neue kürzeste Seite des Bildes aufgefasst. Die andere Seite wird entsprechend vergrößert, damit das Seitenverhältnis des Bildes erhalten bleibt. Ideal, wenn das Bild eine Mindestgröße nicht unterschreiten soll.
     * @var $bild String
     * @var $path Sting
     * @var $image_dimension INT
     * @var $scale_mode INT
     * @example thumbnail($bild, $path, 150, -1);
     */
    public static function Imagethumbnail($bild, $path, $image_dimension, $scale_mode = 0)
    {
        $filename = $bild;
        $bild = TEMP . $bild;
        list($src_width, $src_height, $type) = getimagesize($bild);

        if ($src_width <= 0 || $src_height <= 0) {
            return false;
        }
        $image_aspectratio = $src_width / $src_height;

        if ($scale_mode === 0) {
            $scale_mode = ($image_aspectratio > 1 ? -1 : -2);
        } elseif ($scale_mode === 1) {
            $scale_mode = ($image_aspectratio > 1 ? -2 : -1);
        }

        if ($scale_mode === -1) {
            $new_image_width = $image_dimension;
            $new_image_height = round($image_dimension / $image_aspectratio);
        } elseif ($scale_mode === -2) {
            $new_image_height = $image_dimension;
            $new_image_width = round($image_dimension * $image_aspectratio);
        } else {
            return false;
        }

        $im = imagecreatetruecolor($new_image_width, $new_image_height);

        if ($type === 1) {
            $src = imagecreatefromgif($bild);
            if (is_file($bild)) {
                unlink($bild);
            }

            imagealphablending($im, true);
            imagefilledrectangle($im, 0, 0, $new_image_width, $new_image_height, imagecolorallocate($im, 255, 255, 255));
            imagecopyresampled($im, $src, 0, 0, 0, 0, $new_image_width, $new_image_height, $src_width, $src_height);
            $bild = PATH . '/' . $path . '/' . $filename;
            $bild = str_replace('//', '/', $bild);
            imagegif($im, $bild, 100); // imagepng = Wegen Lizenzproblemen bei PHP
            chmod($bild, 0644);
            imagedestroy($im);
            return $filename;
        } elseif ($type === 2) {
            $src = imagecreatefromjpeg($bild);
            if (is_file($bild)) {
                unlink($bild);
            }
            imagecopyresampled($im, $src, 0, 0, 0, 0, $new_image_width, $new_image_height, $src_width, $src_height);
            $bild = PATH . '/' . $path . '/' . $filename;
            $bild = str_replace('//', '/', $bild);
            imagejpeg($im, $bild, 100);
            chmod($bild, 0644);
            imagedestroy($im);
            return $filename;
        } elseif ($type === 3) {
            $src = imagecreatefrompng($bild);
            if (is_file($bild)) {
                unlink($bild);
            }

            imagealphablending($im, true);
            imagefilledrectangle($im, 0, 0, $new_image_width, $new_image_height, imagecolorallocate($im, 255, 255, 255));
            imagecopyresampled($im, $src, 0, 0, 0, 0, $new_image_width, $new_image_height, $src_width, $src_height);
            $bild = PATH . '/' . $path . '/' . $filename;
            $bild = str_replace('//', '/', $bild);
            $quality = 100;
            if (phpversion() >= 5.1) {
                $quality = 9 - (int)(9 / 100 * $quality);
            }
            imagepng($im, $bild, $quality);
            chmod($bild, 0644);
            imagedestroy($im);
            return $filename;
        } else {
            echo "<p class='fehler'>Dieses Format wird nicht unterst&uuml;zt!</p>";
            return '';
        }
    }

    /**
     * @param $bild
     */
    public static function Image_Down($bild)
    {
        $bild = TEMP . $bild;
        $img_width = 300;
        $img_height = 300;
        $image = imagecreatefromjpeg($bild);
        list($src_width, $src_height) = getimagesize($bild);
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

        $new_image = imagecreatetruecolor($new_image_width, $new_image_height);
        imagecopyresampled($new_image, $image, 0, 0, 0, 0, $new_image_width, $new_image_height, $src_width, $src_height);
        imagejpeg($new_image, $bild, 100); //Die Zahl bestimmt die DPI-Zahl 0=schlecht 100=Beste Qualität 72=Standart im Web
    }

    /**
     * @param $bild
     * @param $nr
     * @return string
     */
    public static function Imageverschieben($bild, $nr)
    {
        $verz1 = 'temp/';
        $verz2 = '../foto/';
        $alt = $verz1 . $bild;
        //$neu=$verz2.$bild;
        $timestamp = time();
        $neu = $verz2 . $timestamp . $nr . ".jpg";
        copy($alt, $neu);
        $filepath = "temp/" . $bild;
        unlink($filepath);
        $bild = $timestamp . $nr . ".jpg";
        return $bild;
    }

    /**
     * Gibt das Bildformat zurück
     * @param string $format
     * @return string
     */
    public static function ImagecheckFormat($format)
    {
        if ($format == '' || !is_numeric($format)) {
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
     * Gibt an, in welchem Farbenmodus das Bild ist
     * @param string $channel
     * @return string
     */
    public static function ImageCheckFarbbereich($channel)
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
     * Umwandeln von Bmp in Jpg
     *
     * @param string $file
     * @return string
     */
    public static function ImageBMPtoJPG($file, $verz = TEMP)
    {
        $old = $file;
        $len = '-' . strlen(Tools::getfiletype($file));
        $file = substr($file, 0, $len);
        $file = $file . 'jpg';
        $exec = "convert " . $verz . $old . " " . $verz . $file;
        exec($exec);
        chmod($file, '0666');
        return $file;
    }


    /**
     * Lese die DPI Zahl aus
     * @param $datei Absoluter Pfad
     * @return string
     */
    public static function Imagedpi_auslesen_jpg($datei)
    {
        $pics = array('jpeg', 'jpg', 'tif', 'tiff');
        $filetype = strtolower(Tools::getfiletype($datei));
        if (!in_array($filetype, $pics)) {
            return "&nbsp;";
        }
        $read = file_get_contents($datei);
        preg_match('/Exif/', $read, $array);
        if (count($array) == 0) {
            return '&nbsp;';
        }
        $header = exif_read_data($datei, 0, true);
        if (array_key_exists('XResolution', $header)) {
            $tmp = explode("/", $header['XResolution']);
            if ($tmp[1] != "") {
                return ($tmp[0] / $tmp[1]);
            } elseif ($tmp[0] != "") {
                return $tmp[0];
            } else {
                return "keine Angaben zu";
            }
        } else {
            return "&nbsp;";
        }
    }

    /**
     * Because latest Adobe Photoshop (CS) does not embed EXIF data to images any more, but embeds EXIF into XMP instead,
     * I wrote this function to read those SMP tags back to EXIF for further use.
     * I specifically intended to write this without using PHP's XML parser functions.
     * @param $filename string
     * @param $printout boolean
     * @return array
     * @example $xmp_parsed = ee_extract_exif_from_pscs_xmp ("CRW_0016b_preview.jpg",1);
     */
    public static function Imageee_extract_exif_from_pscs_xmp($filename, $printout = 0)
    {
        // very straightforward one-purpose utility function which
        // reads image data and gets some EXIF data (what I needed) out from its XMP tags (by Adobe Photoshop CS)
        // returns an array with values
        // code by Pekka Saarinen http://photography-on-the.net

        ob_start();
        readfile($filename);
        $source = ob_get_contents();
        ob_end_clean();

        $xmpdata_start = strpos($source, "<x:xmpmeta");
        $xmpdata_end = strpos($source, "</x:xmpmeta>");
        $xmplenght = $xmpdata_end - $xmpdata_start;
        $xmpdata = substr($source, $xmpdata_start, $xmplenght + 12);

        $xmp_parsed = array();

        $regexps = array(
            array("name" => "DC creator", "regexp" => "/<dc:creator>\s*<rdf:Seq>\s*<rdf:li>.+<\/rdf:li>\s*<\/rdf:Seq>\s*<\/dc:creator>/"),
            array("name" => "TIFF camera model", "regexp" => "/<tiff:Model>.+<\/tiff:Model>/"),
            array("name" => "TIFF maker", "regexp" => "/<tiff:Make>.+<\/tiff:Make>/"),
            array("name" => "EXIF exposure time", "regexp" => "/<exif:ExposureTime>.+<\/exif:ExposureTime>/"),
            array("name" => "EXIF f number", "regexp" => "/<exif:FNumber>.+<\/exif:FNumber>/"),
            array("name" => "EXIF aperture value", "regexp" => "/<exif:ApertureValue>.+<\/exif:ApertureValue>/"),
            array("name" => "EXIF exposure program", "regexp" => "/<exif:ExposureProgram>.+<\/exif:ExposureProgram>/"),
            array("name" => "EXIF iso speed ratings", "regexp" => "/<exif:ISOSpeedRatings>\s*<rdf:Seq>\s*<rdf:li>.+<\/rdf:li>\s*<\/rdf:Seq>\s*<\/exif:ISOSpeedRatings>/"),
            array("name" => "EXIF datetime original", "regexp" => "/<exif:DateTimeOriginal>.+<\/exif:DateTimeOriginal>/"),
            array("name" => "EXIF exposure bias value", "regexp" => "/<exif:ExposureBiasValue>.+<\/exif:ExposureBiasValue>/"),
            array("name" => "EXIF metering mode", "regexp" => "/<exif:MeteringMode>.+<\/exif:MeteringMode>/"),
            array("name" => "EXIF focal length", "regexp" => "/<exif:FocalLength>.+<\/exif:FocalLength>/"),
            array("name" => "AUX lens", "regexp" => "/<aux:Lens>.+<\/aux:Lens>/")
        );

        foreach ($regexps as $key => $k) {
            $name = $k["name"];
            $regexp = $k["regexp"];
            unset($r);
            preg_match($regexp, $xmpdata, $r);
            $xmp_item = "";
            $xmp_item = @$r[0];
            array_push($xmp_parsed, array("item" => $name, "value" => $xmp_item));
        }

        if ($printout === 1) {
            foreach ($xmp_parsed as $key => $k) {
                $item = $k["item"];
                $value = $k["value"];
                print "<br><b>" . $item . ":</b> " . $value;
            }
        }

        return ($xmp_parsed);
    }

    /**
     * @param $post_ID
     */
    public static function Imagefb_read_write_exif_data($post_ID)
    {
        $image = '/pfad/bild.jpg';

        if ($image !== '') {
            error_reporting(0);

            $exif = exif_read_data($image, 0, true);

            if (isset($exif["EXIF"]["DateTimeOriginal"])) {
                $fbdateoriginal = str_replace(":", "-", substr($exif["EXIF"]["DateTimeOriginal"], 0, 10));
                $fbtimeoriginal = substr($exif["EXIF"]["DateTimeOriginal"], 10);
                print __('Datum:', 'photoblogfb') . " {$fbdateoriginal}";
                print __(' Uhrzeit:', 'photoblogfb') . " {$fbtimeoriginal}";
                print "\n";
            }

            if (isset($exif["EXIF"]["FNumber"])) {
                list($num, $den) = explode("/", $exif["EXIF"]["FNumber"]);
                $fbaperture = "F/" . ($num / $den);
                print __('Blende:', 'photoblogfb') . " {$fbaperture}";
            }

            if (isset($exif["EXIF"]["ExposureTime"])) {
                list($num, $den) = explode("/", $exif["EXIF"]["ExposureTime"]);
                if ($num > $den) {
                    $fbexposure = "{$num}s";
                    print __('Belichtungsdauer:', 'photoblogfb') . " {$fbexposure}";
                } else {
                    $den = round($den / $num);
                    $fbexposure = "1/{$den}s";
                    print __('Belichtungsdauer:', 'photoblogfb') . " {$fbexposure}";
                }
            }

            if (isset($exif["EXIF"]["FocalLength"])) {
                list($num, $den) = explode("/", $exif["EXIF"]["FocalLength"]);
                $fbfocallength = ($num / $den) . "mm";
                print __(' Brennweite:', 'photoblogfb') . " {$fbfocallength}";
            }

            if (isset($exif["EXIF"]["FocalLengthIn35mmFilm"])) {
                $fbfbfocallength35 = $exif["EXIF"]["FocalLengthIn35mmFilm"];
                print __(', (KB-Format entsprechend:', 'photoblogfb') . " {$fbfbfocallength35}" . __('mm)');
            }

            print "\n";

            if (isset($exif["EXIF"]["ISOSpeedRatings"])) {
                print __('ISO:', 'photoblogfb') . " {$exif["EXIF"]["ISOSpeedRatings"]}";
            }

            if (isset($exif["EXIF"]["WhiteBalance"])) {
                switch ($exif["EXIF"]["WhiteBalance"]) {
                    case 0:
                        $fbwhitebalance = "Auto";
                        break;
                    case 1:
                        $fbwhitebalance = "Daylight";
                        break;
                    case 2:
                        $fbwhitebalance = "Fluorescent";
                        break;
                    case 3:
                        $fbwhitebalance = "Incandescent";
                        break;
                    case 4:
                        $fbwhitebalance = "Flash";
                        break;
                    case 9:
                        $fbwhitebalance = "Fine Weather";
                        break;
                    case 10:
                        $fbwhitebalance = "Cloudy";
                        break;
                    case 11:
                        $fbwhitebalance = "Shade";
                        break;
                    default:
                        $fbwhitebalance = '';
                        break;
                }
                print __('Weißabgleich:', 'photoblogfb') . " {$fbwhitebalance}";
            }

            if (isset($exif["EXIF"]["Flash"])) {
                switch ($exif["EXIF"]["Flash"]) {
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
                        $fbexif_flash = 'Flash fired, compulsory flash mode, red-eye reduction mode, return light not detected';
                        break;
                    case 79:
                        $fbexif_flash = 'Flash fired, compulsory flash mode, red-eye reduction mode, return light detected';
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
                print __('Blitz:', 'photoblogfb') . " {$fbexif_flash}";
            }

            /**
             * if(isset($exif["EXIF"]["Flash"])) {
             * $fbflash = (bindec($exif["EXIF"]["Flash"]) ? "On" : "Off");
             * print __('Blitz:', 'photoblogfb') . " {$fbflash}";
             * }
             */

            print "\n";

            if (isset($exif["IFD0"]["Make"]) && isset($exif["IFD0"]["Model"])) {
                $fbmake = ucwords(strtolower($exif["IFD0"]["Make"]));
                $fbmodel = ucwords($exif["IFD0"]["Model"]);
                print __('Kamera o. DIA-Scanner:', 'photoblogfb') . " {$fbmake}";
                print __(',', 'photoblogfb') . " {$fbmodel}";
            }

            /* Alle EXIF-Daten untereinander ausgeben */
            /**
             * foreach ($exif as $key => $section) {
             * foreach ($section as $name => $val) {
             * echo "$key.$name: $val\n";
             * }
             * }
             */
        }
    }
}
