<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\Usuario $model */
/** @var ActiveForm $form */
?>
<div class="site-register">

    <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($model, 'fecha_nacimiento') ?>
        <?= $form->field($model, 'fecha_registro') ?>
        <?= $form->field($model, 'ultimo_acceso') ?>
        <?= $form->field($model, 'fecha_bloqueo') ?>
        <?= $form->field($model, 'activo') ?>
        <?= $form->field($model, 'registro_confirmado') ?>
        <?= $form->field($model, 'revisado') ?>
        <?= $form->field($model, 'intentos_acceso') ?>
        <?= $form->field($model, 'bloqueado') ?>
        <?= $form->field($model, 'notas') ?>
        <?= $form->field($model, 'nick') ?>
        <?= $form->field($model, 'password') ?>
        <?= $form->field($model, 'email') ?>
        <?= $form->field($model, 'nombre') ?>
        <?= $form->field($model, 'apellidos') ?>
        <?= $form->field($model, 'ubicacion') ?>
        <?= $form->field($model, 'motivo_bloqueo') ?>
    
        <div class="form-group">
            <?= Html::submitButton(Yii::t('app', 'Submit'), ['class' => 'btn btn-primary']) ?>
        </div>
    <?php ActiveForm::end(); ?>

</div><!-- site-register -->
