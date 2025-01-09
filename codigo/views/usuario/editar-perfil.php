<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\Usuario $model */

$this->title = 'Editar Perfil';
?>
<div class="usuario-editar-perfil">
    <h1><?= Html::encode($this->title) ?></h1>

    <div class="usuario-form">
        <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($model, 'newEmail')->textInput(['maxlength' => true])->label('Nuevo Email') ?>
        <?= $form->field($model, 'confirmNewEmail')->textInput(['maxlength' => true])->label('Confirmar nuevo Email') ?>

        <hr>

        <?= $form->field($model, 'currentPassword')->passwordInput()->label('Contraseña actual')?>
        <?= $form->field($model, 'newPassword')->passwordInput()->label('Nueva contraseña')?>
        <?= $form->field($model, 'confirmNewPassword')->passwordInput()->label('Confirmar nueva contraseña')?>
        

        <div class="form-group mt-2">
            <?= Html::submitButton('Guardar', ['class' => 'btn btn-success']) ?>
            <?= Html::a('Cancelar', ['mi-perfil'], ['class' => 'btn btn-danger', 'name'=>'submit-button', 'value'=>'cambiarAll']) ?>
        </div>

        <?php ActiveForm::end(); ?>
    </div>
    <br>
</div>
