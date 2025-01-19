<?php
use yii\helpers\Html;
use yii\helpers\Url;

/** @var yii\web\View $this */
/** @var app\models\Notificacion $model */

$this->title = 'Detalles de la Notificación';
?>
<h1><?= Html::encode($this->title) ?></h1>
<p><strong>ID de la Notificación:</strong> <?= Html::encode($model->id) ?></p>
<p><strong>Tipo de notificación:</strong> <?= Html::encode($model->codigo_de_clase) ?></p>
<p><strong>Fecha:</strong> <?= Html::encode($model->fecha) ?></p>
<p><strong>Fecha de lectura:</strong> <?= Html::encode($model->fecha_lectura) ?></p>
<?php if (!empty($model->fecha_borrado)): ?>
    <p><strong>Fecha de borrado:</strong> <?= Html::encode($model->fecha_borrado) ?></p>
<?php endif; ?>
<p><strong>Fecha de aceptación:</strong> <?= Html::encode($model->fecha_aceptacion) ?></p>
<p><strong>Usuario origen de la notificación:</strong> <?= Html::encode($model->USUARIOid) ?></p>
<p><strong>ID de Actividad:</strong> <?= in_array($model->codigo_de_clase, ['SOLICITUD_BAJA', 'SOLICITUD_CONTACTO']) ? 'no procede' : Html::encode($model->ACTIVIDADid) ?></p>
<p><strong>Texto de la Notificación:</strong> <?= in_array($model->codigo_de_clase, ['SOLICITUD_BAJA', 'SOLICITUD_CONTACTO']) ? 'no procede' : Html::encode($model->texto) ?></p>

<?php if (!$model->fecha_lectura): ?>
    <p><?= Html::a('Marcar como Leída', ['notificacion/marcar-leida', 'id' => $model->id], ['class' => 'btn btn-success']) ?></p>
<?php endif; ?>

<?php if (!$model->fecha_aceptacion): ?>
    <p><?= Html::a('Aceptar Notificación', ['notificacion/aceptar', 'id' => $model->id], ['class' => 'btn btn-primary']) ?></p>
<?php endif; ?>

<p><?= Html::a('Volver', ['usuario/mis-notificaciones'], ['class' => 'btn btn-primary']) ?></p>

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