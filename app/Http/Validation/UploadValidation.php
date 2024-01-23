<?php

class UploadValidation extends KennedyTedesco\Validation\Validator
{
    /***
     * Validator für Kontaktanfragen!
     * @param $data
     */
    public static function Kontaktform($data)
    {
        $valid = Validator::make($data, [
            'name' => '',
            'vorname' => '',
            'strasse' => '',
            'plz' => '',
            'ort' => '',
            'email' => '',
            'telefon' => '',
        ]);
    }

    /***
     * Validierung vom Dateiupload
     * @param $data
     */
    public static function Images($data)
    {
        $valid = Validator::make($data, [
            'image' => 'required',
            'mimes' => 'jpeg,bmp,png',
            'max' => 8000000
        ]);
    }
}
