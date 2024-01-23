<?php

namespace App\Http\Controllers;

use App\Http\Models\Log;

class LogController extends GroundController
{
    /***
     * @param null $controller
     * @param null $function
     * @param null $message
     * @param null $request
     * @param null $response
     * @param null $errorcode
     * @param null $errormessage
     */
    public static function Log(
        $controller = null,
        $function = null,
        $message = null,
        $request = null,
        $response = null,
        $errorcode = null,
        $errormessage = null
    ) {
        $Log = new Log();
        $Log->controller = $controller;
        $Log->function = $function;
        $Log->message = $message;
        $Log->request = $request;
        $Log->response = $response;
        $Log->errorcode = $errorcode;
        $Log->errormessage = $errormessage;
        $Log->save();
    }
}
