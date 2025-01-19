<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'Parámetros del Servidor';
?>

<div class="parametros-servidor-index">
    <h1><?= Html::encode($this->title) ?></h1>

    <div class="row">
        <div class="col-md-6">
            <h2>Configuración PHP</h2>
            <?php $form = ActiveForm::begin(); ?>

            <?= $form->field($model, 'upload_max_filesize')->textInput(['placeholder' => 'Ejemplo: 10M, 128M']) ?>
            <?= $form->field($model, 'memory_limit')->textInput(['placeholder' => 'Ejemplo: 128M, 256M']) ?>
            </br>
            <div class="alert alert-warning">
                <strong>Nota:</strong> Los cambios en estos parámetros requieren reiniciar el servidor web para tomar efecto.
            </div>

            <div class="form-group">
                <?= Html::submitButton('Guardar', ['class' => 'btn btn-primary']) ?>
            </div>

            <?php ActiveForm::end(); ?>
        </div>

        <div class="col-md-6">
            <h2>Información del Servidor</h2>
            <div class="table-responsive">
                <table class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>Parámetro</th>
                            <th>Valor</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($serverInfo as $parameter => $value): ?>
                        <tr>
                            <td><?= Html::encode($parameter) ?></td>
                            <td><?= Html::encode($value) ?></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
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