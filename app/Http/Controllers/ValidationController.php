<?php

namespace App\Http\Controllers;

use Validator;

/**
 * Class ValidationController
 * @package App\Http\Controllers
 */
class ValidationController extends GroundController
{
    // Entfernt bestimmte Daten
    /**
     * @param $data
     * @return mixed
     */
    public static function CheckInput($data)
    {
        foreach ($data as $key => $value) {
            $data[$key] = trim($value);
        }
        return $data;
    }

    /**
     *
     */
    private static function AddMoreValidatoren()
    {
        Validator::extend('german_url', function ($attribute, $value, $parameters) {
            $url = str_replace(["ä","ö","ü"], ["ae", "oe", "ue"], $value);
            return filter_var($url, FILTER_VALIDATE_URL);
        });
    }

    /**
     * Überprüft die Logindaten auf Falsche Zeichen
     * @param $data
     * @return \Illuminate\Validation\Validator
     */
    public static function LoginValidation($data)
    {
        $data = ValidationController::CheckInput($data);
        return Validator::make($data, [
            'benutzer' => 'required,Alpha_space, between:10,255,regex:""',
            'passwort' => 'required,alphaNum, between:10,255, regex:""',
        ]) ;
    }

    /**
     * @param $data
     * @return \Illuminate\Validation\Validator
     */
    public static function LinksValidation($data)
    {
        ValidationController::AddMoreValidatoren();
        $data = ValidationController::CheckInput($data);
        return Validator::make($data, [
            'url' => 'required|german_url',
            'title' => 'required,alphaNum, min:3',
        ]);
    }

    /**
     * @param $data
     * @return \Illuminate\Validation\Validator
     */
    public static function ChangePasswordValidation($data)
    {
        $data = ValidationController::CheckInput($data);
        return Validator::make($data, [
            'password' => 'hash:' . $data['password'],
            'new_password' => 'required|different:password|confirmed'
        ]);
    }

    /**
     * @param $data
     * @return \Illuminate\Validation\Validator
     */
    public static function ContactFormValidation($data)
    {
        $data = ValidationController::CheckInput($data);
        return Validator::make($data, [
            'name' => 'required,Alpha_space,regex:""',
            'strasse' => 'required,alphaNum, regex:""',
            'plz' => 'required,Numeric,min:5,max:5',
            'wohnort' => 'required,alpha_space,regex:""',
            'email' => 'required,email',
            'telefon' => 'Numeric',
            'message' => 'required, alphaNum',
        ]) ;
    }

    /**
     * @param $data
     * @return \Illuminate\Validation\Validator
     */
    public static function CheckPersonalValidation($data)
    {
        $data = ValidationController::CheckInput($data);
        return Validator::make($data, [
            'datum' => 'required|min:6|max:12',
            'nachname' => 'required,Alpha_space,regex:""',
            'vorname' => 'required,alpha_space,regex:""',
            'strasse' => 'required,alphaNum, regex:""',
            'plz' => 'required,Numeric,min:5,max:5',
            'wohnort' => 'required,alpha_space,regex:""',
            'email' => 'required,email',
        ]) ;
    }

    /**
     * @param $data
     * @return \Illuminate\Validation\Validator
     */
    public static function CheckFireValidation($data)
    {
        $data = ValidationController::CheckInput($data);
        return Validator::make($data, [
            'datum' => 'required|min:6|max:12',
            'nachname' => 'required,Alpha_space,regex:""',
            'vorname' => 'required,alpha_space,regex:""',
            'strasse' => 'required,alphaNum, regex:""',
            'plz' => 'required,Numeric,min:5,max:5',
            'wohnort' => 'required,alpha_space,regex:""',
            'email' => 'required,Between:3,64|Email',
        ]);
    }

    /**
     * @param $data
     * @return \Illuminate\Validation\Validator
     */
    public static function ImageValidation($data)
    {
        $data = ValidationController::CheckInput($data);
        return Validator::make($data, [
            'image' => 'required',
            'mimes' => 'jpeg,bmp,png',
            'max' => 8000000
        ]);
    }
}
