<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\LinkPager;
use yii\data\Sort;

$sort = new Sort([
    'attributes' => [
        'id',
        'titulo',
        'descripcion',
        'fecha_celebracion',
    ],
]);

?>

<p></p>

<a href="<?= Yii::$app->urlManager->createUrl(['site/gestion_admin']) ?>">Panel de administrador</a>

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

