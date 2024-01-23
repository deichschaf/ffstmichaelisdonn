<?php

namespace App\Http\Traits;

use App\Http\Models\Feuerwehrlexikon;
use App\Http\Models\Lexikon;
use App\Http\Models\LexikonKeywords;

trait TelLexikonTrait
{
    public static function search($search, $content)
    {
        $Query1 = Lexikon::where('eintrag', 'LIKE', $search . '%')->get();
        $Query2 = LexikonKeywords::where('keyword', 'LIKE', $search . '%')->get();
        if (count($Query1) === 0 && count($Query2) === 0) {
            return $content;
        }
        $data = array();
        $entries = array();
        $entries['0'] = TelLexikonTrait::getEntry($Query1);
        $entries['1'] = TelLexikonTrait::getKeyword($Query2);
        $data = [];
        $data['lexikon'] = TelLexikonTrait::buildLexikon($entries);
        $content[] = [
            'title' => 'TEL-Lexikon',
            'route' => 'lexikon',
            'content' => view('tel.lexikon_search')->with('data', $data)->render(),
        ];
        return $content;
    }

    private static function getChar()
    {
        $abc = array('0', 'A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z');
        return $abc;
    }

    private static function CheckChar($char)
    {
        $char = strtoupper($char);
        $abc = TelLexikonTrait::getChar();
        if (!in_array($char, $abc)) {
            return 'A';
        }
        return $char;
    }

    /**
     * @param $char
     * @return string
     */
    public static function tellexikon_show($char)
    {
        $char = TelLexikonTrait::CheckChar($char);
        $data = array();
        $data['lexikonnavi'] = TelLexikonTrait::ShowSelect($char);
        if ($char === 'A' || $char === 'O' || $char === 'U') {
            $data['lexikon'] = TelLexikonTrait::getSQLwithSpecialChar($char);
        } elseif ($char === '0') {
            $data['lexikon'] = TelLexikonTrait::getSQLwithNumber();
        } else {
            $data['lexikon'] = TelLexikonTrait::getSQL($char);
        }
        return view('tel.lexikon')->with('data', $data)->render();
    }

    private static function getSQL($char)
    {
        $Query1 = Lexikon::where('eintrag', 'LIKE', $char . '%')->get();
        $Query2 = LexikonKeywords::where('keyword', 'LIKE', $char . '%')->get();
        $data = array();
        $entries = array();
        $entries['0'] = TelLexikonTrait::getEntry($Query1);
        $entries['1'] = TelLexikonTrait::getKeyword($Query2);
        $data = TelLexikonTrait::buildLexikon($entries);
        return $data;
    }

    private static function getSQLwithSpecialChar($char)
    {
        if ($char === 'A') {
            $char_extra = 'Ä';
        }
        if ($char === 'O') {
            $char_extra = 'Ö';
        }
        if ($char === 'U') {
            $char_extra = 'Ü';
        }
        $Query1 = Lexikon::where('eintrag', 'LIKE', $char . '%')->whereOr('eintrag', 'LIKE', $char_extra . '%')->get();
        $Query2 = LexikonKeywords::where('keyword', 'LIKE', $char . '%')->whereOr('eintrag', 'LIKE', $char_extra . '%')->get();
        $data = array();
        $entries = array();
        $entries['0'] = TelLexikonTrait::getEntry($Query1);
        $entries['1'] = TelLexikonTrait::getKeyword($Query2);
        $data = TelLexikonTrait::buildLexikon($entries);
        return $data;
    }

    private static function getSQLwithNumber()
    {
        $Query1 = Lexikon::where('eintrag', 'LIKE', '0%')
                            ->whereOr('eintrag', 'LIKE', '1%')
                            ->whereOr('eintrag', 'LIKE', '2%')
                            ->whereOr('eintrag', 'LIKE', '3%')
                            ->whereOr('eintrag', 'LIKE', '4%')
                            ->whereOr('eintrag', 'LIKE', '5%')
                            ->whereOr('eintrag', 'LIKE', '6%')
                            ->whereOr('eintrag', 'LIKE', '7%')
                            ->whereOr('eintrag', 'LIKE', '8%')
                            ->whereOr('eintrag', 'LIKE', '9%')
                            ->get();
        $Query2 = LexikonKeywords::where('keyword', 'LIKE', '0%')
                            ->whereOr('eintrag', 'LIKE', '1%')
                            ->whereOr('eintrag', 'LIKE', '2%')
                            ->whereOr('eintrag', 'LIKE', '3%')
                            ->whereOr('eintrag', 'LIKE', '4%')
                            ->whereOr('eintrag', 'LIKE', '5%')
                            ->whereOr('eintrag', 'LIKE', '6%')
                            ->whereOr('eintrag', 'LIKE', '7%')
                            ->whereOr('eintrag', 'LIKE', '8%')
                            ->whereOr('eintrag', 'LIKE', '9%')
                            ->get();
        $data = array();
        $entries = array();
        $entries['0'] = TelLexikonTrait::getEntry($Query1);
        $entries['1'] = TelLexikonTrait::getKeyword($Query2);
        $data = TelLexikonTrait::buildLexikon($entries);
        return $data;
    }

    private static function buildLexikon($entries)
    {
        $data = array();
        if (count($entries['0']) > 0) {
            $data = $entries['0'];
        }
        $d = TelLexikonTrait::getKeyword($entries['1']);
        if (count($d) > 0) {
            if (count($data) === 0) {
                $data = $entries['1'];
            } else {
                foreach ($entries['1'] as $key => $val) {
                    $data[] = $val;
                }
            }
        }
        if (count($data) == 0) {
            return array();
        }
        asort($data);
        return $data;
    }

    private static function getEntry($Query)
    {
        if (count($Query) == 0) {
            return array();
        }
        $data = array();
        $Query->each(function ($d) use (&$data) {
            $data[] = array(
                'eintrag' => $d->eintrag,
                'beschreibung' => $d->beschreibung
            );
        });
        return $data;
    }
    private static function getKeyword($Query)
    {
        if (count($Query) == 0) {
            return array();
        }

        $data = array();
        foreach ($Query as $key => $val) {
            if (is_object($val)) {
                $keyword = $val->keyword;
                $beschreibung = $val->beschreibung;
                $data[] = array(
                    'eintrag' => $keyword,
                    'beschreibung' => $beschreibung
                );
            }
        }
        return $data;
    }

    public static function ShowSelect($char)
    {
        $data = array();
        $abc = TelLexikonTrait::getChar();
        foreach ($abc as $key => $val) {
            $select = '';
            if (strtolower($val) === $char) {
                $select = 'selected';
            }
            $data[] = array('char' => $val, 'selected' => $select);
        }
        return $data;
    }
}
