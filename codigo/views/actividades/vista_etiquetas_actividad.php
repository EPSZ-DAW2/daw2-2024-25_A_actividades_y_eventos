<?php
/* @var $this yii\web\View */
/* @var $model app\models\Actividad */
/* @var $etiquetas app\models\Participante[] */

use yii\helpers\Html;

// $this->title = 'etiquetas de la Actividad: ' . $model->nick;

?>
<div class="actividad-etiquetas">
    <h1><?= Html::encode($this->title) ?></h1>
    <p>
        <?= Html::a('Panel Administrador', ['actividades/administrador'], ['class' => 'btn btn-secondary']) ?>
    </p>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID Participante</th>
                <th>Nombre</th>
                <th>Descripción</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($etiquetas) && is_array($etiquetas)): ?>
                <?php foreach ($etiquetas as $participante): ?>
                    <tr>
                        <td><?= Html::encode($participante['id'] ?? $participante->id ?? 'N/A') ?></td>
                        <td><?= Html::encode($participante['nombre'] ?? $participante->nombre ?? 'N/A') ?></td>
                        <td><?= Html::encode($participante['descripcion'] ?? $participante->descripcion ?? 'N/A') ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="3">No hay etiquetas disponibles.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>
