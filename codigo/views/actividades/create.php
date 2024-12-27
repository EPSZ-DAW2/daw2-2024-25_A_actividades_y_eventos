<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'Crear Actividad';
?>

<h1><?= Html::encode($this->title) ?></h1>

<div class="actividad-form">
    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'titulo')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'descripcion')->textarea(['rows' => 6]) ?>
    <?= $form->field($model, 'imagen')->fileInput() ?>
    <?= $form->field($model, 'fecha_inicio')->input('date') ?>
    <?= $form->field($model, 'fecha_fin')->input('date') ?>

    <div class="form-group">
        <?= Html::submitButton('Guardar', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>
