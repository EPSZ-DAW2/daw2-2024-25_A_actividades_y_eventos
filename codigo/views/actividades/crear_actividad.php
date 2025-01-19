<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\jui\DatePicker;


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

        <?= $form->field($model, 'imageFile')->fileInput()->label('Subir foto de actividad.') ?>

        <hr>

        <?= $form->field($model, 'titulo')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'descripcion')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'fecha_celebracion')->widget(DatePicker::classname(), [
            'dateFormat' => 'yyyy-MM-dd',
            'options' => ['class' => 'form-control'],
        ]) ?>
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

        <?= $form->field($model, 'contador_visitas')->textInput() ?>


        <div class="form-group">
            <?= Html::submitButton('Guardar', ['class' => 'btn btn-success']) ?>
        </div>

        <?php ActiveForm::end(); ?>

    </div>

</div>


<div class = "d-none">
        <?php
            // API Key de Google Maps
            $apiKey = 'AIzaSyAwkqhsAcJIftL32sor2fYd5Q7-zaOkc5A';
            $direccionActividad = "plaza marina 1, 49004 Zamora";
            $direccionEncodedActividad = urlencode($direccionActividad);
            $urlActividad = "https://maps.googleapis.com/maps/api/geocode/json?address=$direccionEncodedActividad&components=country:ES&key=$apiKey";
            $responseActividad = file_get_contents($urlActividad);
            $dataActividad = json_decode($responseActividad, true);

            if ($dataActividad['status'] == 'OK') {
                $latActividad = $dataActividad['results'][0]['geometry']['location']['lat'];
                $lngActividad = $dataActividad['results'][0]['geometry']['location']['lng'];
            } else {
                $latActividad = null;
                $lngActividad = null;
            }

            $this->params['latActividad'] = $latActividad;
            $this->params['lngActividad'] = $lngActividad;


            // Agregar mapa de actividad
            if ($latActividad && $lngActividad) {
                echo "<div style='display: flex; justify-content: center; align-items: center;'>
                    <div id='map-actividad' style='width: 100%; height: 200px;'></div>
                </div>";
            }
        ?>
    </div>