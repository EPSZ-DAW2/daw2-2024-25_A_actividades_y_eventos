<?php
/** @var yii\web\View $this */
/** @var app\models\Etiqueta[] $etiquetas */

use yii\helpers\Html;
use app\models\Roles;

$this->title = 'Actividades por Etiquetas';
$this->params['breadcrumbs'][] = ['label' => 'Actividades', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

// Obtener todas las imágenes asociadas a las actividades
$imgActividades = Yii::$app->db->createCommand('
    SELECT i.*, a.id AS actividad_id 
    FROM imagen i
    LEFT JOIN IMAGEN_ACTIVIDAD ia ON i.id = ia.IMAGENid 
    LEFT JOIN actividad a ON ia.ACTIVIDADid = a.id
')->queryAll();
?>

<h1 class="text-center mb-4"><?= Html::encode($this->title) ?></h1>

<div class="actividades-list">
    <?php if (!empty($etiquetas)): ?>
        <?php foreach ($etiquetas as $etiqueta): ?>
            <div class="etiqueta-section mb-5">
                <h2><?= Html::encode($etiqueta->nombre) ?></h2>
                <p><?= Html::encode($etiqueta->descripcion) ?></p>
                <div class="mb-3 d-flex gap-3">
                    <?= Html::a(
                        '<i class="bi bi-plus-circle"></i> Seguir Etiqueta', 
                        ['seguir-etiqueta', 'id' => $etiqueta->id], 
                        [
                            'class' => 'btn btn-success fw-bold text-white rounded-pill shadow',
                            'style' => 'font-size: 1.1rem; padding: 8px 16px;'
                        ]
                    ) ?>
                    <?= Html::a(
                        '<i class="bi bi-dash-circle"></i> Dejar de Seguir', 
                        ['dejar-seguir-etiqueta', 'id' => $etiqueta->id], 
                        [
                            'class' => 'btn btn-danger fw-bold text-white rounded-pill shadow',
                            'style' => 'font-size: 1.1rem; padding: 8px 16px;'
                        ]
                    ) ?>
                </div>
                <?php if (!empty($etiqueta->actividades)): ?>
                    <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
                        <?php foreach ($etiqueta->actividades as $actividad): ?>
                            <div class="col">
                                <div class="card shadow-sm h-100 actividad-card" style="position: relative;">
                                    <?php 
                                        // Verificar si la actividad tiene imagen asociada
                                        $imagen = null;
                                        foreach ($imgActividades as $img) {
                                            if ($img['actividad_id'] == $actividad->id) {
                                                $imagen = $img;
                                                break;
                                            }
                                        }
                                    ?>
                                    <img 
                                        src="<?= Yii::getAlias('@web/images/actividades/' . ($imagen ? Html::encode($imagen['nombre_Archivo'] . '.' . $imagen['extension']) : 'default.jpg')) ?>"
                                        alt="<?= Html::encode($actividad->titulo) ?>" 
                                        class="card-img-top" 
                                        style="height: 180px; object-fit: cover;"
                                    >
                                    <div class="card-body">
                                        <h5 class="card-title"><?= Html::encode($actividad->titulo) ?></h5>
                                        <p class="card-text text-muted" style="font-size: 0.9rem;"><?= Html::encode($actividad->descripcion) ?></p>
                                    </div>

                                    <!-- Información adicional al pasar el ratón -->
                                    <div class="actividad-info">
                                        <p class="card-text"><strong>Fecha:</strong> <?= Html::encode($actividad->fecha_celebracion) ?></p>
                                        <p class="card-text"><strong>Lugar:</strong> <?= Html::encode($actividad->lugar_celebracion ?? 'No especificado') ?></p>
                                        <p class="card-text"><strong>Duración:</strong> <?= Html::encode($actividad->duracion_estimada ?? 'No especificado') ?> minutos</p>
                                    </div>

                                    <div class="card-footer d-flex justify-content-between">
                                        <?= Html::a('Ver', 
                                            [Yii::$app->user->hasRole([Roles::MODERADOR, Roles::ADMINISTRADOR, Roles::SYSADMIN]) ? 'ver_actividad' : 'actividad', 'id' => $actividad['id']], 
                                            ['class' => 'btn btn-primary']) ?>
                                        <?php if (Yii::$app->user->hasRole([Roles::MODERADOR, Roles::ADMINISTRADOR, Roles::SYSADMIN])): ?>
                                            <?= Html::a('Editar', ['update', 'id' => $actividad['id']], ['class' => 'btn btn-warning ']) ?>
                                            <?= Html::a('Eliminar', ['delete', 'id' => $actividad['id']], [
                                                'class' => 'btn btn-danger ',
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
                        No hay actividades asociadas a esta etiqueta en este momento.
                    </div>
                <?php endif; ?>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <div class="alert alert-warning text-center" role="alert">
            No hay etiquetas disponibles en este momento.
        </div>
    <?php endif; ?>
</div>

<?php
$this->registerCss("
    .actividad-card {
        position: relative;
        overflow: hidden;
    }

    .actividad-info {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        background: rgba(0, 0, 0, 0.7);
        color: #fff;
        padding: 10px;
        font-size: 0.9rem;
        opacity: 0;
        transform: translateY(-100%);
        transition: all 0.3s ease;
        z-index: 10;
    }

    .actividad-card:hover .actividad-info {
        opacity: 1;
        transform: translateY(0);
    }

    .card-footer {
        position: relative;
        z-index: 20;
    }
");
?>

