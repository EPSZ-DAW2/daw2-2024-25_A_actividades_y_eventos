<?php
/* @var $this yii\web\View */
/* @var $actividades app\models\Actividad[] */

use yii\helpers\Html;


?>
<div class="actividades-index">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Actividades Recomendadas', ['actividades/recomendadas'], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Actividades Más Cercanas', ['actividades/mas-proximas'], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Actividades Más Nuevas', ['actividades/mas-nuevas'], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Actividades Más Visitadas', ['actividades/mas-visitadas'], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Actividades Pasadas', ['actividades/pasadas-usuario', 'usuarioId' => Yii::$app->user->id], ['class' => 'btn btn-primary']) ?>
    </p>

    <div class="row">
        <div class="col-lg-12">
            <h2>Lista de Actividades</h2>
            <?php if (!empty($actividades)): ?>
                <ul class="list-unstyled">
                    <?php foreach ($actividades as $actividad): ?>
                        <li class="mb-4">
                            <h3><?= Html::encode($actividad->titulo) ?></h3>
                            <p><?= Html::encode($actividad->descripcion) ?></p>
                            <p><strong>Fecha de Celebración:</strong> <?= Yii::$app->formatter->asDate($actividad->fecha_celebracion) ?></p>
                            <?= Html::a('Ver Detalles', ['ver_actividad', 'id' => $actividad->id], ['class' => 'btn btn-info']) ?>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php else: ?>
                <p>No hay actividades disponibles en este momento.</p>
            <?php endif; ?>
        </div>
    </div>
</div>
