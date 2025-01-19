<?php
/* @var $this yii\web\View */
/* @var $etiquetas app\models\Etiqueta[] */

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\LinkPager;
use yii\data\Sort;

$sort = new Sort([
    'attributes' => [
        'id',
        'Nombre',
        'Descripcion',
    ],
]);

$this->title = 'Etiquetas';
?>
<div class="etiquetas-index">
    <h1>Gestion de etiquetas</h1>
    <?= Html::a('Crear nueva etiqueta', ['create'], ['class' => 'btn btn-success']) ?></p>
    <table class="table table-bordered">
        <thead>
            <tr>
            <th><?= $sort->link('id') ?></th>
            <th><?= $sort->link('Nombre') ?></th>
            <th><?= $sort->link('Descripcion') ?></th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($etiquetas as $etiqueta): ?>
                <tr>
                    <td><?= Html::encode($etiqueta->id) ?></td>
                    <td><?= Html::encode($etiqueta->nombre) ?></td>
                    <td><?= Html::encode($etiqueta->descripcion) ?></td>
                    <td>
                        <?= Html::a('Ver', ['view', 'id' => $etiqueta->id], ['class' => 'btn btn-primary']) ?>
                        <?= Html::a('Actualizar', ['update', 'id' => $etiqueta->id], ['class' => 'btn btn-warning']) ?>
                        <?= Html::a('Eliminar', ['delete', 'id' => $etiqueta->id], [
                            'class' => 'btn btn-danger',
                            'data' => [
                                'confirm' => '¿Estás seguro de que quieres eliminar esta etiqueta?',
                                'method' => 'post',
                            ],
                        ]) ?>
                    </td>
                </tr>
            <?php endforeach; ?>
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