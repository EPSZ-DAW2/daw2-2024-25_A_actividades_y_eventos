<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\Usuario $model */

$this->title = 'Editar Perfil';
$this->params['breadcrumbs'][] = ['label' => 'Mi Perfil', 'url' => ['mi-perfil']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="usuario-editar-perfil">
    <h1><?= Html::encode($this->title) ?></h1>

    <div class="usuario-form">
        <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($model, 'nick')->textInput(['maxlength' => true]) ?>
        <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>
        <?= $form->field($model, 'nombre')->textInput(['maxlength' => true]) ?>
        <?= $form->field($model, 'apellidos')->textInput(['maxlength' => true]) ?>

        <div class="form-group">
            <?= Html::submitButton('Guardar', ['class' => 'btn btn-success']) ?>
        </div>

        <?php ActiveForm::end(); ?>
    </div>
</div>
