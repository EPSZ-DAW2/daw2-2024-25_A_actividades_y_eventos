<?php
/* @var $this yii\web\View */
/* @var $id int */
/* @var $etiquetas array */

use yii\helpers\Html;

// $this->title = 'Etiquetas de la Actividad: ' . $id;

?>
<div class="actividad-etiquetas">
    <h1><?= Html::encode($this->title) ?></h1>
    <p>
        <?= Html::a('Panel Administrador', ['actividades/administrador'], ['class' => 'btn btn-secondary']) ?>
    </p>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID Etiqueta</th>
                <th>Nombre</th>
                <th>Descripción</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($etiquetas) && is_array($etiquetas)): ?>
                <?php foreach ($etiquetas as $etiqueta): ?>
                    <tr>
                        <td><?= Html::encode($etiqueta['id']) ?></td>
                        <td><?= Html::encode($etiqueta['nombre']) ?></td>
                        <td><?= Html::encode($etiqueta['descripcion']) ?></td>
                        <td>
                            <?= Html::a('Eliminar', ['etiquetas/eliminar_etiqueta_actividad', 'actividad_id' => $id, 'etiqueta_id' => $etiqueta['id']], [
                                'class' => 'btn btn-danger',
                                'data' => [
                                    'confirm' => '¿Estás seguro de que deseas eliminar esta etiqueta de la actividad?',
                                    'method' => 'post',
                                ],
                            ]) ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="4">No hay etiquetas disponibles.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>
