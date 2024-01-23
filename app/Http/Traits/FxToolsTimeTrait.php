<?php

namespace App\Http\Traits;

use Date;
use Time;
use DateTime;

trait FxToolsTimeTrait
{
    public $start_date = '';
    public $end_date = '';

    /**
     * @param string|null $date
     * @return string|bool
     */
    private function getDateOnly(string|null $date): string|bool
    {
        if (preg_match('/([0-9]){4}-([0-9]){2}-([0-9]){2} ([0-9]){2}:([0-9]){2}:([0-9]){2}/mD', $date)) {
            $split = explode(' ', $date);
            return $split['0'];
        }
        if (preg_match('/([0-9]){4}-([0-9]){2}-([0-9]){2}/mD', $date)) {
            return $date;
        }
        return false;
    }

    /**
     * @param string|null $date
     * @return string|bool
     */
    private function getTimeOnly(string|null $date): string|bool
    {
        if (preg_match('/([0-9]){4}-([0-9]){2}-([0-9]){2} ([0-9]){2}:([0-9]){2}:([0-9]){2}/mD', $date)) {
            $split = explode(' ', $date);
            return $split['1'];
        }
        if (preg_match('/([0-9]){2}:([0-9]){2}:([0-9]){2}/mD', $date)) {
            return $date;
        }
        return false;
    }

    /**
     * @param string|null $date
     * @return string
     */
    public function getGermanDateFormat(string|null $date): string
    {
        if ($date === null) {
            return '';
        }
        $date = explode('-', $date);
        return $date['2'] . '.' . $date['1'] . '.' . $date['0'];
    }

    /**
     * @param string|null $time
     * @return string
     */
    public function getOnlyHourMinutes(string|null $time): string
    {
        if ($time === null) {
            return '';
        }
        $time = explode(':', $time);
        return $time['0'] . ':' . $time['1'];
    }

    /**
     * @param string|null $start
     * @param string|null $end
     * @return string
     */
    public function makeDatum(string|null $start = null, string|null $end = null): string
    {
        if ($start === null) {
            return '';
        }
        $date = [];
        $start = $this->getDateOnly($start);
        if ($start === false) {
            return '';
        }
        $date[] = $this->getGermanDateFormat($start);
        $end = $this->getDateOnly($end);
        if ($start !== $end) {
            if ($end !== false) {
                $date[] = $this->getGermanDateFormat($end);
            }
        }
        return implode(' - ', $date);
    }

    /**
     * @param string|null $start
     * @param string|null $end
     * @return string
     */
    public function makeZeit(string|null $start = null, string|null $end = null): string
    {
        if ($start === null || $start === '55:55:55') {
            return '';
        }
        $date = [];
        $start = $this->getTimeOnly($start);
        if ($start === false) {
            return '';
        }
        $date[] = $this->getOnlyHourMinutes($start);
        $end = $this->getTimeOnly($end);
        if ($start !== $end && $end !== '55:55:55') {
            if ($end !== false) {
                $date[] = $this->getOnlyHourMinutes($end);
            }
        }
        return implode(' - ', $date);
    }

