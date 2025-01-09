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

        <?= $form->field($model, 'nick')->textInput(['maxlength' => true]) ?>
        <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>
        <?= $form->field($model, 'nombre')->textInput(['maxlength' => true]) ?>
        <?= $form->field($model, 'apellidos')->textInput(['maxlength' => true]) ?>

        <div class="form-group mt-2">
            <?= Html::submitButton('Guardar', ['class' => 'btn btn-success']) ?>
            <?= Html::a('Cancelar', ['mi-perfil'], ['class' => 'btn btn-danger', 'name'=>'submit-button', 'value'=>'cambiarAll']) ?>
        </div>

        <?php ActiveForm::end(); ?>
    </div>
    <br>
    
    <div class="container border border-dark p-3">
            <div class="row">


                <div class="col">
                    <h2>Cambiar Email</h2>

                    <?php $form = ActiveForm::begin([
                        'id' => 'change-email-form',
                        'options' => ['class' => 'form-horizontal'],
                        'fieldConfig' => [
                            'template' => "{label}\n<div class=\"col-lg-12\">{input}</div>\n<div class=\"col-lg-12\">{error}\n",
                            'labelOptions' => ['class' => 'col-lg-12 control-label'],
                        ],
                    ]); ?>

                    <?= $form->field($model, 'newEmail')->input('email')->label('Nuevo Email') ?>
                    <?= $form->field($model, 'confirmNewEmail')->input('email')->label('Confirmar Nuevo Email') ?>
                    </br>
                    <div class="form-group">
                        <?= Html::submitButton('Cambiar Email', ['class' => 'btn btn-primary', 'name'=>'submit-button', 'value'=>'cambiarEmail']) ?>
                    </div>

                    <?php ActiveForm::end(); ?>
                </div>
                <br>

                <div class="col">
                    <h2>Cambiar Contraseña</h2>

                    <?php $form = ActiveForm::begin([
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
                            <?= Html::submitButton('Cambiar Contraseña', ['class' => 'btn btn-primary', 'name'=>'submit-button', 'value'=>'cambiarPass']) ?>
                        </div>
                    </div>

                    <?php ActiveForm::end(); ?>
                </div>
            </div>
    </div>

</div>
