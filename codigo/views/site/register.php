<?php

use yii\helpers\Html;
use yii\bootstrap5\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\Usuario $model */
/** @var ActiveForm $form */

$this->title = 'Registro de Usuario';
?>
<div class="site-register">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>Por favor, rellene los siguientes campos para registrarse:</p>

    <?php $form = ActiveForm::begin([
        'id' => 'register-form',
        'layout' => 'horizontal',
        'fieldConfig' => [
            'template' => "{label}\n<div class=\"col-lg-4\">{input}</div>\n<div class=\"col-lg-8\">{error}</div>",
            'labelOptions' => ['class' => 'col-lg-3 col-form-label'],
            'inputOptions' => ['class' => 'form-control'],
            'errorOptions' => ['class' => 'invalid-feedback'],
        ],
    ]); ?>

        <?= $form->field($model, 'nombre')->textInput(['autofocus' => true]) ?>
        <?= $form->field($model, 'apellidos') ?>
        <?= $form->field($model, 'email')->input('email') ?>
        <?= $form->field($model, 'nick') ?>
        <?= $form->field($model, 'password')->passwordInput() ?>
        <?= $form->field($model, 'fecha_nacimiento')->input('date') ?>

        <div class="form-group row">
            <div class="offset-lg-3 col-lg-4">
                <?= Html::submitButton(Yii::t('app', 'Registrarse'), ['class' => 'btn btn-primary', 'name' => 'register-button']) ?>
            </div>
        </div>

    <?php ActiveForm::end(); ?>
</div>