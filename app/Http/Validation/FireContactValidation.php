<?php

class FireContactValidation extends KennedyTedesco\Validation\Validator
{
    public static function Check($data)
    {
        $valid = Validator::make($data, [
            'datum' => 'Required|min:6|max:12',
            'nachname' => 'Required,Alpha_space,regex:""',
            'vorname' => 'Required,alpha_space,regex:""',
            'strasse' => 'Required,alphaNum, regex:""',
            'plz' => 'Required,Numeric,min:5,max:5',
            'wohnort' => 'Required,alpha_space,regex:""',
            'email' => 'Required,Between:3,64|Email',
        ]);
    }
}
