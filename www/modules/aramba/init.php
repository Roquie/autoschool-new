<?php
/**
 * Developer: Roquie
 * Current file name: init.php
 * 
 * All rights reserved (c)
 */

Route::set('aramba', 'aramba(/<action>(/<id>))')
    ->defaults(array(
        'controller' => 'Aramba',
        'action' => 'send_sms',
    ));