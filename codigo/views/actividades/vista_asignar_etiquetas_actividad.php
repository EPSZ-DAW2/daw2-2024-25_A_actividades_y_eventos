<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\models\Etiqueta;
use app\models\Actividad;





?>
        <?= Html::a('Panel Administrador', ['actividades/administrador'], ['class' => 'btn btn-secondary']) ?>


<div class="asignar-etiquetas-actividad">
    <h1>Asignar Etiquetas a Actividad</h1>
    <?php $form = ActiveForm::begin([
        'action' => ['etiquetas/procesar_asignacion_etiquetas'], // Asegúrate de que la acción apunte al controlador correcto
        'method' => 'post',
    ]); ?>

    <?= $form->field($model, 'actividad_id')->dropDownList($listaActividades, ['prompt' => 'Seleccione una actividad']) ?>

    <?= $form->field($model, 'etiqueta_id')->dropDownList($listaEtiquetas, ['prompt' => 'Seleccione una etiqueta']) ?>

    <div class="form-group">
        <?= Html::submitButton('Asignar Etiqueta', ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>
