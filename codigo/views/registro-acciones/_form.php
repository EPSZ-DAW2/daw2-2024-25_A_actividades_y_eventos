<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\RegistroAcciones $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="registro-acciones-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'usuario_accion')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'fecha_accion')->textInput() ?>

    <?= $form->field($model, 'accion')->textarea(['rows' => 6]) ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
