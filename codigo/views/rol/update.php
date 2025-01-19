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