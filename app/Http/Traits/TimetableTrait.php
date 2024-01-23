<?php

namespace App\Http\Traits;

use App\Http\Models\TimeTable;

/***
 * Trait TimetableTrait
 * @package App\Http\Traits
 */
trait TimetableTrait
{
    public static function getStaticDays()
    {
        return ["", "Montag", "Dienstag", "Mittwoch", "Donnerstag", "Freitag", "Samstag", "Sonntag"];
    }

    public static function getStaticDayIds()
    {
        return ['1', '2', '3', '4', '5', '6', '7'];
    }

    public static function buildTimeTable($place_id = 1)
    {
        $days = self::getDayIds();

        $min = mktime(23, 59, 59, 1, 1, date('Y'));
        $next = mktime(23, 59, 59, 1, 1, date('Y'));
        $vorhanden = [];
        $i = 0;
        $plan = [];
        $TimeTable = TimeTable::where('place_id', '=', $place_id)
            ->orderBy('day', 'ASC')
            ->get();
        $TimeTable->each(function ($tt) use (&$plan, &$i, &$min, &$next, &$vorhanden) {
            $description = $tt->description;
            if ($tt->trainer !== '' && $tt->trainer !== 'NULL' && $tt->trainer !== null) {
                $description .= "<br>" . $tt->trainer;
            }
            if ($tt->period !== '' && $tt->period !== 'NULL' && $tt->period !== null) {
                $description .= "<br><i>" . $tt->period . "</i>";
            }
            if ($tt->sub_description !== '' && $tt->sub_description !== 'NULL' && $tt->sub_description !== null) {
                $description .= "<br>" . $tt->sub_description;
            }
            $plan[] = array(
                'ID' => $i,
                'Belegung' => $description,
                'Start' => FxToolsTrait::zeit_static($tt->begin),
                'End' => FxToolsTrait::zeit_static($tt->end),
                'day' => $tt->day
            );
            $start = self::getStamp($tt->begin);
            $end = self::getStamp($tt->end);
            if ($start < $min) {
                $min = $start;
            }
            if ($end < $next) {
                $next = $end;
            }
            $vorhanden[] = $tt->day;
            $i++;
        });


        foreach ($days as $key => $val) {
            if (in_array($val, $vorhanden)) {
                unset($days[$key]);
            }
        }

        if (count($days) > 0) {
            foreach ($days as $key => $val) {
                $plan[] = array(
                    'ID' => '',
                    'Belegung' => 'FREI',
                    'Start' => date('H:i', $min),
                    'End' => date('H:i', $next),
                    'day' => $val
                );
            }
        }
        return self::makeTimeTableOutput($plan);
    }

