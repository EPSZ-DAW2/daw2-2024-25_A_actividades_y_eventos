<?php
/** @var yii\web\View $this */
/** @var app\models\Actividad[] $actividades */

use yii\helpers\Html;

$this->title = 'Actividades Recomendadas';
?>

<h1><?= Html::encode($this->title) ?></h1>

<p>
    <?= Html::a('Crear Actividad', ['create'], ['class' => 'btn btn-success']) ?>
</p>

<div class="actividades-list">
    <?php if (!empty($actividades)): ?>
        <?php foreach ($actividades as $actividad): ?>
            <div class="actividad">
                <h2><?= Html::encode($actividad->titulo) ?></h2>
                <p><?= Html::encode($actividad->descripcion) ?></p>
                <?php if (!empty($actividad->imagen_principal)): ?>
                    <img src="<?= Yii::getAlias('@web') . '/images/' . Html::encode($actividad->imagen_principal) ?>" 
                         alt="<?= Html::encode($actividad->titulo) ?>" 
                         class="actividad-imagen">
                <?php endif; ?>
                <p><strong>Fecha de celebración:</strong> <?= Html::encode($actividad->fecha_celebracion) ?></p>
                <p>
                    <?= Html::a('Ver', ['view', 'id' => $actividad->id], ['class' => 'btn btn-info']) ?>
                    <?= Html::a('Editar', ['update', 'id' => $actividad->id], ['class' => 'btn btn-primary']) ?>
                    <?= Html::a('Eliminar', ['delete', 'id' => $actividad->id], [
                        'class' => 'btn btn-danger',
                        'data' => [
                            'confirm' => '¿Estás seguro de que deseas eliminar esta actividad?',
                            'method' => 'post',
                        ],
                    ]) ?>
                </p>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <p>No hay actividades recomendadas en este momento.</p>
    <?php endif; ?>
</div>
