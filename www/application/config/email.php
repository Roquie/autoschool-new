<?php defined('SYSPATH') OR die('No direct access allowed.');


$opt = Kohana::$config->load('settings.smtp');

if ($opt == '0')
{
    return array(
        'driver' => 'native',
        'options' => NULL
    );

}
else
{
    $smtp = unserialize($opt);
    return array(

        'driver' => 'smtp',
        'options' => array(

            //'hostname' => 'smtp.'.UTF8::strstr_after($smtp['login'], '@'), // вернет smtp.gmail.com
            'hostname' => $smtp['server'],
            'username' => $smtp['login'],
            'password' => $smtp['password'],
            'port' => $smtp['port']
        )

    );
}

/*
$opt = @Kohana::$config->load('settings.smtp');
$smtp = @unserialize($opt);

return array(
    'default' => array(
        'driver' => 'native',
        'options' => NULL
    ),
    'smtp' => array(
        'driver' => 'smtp',
        'options' => array(

            //'hostname' => 'smtp.'.UTF8::strstr_after($smtp['login'], '@'), // вернет smtp.gmail.com
            'hostname' => $smtp['server'],
            'username' => $smtp['login'],
            'password' => $smtp['password'],
            'port' => $smtp['port']
        )
    )

);
*/



