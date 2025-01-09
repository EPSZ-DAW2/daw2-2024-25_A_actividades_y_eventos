<?php
/** @var yii\web\View $this */
/** @var app\models\Actividad[] $actividades */

use yii\helpers\Html;

$this->title = 'Actividades Más Buscadas';
$this->params['breadcrumbs'][] = ['label' => 'Actividades', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<h1><?= Html::encode($this->title) ?></h1>
    <div class="actividades-list">
    <?php if (!empty($actividades)): ?>
        <div class="list-group">
            <?php foreach ($actividades as $actividad): ?>
                <div class="list-group-item">
                <div class="actividad">
                    <h2><?= Html::encode($actividad->titulo) ?></h2>
                    <p><?= Html::encode($actividad->descripcion) ?></p>
                    <?php if (!empty($actividad->imagen_principal)): ?>
                        <img src="<?= Yii::getAlias('@web') . '/images/' . Html::encode($actividad->imagen_principal) ?>" 
                            alt="<?= Html::encode($actividad->titulo) ?>" 
                            class="actividad-imagen">
                    <?php endif; ?>
                    <p><strong>Votos Positivos:</strong> <?= Html::encode($actividad->votosOK) ?></p>
                    <p>
                    <?= Html::a('Ver', ['ver_actividad', 'id' => $actividad->id], ['class' => 'btn btn-info']) ?>
                    </p>
                </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <p>No hay actividades próximas en este momento.</p>
    <?php endif; ?>
    </div>