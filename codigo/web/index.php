<?php
//EPSZ-DAW2: Adaptación para cargar "vendor" en una ubicación compartida.

// comment out the following two lines when deployed to production
defined('YII_DEBUG') or define('YII_DEBUG', true);
defined('YII_ENV') or define('YII_ENV', 'dev');

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

$config = require dirname( __DIR__) . '/config/web.php';
//--echo '<pre>'; print_r( $config); echo '</pre>'; die();

(new yii\web\Application($config))->run();

