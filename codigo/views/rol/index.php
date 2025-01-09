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

    <h1><?= Html::encode($this->title) ?></h1>

    
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
