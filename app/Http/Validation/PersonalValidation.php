<?php

namespace App\Http\Validation;

class PersonalValidation
{
    public function validateSpamCop($attribute, $value, $parameters, $validator)
    {
        $spam = Lang::get('spamwords');
        if (preg_match('/^[a-zA-ZäöüÄÖÜ0-9 \.\-\,]+$/i', $value)) {
            return true;
        }
        return false;
    }

    /**
     * Super Strenges Password
     * @param $attribute
     * @param $value
     * @param $parameters
     * @param $validator
     * @return bool
     */
    public function validateSystemPassword($attribute, $value, $parameters, $validator)
    {
        if (preg_match('/^(?=^.{8,}$)(?=.*\d)(?=.*[!@#$%^\-\+*]+)(?![.\n])(?=.*[A-Z])(?=.*[a-z]).*$/', $value)) {
            return true;
        }
        return false;
    }

    /***
     * @param $attribute
     * @param $value
     * @param $parameters
     * @param $validator
     * @return bool
     */
    public function validateName($attribute, $value, $parameters, $validator)
    {
        if (preg_match('/^[a-zA-ZäöüÄÖÜ \.\-\,]+$/', $value)) {
            return true;
        }
        return false;
    }

    /***
     * @param $attribute
     * @param $value
     * @param $parameters
     * @param $validator
     * @return bool
     */
    public function validateNameFull($attribute, $value, $parameters, $validator)
    {
        if (
            preg_match(
                '/^[a-zA-ZàáâäãåèéêëìíîïòóôöõøùúûüÿýñçšžÀÁÂÄÃÅÈÉÊËÌÍÎÏÒÓÔÖÕØÙÚÛÜŸÝÑßÇOEÆŠŽð ,.\'-]+$/u',
                $value
            )
        ) {
            return true;
        }
        return false;
    }

    /***
     * @param $attribute
     * @param $value
     * @param $parameters
     * @param $validator
     * @return bool
     */
    public function validateStreetHo($attribute, $value, $parameters, $validator)
    {
        if (preg_match('/^[a-zA-ZäöüÄÖÜ \.\-]+ [0-9]+[a-zA-Z]?+$/', $value)) {
            return true;
        }
        return false;
    }

    /***
     * @param $attribute
     * @param $value
     * @param $parameters
     * @param $validator
     * @return bool
     */
    public function validateStreet($attribute, $value, $parameters, $validator)
    {
        if (preg_match('/^[a-z0-9äöüß \-\.\,\s]+$/i', $value)) {
            return true;
        }
        return false;
    }

    /***
     * @param $attribute
     * @param $value
     * @param $parameters
     * @param $validator
     * @return bool
     */
    public function validateHouseNo($attribute, $value, $parameters, $validator)
    {
        if (preg_match('/^[1-9][0-9]*[a-z]?(\s*(\/|-)\s*[1-9][0-9]*[a-z])?$/i', $value)) {
            return true;
        }
        return false;
    }

    /***
     * @param $attribute
     * @param $value
     * @param $parameters
     * @param $validator
     * @return bool
     */
    public function validateZipCode($attribute, $value, $parameters, $validator)
    {
        if (preg_match('/^([0]{1}[1-9]{1}|[1-9]{1}[0-9]{1})[0-9]{3}$/i', $value)) {
            return true;
        }
        return false;
    }

    /***
     * @param $attribute
     * @param $value
     * @param $parameters
     * @param $validator
     * @return bool
     */
    public function validateCity($attribute, $value, $parameters, $validator)
    {
        if (preg_match('/^[a-z0-9äöüßéèâ \-\.\,\s]+$/i', $value)) {
            return true;
        }
        return false;
    }

    /***
     * @param $attribute
     * @param $value
     * @param $parameters
     * @param $validator
     * @return bool
     */
    public function validatePhoneNumber($attribute, $value, $parameters, $validator)
    {
        if (preg_match('/^(0049|0|\+49)[0-9]+$/i', $value)) {
            return true;
        }
        return false;
    }

    /***
     * @param $attribute
     * @param $value
     * @param $parameters
     * @param $validator
     * @return bool
     */
    public function validateGermanMobilePhone($attribute, $value, $parameters, $validator)
    {
        if (preg_match('/^(\+49|0049|0)1[5-7][0-9]{6,9}$/', $value)) {
            return true;
        }
        return false;
    }
}
