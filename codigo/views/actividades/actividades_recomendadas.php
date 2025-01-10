<?php
/** @var yii\web\View $this */
/** @var app\models\Actividad[] $actividades */

use yii\helpers\Html;
use app\models\Roles;

$this->title = 'Actividades Recomendadas';
$this->params['breadcrumbs'][] = ['label' => 'Actividades', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<h1 class="text-center mb-4"><?= Html::encode($this->title) ?></h1>

<div class="actividades-list">
    <?php if (!empty($masVotadas)): ?>
        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
            <?php foreach ($masVotadas as $actividad): ?>
                <div class="col">
                    <div class="card shadow-sm h-100">
                        <?php if (!empty($actividad['nombre_Archivo'])): ?>
                            <img 
                                src="<?= Yii::getAlias('@web/images/actividades/' . Html::encode($actividad['nombre_Archivo'] . '.' . $actividad['extension'])) ?>"
                                alt="<?= Html::encode($actividad['titulo']) ?>" 
                                class="card-img-top" 
                                style="height: 180px; object-fit: cover;"
                            >
                        <?php else: ?>
                            <img 
                                src="<?= Yii::getAlias('@web/images/actividades/default.jpg') ?>"
                                alt="<?= Html::encode($actividad['titulo']) ?>" 
                                class="card-img-top" 
                                style="height: 180px; object-fit: cover;"
                            >
                        <?php endif; ?>
                        <div class="card-body">
                            <h5 class="card-title"><?= Html::encode($actividad['titulo']) ?></h5>
                            <p class="card-text text-muted" style="font-size: 0.9rem;"><?= Html::encode($actividad['descripcion']) ?></p>
                            <p class="card-text"><strong>Fecha:</strong> <?= Html::encode($actividad['fecha_celebracion']) ?></p>
                        </div>
                        <div class="card-footer d-flex justify-content-between">
                            <?= Html::a('Ver', 
                                [Yii::$app->user->hasRole([Roles::MODERADOR, Roles::ADMINISTRADOR, Roles::SYSADMIN]) ? 'ver_actividad' : 'actividad', 'id' => $actividad['id']], 
                                ['class' => 'btn btn-info btn-sm']) ?>
                            <?php if (Yii::$app->user->hasRole([Roles::MODERADOR, Roles::ADMINISTRADOR, Roles::SYSADMIN])): ?>
                                <?= Html::a('Editar', ['update', 'id' => $actividad['id']], ['class' => 'btn btn-primary btn-sm']) ?>
                                <?= Html::a('Eliminar', ['delete', 'id' => $actividad['id']], [
                                    'class' => 'btn btn-danger btn-sm',
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
        </div>
    <?php else: ?>
        <div class="alert alert-warning text-center" role="alert">
            No hay actividades recomendadas en este momento.
        </div>
    <?php endif; ?>
</div>