    /**
     * @example echo makeDateDiff('w', '9 July 2003', '4 March 2004', false);
     * $interval can be:
     * yyyy - Number of full years
     * q - Number of full quarters
     * m - Number of full months
     * y - Difference between day numbers (eg 1st Jan 2004 is "1", the first day.
     * 2nd Feb 2003 is "33". The datediff is "-32".)
     * d - Number of full days
     * w - Number of full weekdays
     * ww - Number of full weeks
     * h - Number of full hours
     * n - Number of full minutes
     * s - Number of full seconds (default)
     */
    public function makeDateDiff($interval, $datefrom, $dateto, $using_timestamps = false): int
    {
        if (!$using_timestamps) {
            $datefrom = strtotime($datefrom, 0);
            $dateto = strtotime($dateto, 0);
        }
        $difference = $dateto - $datefrom; // Difference in seconds
        $months_difference = 0;
        switch ($interval) {
            case 'yyyy': // Number of full years
                $years_difference = floor($difference / 31536000);
                if (
                    mktime(
                        date('H', $datefrom),
                        date('i', $datefrom),
                        date('s', $datefrom),
                        date('n', $datefrom),
                        date('j', $datefrom),
                        date('Y', $datefrom)
                        + $years_difference
                    ) > $dateto
                ) {
                    --$years_difference;
                }
                if (
                    mktime(
                        date('H', $dateto),
                        date('i', $dateto),
                        date('s', $dateto),
                        date('n', $dateto),
                        date('j', $dateto),
                        date('Y', $dateto)
                        - ($years_difference + 1)
                    ) > $datefrom
                ) {
                    ++$years_difference;
                }
                $datediff = $years_difference;
                break;
            case 'q': // Number of full quarters
                $quarters_difference = floor($difference / 8035200);
                while (
                    mktime(
                        date('H', $datefrom),
                        date('i', $datefrom),
                        date('s', $datefrom),
                        date('n', $datefrom) + ($quarters_difference * 3),
                        date('j', $dateto),
                        date('Y', $datefrom)
                    ) < $dateto
                ) {
                    ++$months_difference;
                }
                --$quarters_difference;
                $datediff = $quarters_difference;
                break;
            case 'm': // Number of full months
                $months_difference = floor($difference / 2678400);
                while (
                    mktime(
                        date('H', $datefrom),
                        date('i', $datefrom),
                        date('s', $datefrom),
                        date('n', $datefrom) + ($months_difference),
                        date('j', $dateto),
                        date('Y', $datefrom)
                    ) < $dateto
                ) {
                    ++$months_difference;
                }
                --$months_difference;
                $datediff = $months_difference;
                break;
            case 'y': // Difference between day numbers
                $datediff = date('z', $dateto) - date('z', $datefrom);
                break;
            case 'd': // Number of full days
                $datediff = floor($difference / 86400);
                break;
            case 'w': // Number of full weekdays
                $days_difference = floor($difference / 86400);
                $weeks_difference = floor($days_difference / 7); // Complete weeks
                $first_day = date('w', $datefrom);
                $days_remainder = floor($days_difference % 7);
                $odd_days = $first_day + $days_remainder; // Do we have a Saturday or Sunday in the remainder?
                if ($odd_days > 7) {
                    // Sunday
                    --$days_remainder;
                }
                if ($odd_days > 6) {
                    // Saturday
                    --$days_remainder;
                }
                $datediff = ($weeks_difference * 5) + $days_remainder;
                break;
            case 'ww': // Number of full weeks
                $datediff = floor($difference / 604800);
                break;
            case 'h': // Number of full hours
                $datediff = floor($difference / 3600);
                break;
            case 'n': // Number of full minutes
                $datediff = floor($difference / 60);
                break;
            default: // Number of full seconds (default)
                $datediff = $difference;
                break;
        }

        return $datediff;
    }

    public function makeDateDifferenz($begin, $end, $round = 0)
    {
        $begin = explode(' ', $begin);
        $end = explode(' ', $end);
        $diff = strtotime($end['0']) - strtotime($begin['0']);
        $diff = $diff / 86400;
        if ('1' === $round) {
            $diff = ceil($diff);
        }

        return $diff;
    }

    public function checkTime($time)
    {
        $time = trim($time);
        $time = str_replace(',', '.', $time);
        $time = str_replace(';', '.', $time);
        if (strlen($time) <= 2) {
            if (is_numeric($time)) {
                $time = $time . ':00';

                return $time;
            } else {
                return '';
            }
        } else {
            $time = str_replace('.', ':', $time);
            $pattern = '/^(\d|[0-9][0-9]):(\d{2})$/';
            preg_match($pattern, $time, $match);
            if (is_array($match)) {
                if (count($match) > 2) {
                    $match = explode(':', $match['0']);
                    if ($match['0'] >= 0 && $match['0'] <= 23) {
                        if ($match['1'] >= 0 && $match['1'] <= 59) {
                            return $time;
                        } else {
                            $time = $match['0'] . ':00';

                            return $time;
                        }
                    } else {
                        return '';
                    }
                } else {
                    return '';
                }
            } else {
                return '';
            }
        }
    }

