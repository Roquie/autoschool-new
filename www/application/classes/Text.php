<?php defined('SYSPATH') OR die('No direct script access.');

class Text extends Kohana_Text
{



    public static function format_phone($phone)
    {
        $number = static::removeThanDigits($phone);

        return sprintf('+7 (%s) %s-%s-%s',
                        substr($number, 1, 3),
                        substr($number, 4, 3),
                        substr($number, 7, 2),
                        substr($number, 9, 2)
        );
    }



    /**
     * удаляет все, кроме цифр из строки
     * @param $str
     *
     * @return mixed
     */
    public static function removeThanDigits($str)
    {
        return preg_replace('/\D+/', '', $str);
    }



    /**
     * хэшируем, хэшируем ИБ гарантируем
     * @param $pass
     * @depricated
     * @return string
     */
    public static function hash($pass)
    {
        return hash_hmac('gost', $pass, 'bugaga-vlomaite-menya-polnostiu=▲♠');
    }

    /**
     * return Фамилия И.О.
     */
    public static function format_name($last_name, $first_name, $daddy_name)
    {
        return UTF8::ucfirst(UTF8::strtolower($last_name)).' '.
        UTF8::ucfirst(UTF8::strtolower(UTF8::substr($first_name, 0, 1).'. ')).' '.
        UTF8::ucfirst(UTF8::strtolower(UTF8::substr($daddy_name, 0, 1).'.'));
    }

    public static function translit($str)
    {
        $tr = array(
            "А"=>"A","Б"=>"B","В"=>"V","Г"=>"G",
            "Д"=>"D","Е"=>"E","Ж"=>"J","З"=>"Z","И"=>"I",
            "Й"=>"Y","К"=>"K","Л"=>"L","М"=>"M","Н"=>"N",
            "О"=>"O","П"=>"P","Р"=>"R","С"=>"S","Т"=>"T",
            "У"=>"U","Ф"=>"F","Х"=>"H","Ц"=>"TS","Ч"=>"CH",
            "Ш"=>"SH","Щ"=>"SCH","Ъ"=>"","Ы"=>"YI","Ь"=>"",
            "Э"=>"E","Ю"=>"YU","Я"=>"YA","а"=>"a","б"=>"b",
            "в"=>"v","г"=>"g","д"=>"d","е"=>"e","ж"=>"j",
            "з"=>"z","и"=>"i","й"=>"y","к"=>"k","л"=>"l",
            "м"=>"m","н"=>"n","о"=>"o","п"=>"p","р"=>"r",
            "с"=>"s","т"=>"t","у"=>"u","ф"=>"f","х"=>"h",
            "ц"=>"ts","ч"=>"ch","ш"=>"sh","щ"=>"sch","ъ"=>"y",
            "ы"=>"yi","ь"=>"","э"=>"e","ю"=>"yu","я"=>"ya"
        );
        return strtr($str, $tr);
    }

    /**
     * Проверка даты полученной из бд
     * @param $date
     * @return bool|null|string
     */
    public static function check_date($date)
    {
        return (empty($date) || $date == '0000-00-00' || $date == '1970-01-01') ? null : date('d.m.Y', strtotime($date));
    }

    /**
     * Преобразование даты для вставки в бд
     * @param $date
     * @return bool|string
     */
    public static function getDateUpdate($date)
    {
        return date('Y-m-d', strtotime($date));
    }
}
