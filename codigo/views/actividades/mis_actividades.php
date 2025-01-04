<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Inscripcion[] $inscripciones */

$this->title = 'Mis Actividades';
?>

<h1><?= Html::encode($this->title) ?></h1>

<div class="mis-actividades">
    <?php if (!empty($inscripciones)): ?>
        <ul class="list-group">
            <?php foreach ($inscripciones as $inscripcion): ?>
                <li class="list-group-item">
                    <h4><?= Html::encode($inscripcion->actividad->titulo) ?></h4>
                    <p><strong>Descripción:</strong> <?= Html::encode($inscripcion->actividad->descripcion) ?></p>
                    <p><strong>Fecha:</strong> <?= Html::encode($inscripcion->actividad->fecha_celebracion) ?></p>
                    <p><strong>Lugar:</strong> <?= Html::encode($inscripcion->actividad->lugar_celebracion) ?></p>
                    <p><strong>Fecha de inscripción:</strong> <?= Html::encode($inscripcion->fecha_inscripcion) ?></p>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php else: ?>
        <p>No estás inscrito en ninguna actividad.</p>
    <?php endif; ?>
</div>