    /**
     * @param array $date
     * @param string $long
     * @return string
     */
    public function getDayofWeek($date = [], $long = 'short'): string
    {
        if ($long !== 'short') {
            return $this->getWeekname(date('w', mktime(0, 0, 0, $date['2'], $date['1'], $date['0'])));
        }
        return $this->getWeeknameShort(date('w', mktime(0, 0, 0, $date['2'], $date['1'], $date['0'])));
    }

    public function getWeekname($week)
    {
        $week = trim($week);
        switch ($week) {
            case '0':
                $day = 'Sonntag';
                break;
            case '1':
                $day = 'Montag';
                break;
            case '2':
                $day = 'Dienstag';
                break;
            case '3':
                $day = 'Mittwoch';
                break;
            case '4':
                $day = 'Donnerstag';
                break;
            case '5':
                $day = 'Freitag';
                break;
            case '6':
                $day = 'Samstag';
                break;
            default:
                $day = $week;
        }
        return $day;
    }

    public function getWeeknameShort($week)
    {
        switch ($week) {
            case '0':
                $day = 'So';
                break;
            case '1':
                $day = 'Mo';
                break;
            case '2':
                $day = 'Di';
                break;
            case '3':
                $day = 'Mi';
                break;
            case '4':
                $day = 'Do';
                break;
            case '5':
                $day = 'Fr';
                break;
            case '6':
                $day = 'Sa';
                break;
            default:
                $day = $week;
        }
        return $day;
    }

    public function makeDatumCheck($Datum, $ZeitspanneBeginn, $ZeitspanneEnde)
    {
        $ZeitspanneBeginn = substr(
            $ZeitspanneBeginn,
            0,
            4
        ) * 10000 + substr(
            $ZeitspanneBeginn,
            5,
            2
        ) * 100 + substr($ZeitspanneBeginn, 8, 2);
        $ZeitspanneEnde = substr(
            $ZeitspanneEnde,
            0,
            4
        ) * 10000 + substr(
            $ZeitspanneEnde,
            5,
            2
        ) * 100 + substr($ZeitspanneEnde, 8, 2);
        $UmgewandeltesDatum = substr($Datum, 0, 4) * 10000 + substr($Datum, 5, 2) * 100 + substr($Datum, 8, 2);
        if ($UmgewandeltesDatum >= $ZeitspanneBeginn && $UmgewandeltesDatum <= $ZeitspanneEnde) {
            return '1';
        } else {
            return '0';
        }
    }

    /*
     *     public function makeDatumCheck($Datum, $ZeitspanneBeginn, $ZeitspanneEnde)
    {
        $ZeitspanneBeginn = substr(
            $ZeitspanneBeginn,
            0,
            4
        ) * 10000 +
            substr(
                $ZeitspanneBeginn,
                5,
                2
            ) * 100 +
            substr(
                $ZeitspanneBeginn,
                8,
                2
            );
        $ZeitspanneEnde = substr(
            $ZeitspanneEnde,
            0,
            4
        ) * 10000 +
            substr(
                $ZeitspanneEnde,
                5,
                2
            ) * 100 +
            substr(
                $ZeitspanneEnde,
                8,
                2
            );
        $UmgewandeltesDatum = substr($Datum, 0, 4) * 10000 + substr($Datum, 5, 2) * 100 + substr($Datum, 8, 2);
        if ($UmgewandeltesDatum >= $ZeitspanneBeginn && $UmgewandeltesDatum <= $ZeitspanneEnde) {
            return '1';
        } else {
            return '0';
        }
    }

     */

