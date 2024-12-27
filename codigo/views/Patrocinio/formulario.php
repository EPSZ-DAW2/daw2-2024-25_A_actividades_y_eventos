<?php
use yii\widgets\ActiveForm;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\PatrocinadoresForm */

$this->title = 'Formulario de Patrocinadores';
?>
<h2><?= Html::encode($this->title) ?></h2>

<div class="form">
    <?php $form = ActiveForm::begin([
        'id' => 'patrocinadores-form',
        'options' => ['class' => 'needs-validation', 'novalidate' => true],
        'enableClientValidation' => true,
        'validateOnSubmit' => true,
    ]); ?>

    <div class="mb-3">
        <?= $form->field($model, 'nombre')->textInput(['maxlength' => true, 'class' => 'form-control']) ?>
    </div>
    <div class="mb-3">
        <?= $form->field($model, 'apellido')->textInput(['maxlength' => true, 'class' => 'form-control']) ?>
    </div>
    <div class="mb-3">
        <?= $form->field($model, 'email')->input('email', ['class' => 'form-control']) ?>
    </div>
    <div class="mb-3">
        <?= $form->field($model, 'password')->passwordInput(['maxlength' => true, 'class' => 'form-control']) ?>
    </div>

    <div class="form-group">
        <?= Html::submitButton('Guardar', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>
