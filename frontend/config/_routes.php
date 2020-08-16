<?php
/**
 * Created by PhpStorm.
 * User: antonfedorov
 * Date: 15/09/2019
 * Time: 11:22
 */

return [
    //    'product/<id:\d+>_<name>' => 'product/view',

    // Общие
    [
        'pattern' => '<controller>/<action>/<id:\d+>',
        'route'   => '<controller>/<action>',
    ],
    [
        'pattern' => '<controller>/<action>',
        'route'   => '<controller>/<action>',
    ],
    [
        'pattern' => '<module>/<controller>/<action>/<id:\d+>',
        'route'   => '<module>/<controller>/<action>',
    ],
    [
        'pattern' => '<module>/<controller>/<action>',
        'route'   => '<module>/<controller>/<action>',
    ],

    'anketa' => 'profile/sign-in',
    'set-nominations' => 'profile/sign-in-captain',
    '' => 'member/index',
];