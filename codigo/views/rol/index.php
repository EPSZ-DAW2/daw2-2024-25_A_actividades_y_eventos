<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\LinkPager;
use yii\data\Sort;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $pagination yii\data\Pagination */

$this->title = 'Roles';

$sort = new Sort([
    'attributes' => [
        'id',
        'nombre_rol',
        'descripcion',
    ],
]);
?>
<div class="roles-index">

    <h1>Gestion de roles</h1>


    
    <p>
        <?= Html::a('Crear Rol', ['create'], ['class' => 'btn btn-success']) ?>
        <?= Html::a('Asignar Rol', ['rol/add_rol_persona'], ['class' => 'btn btn-success']) ?>

    </p>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th><?= $sort->link('id') ?></th>
                <th><?= $sort->link('nombre_rol') ?></th>
                <th><?= $sort->link('descripcion') ?></th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($dataProvider->models as $rol): ?>
                <tr>
                    <td><?= Html::encode($rol->id) ?></td>
                    <td><?= Html::encode($rol->nombre_rol) ?></td>
                    <td><?= Html::encode($rol->descripcion) ?></td>
                    <td>
                        <?= Html::a('Ver', ['view', 'id' => $rol->id], ['class' => 'btn btn-primary']) ?>
                        <?= Html::a('Editar', ['update', 'id' => $rol->id], ['class' => 'btn btn-warning']) ?>
                        <?= Html::a('Eliminar', ['delete', 'id' => $rol->id], [
                            'class' => 'btn btn-danger',
                            'data' => [
                                'confirm' => '¿Estás seguro de que deseas eliminar este rol?',
                                'method' => 'post',
                            ],
                        ]) ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <?php if (isset($pagination)): ?>
        <?= LinkPager::widget([
            'pagination' => $pagination,
        ]) ?>
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