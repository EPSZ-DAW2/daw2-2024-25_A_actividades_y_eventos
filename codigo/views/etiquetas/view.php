<?php
/* @var $this yii\web\View */
/* @var $etiqueta app\models\Etiqueta */

use yii\helpers\Html;

$this->title = $etiqueta->nombre;
$this->params['breadcrumbs'][] = ['label' => 'Etiquetas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="etiqueta-view">
    <h1><?= Html::encode($this->title) ?></h1>
    <p>
        <?= Html::a('Editar', ['update', 'id' => $etiqueta->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Eliminar', ['delete', 'id' => $etiqueta->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => '¿Estás seguro de que quieres eliminar esta etiqueta?',
                'method' => 'post',
            ],
        ]) ?>
        <?= Html::a('Volver a la lista', ['index'], ['class' => 'btn btn-secondary']) ?>

    </p>
    <table class="table table-bordered">
        <tr>
            <th>ID</th>
            <td><?= Html::encode($etiqueta->id) ?></td>
        </tr>
        <tr>
            <th>Nombre</th>
            <td><?= Html::encode($etiqueta->nombre) ?></td>
        </tr>
        <tr>
            <th>Descripción</th>
            <td><?= Html::encode($etiqueta->descripcion) ?></td>
        </tr>
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