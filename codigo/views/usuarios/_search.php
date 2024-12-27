<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\UsuariosSearch $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="usuarios-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => [
            'data-pjax' => 1
        ],
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'nick') ?>

    <?= $form->field($model, 'contraseña') ?>

    <?= $form->field($model, 'email') ?>

    <?= $form->field($model, 'nombre') ?>

    <?php // echo $form->field($model, 'apellidos') ?>

    <?php // echo $form->field($model, 'fecha_nacimiento') ?>

    <?php // echo $form->field($model, 'direccion') ?>

    <?php // echo $form->field($model, 'ubicacion') ?>

    <?php // echo $form->field($model, 'activo') ?>

    <?php // echo $form->field($model, 'fecha_hora_registro') ?>

    <?php // echo $form->field($model, 'registro_confirmado') ?>

    <?php // echo $form->field($model, 'revisado') ?>

    <?php // echo $form->field($model, 'ultimo_acceso') ?>

    <?php // echo $form->field($model, 'intentos_acceso') ?>

    <?php // echo $form->field($model, 'bloqueado') ?>

    <?php // echo $form->field($model, 'fecha_hora_bloqueo') ?>

    <?php // echo $form->field($model, 'motivo_bloqueo') ?>

    <?php // echo $form->field($model, 'valoracion_usuario') ?>

    <?php // echo $form->field($model, 'notas') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
