<?php

namespace App\Http\Controllers;

/**
 * Klasse zum Vergleichen nach Unterschieden
 *
 */
class Diff extends GroundController
{
    public function diff($old, $new)
    {
        $maxlen = 0;
        foreach ($old as $oindex => $ovalue) {
            $nkeys = array_keys($new, $ovalue);
            foreach ($nkeys as $nindex) {
                $matrix[$oindex][$nindex] = isset($matrix[$oindex - 1][$nindex - 1]) ?
                $matrix[$oindex - 1][$nindex - 1] + 1 : 1;
                if ($matrix[$oindex][$nindex] > $maxlen) {
                    $maxlen = $matrix[$oindex][$nindex];
                    $omax = $oindex + 1 - $maxlen;
                    $nmax = $nindex + 1 - $maxlen;
                }
            }
        }
        if ($maxlen === 0) {
            return array(array('d' => $old, 'i' => $new));
        }
        return array_merge($this->diff(array_slice($old, 0, $omax), array_slice($new, 0, $nmax)), array_slice($new, $nmax, $maxlen), Diff::diff(array_slice($old, $omax + $maxlen), array_slice($new, $nmax + $maxlen)));
    }

    public function htmlDiff($old, $new)
    {
        $ret = '';
        $diff = $this->diff(explode(' ', $old), explode(' ', $new));
        foreach ($diff as $k) {
            if (is_array($k)) {
                $ret .= (!empty($k['d']) ? "<del>" . implode(' ', $k['d']) . "</del> " : '') . (!empty($k['i']) ? "<ins>" . implode(' ', $k['i']) . "</ins> " : '');
            } else {
                $ret .= $k . ' ';
            }
        }
        return $ret;
    }

    public static function Diff_Check($text1, $text2, $trenner)
    {
        $array1 = explode(" ", str_replace(array("  ", "\r", "\n"), array(" ", "", ""), $text1));
        $array2 = explode(" ", str_replace(array("  ", "\r", "\n"), array(" ", "", ""), $text2));
        $max1 = count($array1);
        $max2 = count($array2);

        $start1 = $start2 = 0;
        $jump1 = $jump2 = 0;
        while ($start1 < $max1 && $start2 < $max2) {
            $pos11 = $pos12 = $start1;
            $pos21 = $pos22 = $start2;
            $diff2 = 0;
            // schaukel 1. Array hoch
            while ($pos11 < $max1 && $array1[$pos11] !== $array2[$pos21]) {
                ++$pos11;
            }
            // Ende des 1 Arrays erreicht ?
            if ($pos11 === $max1) {
                $start2++;
                continue;
            }
            // Gegenschaukel wenn übersprunge Wörter
            if (($diff1 = $pos11 - $pos21) > 1) {
                while ($pos22 < $max2 && $array1[$pos12] !== $array2[$pos22]) {
                    ++$pos22;
                }
                $diff2 = $pos22 - $pos12 + $jump2;
            }
            // Ende des 2 Arrays erreicht ?
            if ($pos22 === $max2) {
                $start1++;
                continue;
            }
            $diff1 += $jump1;
            // Auswertung der Schaukel
            if ($diff1 >= $diff2 && $diff2) {
                unset($array1[$pos12], $array2[$pos22]);
                $start1 = $pos12 + 1;
                $start2 = $pos22 + 1;
                $jump2 = $diff2;
            } else {
                unset($array1[$pos11], $array2[$pos21]);
                $start1 = $pos11 + 1;
                $start2 = $pos21 + 1;
                $jump1 = $diff1;
            }
        }
        $safe1 = explode(" ", $text1);
        reset($array1);
        while (list($key1, ) = each($array1)) {
            $safe1[$key1] = "<font color=green>" . $safe1[$key1] . "</font>";
        }
        $safe2 = explode(" ", $text2);
        reset($array2);
        while (list($key2, ) = each($array2)) {
            $safe2[$key2] = "<font color=red>" . $safe2[$key2] . "</font>";
        }
        $text1 = implode(" ", $safe1);
        $text2 = implode(" ", $safe2);
        if ($trenner != '' && $text1 != $text2) {
            return $text1 . $trenner . $text2;
        } elseif ($text1 != $text2) {
            return '<b>Alt: </b>' . $text1 . '<br><b>Neu: </b>' . $text2;
        } else {
            return '';
        }
        #return implode(" ", $safe1) . "<br><br><br>" . implode(" ", $safe2) . "<br><br>";
    }
}
