<?php

if (! function_exists('perpare_images')) {
    function perpare_images($name)
    {
        return str_replace('.', '-|-', $name);
    }
}
if (! function_exists('mix_cache')) {
    function mix_cache($file)
    {
        $filename = explode('?', $file);
        $size = filemtime(public_path($filename['0']));
        $new_name = str_replace('.js?', '.' . $size . '.js?', $file);
        $new_name = str_replace('.css?', '.' . $size . '.css?', $new_name);

        return $new_name;
    }
}

if (!function_exists('rroute')) {
    function rroute($name, $params = [])
    {
        return route($name, $params, false);
    }
}
