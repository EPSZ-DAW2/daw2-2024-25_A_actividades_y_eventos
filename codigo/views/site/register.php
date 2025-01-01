<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\Usuario $model */
/** @var ActiveForm $form */

$this->title = 'Registro de Usuario';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-register">
    <h1><?= Html::encode($this->title) ?></h1>

    <?php $form = ActiveForm::begin([
        'id' => 'register-form',
        'fieldConfig' => [
            'template' => "{label}\n{input}\n{error}",
            
            'inputOptions' => ['class' => 'col-lg-3 form-control'],
            'errorOptions' => ['class' => 'col-lg-7 invalid-feedback'],
        ],
    ]); ?>
    <?= $form->field($model, 'nombre') ?>
    <?= $form->field($model, 'apellidos') ?>
    <?= $form->field($model, 'email') ?>
    <?= $form->field($model, 'nick') ?>
    <?= $form->field($model, 'password') ?>

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
    <?= $form->field($model, 'ubicacion') ?>
    <?= $form->field($model, 'motivo_bloqueo') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Subir'), ['class' => 'btn btn-primary mt-2']) ?>
    </div>
    <?php ActiveForm::end(); ?>

</div>