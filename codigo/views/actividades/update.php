<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'Actualizar Actividad';
?>

<h1><?= Html::encode($this->title) ?></h1>

<div class="actividad-form">
    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'titulo')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'descripcion')->textarea(['rows' => 6]) ?>
    <?= $form->field($model, 'imagen_principal')->fileInput() ?>
    <?= $form->field($model, 'fecha_celebracion')->input('date') ?>
    <?= $form->field($model, 'duracion_estimada')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'lugar_celebracion')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('Actualizar', ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>
