<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Roles */

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
        <?= Html::a('Personas con este rol', ['rol/view_roles_personas', 'id' => $model->id], ['class' => 'btn btn-success']) ?>
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
</div>