    /**
     * Prüfe ob das angegebene Datum einem waren Datum entspricht.
     *
     * @param string $d
     * @param string $m
     * @param string $y
     */
    public function makeCheckDatum($d, $m, $y)
    {
        $d = trim($d);
        $m = trim($m);
        $y = trim($y);
        if ((!is_numeric($d)) || (!is_numeric($m)) || (!is_numeric($y))) {
            echo '<p class="fehler">Bitte nur Zahlen verwenden!</p>';

            return false;
        }

        if ($d < 1 || $d > 31) {
            echo '<p class="fehler">Der Tag liegt ausserhalb von 1-31!</p>';

            return false;
        }
        if ($m < 1 || $m > 12) {
            echo '<p class="fehler">Der Monat liegt ausserhalb von 1-12!</p>';

            return false;
        }
        if ($y < 2000 || $y > 2050) {
            echo '<p class="fehler">Das Jahr liegt ausserhalb von 2000-2050!</p>';

            return false;
        }

        if (true === checkdate($m, $d, $y)) {
            return true;
        }
        echo '<p class="fehler">Das Datum "' . $d . '.' . $m . '.' . $y . '" gibt es nicht!</p>';

        return false;
    }

    public function makeDatumCheck2($datum)
    {
        $datum = trim($datum);
        $datum = str_replace(',', '.', $datum);
        $error = 0;
        $len = strlen($datum);
        if (10 === $len) {
            for ($x = 0; $x < $len; ++$x) {
                if (2 === $x or 5 === $x) {
                    if (' ' === $datum[$x] or '-' === $datum[$x] or '.' === $datum[$x]) {
                        $error = $error;
                    } else {
                        $error = 1;
                    }
                } else {
                    if (preg_match('|[0-9]|', $datum[$x])) {
                        $error = $error;
                    } else {
                        $error = 1;
                    }
                }
            }
        } else {
            $error = 1;
        }

        return $error;
    }

    public function makeStartDate()
    {
        $Tools = new Tools();

        return $Tools->getDatumEn($_REQUEST['von']);
    }

    public function makeEndDate()
    {
        $Tools = new Tools();

        return $Tools->getDatumEn($_REQUEST['bis']);
    }

    /**
     * Berechnung ob es sich um ein Schaltjahr handelt
     * @param $jahr
     * @return int|string
     */
    public function checkIsSchaltJahr($jahr)
    {
        $jahr = trim($jahr);
        if ('' === $jahr) {
            return -1;
        }
        if (0 === $jahr % 400) {
            return 1;
        } elseif (0 === $jahr % 4 && 0 !== $jahr % 100) {
            return 1;
        } else {
            return 0;
        }
    }


    public function makeTimePeriod()
    {
        if ('' !== $this->makeStartDate()) {
            if ($this->makeStartDate() === $this->makeEndDate()) {
                return 'day';
            }

            $start_date = explode('-', $this->makeStartDate());
            $end_date = explode('-', $this->makeEndDate());
            if ($start_date[0] === $end_date[0] && $start_date[1] === $end_date[1]) {
                return 'days';
            }

            if ($start_date[0] < $end_date[0]) {
                return 'month';
            }

            if (($end_date[1] - $start_date[1]) > 12) {
                return 'year';
            } else {
                return 'month';
            }
        } else {
            return 'year';
        }
    }

