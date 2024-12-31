<?php
use yii\helpers\Html;

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

<?php $form = \yii\widgets\ActiveForm::begin([
    'id' => 'change-password-form',
    'options' => ['class' => 'form-horizontal'],
    'fieldConfig' => [
        'template' => "{label}\n<div class=\"col-lg-12\">{input}</div>\n<div class=\"col-lg-12\">{error}</div>",
        'labelOptions' => ['class' => 'col-lg-12 control-label'],
    ],
]); ?>

<?= $form->field($model, 'currentPassword')->passwordInput()->label('Contraseña Actual') ?>
<?= $form->field($model, 'newPassword')->passwordInput()->label('Nueva Contraseña') ?>
<?= $form->field($model, 'confirmNewPassword')->passwordInput()->label('Confirmar Nueva Contraseña') ?>
</br>
<div class="form-group">
    <div class="col-lg-12">
        <?= Html::submitButton('Cambiar Contraseña', ['class' => 'btn btn-primary']) ?>
    </div>
</div>

<?php \yii\widgets\ActiveForm::end(); ?>

</br>
<h2> Cambiar correo electrónico </h2>
<?php $form = \yii\widgets\ActiveForm::begin([
    'id' => 'change-email-form',
    'options' => ['class' => 'form-horizontal'],
    'fieldConfig' => [
        'template' => "{label}\n<div class=\"col-lg-12\">{input}</div>\n<div class=\"col-lg-12\">{error}</div>",
        'labelOptions' => ['class' => 'col-lg-12 control-label'],
    ],
]); ?>

<?= $form->field($model, 'newEmail')->input('email')->label('Nuevo Correo Electrónico') ?>
<?= $form->field($model, 'confirmNewEmail')->input('email')->label('Confirmar Nuevo Correo Electrónico') ?>
</br>
<div class="form-group">
    <div class="col-lg-12">
        <?= Html::submitButton('Cambiar Correo Electrónico', ['class' => 'btn btn-primary']) ?>
    </div>
</div>

<?php \yii\widgets\ActiveForm::end(); ?>



