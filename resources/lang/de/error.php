<?php

/**
 * Created by PhpStorm.
 * User: Jörg-Marten Hoffmann
 * Date: 29.09.2015
 * Time: 17:37
 */

return [
    'validation' => [
        'required' => 'The :attribute field is required.',
        'email' => '',
        'email.required' => '',
        'email.between' => '',
        'plz' => '',
        'plz.required' => '',
        'plz.min' => '',
        'plz.max' => '',
        'plz.regex' => '',
    ],
    'fileupload' =>  [
        'errorcodes' => [
            'UPLOAD_ERR_OK' => 'Es liegt kein Fehler vor, die Datei wurde erfolgreich hochgeladen.',
            '0' => 'Es liegt kein Fehler vor, die Datei wurde erfolgreich hochgeladen.',
            'UPLOAD_ERR_INI_SIZE' => 'Die hochgeladene Datei überschreitet die in der Anweisung upload_max_filesize in php.ini festgelegte Größe.',
            '1' => 'Die hochgeladene Datei überschreitet die in der Anweisung upload_max_filesize in php.ini festgelegte Größe.',
            'UPLOAD_ERR_FORM_SIZE' => 'Die hochgeladene Datei überschreitet die in dem HTML Formular mittels der Anweisung MAX_FILE_SIZE angegebene maximale Dateigröße.',
            '2' => 'Die hochgeladene Datei überschreitet die in dem HTML Formular mittels der Anweisung MAX_FILE_SIZE angegebene maximale Dateigröße.',
            'UPLOAD_ERR_PARTIAL' => 'Die Datei wurde nur teilweise hochgeladen.',
            '3' => 'Die Datei wurde nur teilweise hochgeladen.',
            'UPLOAD_ERR_NO_FILE' => 'Es wurde keine Datei hochgeladen.',
            '4' => 'Es wurde keine Datei hochgeladen.',
            '5' => 'Unbekannter Fehler!',
            'UPLOAD_ERR_NO_TMP_DIR' => 'Fehlender temporärer Ordner. Eingeführt in PHP 5.0.3.',
            '6' => 'Fehlender temporärer Ordner. Eingeführt in PHP 5.0.3.',
            'UPLOAD_ERR_CANT_WRITE' => 'Speichern der Datei auf die Festplatte ist fehlgeschlagen. Eingeführt in PHP 5.1.0.',
            '7' => 'Speichern der Datei auf die Festplatte ist fehlgeschlagen. Eingeführt in PHP 5.1.0.',
            'UPLOAD_ERR_EXTENSION' => 'Eine PHP Erweiterung hat den Upload der Datei gestoppt. PHP bietet keine Möglichkeit an, um festzustellen welche Erweiterung das Hochladen der Datei gestoppt hat. Überprüfung aller geladenen Erweiterungen mittels phpinfo() könnte helfen. Eingeführt in PHP 5.2.0.',
            '8' => 'Eine PHP Erweiterung hat den Upload der Datei gestoppt. PHP bietet keine Möglichkeit an, um festzustellen welche Erweiterung das Hochladen der Datei gestoppt hat. Überprüfung aller geladenen Erweiterungen mittels phpinfo() könnte helfen. Eingeführt in PHP 5.2.0.',
        ]
    ],
];
