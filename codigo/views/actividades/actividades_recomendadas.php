<?php
/** @var yii\web\View $this */
/** @var app\models\Actividad[] $actividades */

use yii\helpers\Html;

$this->title = 'Actividades Recomendadas';
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
                        <?php 
                            // Si no hay imagen principal, usar la imagen predeterminada
                            $imagen = !empty($actividad->imagen_principal) ? $actividad->imagen_principal : 'profile_4.jpg'; 
                        ?>
                        <div class="actividad-imagen">
                            <img src="<?= Yii::getAlias('@web/images/perfiles/') . Html::encode($imagen) ?>"
                                 alt="<?= Html::encode($actividad->titulo) ?>"
                                 class="img-fluid" style="max-width: 100%; height: 100px;">
                        </div>

                        <h3><?= Html::encode($actividad->titulo) ?></h3>
                        <p><?= Html::encode($actividad->descripcion) ?></p>
                        <p><strong>Fecha de celebración:</strong> <?= Html::encode($actividad->fecha_celebracion) ?></p>
                        <p>
                            <?= Html::a('Ver', ['ver_actividad', 'id' => $actividad->id], ['class' => 'btn btn-info']) ?>
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
                </div>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <p>No hay actividades recomendadas en este momento.</p>
    <?php endif; ?>
</div>