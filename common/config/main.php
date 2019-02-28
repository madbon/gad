<?php
return [
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'components' => [
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
    ],
    'modules' => [
        'user' => [
            'class' => 'niksko12\user\Module',
            'enableUnconfirmedLogin'=> true,
            'enableConfirmation' => false,
            'enableFlashMessages'=> false,
            'admins' => ['markbon'],
        ],
        'gii' => [
            'class' => 'yii\gii\Module',
            'allowedIPs' => ['127.0.0.1', '::1', '192.168.0.*', '192.168.178.20','192.168.83.*'] // adjust this to your needs
        ],
    ],

];
