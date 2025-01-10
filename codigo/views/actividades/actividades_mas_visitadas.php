<?php
/** @var yii\web\View $this */
/** @var app\models\Actividad[] $actividades */

use yii\helpers\Html;
use app\models\Roles;

$this->title = 'Actividades Más Visitadas';
$this->params['breadcrumbs'][] = ['label' => 'Actividades', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<h1 class="text-center mb-4"><?= Html::encode($this->title) ?></h1>

<div class="activities-section mt-5">
    <h2><?= Html::encode($this->title) ?></h2>
    <div class="row">
        <?php if (!empty($actividades)): ?>
            <?php foreach ($actividades as $actividad): ?>
                <div class="col-lg-4 mb-4">
                    <div class="card h-100">
                        <?php if (!empty($actividad['nombre_Archivo'])): ?>
                            <img class="card-img-top fixed-size-img" 
                                 src="<?= Yii::getAlias('@web/images/actividades/' . Html::encode($actividad['nombre_Archivo'] . '.' . $actividad['extension'])) ?>"
                                 alt="<?= Html::encode($actividad['titulo']) ?>">
                        <?php else: ?>
                            <img class="card-img-top fixed-size-img" 
                                 src="<?= Yii::getAlias('@web/images/actividades/default.jpg') ?>"
                                 alt="<?= Html::encode($actividad['titulo']) ?>">
                        <?php endif; ?>

                        <div class="card-body">
                            <h5 class="card-title"><?= Html::encode($actividad['titulo']) ?></h5>
                            <p class="card-text"><?= Html::encode($actividad['descripcion']) ?></p>
                            <p class="card-text">
                                <small class="text-muted">
                                    Visitas: <?= Html::encode($actividad['contador_visitas']) ?>
                                </small>
                            </p>
                            <?= Html::a('Ver más', 
                                [Yii::$app->user->hasRole([Roles::MODERADOR, Roles::ADMINISTRADOR, Roles::SYSADMIN]) ? 'actividades/ver_actividad' : 'actividades/actividad', 'id' => $actividad['id']], 
                                ['class' => 'btn btn-primary']) ?>
                            <?php if (Yii::$app->user->hasRole([Roles::MODERADOR, Roles::ADMINISTRADOR, Roles::SYSADMIN])): ?>
                                <?= Html::a('Editar', ['editar', 'id' => $actividad['id']], ['class' => 'btn btn-warning']) ?>
                                <?= Html::a('Eliminar', ['eliminar', 'id' => $actividad['id']], [
                                    'class' => 'btn btn-danger',
                                    'data' => [
                                        'confirm' => '¿Estás seguro de que deseas eliminar esta actividad?',
                                        'method' => 'post',
                                    ],
                                ]) ?>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="alert alert-warning text-center" role="alert">
                No hay actividades más visitadas en este momento.
            </div>
        <?php endif; ?>
    </div>
</div>
