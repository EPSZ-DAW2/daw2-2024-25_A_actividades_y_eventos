<?php

$params = require __DIR__ . '/params.php';
$db = require __DIR__ . '/db.php';

$config = [
    'id' => 'basic',
    'name' => 'Actividades y eventos',
    'basePath' => dirname(__DIR__),
    'vendorPath' => implode( DIRECTORY_SEPARATOR, [ dirname( dirname( __DIR__)), 'librerias', 'vendor']),
    'bootstrap' => ['log'],
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'components' => [
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => 'EPSZ_DAW2_2024-25',
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'user' => [
            'identityClass' => 'app\models\Usuario',
            'enableAutoLogin' => true,
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'mailer' => [
            'class' => \yii\symfonymailer\Mailer::class,
            'viewPath' => '@app/mail',
            // send all mails to a file by default.
            'useFileTransport' => true,
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
        
        // Configuración de URL Manager
        'urlManager' => [
            'enablePrettyUrl' => true,  // Habilitar URLs amigables
            'showScriptName' => false,  // Ocultar 'index.php' en las URLs
            'rules' => [
                // Regla personalizada para acceder a index2.php
                'index2' => 'site/index2',  // Esto mapea 'index2' a 'site/index2'
                // Regla personalizada para acceder a mi perfil
                'perfil' => 'usuario/mi-perfil',  // Esto mapea 'mi-perfil' a 'usuario/mi-perfil'
                'gii' => 'gii/default/index',  // Esto mapea 'gii' al generador de código
            ],
        ],
    ],
    'params' => $params,
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        //'allowedIPs' => ['127.0.0.1', '::1'],
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        //'allowedIPs' => ['127.0.0.1', '::1'],
    ];
}

return $config;
