<?php
//EPSZ-DAW2: Adaptación para cargar "vendor" en una ubicación compartida.

// NOTE: Make sure this file is not accessible when deployed to production
if (!in_array(@$_SERVER['REMOTE_ADDR'], ['127.0.0.1', '::1'])) {
    die('You are not allowed to access this file.');
}

defined('YII_DEBUG') or define('YII_DEBUG', true);
defined('YII_ENV') or define('YII_ENV', 'test');

$base= dirname( dirname( __DIR__)).'/librerias';
$requires= [ 
    [ $base, 'vendor', 'autoload.php']
  , [ $base, 'vendor', 'yiisoft', 'yii2', 'Yii.php']
];
foreach( $requires as $path) {
  $path= implode( DIRECTORY_SEPARATOR, $path);
  //print_r($path); echo '<br>';
  require $path;
}

$config = require dirname( __DIR__) . '/config/test.php';
//--echo '<pre>'; print_r( $config); echo '</pre>'; die();

(new yii\web\Application($config))->run();

