<?php defined('SYSPATH') OR die('No direct script access.');

class Date extends Kohana_Date
{
    /**
     * для месяцев на русском
     * @param     $param
     * @param int $time
     *
     * @return bool|string
     */
    public static function rdate($param, $time = 0)
    {
        if (intval($time) == 0) {
            $time = time();
        }
        $MonthNames = array("Январь", "Февраль", "Март", "Апрель", "Май", "Июнь", "Июль", "Август", "Сентябрь",
                            "Октябрь", "Ноябрь", "Декабрь");
        if (strpos($param, 'M') === false) {
            return date($param, $time);
        } else {
            return date(str_replace('M', $MonthNames[date('n', $time) - 1], $param), $time);
        }
    }
}
