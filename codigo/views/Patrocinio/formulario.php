<?php
use yii\widgets\ActiveForm;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\PatrocinadoresForm */

$this->title = 'Formulario de Patrocinador';
?>
<h2><?= Html::encode($this->title) ?></h2>

<div class="form">
    <?php $form = ActiveForm::begin([
        'id' => 'patrocinadores-form',
        'enableClientValidation' => true,
        'validateOnSubmit' => true,
    ]); ?>

    <?= $form->field($model, 'nick')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'password')->passwordInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'email')->input('email') ?>
    <?= $form->field($model, 'nombre')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'apellidos')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'fecha_nacimiento')->input('date') ?>
    <?= $form->field($model, 'ubicacion')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'activo')->checkbox() ?>
    <?= $form->field($model, 'fecha_registro')->input('date') ?>
    <?= $form->field($model, 'registro_confirmado')->checkbox() ?>
    <?= $form->field($model, 'revisado')->checkbox() ?>
    <?= $form->field($model, 'ultimo_acceso')->input('date') ?>
    <?= $form->field($model, 'intentos_acceso')->textInput(['type' => 'number']) ?>
    <?= $form->field($model, 'bloqueado')->checkbox() ?>
    <?= $form->field($model, 'fecha_bloqueo')->input('date') ?>
    <?= $form->field($model, 'motivo_bloqueo')->textarea(['rows' => 3]) ?>
    <?= $form->field($model, 'notas')->textarea(['rows' => 3]) ?>

    <div class="form-group">
        <?= Html::submitButton('Guardar', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>
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