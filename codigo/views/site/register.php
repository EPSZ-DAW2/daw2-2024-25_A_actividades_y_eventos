<?php

/** @var yii\web\View $this */
/** @var yii\bootstrap5\ActiveForm $form */
/** @var app\models\Usuario $model */

use yii\bootstrap5\ActiveForm;
use yii\helpers\Html;

$this->title = 'Registro de usuario';

$this->registerCssFile('@web/css/estiloFormularios.css', [
    'depends' => [\yii\bootstrap5\BootstrapAsset::class],
]);

?>

<div class="site-login">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>Por favor, complete los siguientes campos para registrarse:</p>

    <?php $form = ActiveForm::begin([
        'id' => 'register-form',
        'layout' => 'horizontal',
        'fieldConfig' => [
            'template' => "<div>{label}</div><div>{input}</div><div>{error}</div>", // Asegura que las etiquetas se muestren
            'labelOptions' => ['class' => 'col-form-label'], // Etiqueta al lado
            'inputOptions' => ['class' => 'form-control'], // Asegura que los inputs tengan el ancho completo
            'errorOptions' => ['class' => 'invalid-feedback'],
        ],
    ]); ?>

    <!-- Campo Nombre -->
    <div class="form-group1">
        <?= $form->field($model, 'nombre')->textInput([
            'autofocus' => true,
            'placeholder' => 'Tu nombre',
        ]) ?>
    </div>

    <!-- Campo Apellidos -->
    <div class="form-group1">
        <?= $form->field($model, 'apellidos')->textInput([
            'placeholder' => 'Tus apellidos',
        ]) ?>
    </div>

    <!-- Campo Email -->
    <div class="form-group1">
        <?= $form->field($model, 'email')->input('email', [
            'placeholder' => 'Tu correo electrónico',
        ]) ?>
    </div>

    <!-- Campo Nick -->
    <div class="form-group1">
        <?= $form->field($model, 'nick')->textInput([
            'placeholder' => 'Tu nickname',
        ]) ?>
    </div>

    <!-- Campo Contraseña -->
    <div class="form-group1">
        <?= $form->field($model, 'password')->passwordInput([
            'placeholder' => 'Al menos 8 caracteres',
        ]) ?>
    </div>

    <!-- Campo Fecha de Nacimiento -->
    <div class="form-group1">
        <?= $form->field($model, 'fecha_nacimiento')->input('date') ?>
    </div>

    <!-- Botón Enviar -->
    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'REGISTRARSE'), [
            'class' => 'btn btn-primaryy',
            'name' => 'register-button',
        ]) ?>
    </div>

    <section class="form-group my-2">
        <p>Al registrarse, usted asume ser un usuario <strong>mayor de 16 años</strong> y acepta los <?= Html::a('términos y condiciones', ['site/politicaprivacidad']) ?></p>
    </section>

    <?php ActiveForm::end(); ?>
</div>
