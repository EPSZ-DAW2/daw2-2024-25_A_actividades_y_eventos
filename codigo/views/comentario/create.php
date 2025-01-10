<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Comentario $model */

$this->title = Yii::t('app', 'Crear nuevo comentario');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Comentarios'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="comentario-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
