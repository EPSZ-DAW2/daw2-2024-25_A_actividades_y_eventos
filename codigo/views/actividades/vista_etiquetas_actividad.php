<?php
/* @var $this yii\web\View */
/* @var $id int */
/* @var $etiquetas array */

use yii\helpers\Html;

// $this->title = 'Etiquetas de la Actividad: ' . $id;

?>
<div class="actividad-etiquetas">
    <h1><?= Html::encode($this->title) ?></h1>
    <p>
        <?= Html::a('Panel Administrador', ['actividades/administrador'], ['class' => 'btn btn-secondary']) ?>
    </p>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID Etiqueta</th>
                <th>Nombre</th>
                <th>Descripción</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($etiquetas) && is_array($etiquetas)): ?>
                <?php foreach ($etiquetas as $etiqueta): ?>
                    <tr>
                        <td><?= Html::encode($etiqueta['id']) ?></td>
                        <td><?= Html::encode($etiqueta['nombre']) ?></td>
                        <td><?= Html::encode($etiqueta['descripcion']) ?></td>
                        <td>
                            <?= Html::a('Eliminar', ['etiquetas/eliminar_etiqueta_actividad', 'actividad_id' => $id, 'etiqueta_id' => $etiqueta['id']], [
                                'class' => 'btn btn-danger',
                                'data' => [
                                    'confirm' => '¿Estás seguro de que deseas eliminar esta etiqueta de la actividad?',
                                    'method' => 'post',
                                ],
                            ]) ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="4">No hay etiquetas disponibles.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
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