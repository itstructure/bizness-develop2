<?php

$params = require __DIR__ . '/params.php';
$db = require __DIR__ . '/db.php';
$translations = require __DIR__ . '/translations.php';
$baseUrl = require __DIR__ . '/base-url.php';

$config = [
    'id' => 'yii2_template_multilanguage',
    'version' => '1.0.0',
    'basePath' => dirname(__DIR__),
    'homeUrl' => $baseUrl,
    'bootstrap' => ['log'],
    'language' => 'en-US',
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'components' => [
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => md5('ardGWC2D'),
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'user' => [
            'identityClass' => 'app\models\User',
            'enableAutoLogin' => true,
            //'loginUrl' => 'en/login'
        ],
        'authManager' => [
            'class' => 'yii\rbac\DbManager',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            // send all mails to a file by default. You have to set
            // 'useFileTransport' to false and configure a transport
            // for the mailer to send real emails.
            'useFileTransport' => false,
            'transport' => [
                'class' => 'Swift_SmtpTransport',
                'host' => 'smtp.gmail.com',
                'username' => 'packdevelop.info@gmail.com',
                'password' => 'hmuyzjvbkwsmizlk',
                'port' => '465',
                'encryption' => 'SSL',
            ],
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
        'db' => $db,
        'urlManager' => [
            'enablePrettyUrl' => true,
            'enableStrictParsing' => true,
            'showScriptName' => false,
            'normalizer' => [
                'class' => 'yii\web\UrlNormalizer',
                'action' => \yii\web\UrlNormalizer::ACTION_REDIRECT_TEMPORARY,
            ],
            'rules' => [

                /* DASHBOARD */
                '<shortLanguage:\w+>/admin' => 'admin/settings',
                '<shortLanguage:\w+>/<module:(admin|rbac)>/<controller>' => '<module>/<controller>/index',
                '<shortLanguage:\w+>/<module:(admin|rbac)>/<controller>/<action>' => '<module>/<controller>/<action>',

                /* OUTSIDE */
                '' => 'redirect/home-page',
                '<shortLanguage:\w+>' => '/home/index',
                '<shortLanguage:\w+>/logout' => 'site/logout',
                '<shortLanguage:\w+>/<action:(reg|login)>' => 'site/<action>',
                '<shortLanguage:\w+>/<controller:(contact|site)>/captcha' => '<controller>/captcha',
                '<shortLanguage:\w+>/<controller:(home|about|contact|site)>' => '<controller>/index',
                '<shortLanguage:\w+>/<controller:(page|category|article|product)>/<alias>' => '<controller>/view',
                '<controller:(ajax/feedback-ajax)>/<action:(send)>' => '<controller>/<action>',
                '<controller:(ajax/recaptcha-ajax)>/<action:(validate)>' => '<controller>/<action>',

                /* MFU Module */
                '<module:(mfuploader)>/<controller:(managers)>/<action:(filemanager|uploadmanager)>' => '<module>/<controller>/<action>',
                '<module:(mfuploader)>/<controller:(fileinfo)>' => '<module>/<controller>/index',
                '<module:(mfuploader)>/<controller:(fileinfo)>/<action:(index)>' => '<module>/<controller>/<action>',
                '<module:(mfuploader)>/<controller:(upload/local-upload|upload/s3-upload)>/<action:(send|update|delete)>' => '<module>/<controller>/<action>',
                '<shortLanguage:\w+>/<module:(mfuploader)>/<controller:(image-album|audio-album|video-album|application-album|text-album|other-album)>' => '<module>/<controller>/index',
                '<shortLanguage:\w+>/<module:(mfuploader)>/<controller:(image-album|audio-album|video-album|application-album|text-album|other-album)>/<action:(index|view|create|update|delete)>' => '<module>/<controller>/<action>',
            ],
        ],
        /*'assetManager' => [
            'linkAssets' => YII_DEBUG
        ],*/
        'i18n' => [
            'translations' => $translations
        ],
        /*'basket' => [
            'class' => app\components\BasketComponent::class,
            'modelClass' => app\models\Product::class,
            'modelAdditionKeys' => ['alias', 'title', 'description']
        ],*/
    ],
    'defaultRoute' => '/en/home/index',
    'params' => $params,
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        'allowedIPs' => ['127.0.0.1', '::1', '*'],
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        'allowedIPs' => ['127.0.0.1', '::1', '*'],
    ];
}

return $config;
