<?php defined('SYSPATH') or die('No direct script access.');

return array(
    'default' => array
    (
        'type'       => 'MySQL',
        'connection' => array(
            'hostname'   => '5.101.153.30',
            'username'   => 'melnik5g_rqmpt',
            'password'   => '123qweasdzxc123',
            'persistent' => false,
            'database'   => 'melnik5g_rqmpt',
        ),
        'table_prefix' => '',
        'charset'      => 'utf8',
        'profiling'    => false,

    ),

    'localhost' => array
    (
        'type'       => 'MySQL',
        'connection' => array(
            'hostname'   => 'localhost',
            'username'   => 'rootuser',
            'password'   => 'root',
            'persistent' => false,
            'database'   => 'mpt_auto',
        ),
        'table_prefix' => '',
        'charset'      => 'utf8',
        'profiling'    => false,

    ),

);