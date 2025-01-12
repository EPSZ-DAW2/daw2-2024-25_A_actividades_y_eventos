<?php
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $actividad array */

$this->title = $actividad['titulo'];
?>
<div class="actividad-view">
    <div class="row">
        <div class="col-lg-8 offset-lg-2">
            <div class="card">
                <!-- Imagen de la actividad si existe -->
                <?php if (!empty($actividad['nombre_Archivo'])): ?>
                    <img class="card-img-top" 
                         src="<?= Yii::getAlias('@web/images/actividades/' . 
                              Html::encode($actividad['nombre_Archivo'] . '.' . 
                              $actividad['extension'])) ?>"
                         alt="<?= Html::encode($actividad['titulo']) ?>">
                <?php else: ?>
                    <img class="card-img-top" 
                         src="<?= Yii::getAlias('@web/images/default.jpg') ?>" 
                         alt="Imagen predeterminada">
                <?php endif; ?>

                <div class="card-body">
                    <h1 class="card-title"><?= Html::encode($actividad['titulo']) ?></h1>
                    <div class="mb-4">
                        <h5>Descripción</h5>
                        <p class="card-text"><?= Html::encode($actividad['descripcion']) ?></p>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <h5>Detalles del Evento</h5>
                            <p><strong>Fecha:</strong> <?= Yii::$app->formatter->asDateTime($actividad['fecha_celebracion']) ?></p>
                            <p><strong>Duración:</strong> <?= Html::encode($actividad['duracion_estimada']) ?> minutos</p>
                            <p><strong>Lugar:</strong> <?= Html::encode($actividad['lugar_celebracion']) ?></p>
                            <p><strong>Edad Recomendada:</strong> <?= Html::encode($actividad['edad_recomendada']) ?> años</p>
                        </div>
                        <div class="col-md-6">
                            <h5>Participación</h5>
                            <p><strong>Participantes:</strong> <?= Html::encode($actividad['participantes']) ?></p>
                            <p><strong>Mínimo:</strong> <?= Html::encode($actividad['minimo_participantes']) ?></p>
                            <p><strong>Máximo:</strong> <?= Html::encode($actividad['maximo_participantes']) ?></p>
                            <p><strong>Reserva disponible:</strong> <?= Html::encode($actividad['reserva'] ? 'Sí' : 'No') ?></p>
                        </div>
                    </div>

                    <div class="mb-3">
                        <h5>Valoraciones</h5>
                        <div class="d-flex justify-content-start">
                            <!-- Botón de Like -->
                            <?= Html::a('<i class="fas fa-thumbs-up"></i> Me gusta', ['actividades/like', 'id' => $actividad['id']], [
                                'class' => 'btn btn-success btn-sm me-2',
                                'data' => [
                                    'method' => 'post',
                                ],
                            ]) ?>

                            <!-- Botón de Dislike -->
                            <?= Html::a('<i class="fas fa-thumbs-down"></i> No me gusta', ['actividades/dislike', 'id' => $actividad['id']], [
                                'class' => 'btn btn-danger btn-sm',
                                'data' => [
                                    'method' => 'post',
                                ],
                            ]) ?>
                        </div>
                        <p class="text-success">Votos positivos: <?= Html::encode($actividad['votosOK']) ?></p>
                        <p class="text-danger">Votos negativos: <?= Html::encode($actividad['votosKO']) ?></p>
                    </div>

                    <?php if (!empty($actividad['detalles']) || !empty($actividad['notas'])): ?>
                        <div class="mb-3">
                            <h5>Información Adicional</h5>
                            <?php if (!empty($actividad['detalles'])): ?>
                                <p><strong>Detalles:</strong> <?= Html::encode($actividad['detalles']) ?></p>
                            <?php endif; ?>
                            <?php if (!empty($actividad['notas'])): ?>
                                <p><strong>Notas:</strong> <?= Html::encode($actividad['notas']) ?></p>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>

                    <!-- Botón para registrarse en la actividad -->
                    <?php
                        // Crear un objeto DateTime a partir de la fecha de celebración
                        $fechaCelebracion = new DateTime($actividad['fecha_celebracion']);

                        // Crear un objeto DateTime para la fecha y hora actual
                        $fechaActual = new DateTime();

                        // Comprobar si la fecha de celebración es anterior a la fecha actual
                        if ($fechaCelebracion > $fechaActual) {
                            echo Html::a('Participar', ['actividades/registrar', 'id' => $actividad['id']], [
                                'class' => 'btn btn-warning',
                                'data' => [
                                    'confirm' => '¿Estás seguro de que deseas participar en esta actividad?',
                                    'method' => 'post',
                                ],
                            ]);
                        } else {
                            echo '<div class="alert alert-danger" role="alert">Esta actividad ya ha finalizado.</div>';
                        }
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>
