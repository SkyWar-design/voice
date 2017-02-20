<?php
return [
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'language' => 'ru-RU',
    'components' => [
        'db' => [
            'class' => 'yii\db\Connection',
            'dsn' => 'mysql:host=localhost;dbname=voice',
            'username' => 'voice',
            'password' => 'voice',
            'charset' => 'utf8',
        ],

        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
    ],
];
