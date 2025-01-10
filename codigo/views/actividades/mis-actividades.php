<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $actividades array */

$this->title = 'Actividades en las que estoy apuntado';
?>
<div class="mis-actividades">
    <h1><?= Html::encode($this->title) ?></h1>

    <?php if (!empty($actividades)): ?>
        <div class="row">
            <?php foreach ($actividades as $actividad): ?>
                <div class="col-lg-4 mb-4">
                    <div class="card h-100">
                        <?php if (!empty($actividad['nombre_Archivo'])): ?>
                            <img class="card-img-top" 
                                 src="<?= Yii::getAlias('@web/images/actividades/' . 
                                      Html::encode($actividad['nombre_Archivo'] . '.' . 
                                      $actividad['extension'])) ?>"
                                 alt="<?= Html::encode($actividad['titulo']) ?>">
                        <?php else: ?>
                            <img class="card-img-top" 
                                 src="<?= Yii::getAlias('@web/images/default.jpg') ?>" 
                                 alt="Imagen predeterminada">
                        <?php endif; ?>

                        <div class="card-body">
                            <h5 class="card-title"><?= Html::encode($actividad['titulo']) ?></h5>
                            <p class="card-text"><?= Html::encode($actividad['descripcion']) ?></p>
                            <p class="card-text">
                                <small class="text-muted">
                                    Fecha: <?= Yii::$app->formatter->asDateTime($actividad['fecha_celebracion']) ?>
                                </small>
                            </p>
                            <?= Html::a('Desapuntarse', ['actividades/desapuntar', 'id' => $actividad['id']], [
                                'class' => 'btn btn-danger',
                                'data' => [
                                    'confirm' => '¿Estás seguro de que deseas desapuntarte de esta actividad?',
                                    'method' => 'post',
                                ],
                            ]) ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <p>No estás apuntado a ninguna actividad.</p>
    <?php endif; ?>
</div>
