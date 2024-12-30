<?php
use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Usuario $model */

$this->title = 'Mi Perfil';
?>
<h1><?= Html::encode($this->title) ?></h1>

<p>Nombre de usuario: <?= Html::encode($model->nick) ?></p>
<p>Email: <?= Html::encode($model->email) ?></p>
