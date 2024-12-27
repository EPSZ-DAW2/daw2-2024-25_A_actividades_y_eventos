<?php

/** @var yii\web\View $this */

use yii\bootstrap5\Nav;
use yii\bootstrap5\NavBar;
use yii\helpers\Html;

$this->title = 'Vista Privada';
?>

<?php
NavBar::begin([
    'brandLabel' => 'Inicio',
    'brandUrl' => Yii::$app->homeUrl,
    'options' => [
        'class' => 'navbar navbar-expand-lg navbar-light bg-light',
    ],
]);

echo Nav::widget([
    'options' => ['class' => 'navbar-nav'],
    'items' => [
        ['label' => 'Home', 'url' => ['/site/index']],
        ['label' => 'Actividades', 'url' => ['/actividades/view']],
        ['label' => 'Patrocinadores', 'url' => ['/patrocinio/index']]
    ],
]);

NavBar::end();
?>

<div class="site-privada">
    <h1><?= Html::encode($this->title) ?></h1>
    <p>Esta es una vista privada.</p>
</div>