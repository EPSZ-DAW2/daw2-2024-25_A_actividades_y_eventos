<?php
/** @var yii\web\View $this */
/** @var app\models\Actividades[] $actividades */

use yii\helpers\Html;

$this->title = 'Actividades Recomendadas';
?>

<h1><?= Html::encode($this->title) ?></h1>


<!-- Mostrar lista de actividades -->
<div class="actividades-list">
    <?php if (!empty($actividades)): ?>
        <?php foreach ($actividades as $actividad): ?>
            <div class="actividad">
                <h2><?= Html::encode($actividad->titulo) ?></h2>
                <p><?= Html::encode($actividad->descripcion) ?></p>
                <?php if ($actividad->imagen): ?>
                    <img src="<?= Yii::getAlias('@web') . '/images/' . Html::encode($actividad->imagen) ?>" alt="<?= Html::encode($actividad->titulo) ?>">
                <?php endif; ?>
                <p><strong>Fecha:</strong> del <?= Html::encode($actividad->fecha_inicio) ?> al <?= Html::encode($actividad->fecha_fin) ?></p>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <p>No hay actividades recomendadas en este momento.</p>
    <?php endif; ?>
</div>
