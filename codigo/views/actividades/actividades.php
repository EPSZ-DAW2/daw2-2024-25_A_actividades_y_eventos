<?php
/* @var $this yii\web\View */
/* @var $actividades app\models\Actividad[] */

use yii\helpers\Html;

$this->title = 'Actividades';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="actividades-index">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?php if (!Yii::$app->user->isGuest): ?>
            <?= Html::a('Crear Actividad', ['crear'], ['class' => 'btn btn-success']) ?>
        <?php endif; ?>
        <?= Html::a('Actividades Recomendadas', ['recomendadas'], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Próximas Actividades', ['mas-proximas'], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Actividades Más Visitadas', ['mas-visitadas'], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Actividades Pasadas', ['pasadas-usuario', 'usuarioId' => Yii::$app->user->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Actividades Más Buscadas', ['mas-buscadas'], ['class' => 'btn btn-primary']) ?>
    </p>

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
                            <?= Html::a('Ver Detalles', ['ver_actividad', 'id' => $actividad->id], ['class' => 'btn btn-info']) ?>
                        </p>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <p>No hay actividades próximas en este momento.</p>
    <?php endif; ?>
    </div>
</div>