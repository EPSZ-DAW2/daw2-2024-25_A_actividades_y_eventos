<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\LinkPager;
use yii\data\Sort;
/** @var yii\web\View $this */

$sort = new Sort([
    'attributes' => [
        'id',
        'titulo',
        'descripcion',
        'fecha_celebracion',
    ],
]);
$this->title = 'Administracion de actividades';
?>


<h1>Gestion de actividades</h1>
<?= Html::a('Crear Actividad', ['crear'], ['class' => 'btn btn-success']) ?>
</p>

<table class="table table-bordered">
    <thead>
        <tr>
            <th><?= $sort->link('id') ?></th>
            <th><?= $sort->link('titulo') ?></th>
            <th><?= $sort->link('descripcion') ?></th>
            <th><?= $sort->link('fecha_celebracion') ?></th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($id as $actividad): ?>
            <tr>
                <td><?= Html::encode($actividad->id) ?></td>
                <td><?= Html::encode($actividad->titulo) ?></td>
                <td><?= Html::encode($actividad->descripcion) ?></td>
                <td><?= Html::encode($actividad->fecha_celebracion) ?></td>
                <td>
                    <?= Html::a('Ver', ['ver_actividad', 'id' => $actividad->id], ['class' => 'btn btn-primary']) ?>
                    <?= Html::a('Editar', ['editar', 'id' => $actividad->id], ['class' => 'btn btn-warning']) ?>
                    <?= Html::a('Eliminar', ['eliminar', 'id' => $actividad->id], [
                        'class' => 'btn btn-danger',
                        'data' => [
                            'confirm' => '¿Estás seguro de que deseas eliminar esta actividad?',
                            'method' => 'post',
                        ],
                    ]) ?>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<?php if ($pagination): ?>
    <?= LinkPager::widget([
        'pagination' => $pagination,
    ]) ?>
<?php endif; ?>

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