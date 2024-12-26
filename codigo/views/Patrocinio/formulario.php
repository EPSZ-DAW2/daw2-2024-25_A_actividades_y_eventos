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
        'enableClientValidation' => true,
        'validateOnSubmit' => true,
    ]); ?>

    <?= $form->field($model, 'nombre')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'apellido')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'email')->input('email') ?>
    <?= $form->field($model, 'password')->passwordInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('Guardar', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>
