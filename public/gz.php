<?php

function get_content_type($file) {
    // Determine Content-Type based on file extension
    // Default to text/html
    $info = pathinfo($file);
    $content_types = array('css' => 'text/css; charset=UTF-8',
                           'html' => 'text/html; charset=UTF-8',
                           'gif' => 'image/gif',
                           'ico' => 'image/x-icon',
                           'jpg' => 'image/jpeg',
                           'jpeg' => 'image/jpeg',
                           'js' => 'application/javascript',
                           'json' => 'application/json',
                           'png' => 'image/png',
                           'webp' => 'image/webp',
                           'txt' => 'text/plain',
                           'xml' => 'application/xml');
    if (empty($content_types[$info['extension']]))
        return 'text/html; charset=UTF-8';
    return $content_types[$info['extension']];
}

function save_log($txt)
{
  $datum = date("l dS of F Y h:i:s");
  $information = $txt. "|" .$datum;
  $datei_handle=fopen($_SERVER['DOCUMENT_ROOT']."/lo.txt","w");
  fwrite($datei_handle,$information);
  fclose($datei_handle);
}

function verkleiner($data)
{
    $data = preg_replace('!/\*[^*]*\*+([^/][^*]*\*+)*/!', '', $data);
    $data = str_replace(array("\r\n", "\r", "\n", "\t"), '', $data);
    $data = preg_replace('/\s\s+/', ' ', $data);
    return $data;
}

function main() {
    // Get file path by stripping query parameters from the request URI
    if (!empty($_SERVER['REQUEST_URI']))
        $path = preg_replace('/\/?(?:\?.*)?$/', '', $_SERVER['REQUEST_URI']);

    // If the path is empty, either use DEFAULT_FILENAME if defined, or exit
    if (empty($path)) {
        if (defined('DEFAULT_FILENAME')) $path = '/' . DEFAULT_FILENAME;
        else die();
    }

    //save_log($path);

    $file = dirname(__FILE__) . $path;
    if (!file_exists($file)) die();

    $mtime = filemtime($file);

    // If the user agent sent a IF_MODIFIED_SINCE header, check if the file
    // has been modified. If it hasn't, send '304 Not Modified' header & exit
    if (!empty($_SERVER['HTTP_IF_MODIFIED_SINCE']) &&
        $mtime <= strtotime($_SERVER['HTTP_IF_MODIFIED_SINCE'])) {
        header($_SERVER['SERVER_PROTOCOL'] . ' 304 Not Modified', true, 304);
        exit;
    }

    // Determine Content-Type based on file extension
    $content_type = get_content_type($file);

    // If the user agent accepts GZIP encoding, store a compressed version of
    // the file (<filename>.gz)
    if (!empty($_SERVER['HTTP_ACCEPT_ENCODING']) &&
        in_array('gzip', preg_split('/\s*,\s*/',
                                    $_SERVER['HTTP_ACCEPT_ENCODING']))) {
        // Only write the compressed version if it does not yet exist or the
        // original file has changed
        $gzfile = $file . '.gz';
        if (!file_exists($gzfile) || filemtime($gzfile) < $mtime)
		{
			$info=pathinfo($file);
			$content=file_get_contents($file);
			if ($info['extension']=='css' ||$info['extension']=='js')
			{
				$content=verkleiner($content);
            }
			file_put_contents($gzfile, gzencode($content));
        }
		// Send compression headers and use the .gz file instead of the
        // original filename
        header('Content-Encoding: gzip');
        $file = $file . '.gz';
    }

    // Vary max-age and expiration headers based on content type
    switch ($content_type) {
        case 'image/gif':
        case 'image/jpeg':
        case 'image/png':
            // Max-age for images: 31 days
            $maxage = 60 * 60 * 24 * 31;
            break;
        default:
            // Max-age for everything else: 7 days
            $maxage = 60 * 60 * 24 * 7;
    }

    // Send remaining headers
    header('Vary: Accept-Encoding');
    header('Cache-Control: max-age=' . $maxage);
    header('Expires: ' . gmdate('D, d M Y H:i:s', time() + $maxage) . ' GMT');
    header('Last-Modified: ' . gmdate('D, d M Y H:i:s', $mtime) . ' GMT');
    header('Content-Type: ' . $content_type);
    header('Content-Length: ' . filesize($file));

    // If the request method isn't HEAD, send the file contents
    if ($_SERVER['REQUEST_METHOD'] !== 'HEAD') readfile($file);
}

main();

?>
