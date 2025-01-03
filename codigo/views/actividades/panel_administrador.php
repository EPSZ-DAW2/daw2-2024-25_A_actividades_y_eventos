<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\LinkPager;

?>

<p>
    <?= Html::a('Crear Actividad', ['crear'], ['class' => 'btn btn-success']) ?>
</p>

<table class="table table-bordered">
    <thead>
        <tr>
            <th>ID</th>
            <th>Titulo</th>
            <th>Descripcion</th>
            <th>Fecha Celebracion</th>
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

<?= LinkPager::widget([
    'pagination' => $pagination,
]) ?>

