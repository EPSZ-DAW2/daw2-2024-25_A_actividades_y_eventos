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
    <?= $form->field($model, 'fecha_celebracion')->input('date') ?>
    <?= $form->field($model, 'duracion_estimada')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'lugar_celebracion')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'detalles')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'notas')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'edad_recomendada')->textInput() ?>
    <?= $form->field($model, 'votosOK')->textInput() ?>
    <?= $form->field($model, 'votosKO')->textInput() ?>
    <?= $form->field($model, 'maximo_participantes')->textInput() ?>
    <?= $form->field($model, 'minimo_participantes')->textInput() ?>
    <?= $form->field($model, 'reserva')->checkbox() ?>
    <?= $form->field($model, 'participantes')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Actualizar', ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>
