<?php defined('SYSPATH') OR die('No direct script access.');

class HTML extends Kohana_HTML
{
    /**
     * js
     * @param string $file
     * @param array $attributes
     * @param null $protocol
     * @param bool $index
     * @return string
     */
    public static function script($file, array $attributes = NULL, $protocol = NULL, $index = FALSE)
    {
        if (strpos($file, '://') === FALSE)
            $file = URL::site('public/'.$file, $protocol, $index);

        $attributes['src'] = $file;
        //$attributes['defer'] = '';
        return '<script'.HTML::attributes($attributes).'></script>';
    }

    /**
     * css
     * @param string $file
     * @param array $attributes
     * @param null $protocol
     * @param bool $index
     * @return string
     */
    public static function style($file, array $attributes = NULL, $protocol = NULL, $index = FALSE)
    {
        if (strpos($file, '://') === FALSE)
            $file = URL::site('public/'.$file, $protocol, $index);

        $attributes['href'] = $file;
        $attributes['rel'] = empty($attributes['rel']) ? 'stylesheet' : $attributes['rel'];
        return '<link'.HTML::attributes($attributes).' />';
    }

}
































