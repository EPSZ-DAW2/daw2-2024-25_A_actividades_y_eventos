<?php
use yii\widgets\ActiveForm;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\PatrocinadoresForm */

$this->title = 'Formulario de Patrocinador';
?>
<h2><?= Html::encode($this->title) ?></h2>

<div class="form">
    <?php $form = ActiveForm::begin([
        'id' => 'patrocinadores-form',
        'enableClientValidation' => true,
        'validateOnSubmit' => true,
    ]); ?>

    <?= $form->field($model, 'nick')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'password')->passwordInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'email')->input('email') ?>
    <?= $form->field($model, 'nombre')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'apellidos')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'fecha_nacimiento')->input('date') ?>
    <?= $form->field($model, 'ubicacion')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'activo')->checkbox() ?>
    <?= $form->field($model, 'fecha_registro')->input('date') ?>
    <?= $form->field($model, 'registro_confirmado')->checkbox() ?>
    <?= $form->field($model, 'revisado')->checkbox() ?>
    <?= $form->field($model, 'ultimo_acceso')->input('date') ?>
    <?= $form->field($model, 'intentos_acceso')->textInput(['type' => 'number']) ?>
    <?= $form->field($model, 'bloqueado')->checkbox() ?>
    <?= $form->field($model, 'fecha_bloqueo')->input('date') ?>
    <?= $form->field($model, 'motivo_bloqueo')->textarea(['rows' => 3]) ?>
    <?= $form->field($model, 'notas')->textarea(['rows' => 3]) ?>

    <div class="form-group">
        <?= Html::submitButton('Guardar', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>