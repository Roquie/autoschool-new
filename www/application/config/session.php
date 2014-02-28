<?php defined('SYSPATH') OR die('No direct script access.');

return array(
    'database' => array(
        'name' => 'session',
        'encrypted' => TRUE,
        'lifetime' => DATE::HOUR,
        'group' => 'default',
        'table' => 'sessions',
        'columns' => array(
            'session_id'  => 'session_id',
            'last_active' => 'last_active',
            'contents'    => 'contents'
        ),
        'gc' => 500,
    ),
);