    private static function makeTimeTableOutput($plan)
    {
        $timetable = [];  // der Stundenplan
        $times = [];       // alle Zeitspannen die im Stundenplan vorkommen
        $multible = []; // wieviel Veranstaltungen passieren an einem Tag maximal parallel
        $double = [];

        // Daten einlesen
        foreach ($plan as $key => $value) {
            $neuepos = count($timetable);
            $timetable[$neuepos]['ID'] = $value['ID'];
            if (isset($double[$timetable[$neuepos]['ID']])) {
                $double[$timetable[$neuepos]['ID']]++;
            } else {
                $double[$timetable[$neuepos]['ID']] = 1;
            }
            $timetable[$neuepos]['Belegung'] = $value['Belegung'];
            $timetable[$neuepos]['Start'] = $value['Start'];
            $timetable[$neuepos]['End'] = $value['End'];
            if (($value['day'] < 1) || ($value['day'] > 6)) {
                $value['day'] = 7;
            }
            $timetable[$neuepos]['Wochentag'] = $value['day'];
            $times = self::makeUpdateTimes($times, $timetable[$neuepos]['Start'], $timetable[$neuepos]['End']);
        }

        $times = self::makeAddPausen($times);
        $multible = self::mehrbelegung($timetable, $times);

        // Wie oft kommt jede Veranstaltung vor?
        for ($i1 = 0; $i1 < count($timetable); $i1++) {
            $timetable[$i1]['doppelt'] = $double[$timetable[$i1]['ID']];
        }
        unset($double);

        $dayssnamen = self::getDays();

        // Tabelle ausgeben
        $tmp_txt = '';
        $tmp_txt .= '<table border="0" cellspacing="0" cellpadding="0" class="liste">' . "\n";
        $tmp_txt .= ' <tr>' . "\n";
        if (count($times) > 0) {
            $tmp_txt .= '  <th class="bgueberschrift">Zeiten</th>' . "\n";
        } else {
            $tmp_txt .= '  <th>Leerer Stundenplan</th>' . "\n";
        }
        // Nur belegte Tage ausgeben, Spalten breit genug machen
        for ($i1 = 1; $i1 <= 7; $i1++) {
            if ($multible[$i1] > 0) {
                $tmp_txt .= '  <th colspan="' . $multible[$i1] . '" class="bgueberschrift" width="106">' . $dayssnamen[$i1] . '</th>' . "\n";
            }
        }
        $tmp_txt .= ' </tr>' . "\n";
        // Jeder period ist eine Zeile
        for ($i1 = 0; $i1 < count($times); $i1++) {
            $tmp_txt .= ' <tr>' . "\n";
            ;
            $tmp_txt .= '  <td class="bgueberschrift">';
            $tmp_txt .= $times[$i1]['Start'] . " - " . $times[$i1]['End'];
            $tmp_txt .= '  </td>' . "\n";
            ;
            // Jeder Tag ist eine Spalte
            for ($i3 = 1; $i3 <= 7; $i3++) {
                // Alle Faecher durchsuchen
                for ($i2 = 0; $i2 < count($timetable); $i2++) {
                    if (($i3 === $timetable[$i2]['Wochentag']) && (self::makeStartTimes($times, $i1, $timetable[$i2]['Start']))) {
                        if ($timetable[$i2]['Belegung'] !== 'FREI') {
                            $tmp_txt .= '  <td class="bgdunkel" rowspan="' . self::makeSizeOfTimes($times, $timetable[$i2]['Start'], $timetable[$i2]['End']) . '">' . "\n";
                            $tmp_txt .= self::printentry($timetable, $i2);
                            $tmp_txt .= "  </td>" . "\n";
                        } else {
                            $tmp_txt .= '  <td class="bghell" rowspan="' . self::makeSizeOfTimes($times, $timetable[$i2]['Start'], $timetable[$i2]['End']) . '">' . "\n";
                            $tmp_txt .= '&nbsp;';
                            $tmp_txt .= "  </td>" . "\n";
                        }
                    }
                }
                // gegebenenfalls Spalte mit leeren Zellen auffuellen
                for ($i4 = 0; $i4 < ($multible[$i3] - self::makeMehrBelegungProPeriod($timetable, $times, $i1, $i3)); $i4++) {
                    $tmp_txt .= '<td>&nbsp;</td>';
                }
            }
            $tmp_txt .= ' </tr>' . "\n";
        }
        $tmp_txt .= '</table>' . "\n";
        return $tmp_txt;
    }

    /***
     * @param $times
     * @param $von
     * @param $bis
     * @return int
     * gibt es die Zeitspanne schon?
     */
    private static function makeUniqTimes($times, $von, $bis)
    {
        for ($i1 = 0; $i1 < count($times); $i1++) {
            if (($times[$i1]['Start'] === $von) && ($times[$i1]['End'] === $bis)) {
                return $i1;
            }
        }
        return -1;
    }

    /***
     * @param $times
     * @param $pos
     * @param $von
     * @param $bis
     * @return bool
     * liegt der period 'pos' zwischen 'Start' und 'End'
     */
    private static function makeWithinTimes($times, $pos, $von, $bis)
    {
        if (($pos >= 0) && ($pos < count($times))) {
            if (($times[$pos]['Start'] >= $von) && ($times[$pos]['End'] <= $bis)) {
                return true;
            }
        }
        return false;
    }

    /***
     * @param $times
     * @param $pos
     * @param $von
     * @return bool
     * ist der period pos derjenige, der mit 'Start' startet?
     */
    private static function makeStartTimes($times, $pos, $von)
    {
        // guelltiges pos?
        if (($pos >= 0) && ($pos < count($times))) {
            // Startzeiten stimmen?
            if ($times[$pos]['Start'] === $von) {
                // und der period davor wuerde nicht passen?
                if (($pos === 0) || ($times[$pos - 1]['Start'] !== $von)) {
                    return true;
                }
            }
        }
        return false;
    }

    /***
     * @param $times
     * @param $von
     * @param $bis
     * @return int
     * wieviel Zeitspannen umfasst 'Start' -> 'End'?
     */
    private static function makeSizeOfTimes($times, $von, $bis)
    {
        $ergb = 0;
        for ($i1 = 0; $i1 < count($times); $i1++) {
            if (self::makeWithinTimes($times, $i1, $von, $bis)) {
                $ergb++;
            }
        }
        return $ergb;
    }

