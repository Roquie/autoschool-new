<?php defined('SYSPATH') or die('No direct script access.');

return array(
    'default' => array
    (
        'type'       => 'MySQL',
        'connection' => array(
            'hostname'   => 'localhost',
            'username'   => 'rootuser',
            'password'   => 'root',
            'persistent' => FALSE,
            'database'   => 'autoschool',
        ),
        'table_prefix' => '',
        'charset'      => 'utf8',
        'profiling'    => true,

    ),

);