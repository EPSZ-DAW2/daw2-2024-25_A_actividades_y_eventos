<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var $this yii\web\View; */
/** @var $model app\models\Roles; */
$this->title = $model->nombre_rol;
?>
<div class="roles-view">
    <?= Html::a('Lista de roles', ['index'], ['class' => 'btn btn-secondary']) ?>

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Actualizar', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Eliminar', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => '¿Estás seguro de que quieres eliminar este elemento?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <table class="table table-striped table-bordered detail-view">
        <tr>
            <th>ID</th>
            <td><?= Html::encode($model->id) ?></td>
        </tr>
        <tr>
            <th>Nombre Rol</th>
            <td><?= Html::encode($model->nombre_rol) ?></td>
        </tr>
        <tr>
            <th>Descripción</th>
            <td><?= Html::encode($model->descripcion) ?></td>
        </tr>
    </table>

    <h2>Usuarios con este rol</h2>
    <table class="table w-50 table-striped detail-view">
    <thead>
        <tr>
            <th>ID</th>
            <th>Nombre de usuario</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
    <?php 
        if($usuarios){
            foreach ($usuarios as $usuario) { ?>
                <tr>
                    <td><?= Html::encode($usuario->ID) ?></td>
                    <td><?= Html::encode($usuario->nick) ?></td>
                    <td>
                        <?= Html::a('Ver', ['usuario/view', 'id' => $usuario->ID], ['class' => 'btn btn-primary']) ?>
                        <?= Html::a('Quitar Rol', ['rol/delete_rol_persona', 'id' => $usuario['id']], [
                                'class' => 'btn btn-danger',
                                'data' => [
                                    'confirm' => '¿Estás seguro de que deseas eliminar este rol?',
                                    'method' => 'post',
                                ],
                            ]) ?>
                    </td>
                </tr>
                <?php
        }
    } else {
        echo '<tr><td>No hay usuarios con este rol.</td></tr>';
    }
    ?>
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