    /***
     * @param $times
     * @return mixed
     * zwischen nicht direkt anschliessendn Zeiten Pausen einfuegen
     */
    private static function makeAddPausen($times)
    {
        for ($i1 = 0; ($i1 + 1) < count($times); $i1++) {
            // Luecke zwischen 2 Zeiten ist neue Pause
            if ($times[$i1]['End'] !== $times[$i1 + 1]['Start']) {
                $times = self::add_times($times, $times[$i1]['End'], $times[$i1 + 1]['Start']);
            }
        }
        return $times;
    }

    /***
     * @param $timetable
     * @param $times
     * @param $pos
     * @param $tag
     * @return int
     * Findet raus wieviel Veranstaltungen zu einem gegeben Zeitpunkt gleichzeitg stattfinden
     */
    private static function makeMehrBelegungProPeriod($timetable, $times, $pos, $tag)
    {
        $anzahl = 0;
        // Gueltige pos?
        if (($pos >= 0) && ($pos < count($times))) {
            // alle Faecher ansehen
            for ($i1 = 0; $i1 < count($timetable); $i1++) {
                // wenn aktuelles Fach im period liegt +1
                if (($timetable[$i1]['Wochentag'] === $tag) && (self::makeWithinTimes($times, $pos, $timetable[$i1]['Start'], $timetable[$i1]['End']))) {
                    $anzahl++;
                }
            }
        }
        return $anzahl;
    }

    /***
     * @param $timetable
     * @param $times
     * @return array
     * stellt fuer jeden Tag fest wieviele Veranstaltungen maximal gleichzeitig stattfinden
     */
    private static function mehrbelegung($timetable, $times)
    {
        $multible = array("", 0, 0, 0, 0, 0, 0, 0);
        // alle Tage ansehen
        for ($i2 = 1; $i2 <= 7; $i2++) {
            $maxvalue = 0;
            // alle Zeitspannen ansehen
            for ($i1 = 0; $i1 < count($times); $i1++) {
                if ($maxvalue < self::makeMehrBelegungProPeriod($timetable, $times, $i1, $i2)) {
                    $maxvalue = self::makeMehrBelegungProPeriod($timetable, $times, $i1, $i2);
                }
            }
            $multible[$i2] = $maxvalue;
        }
        return $multible;
    }

    /***
     * @param $times
     * @param $von
     * @param $bis
     * @return mixed
     * bekommt eine Zeitspanne, die in eine Liste einsortiert wird, falls sie dort nicht schon enthalten ist
     */
    private static function add_times($times, $von, $bis)
    {
        // Eintrag schon vorhanden?
        if (self::makeUniqTimes($times, $von, $bis) !== -1) {
            return $times;
        } else {
            // Eintrag hinten anfuegen
            $pos = count($times);
            $times[$pos]['Start'] = $von;
            $times[$pos]['End'] = $bis;

            // Nach vorne sortieren
            for ($pos = (count($times) - 1); $pos > 0; $pos--) {
                if (($times[$pos - 1]['Start'] > $times[$pos]['Start']) || (($times[$pos - 1]['Start'] === $times[$pos]['Start']) && ($times[$pos - 1]['End'] > $times[$pos]['End']))) {
                    $tmp = $times[$pos - 1];
                    $times[$pos - 1] = $times[$pos];
                    $times[$pos] = $tmp;
                }
            }
            return $times;
        }
    }

