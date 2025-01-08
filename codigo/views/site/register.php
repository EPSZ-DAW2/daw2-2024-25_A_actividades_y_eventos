<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\Usuario $model */
/** @var ActiveForm $form */

$this->title = 'Registro de Usuario';
?>
<div class="site-register d-flex justify-content-center align-items-center" style="min-height: 100vh;">

    <div class="w-50">
        <h2>Por favor, rellene los siguientes campos para registrarse:</h2>

        <?php $form = ActiveForm::begin([
            'id' => 'register-form',
            'fieldConfig' => [
                'template' => "{label}\n{input}\n{error}",
                'labelOptions' => ['class' => 'col-lg-2 col-form-label mb-1'],
                'inputOptions' => ['class' => 'w-100 form-control mb-1'],
                'errorOptions' => ['class' => 'col-lg-7 invalid-feedback'],
            ],
        ]); ?>
        <?= $form->field($model, 'nombre') ?>
        <?= $form->field($model, 'apellidos') ?>
        <?= $form->field($model, 'email')->input('email') ?>
        <?= $form->field($model, 'nick') ?>
        <?= $form->field($model, 'password')->passwordInput() ?>
        <?= $form->field($model, 'fecha_nacimiento')->input('date') ?>

        <div class="form-group">
            <?= Html::submitButton(Yii::t('app', 'Registrarse'), ['class' => 'btn btn-primary mt-2']) ?>
        </div>
        <?php ActiveForm::end(); ?>
    </div>

</div>