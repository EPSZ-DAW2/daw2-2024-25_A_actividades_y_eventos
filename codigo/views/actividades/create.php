<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

Yii::$app->view->title = 'Crear Actividad'; 
?>

<h1><?= Html::encode($this->title) ?></h1>

<div class="actividad-form">
    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

    <?= $form->field($model, 'titulo')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'descripcion')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'imagen_principal')->fileInput() ?>

    <?= $form->field($model, 'fecha_celebracion')->input('date') ?>

    <?= $form->field($model, 'duracion_estimada')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'lugar_celebracion')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'estado_actividad')->dropDownList([
        'pendiente' => 'Pendiente',
        'en curso' => 'En curso',
        'finalizado' => 'Finalizado',
    ], ['prompt' => 'Seleccionar estado']) ?>

    <div class="form-group">
        <?= Html::submitButton('Guardar', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>