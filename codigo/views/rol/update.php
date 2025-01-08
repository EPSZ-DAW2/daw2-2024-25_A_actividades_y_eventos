<?php
/* @var $this yii\web\View */
/* @var $model app\models\Roles */

use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'Actualizar Rol: ' . $model->nombre_rol;
$this->params['breadcrumbs'][] = ['label' => 'Roles', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->nombre_rol, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Actualizar';
?>
<div class="roles-update">
    <h1><?= Html::encode($this->title) ?></h1>
    <div class="roles-form">
        <?php $form = ActiveForm::begin(); ?>
        <?= $form->field($model, 'nombre_rol')->textInput(['maxlength' => true]) ?>
        <?= $form->field($model, 'descripcion')->textarea(['rows' => 6]) ?>
        <div class="form-group">
            <?= Html::submitButton('Guardar', ['class' => 'btn btn-success']) ?>
            <?= Html::a('Cancelar', ['index'], ['class' => 'btn btn-secondary']) ?>
        </div>
        <?php ActiveForm::end(); ?>
    </div>
</div>
