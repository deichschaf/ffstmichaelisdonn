<?php

namespace App\Http\Traits;

trait CalendarTrait
{
    /**
     * @param $year
     * @return bool|string
     */
    private static function checkYear($year)
    {
        if (!is_numeric($year)) {
            return date('Y');
        }
        if ($year < 2010 || $year > (date('Y') + 2)) {
            return date('Y');
        }
        return $year;
    }

    /**
     * @param $month
     * @return bool|string
     */
    private static function checkMonth($month)
    {
        if (!is_numeric($month)) {
            return date('m');
        }
        if ($month < 1 || $month > 12) {
            return date('m');
        }
        return $month;
    }

    /**
     * @param $year
     * @param $month
     * @param $day
     * @return bool|string
     */
    private static function checkDay($year, $month, $day)
    {
        if (!is_numeric($day)) {
            return date('d');
        }

        if ($day < 1 || $day > 31) {
            return date('d');
        }
        $day = date('d', mktime(0, 0, 0, $month, $day, $year));

        return $day;
    }

    /**
     * @param $year
     * @param $month
     * @param $day
     */
    public static function makeCalendar($year, $month, $day)
    {
        $year = CalendarTrait::checkYear($year);
        $month = CalendarTrait::checkMonth($month);
        if ($day != '') {
            $day = CalendarTrait::checkDay($year, $month, $day);
        }
    }
}
