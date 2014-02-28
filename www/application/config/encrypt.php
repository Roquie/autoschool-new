<?php defined('SYSPATH') OR die('No direct script access.');
// не знаю нахера нам encrypt, но вдруг понадобится для api
// http://kohanaframework.org/3.3/guide/kohana/security/encryption
return array(
    'default' => array(
        'key'   => '',
        'cipher' => MCRYPT_RIJNDAEL_256,
        'mode'   => MCRYPT_MODE_NOFB,
    ),
    'blowfish' => array(
        'key'    => 'O@J*HJKFHHFFF4╝48*1&%*hkjIU98O())_666◘5♦66☺9♠23☼8◄☻↨♦•1☺♣W1♣2☼☺39a☺☻◘6☺87♦1♣',
        'cipher' => MCRYPT_BLOWFISH,
        'mode'   => MCRYPT_MODE_ECB,
    ),

);
