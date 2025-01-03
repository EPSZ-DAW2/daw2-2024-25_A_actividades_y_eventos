<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Actividad */
/* @var $form yii\widgets\ActiveForm */

$this->title = 'Crear Nueva Actividad';
$this->params['breadcrumbs'][] = ['label' => 'Actividades', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="actividad-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <div class="actividad-form">

        <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($model, 'titulo')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'descripcion')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'fecha_celebracion')->textInput() ?>

        <?= $form->field($model, 'duracion_estimada')->textInput() ?>

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
            <?= Html::submitButton('Guardar', ['class' => 'btn btn-success']) ?>
        </div>

        <?php ActiveForm::end(); ?>

    </div>

</div>