    /***
     * @param $times
     * @param $von
     * @param $bis
     * @return mixed
     * Sorgt dafuer dass alle Zeitspannen so zerteilt werden dass sie sich nicht mehr ueberschneiden
     */
    private static function makeUpdateTimes($times, $von, $bis)
    {
        $bonusfeld = false; // muss ein zusaetzliches Feld erzeugt werden?
        $modified = false;  // mussten Zeiten veraendrt werden?

        // Neue Zeite mit allen anderen vergleichen und testen ob es irgendwo schneidet
        // Falls es schneidet Felder aufsplitten
        for ($i1 = 0; $i1 < count($times); $i1++) {
            // Faengt davor an ...
            if ($von < $times[$i1]['Start']) {
                // ... und endt leider nicht auch davor sondern ...
                if ($bis > $times[$i1]['Start']) {
                    // ... mittendrin, 3 Mengen bauen
                    if ($bis < $times[$i1]['End']) {
                        $bonus_von = $bis;
                        $bonus_bis = $times[$i1]['End'];
                        $times[$i1]['End'] = $bis;
                        $bis = $times[$i1]['Start'];
                        $bonusfeld = true;
                        $modified = true;
                    } // ... gleichzeitig, kleine Menge davor
                    elseif ($bis === $times[$i1]['End']) {
                        $bis = $times[$i1]['Start'];
                    } // ... endt hintendran, vorher und nacher neue Mengen
                    elseif ($bis > $times[$i1]['End']) {
                        $bonus_von = $times[$i1]['End'];
                        $bonus_bis = $bis;
                        $bis = $times[$i1]['Start'];
                        $bonusfeld = true;
                        $modified = true;
                    }
                }
            } // Faengt gleichzeitig an ...
            elseif ($von === $times[$i1]['Start']) {
                // ... beide sind nicht leer ...
                if (($von !== $bis) && ($times[$i1]['Start'] !== $times[$i1]['End'])) {
                    // ... und endt mittendrin, Menge halbieren
                    if ($bis < $times[$i1]['End']) {
                        $times[$i1]['Start'] = $bis;
                        $modified = true;
                    } // ... und endt hintendran, hinten Menge anhaengen
                    elseif ($bis > $times[$i1]['End']) {
                        $von = $times[$i1]['End'];
                        $modified = true;
                    }
                }
            } // Faengt dahinter an ...
            elseif ($von > $times[$i1]['Start']) {
                // ... und endt mittendrin, andere Zeit halbieren und davor und danach plazieren
                if ($bis < $times[$i1]['End']) {
                    $bonus_von = $bis;
                    $bonus_bis = $times[$i1]['End'];
                    $times[$i1]['End'] = $von;
                    $bonusfeld = true;
                    $modified = true;
                } // Hoeren gleichzeitig auf, Menge halbieren
                elseif ($bis === $times[$i1]['End']) {
                    $times[$i1]['End'] = $von;
                    $modified = true;
                } // ... und endt hintendran, 3 kleine Mengen
                elseif (($bis > $times[$i1]['End']) && ($von < $times[$i1]['End'])) {
                    $bonus_von = $times[$i1]['End'];
                    $bonus_bis = $bis;
                    $bis = $times[$i1]['End'];
                    $times[$i1]['End'] = $von;
                    $bonusfeld = true;
                    $modified = true;
                }
            }
        }

        if ($modified) { // die Zeitspanne wurde veraendrt, lieber nochmal durchschicken ob sie jetzt OK ist
            $times = self::makeUpdateTimes($times, $von, $bis);
            if ($bonusfeld) {
                $times = self::makeUpdateTimes($times, $bonus_von, $bonus_bis);
            }
        } else { // die Zeitpanne sind OK, abspeichern
            $times = self::add_times($times, $von, $bis);
            if ($bonusfeld) {
                $times = self::add_times($times, $bonus_von, $bonus_bis);
            }
        }
        return $times;
    }

    /***
     * @param $timetable
     * @param $nr
     * @return string
     * Gibt Eintrag aus
     */
    private static function printentry($timetable, $nr)
    {
        $tmp_txt = "";
        $tmp_txt .= '   ';
        $tmp_txt .= $timetable[$nr]['Belegung'];
        $tmp_txt .= "<br />\n";
        if ($timetable[$nr]['doppelt'] > 1) {
            $tmp_txt .= '(' . $timetable[$nr]['ID'] . ': 1/' . $timetable[$nr]['doppelt'] . ')' . "<br />\n";
        }
        return $tmp_txt;
    }

    /***
     * @param $belegung
     * @param $von
     * @param $bis
     * @param $wochentag
     * Erzeugt neuen Eintrag
     */
    private static function newentry($belegung, $von, $bis, $wochentag)
    {
        global $timetable;
        global $times;

        $neuepos = count($timetable);
        $timetable[$neuepos]['Belegung'] = $belegung;
        if ($bis < $von) {
            $bis = $von;
        }
        $timetable[$neuepos]['Start'] = $von;
        $timetable[$neuepos]['End'] = $bis;
        if (($wochentag < 1) || ($wochentag > 6)) {
            $wochentag = 7;
        }
        $timetable[$neuepos]['Wochentag'] = $wochentag;
        $times = self::makeUpdateTimes($times, $timetable[$neuepos]['Start'], $timetable[$neuepos]['End']);
    }

    /***
     * @param $time
     * @return false|int
     */
    private static function getStamp($time)
    {
        $time = explode(':', $time);
        $stamp = mktime($time['0'], $time['1'], $time['2'], 1, 1, 2012);
        return $stamp;
    }
}
