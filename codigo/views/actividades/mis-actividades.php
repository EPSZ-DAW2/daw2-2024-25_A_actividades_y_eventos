<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $actividades array */

$this->title = 'Actividades en las que estoy apuntado';
?>
<div class="mis-actividades">
    <h1><?= Html::encode($this->title) ?></h1>

    <?php if (!empty($actividades)): ?>
        <div class="row">
            <?php foreach ($actividades as $actividad): ?>
                <div class="col-lg-4 mb-4">
                    <div class="card h-100">
                        <?php if (!empty($actividad['nombre_Archivo'])): ?>
                            <img class="card-img-top" 
                                 src="<?= Yii::getAlias('@web/images/actividades/' . 
                                      Html::encode($actividad['nombre_Archivo'] . '.' . 
                                      $actividad['extension'])) ?>"
                                 alt="<?= Html::encode($actividad['titulo']) ?>">
                        <?php else: ?>
                            <img class="card-img-top" 
                                 src="<?= Yii::getAlias('@web/images/default.jpg') ?>" 
                                 alt="Imagen predeterminada">
                        <?php endif; ?>

                        <div class="card-body">
                            <h5 class="card-title"><?= Html::encode($actividad['titulo']) ?></h5>
                            <p class="card-text"><?= Html::encode($actividad['descripcion']) ?></p>
                            <p class="card-text">
                                <small class="text-muted">
                                    Fecha: <?= Yii::$app->formatter->asDateTime($actividad['fecha_celebracion']) ?>
                                </small>
                            </p>
                            <?= Html::a('Desapuntarse', ['actividades/desapuntar', 'id' => $actividad['id']], [
                                'class' => 'btn btn-danger',
                                'data' => [
                                    'confirm' => '¿Estás seguro de que deseas desapuntarte de esta actividad?',
                                    'method' => 'post',
                                ],
                            ]) ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <p>No estás apuntado a ninguna actividad.</p>
    <?php endif; ?>
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
