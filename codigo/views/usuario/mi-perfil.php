<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\Usuario $model */

$this->title = 'Mi Perfil';
?>
<h1><?= Html::encode($this->title) ?></h1>

<p>Nombre de usuario: <?= Html::encode($model->nick) ?></p>
<p>Email: <?= Html::encode($model->email) ?></p>
<p>Nombre: <?= Html::encode($model->nombre) ?></p>
<p>Apellidos: <?= Html::encode($model->apellidos) ?></p>
<p>Fecha de nacimiento: <?= Html::encode($model->fecha_nacimiento) ?></p>
<p>Ubicación: <?= Html::encode($model->ubicacion) ?></p>
<p>Activo: <?= Html::encode($model->activo) ?></p>
<p>Fecha de registro: <?= Html::encode($model->fecha_registro) ?></p>
<p>Registro confirmado: <?= Html::encode($model->registro_confirmado) ?></p>
<p>Revisado: <?= Html::encode($model->revisado) ?></p>
<p>Último acceso: <?= Html::encode($model->ultimo_acceso) ?></p>
<h2>Cambiar Contraseña</h2>
<?php $form = ActiveForm::begin(['id' => 'changePasswordForm']); ?>
<?= $form->field($model, 'currentPassword')->passwordInput()->label('Contraseña Actual') ?>
<?= $form->field($model, 'newPassword')->passwordInput()->label('Nueva Contraseña') ?>
<?= $form->field($model, 'confirmNewPassword')->passwordInput()->label('Confirmar Nueva Contraseña') ?>
<div class="form-group">
    <?= Html::submitButton('Cambiar Contraseña', ['class' => 'btn btn-primary']) ?>
</div>
<?php ActiveForm::end(); ?>

<h2>Cambiar Correo Electrónico</h2>
<?php $form = ActiveForm::begin(['id' => 'changeEmailForm']); ?>
<?= $form->field($model, 'newEmail')->input('email')->label('Nuevo Correo Electrónico') ?>
<?= $form->field($model, 'confirmNewEmail')->input('email')->label('Confirmar Nuevo Correo Electrónico') ?>
<div class="form-group">
    <?= Html::submitButton('Cambiar Correo Electrónico', ['class' => 'btn btn-primary']) ?>
</div>
<?php ActiveForm::end(); ?>
