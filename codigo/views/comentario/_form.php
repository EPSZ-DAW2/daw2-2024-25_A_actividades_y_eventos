<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\Comentario $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="comentario-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'texto')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'comentario_relacionado')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'cerrado_comentario')->textInput() ?>

    <?= $form->field($model, 'numero_de_denuncias')->textInput() ?>

    <?= $form->field($model, 'fecha_bloque')->textInput() ?>

    <?= $form->field($model, 'motivos_bloqueo')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'USUARIOid')->textInput() ?>

    <?= $form->field($model, 'ACTIVIDADid')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
