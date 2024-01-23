<?php

namespace App\Http\Traits;

/**
 * Programme zum Checken ob es bestimmte Funktionen auf dem Server gibt.
 */
trait FxToolsCheckProgsTrait
{
    use FxToolsSystemToolsTrait;

    public function checkImageMagick($ausgabe = 1)
    {
        $output = [];
        $cmd = 'whereis convert';
        $output = $this->loadConsole($cmd);
        if ('1' === $ausgabe) {
            echo '<pre>';
            print_r($output);
            echo '</pre>';
        }
        $tx = [];
        foreach ($output as $key => $value) {
            $value = str_replace('convert: ', '', $value);
            $value = explode(' ', $value);

            foreach ($value as $key2 => $value2) {
                $cmd = $value2 . ' -version';
                $out = '';
                $out = $this->loadConsole($cmd);
                $tx[] = $out;
            }
        }
        if ('1' === $ausgabe) {
            echo '<pre>';
            print_r($tx);
            echo '</pre>';
        }

        return $tx;
    }

    public function checkServerVersion()
    {
        return $_SERVER['SERVER_SOFTWARE'];
    }
}
