<?php

return [

    'validation.name_full' => '',
    'email.required' => '',
    'email.between' => '',
    'systempassword' => 'Bitte kontrollieren Sie Ihr Passwort.',
    'name' => 'Bitte nur Buchstaben verwenden',
    'street' => 'Bitte nur Buchstaben verwenden',
    'city' => 'Bitte nur Buchstaben verwenden',
    'plz' => 'Bitte nur Zahlen nutzen',
    'plz.required' => '',
    'plz.min' => 'Mindestens :min Zahlen.',
    'plz.max' => 'Maximal :max Zahlen.',
    'plz.regex' => '',
    'german_url' => ':attribute is not a valid URL',

    'accepted'             => ':attribute muss akzeptiert werden.',
    'active_url'           => ':attribute ist keine gültige Internet-Adresse.',
    'after'                => ':attribute muss ein Datum nach dem :date sein.',
    'alpha'                => ':attribute darf nur aus Buchstaben bestehen.',
    'alpha_dash'           => ':attribute darf nur aus Buchstaben, Zahlen, Binde- und Unterstrichen bestehen. Umlaute (ä, ö, ü) und Eszett (ß) sind nicht erlaubt.',
    'alpha_num'            => ':attribute darf nur aus Buchstaben und Zahlen bestehen.',
    'array'                => ':attribute muss ein Array sein.',
    'before'               => ':attribute muss ein Datum vor dem :date sein.',
    'between'              => [
        'numeric' => ':attribute muss zwischen :min & :max liegen.',
        'file'    => ':attribute muss zwischen :min & :max Kilobytes groß sein.',
        'string'  => ':attribute muss zwischen :min & :max Zeichen lang sein.',
        'array'   => ':attribute muss zwischen :min & :max Elemente haben.',
    ],
    'boolean'              => ":attribute muss entweder 'true' oder 'false' sein.",
    'confirmed'            => ':attribute stimmt nicht mit der Bestätigung überein.',
    'date'                 => ':attribute muss ein gültiges Datum sein.',
    'date_format'          => ':attribute entspricht nicht dem gültigen Format für :format.',
    'different'            => ':attribute und :other müssen sich unterscheiden.',
    'digits'               => ':attribute muss :digits Stellen haben.',
    'digits_between'       => ':attribute muss zwischen :min und :max Stellen haben.',
    'dimensions'           => ':attribute hat ungültige Bildabmessungen.',
    'distinct'             => 'Das Feld :attribute beinhaltet einen bereits vorhandenen Wert.',
    'email'                => ':attribute Format ist ungültig.',
    'exists'               => 'Der gewählte Wert für :attribute ist ungültig.',
    'file'                 => ':attribute muss eine Datei sein.',
    'filled'               => ':attribute muss ausgefüllt sein.',
    'image'                => ':attribute muss ein Bild sein.',
    'in'                   => 'Der gewählte Wert für :attribute ist ungültig.',
    'in_array'             => 'Der gewählte Wert für :attribute kommt nicht in :other vor.',
    'integer'              => ':attribute muss eine ganze Zahl sein.',
    'ip'                   => ':attribute muss eine gültige IP-Adresse sein.',
    'json'                 => ':attribute muss ein gültiger JSON-String sein.',
    'max'                  => [
        'numeric' => ':attribute darf maximal :max sein.',
        'file'    => ':attribute darf maximal :max Kilobytes groß sein.',
        'string'  => ':attribute darf maximal :max Zeichen haben.',
        'array'   => ':attribute darf nicht mehr als :max Elemente haben.',
    ],
    'mimes'                => ':attribute muss den Dateityp :values haben.',
    'min'                  => [
        'numeric' => ':attribute muss mindestens :min sein.',
        'file'    => ':attribute muss mindestens :min Kilobytes groß sein.',
        'string'  => ':attribute muss mindestens :min Zeichen lang sein.',
        'array'   => ':attribute muss mindestens :min Elemente haben.',
    ],
    'not_in'               => 'Der gewählte Wert für :attribute ist ungültig.',
    'numeric'              => ':attribute muss eine Zahl sein.',
    'present'              => 'Das Feld :attribute muss vorhanden sein.',
    'regex'                => ':attribute Format ist ungültig.',
    'required'             => ':attribute muss ausgefüllt sein.',
    'required_if'          => ':attribute muss ausgefüllt sein, wenn :other :value ist.',
    'required_unless'      => ':attribute muss ausgefüllt sein, wenn :other nicht :values ist.',
    'required_with'        => ':attribute muss angegeben werden, wenn :values ausgefüllt wurde.',
    'required_with_all'    => ':attribute muss angegeben werden, wenn :values ausgefüllt wurde.',
    'required_without'     => ':attribute muss angegeben werden, wenn :values nicht ausgefüllt wurde.',
    'required_without_all' => ':attribute muss angegeben werden, wenn keines der Felder :values ausgefüllt wurde.',
    'same'                 => ':attribute und :other müssen übereinstimmen.',
    'size'                 => [
        'numeric' => ':attribute muss gleich :size sein.',
        'file'    => ':attribute muss :size Kilobyte groß sein.',
        'string'  => ':attribute muss :size Zeichen lang sein.',
        'array'   => ':attribute muss genau :size Elemente haben.',
    ],
    'string'               => ':attribute muss ein String sein.',
    'timezone'             => ':attribute muss eine gültige Zeitzone sein.',
    'unique'               => ':attribute ist schon vergeben.',
    'url'                  => 'Das Format von :attribute ist ungültig.',

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | Here you may specify custom validation messages for attributes using the
    | convention "attribute.rule" to name the lines. This makes it quick to
    | specify a specific custom language line for a given attribute rule.
    |
    */

    'custom'               => [
        'attribute-name' => [
            'rule-name' => 'custom-message',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Attributes
    |--------------------------------------------------------------------------
    |
    | The following language lines are used to swap attribute place-holders
    | with something more reader friendly such as E-Mail Address instead
    | of "email". This simply helps us make messages a little cleaner.
    |
    */

    'attributes' => [
        'username' => 'Benutzername',
        'password' => 'Passwort',
        'email'    => 'E-Mail',
    ],

    'isin' => 'Der Wert :attribute ist keine International Securities Identification Number (ISIN).',
    'iban' => 'Der Wert :attribute ist keine International Bank Account Number (IBAN).',
    'bic' => 'Der Wert :attribute muss einen gültigen Business Identifier Code (BIC) enthalten.',
    'hexcolor' => 'Der Wert :attribute muss einen gültigen Hexadezimal Farbwert enthalten.',
    'creditcard' => 'Der Wert :attribute ist keine gültige Kreditkartennummer.',
    'isbn' => 'Der Wert :attribute muss eine gültige International Standard Book Number (ISBN) enthalten.',
    'isodate' => 'Der Wert :attribute enthält kein gültiges Datum nach ISO 8601.',
    'username' => 'Der Wert :attribute enthält keinen gültigen Benutzernamen.',
    'htmlclean' => 'Der Wert :attribute enthält nicht erlaubten HTML Code.',
    'password' => 'Der Wert :attribute muss 6 bis 64 Zeichen enthalten, die aus mindestens einer Zahl, einem 
    Großbuchstaben, einem Kleinbuchstaben und einem Sonderzeichen bestehen.',

];
