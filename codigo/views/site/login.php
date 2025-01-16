<?php

/** @var yii\web\View $this */
/** @var yii\bootstrap5\ActiveForm $form */
/** @var app\models\LoginForm $model */

use yii\bootstrap5\ActiveForm;
use yii\bootstrap5\Html;

$this->title = 'Inicio de sesión';

// Estilos del Formulario

$this->registerCssFile('@web/css/estiloFormularios.css', [
    'depends' => [\yii\bootstrap5\BootstrapAsset::class],
]);
?>

<div class="site-login">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>Por favor, rellene este formulario para iniciar sesión:</p>

    <?php $form = ActiveForm::begin([
        'id' => 'login-form',
        'layout' => 'horizontal',
        'fieldConfig' => [
            'template' => "{label}\n<div>{input}</div>\n<div>{error}</div>",
            'labelOptions' => ['class' => 'col-form-label'],
            'inputOptions' => ['class' => 'form-control'], 
            'errorOptions' => ['class' => 'invalid-feedback'],
        ],
    ]); ?>

    <div class="form-group1">
        <?= $form->field($model, 'username')->textInput([
            'autofocus' => true,
            'placeholder' => 'Nombre de usuario',
        ]) ?>
    </div>

    <div class="form-group1">
        <?= $form->field($model, 'password')->passwordInput([
            'placeholder' => 'Contraseña',
        ]) ?>
    </div>

    <div class="form-group">
        <?= $form->field($model, 'rememberMe')->checkbox([
        'value' => 0, 
        'checked' => false, 
        'template' => "<div class=\"custom-control custom-checkbox\">{input} {label}</div>\n<div>{error}</div>",
        ]) ?>
    </div>

    <div class="form-group">
        <?= Html::submitButton('INICIAR SESION', [
            'class' => 'btn btn-primaryy',
            'name' => 'login-button',
        ]) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>

