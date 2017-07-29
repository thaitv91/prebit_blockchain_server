<?php
$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);

return [
    'id' => 'app-frontend',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'controllerNamespace' => 'frontend\controllers',
    'components' => [
	 
        'request' => [
            'csrfParam' => '_csrf-frontend',       
        ],
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => true,
            'identityCookie' => ['name' => '_identity-frontend', 'httpOnly' => true],
        ],
		'languages' => [
            'class' => 'common\extensions\Languages',
        ],
        'session' => [
            // this is the name of the session cookie used for login on the frontend
            'name' => 'advanced-frontend',
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
		'urlManager' => [
            'class' => 'yii\web\UrlManager',
            'baseUrl' => 'http://system.pre-bit.org/',
            'showScriptName' => false, // Disable index.php
            'enablePrettyUrl' => true, // Disable r= routes
            'rules' => [
                '/' => 'site/index',
                'about' => 'site/about',
                'login' => 'site/login',
				'checkcode'=>'site/checkcode',
                'register' => 'site/register',
                'news/index' => 'newsmanagement/index',
                'sending/index' => 'sendhelp/index',
                'withdraw/index' => 'gethelp/index',
                'news/view/<id:\d+>' => 'newsmanagement/view',
                'charity-donation/index' => 'charitydonors/index',
                '<controller:\w+>/<action:\w+>/<id:\w+>' => '<controller>/<action>',
                '<controller:\w+>/<action:\w+>' => '<controller>/<action>',
            ]
        ],
		'redis' => [
            'class' => 'yii\redis\Connection',
            'hostname' => 'localhost',
            'port' => 6379,
            'database' => 0,
        ],
        'reCaptcha' => [
            'name' => 'reCaptcha',
            'class' => 'himiklab\yii2\recaptcha\ReCaptcha',
            'siteKey' => '6LfPxBkUAAAAAIyM9Ggckl8Sb1tVEp20ab03ugaC',
            'secret' => '6LfPxBkUAAAAAHEfZ6Wa9qk0PqlDu-I4XYWP0nEZ',
        ],
        'convert' => [
            'class' => 'frontend\components\Convert',
        ],
        'errorHandler' => [
            'errorAction' => 'site/404',
        ],
    ],
    'params' => $params,
];
