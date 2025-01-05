<?php
/* @var $this yii\web\View */
/* @var $model app\models\Actividad */
/* @var $participantes app\models\Participante[] */

use yii\helpers\Html;

// $this->title = 'Participantes de la Actividad: ' . $model->nick;

?>
<div class="actividad-participantes">
    <h1><?= Html::encode($this->title) ?></h1>
    <p>
        <?= Html::a('Panel Administrador', ['actividades/administrador'], ['class' => 'btn btn-secondary']) ?>
    </p>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID Participante</th>
                <th>Nombre</th>
                <th>Email</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($participantes) && is_array($participantes)): ?>
                <?php foreach ($participantes as $participante): ?>
                    <tr>
                        <td><?= Html::encode($participante['id'] ?? $participante->id ?? 'N/A') ?></td>
                        <td><?= Html::encode($participante['nombre'] ?? $participante->nombre ?? 'N/A') ?></td>
                        <td><?= Html::encode($participante['email'] ?? $participante->email ?? 'N/A') ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="3">No hay participantes disponibles.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>
