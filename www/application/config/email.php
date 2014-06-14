<?php defined('SYSPATH') OR die('No direct access allowed.');

$setting = new Model_Settings();

if ($setting->get('smtp'))
{
    $option = json_decode($setting->get('smtp_data'));
    return array(
        'driver' => 'smtp',
        'options' => array(
            'hostname' => $option->server,
            'username' => $option->login,
            'password' => $option->password,
            'port' => $option->port
        )
    );
}
else
{
    return array(
        'driver' => 'native',
        'options' => NULL
    );
}
