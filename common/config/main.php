<?php
return [
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'components' => [
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            'viewPath' => '@common/mail',
            'transport' => [
                'class' => 'Swift_SmtpTransport',
                'host' => 'mail.smtp2go.com',
                'username' => 'bitway',
                'password' => 'MHZla2V0M3U2cTN1',
                'port' => '2525',
                'encryption' => 'ssl',
            ],
            'messageConfig' => [
                    'charset' => 'UTF-8',
            ],
        ],
    ],
];
