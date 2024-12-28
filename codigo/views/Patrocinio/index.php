<?php

use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $patrocinadores app\models\Patrocinadores[] */

$this->title = 'Lista de Patrocinadores';
?>

<div class="row">
    <div class="col-9">
        <h2 style="display: inline;">Opciones para patrocinadors</h2>
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
            <th>Nick</th>
            <th>Password</th>
            <th>Email</th>
            <th>Nombre</th>
            <th>Apellidos</th>
            <th>Fecha Nacimiento</th>
            <th>Ubicación</th>
            <th>Activo</th>
            <th>Fecha Registro</th>
            <th>Registro Confirmado</th>
            <th>Revisado</th>
            <th>Último Acceso</th>
            <th>Intentos Acceso</th>
            <th>Bloqueado</th>
            <th>Fecha Bloqueo</th>
            <th>Motivo Bloqueo</th>
            <th>Notas</th>
            <th>Editar</th>
            <th>Eliminar</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($patrocinadores as $patrocinador): ?>
            <tr>
                <td><?= Html::encode($patrocinador->id) ?></td>
                <td><?= Html::encode($patrocinador->nick) ?></td>
                <td><?= Html::encode(substr($patrocinador->password, 0, 18)) ?></td>
                <td><?= Html::encode($patrocinador->email) ?></td>
                <td><?= Html::encode($patrocinador->nombre) ?></td>
                <td><?= Html::encode($patrocinador->apellidos) ?></td>
                <td><?= Html::encode($patrocinador->fecha_nacimiento) ?></td>
                <td><?= Html::encode($patrocinador->ubicacion) ?></td>
                <td><?= Html::encode($patrocinador->activo ? 'Sí' : 'No') ?></td>
                <td><?= Html::encode($patrocinador->fecha_registro) ?></td>
                <td><?= Html::encode($patrocinador->registro_confirmado ? 'Sí' : 'No') ?></td>
                <td><?= Html::encode($patrocinador->revisado ? 'Sí' : 'No') ?></td>
                <td><?= Html::encode($patrocinador->ultimo_acceso) ?></td>
                <td><?= Html::encode($patrocinador->intentos_acceso) ?></td>
                <td><?= Html::encode($patrocinador->bloqueado ? 'Sí' : 'No') ?></td>
                <td><?= Html::encode($patrocinador->fecha_bloqueo) ?></td>
                <td><?= Html::encode($patrocinador->motivo_bloqueo) ?></td>
                <td><?= Html::encode($patrocinador->notas) ?></td>
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