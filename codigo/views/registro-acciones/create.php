<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\RegistroAcciones $model */

$this->title = Yii::t('app', 'Create Registro Acciones');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Registro Acciones'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="registro-acciones-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
