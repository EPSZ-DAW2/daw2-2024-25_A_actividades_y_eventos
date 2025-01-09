<?php

/** @var yii\web\View $this */
/** @var app\models\Actividad[] $actividades */

use yii\helpers\Html;

$this->title = 'Actividades Más Visitadas';
$this->params['breadcrumbs'][] = ['label' => 'Actividades', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<h1><?= Html::encode($this->title) ?></h1>

<div class="actividades-list">
    <?php if (!empty($actividades)): ?>
        <div class="list-group">
            <?php foreach ($actividades as $actividad): ?>
                <div class="actividad list-group-item">
                    <h2><?= Html::encode($actividad->titulo) ?></h2>
                    <p><?= Html::encode($actividad->descripcion) ?></p>
                    
                    <?php if (!empty($actividad->imagen_principal)): ?>
                        <img src="<?= Yii::getAlias('@web') . '/images/' . Html::encode($actividad->imagen_principal) ?>" 
                             alt="<?= Html::encode($actividad->titulo) ?>" 
                             class="actividad-imagen img-fluid" /> <!-- Aseguramos que la imagen sea responsiva -->
                    <?php endif; ?>
                    
                    <p><strong>Visitas:</strong> <?= Html::encode($actividad->contador_visitas) ?></p>
                    <p>
                        <?= Html::a('Ver más', ['ver_actividad', 'id' => $actividad->id], ['class' => 'btn btn-info']) ?>
                    </p>
                </div>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <p>No hay actividades más visitadas en este momento.</p>
    <?php endif; ?>
</div>
