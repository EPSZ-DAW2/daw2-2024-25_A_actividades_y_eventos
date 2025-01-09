<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\UbicacionSearch $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="ubicacion-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'clase_de_ubicacion') ?>

    <?= $form->field($model, 'ubicacion_raiz') ?>

    <?= $form->field($model, 'notas') ?>

    <?= $form->field($model, 'direccion') ?>

    <?php // echo $form->field($model, 'notas_de_como_llegar') ?>

    <?php // echo $form->field($model, 'notas_de_donde_aparcar') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
