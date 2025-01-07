<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Roles */

$this->title = 'Crear Rol';
$this->params['breadcrumbs'][] = ['label' => 'Roles', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="roles-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <div class="roles-form">

        <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($model, 'nombre_rol')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'descripcion')->textarea(['rows' => 6]) ?>

        <div class="form-group">
            <?= Html::submitButton('Guardar', ['class' => 'btn btn-success']) ?>
        </div>

        <?php ActiveForm::end(); ?>

    </div>

</div>