    public function makeTimePeriodArray()
    {
        /*
        if ($this->makeTimePeriod() === 'day')
        {
            $start=explode(":",$this->start_time());
            $end=explode(":",$this->end_time());

            $hour='';
            $start=$this->killFirstNull($start[0]);
            $end=$this->killFirstNull($end[0]);
            for($i=$start; $i<=$end; $i++)
            {
                $hour[]=array($i,$i,'');
            }
            $order_sales=$hour;
        }
        */
        if ('days' === $this->makeTimePeriod()) {
            $start = explode('-', $this->makeStartDate());
            $end = explode('-', $this->makeEndDate());

            $days = '';
            $start = $this->killFirstNull($start[2]);
            $end = $this->killFirstNull($end[2]);
            for ($i = $start; $i <= $end; ++$i) {
                //$days[]=array($i,$i,'');
                $days[] = [$i, ''];
            }
            $order_sales = $days;
        }
        if ('month' === $this->makeTimePeriod()) {
            $start = explode('-', $this->makeStartDate());
            $end = explode('-', $this->makeEndDate());

            $month = '';
            $start = $this->killFirstNull($start[1]);
            $end = $this->killFirstNull($end[1]);

            if ($start > $end) {
                if (12 === $start) {
                    $month[] = [12, ''];
                } else {
                    for ($i = $start; $i <= 12; ++$i) {
                        $month[] = [$i, ''];
                    }
                }
                if (12 === $end) {
                    $month[] = [12, ''];
                } else {
                    for ($i = 1; $i <= $end; ++$i) {
                        $month[] = [$i, ''];
                    }
                }
            } else {
                for ($i = $start; $i <= $end; ++$i) {
                    //$month[]=array($i,$i,'');
                    $month[] = [$i, ''];
                }
            }
            $order_sales = $month;
        }
        if ('year' === $this->makeTimePeriod()) {
            for ($i = 2006; $i <= date('Y'); ++$i) {
                //$array[]=array($i, $i, '');
                $array[] = [$i, ''];
            }
            $order_sales = $array;
        }

        return $order_sales;
    }

    public function killFirstNull($number)
    {
        $number = trim($number);
        $number = str_replace('00', '0', $number);
        $number = str_replace('01', '1', $number);
        $number = str_replace('02', '2', $number);
        $number = str_replace('03', '3', $number);
        $number = str_replace('04', '4', $number);
        $number = str_replace('05', '5', $number);
        $number = str_replace('06', '6', $number);
        $number = str_replace('07', '7', $number);
        $number = str_replace('08', '8', $number);
        $number = str_replace('09', '9', $number);

        return $number;
    }

    /**
     * Generiert aus einem Sekundenstring ein Stunden Minuten Array.
     *
     * @param string $seconds
     *
     * @return array
     *
     * @example
     *   $seconds = 2953847;
     *   print_r( timespanArray( $seconds ) );
     *  Array
     * (
     *   [total] => 2953847
     *  [sec] => 47
     *  [min] => 30
     *  [std] => 4
     *  [day] => 34
     * )
     */
    public function timespanArray($seconds)
    {
        $seconds = trim($seconds);
        $td = [];
        $td['total'] = $seconds;
        $td['sec'] = $seconds % 60;
        $td['min'] = (($seconds - $td['sec']) / 60) % 60;
        $td['std'] = (((($seconds - $td['sec']) / 60) - $td['min']) / 60) % 24;
        $td['day'] = floor(((((($seconds - $td['sec']) / 60) - $td['min']) / 60) / 24));
        // $td['day'] = ((((($seconds - $td['sec']) / 60) - $td['min']) / 60) / 24);

        return $td;
    }

    public function getZeitspanne($zeit1, $zeit2)
    {
        $zeit1 = trim($zeit1);
        $zeit2 = trim($zeit2);
        if ('' === $zeit1 || '' === $zeit2) {
            return '';
        }
        $zeit1 = explode(':', $zeit1);
        $zeit2 = explode(':', $zeit2);

        $tag = date('d');
        $monat = date('m');
        $jahr = date('Y');

        $z1h = $this->killFirstNull($zeit1['0']);
        $z1m = $this->killFirstNull($zeit1['1']);
        $z1s = $this->killFirstNull($zeit1['2']);
        $z2h = $this->killFirstNull($zeit2['0']);
        $z2m = $this->killFirstNull($zeit2['1']);
        $z2s = $this->killFirstNull($zeit2['2']);

        if ($zeit1['0'] > $zeit2['0']) {
            $zeit1 = mktime($z1h, $z1m, $z1s, $monat, $tag, $jahr);
            $zeit2 = mktime($z2h, $z2m, $z2s, $monat, $tag + 1, $jahr);
        } else {
            $zeit1 = mktime($z1h, $z1m, $z1s, $monat, $tag, $jahr);
            $zeit2 = mktime($z2h, $z2m, $z2s, $monat, $tag, $jahr);
        }
        return $zeit2 - $zeit1;
    }
}
