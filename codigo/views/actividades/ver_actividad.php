<?php
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Actividad */

$this->title = $model->titulo;


?>
<div class="actividad-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Editar', ['editar', 'id' => $model->id], ['class' => 'btn btn-warning']) ?>
        <?= Html::a('Eliminar', ['eliminar', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => '¿Estás seguro de que deseas eliminar esta actividad?',
                'method' => 'post',
            ],
        ]) ?>
        <?= Html::a('Panel Administrador', ['actividades/administrador'], ['class' => 'btn btn-secondary']) ?>

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
    </table>
    <?= Html::a('Participantes de la actividad', ['ver_participantes_actividad', 'id' => $model->id], ['class' => 'btn btn-warning']) ?>
    <?= Html::a('Etiquetas de la actividad', ['ver_etiquetas_actividad', 'id' => $model->id], ['class' => 'btn btn-warning']) ?>


</div>
