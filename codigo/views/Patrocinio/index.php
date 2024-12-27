<?php

use yii\helpers\Html;
use yii\helpers\Url;

?>

<div class="row">
    <div class="col-9">
        <h2 style="display: inline;">Opciones para patrocinadores</h2>
    </div>
    <div class="col-3 text-end">
        <a class="btn btn-success" href="<?= Url::to(['patrocinio/add']) ?>">
            Añadir nuevo patrocinador
        </a>
    </div>
</div>
<div class="clearfix"></div>
<hr/>
<table class="table table-striped">
    <thead>
        <tr>
            <th>ID</th>
            <th>NOMBRE</th>
            <th>APELLIDOS</th>
            <th>EMAIL</th>
            <th>PASSWORD</th>
            <th>EDITAR</th>
            <th>ELIMINAR</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($patrocinadores as $patrocinador): ?>
            <tr>
                <td><?= Html::encode($patrocinador->id) ?></td>
                <td><?= Html::encode($patrocinador->nombre) ?></td>
                <td><?= Html::encode($patrocinador->apellido) ?></td>
                <td><?= Html::encode($patrocinador->email) ?></td>
                <td><?= Html::encode(substr($patrocinador->password, 0, 18)) ?></td>
                <td>
                    <a class="btn btn-primary" href="<?= Url::to(['patrocinio/modificar', 'id' => $patrocinador->id]) ?>">
                        Editar
                    </a>
                </td>
                <td>
                    <a class="btn btn-danger" href="<?= Url::to(['patrocinio/eliminar', 'id' => $patrocinador->id]) ?>" 
                       data-method="post" 
                       data-confirm="¿Estás seguro de que deseas eliminar este patrocinador?">
                        Eliminar
                    </a>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>