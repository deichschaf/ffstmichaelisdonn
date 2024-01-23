<?php

namespace App\Http\Controllers;

/**
 * Controller für Errorcodes
 */
class ErrorController extends GroundController
{
    public function error_show($nr)
    {
        $data = array();
        $status = $this->status($nr);
    }

    private function status($nr)
    {
        $status = array();
        $status['100'] = array();
        $status['100']['code'] = '';
        $status['100']['title'] = '';
        $status['100']['text'] = '';

        return $status[$nr];
    }
}
