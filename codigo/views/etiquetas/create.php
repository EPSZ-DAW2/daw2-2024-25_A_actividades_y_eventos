<?php
/* @var $this yii\web\View */
/* @var $model app\models\Etiqueta */

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\jui\DatePicker;

$this->title = 'Crear Etiqueta';
$this->params['breadcrumbs'][] = ['label' => 'Etiquetas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="etiqueta-create">
    <h1><?= Html::encode($this->title) ?></h1>
    <div class="etiqueta-form">
        <?php $form = ActiveForm::begin(); ?>
        <?= $form->field($model, 'nombre')->textInput(['maxlength' => true]) ?>
        <?= $form->field($model, 'descripcion')->textInput(['maxlength' => true]) ?>
        <?= $form->field($model, 'fecha_creacion')->widget(DatePicker::classname(), [
            'dateFormat' => 'yyyy-MM-dd',
            'options' => ['class' => 'form-control'],
        ]) ?>
        <div class="form-group">
            <?= Html::submitButton('Guardar', ['class' => 'btn btn-success']) ?>
        </div>
        <?php ActiveForm::end(); ?>
    </div>
</div>
