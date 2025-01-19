<?php
use yii\helpers\Html;
use app\models\Roles;

/* @var $this yii\web\View */
/* @var $model app\models\Actividad */

if (!Yii::$app->user->hasRole([Roles::MODERADOR, Roles::ADMINISTRADOR, Roles::SYSADMIN])) {
    return Yii::$app->response->redirect(['actividades/actividad', 'id' => $model->id]);
}

$this->title = $model->titulo;


?>
<div class="actividad-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Vista usuario', ['actividad', 'id' => $model->id], ['class' => 'btn btn-outline-primary btn-block']) ?> 
        <?= Html::a('Editar', ['editar', 'id' => $model->id], ['class' => 'btn btn-warning']) ?>
        <?= Html::a('Eliminar', ['eliminar', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => '¿Estás seguro de que deseas eliminar esta actividad?',
                'method' => 'post',
            ],
        ]) ?>

        <?= Html::a('Añadir Etiqueta', ['etiquetas/asignar_etiqueta', 'actividad_id' => $model->id], ['class' => 'btn btn-primary']) ?>

    </p>

    <table class="table table-bordered">
        <tr>
            <th>ID</th>
            <td><?= Html::encode($model->id) ?></td>
        </tr>
        <tr>
            <th>Titulo</th>
            <td><?= Html::encode($model->titulo) ?></td>
        </tr>
        <tr>
            <th>Descripcion</th>
            <td><?= Html::encode($model->descripcion) ?></td>
        </tr>
        <tr>
            <th>Fecha Celebracion</th>
            <td><?= Html::encode($model->fecha_celebracion) ?></td>
        </tr>
        <tr>
            <th>Duracion Estimada</th>
            <td><?= Html::encode($model->duracion_estimada) ?></td>
        </tr>
        <tr>
            <th>Lugar Celebracion</th>
            <td><?= Html::encode($model->lugar_celebracion) ?></td>
        </tr>
        <tr>
            <th>Detalles</th>
            <td><?= Html::encode($model->detalles) ?></td>
        </tr>
        <tr>
            <th>Notas</th>
            <td><?= Html::encode($model->notas) ?></td>
        </tr>
        <tr>
            <th>Edad Recomendada</th>
            <td><?= Html::encode($model->edad_recomendada) ?></td>
        </tr>
        <tr>
            <th>Votos OK</th>
            <td><?= Html::encode($model->votosOK) ?></td>
        </tr>
        <tr>
            <th>Votos KO</th>
            <td><?= Html::encode($model->votosKO) ?></td>
        </tr>
        <tr>
            <th>Maximo Participantes</th>
            <td><?= Html::encode($model->maximo_participantes) ?></td>
        </tr>
        <tr>
            <th>Minimo Participantes</th>
            <td><?= Html::encode($model->minimo_participantes) ?></td>
        </tr>
        <tr>
            <th>Reserva</th>
            <td><?= Html::encode($model->reserva ? 'Sí' : 'No') ?></td>
        </tr>
        <tr>
            <th>Participantes</th>
            <td><?= Html::encode($model->participantes) ?></td>
        </tr>
        <tr>
            <?php
                // API Key de Google Maps
                $apiKey = 'AIzaSyAwkqhsAcJIftL32sor2fYd5Q7-zaOkc5A';
                $direccionActividad = Html::encode($model->lugar_celebracion);
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
        </tr>
        <br>
    </table>
    <?= Html::a('Participantes de la actividad', ['ver_participantes_actividad', 'id' => $model->id], ['class' => 'btn btn-warning']) ?>
    <?= Html::a('Etiquetas de la actividad', ['ver_etiquetas_actividad', 'id' => $model->id], ['class' => 'btn btn-warning']) ?>
</div>