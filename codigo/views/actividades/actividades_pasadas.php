<?php

/** @var yii\web\View $this */
/** @var app\models\Actividad[] $actividades */

use yii\helpers\Html;

$this->title = 'Actividades Pasadas';
$this->params['breadcrumbs'][] = ['label' => 'Actividades', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<h1 class="text-center mb-4"><?= Html::encode($this->title) ?></h1>

<div class="actividades-list">
    <?php if (!empty($actividades)): ?>
        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
            <?php foreach ($actividades as $actividad): ?>
                <div class="col">
                    <div class="card shadow-sm h-100 actividad-card" style="position: relative;">
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

                        <div class="actividad-info">
                            <p class="card-text"><strong>Lugar:</strong> <?= Html::encode($actividad['lugar_celebracion'] ?? 'No especificado') ?></p>
                            <p class="card-text"><strong>Duración estimada:</strong> <?= Html::encode($actividad['duracion_estimada'] ?? 'No especificado') ?> minutos</p>
                            <?php if ($actividad['edad_recomendada'] > 0): ?>
                                <p class="card-text"><strong>Edad recomendada:</strong> <?= Html::encode($actividad['edad_recomendada'] ?? 'No especificado') ?></p>
                            <?php endif; ?>
                            <?php if ($actividad['contador_visitas'] > 0): ?>
                                <p class="card-text"><strong>Visitas:</strong> <?= Html::encode($actividad['contador_visitas']) ?></p>
                            <?php endif; ?>
                            <p class="card-text"><strong>Para más información haga clic en ver y podrá informarse al completo y y se actualizarán los cambios que puedan surgir</strong></p>
                        </div>

                        <div class="card-footer d-flex justify-content-between">
                            <?= Html::a('Ver', ['ver_actividad', 'id' => $actividad['id']], ['class' => 'btn btn-info btn-sm']) ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <div class="alert alert-warning text-center" role="alert">
            No hay actividades pasadas en este momento.
        </div>
    <?php endif; ?>
</div> 

<div class = "d-none">
        <?php
            // API Key de Google Maps
            $apiKey = 'AIzaSyAwkqhsAcJIftL32sor2fYd5Q7-zaOkc5A';
            $direccionActividad = "plaza marina 1, 49004 Zamora";
            $direccionEncodedActividad = urlencode($direccionActividad);
            $urlActividad = "https://maps.googleapis.com/maps/api/geocode/json?address=$direccionEncodedActividad&components=country:ES&key=$apiKey";
            $responseActividad = file_get_contents($urlActividad);
            $dataActividad = json_decode($responseActividad, true);

            if ($dataActividad['status'] == 'OK') {
                $latActividad = $dataActividad['results'][0]['geometry']['location']['lat'];
                $lngActividad = $dataActividad['results'][0]['geometry']['location']['lng'];
            } else {
                $latActividad = null;
                $lngActividad = null;
            }

            $this->params['latActividad'] = $latActividad;
            $this->params['lngActividad'] = $lngActividad;


            // Agregar mapa de actividad
            if ($latActividad && $lngActividad) {
                echo "<div style='display: flex; justify-content: center; align-items: center;'>
                    <div id='map-actividad' style='width: 100%; height: 200px;'></div>
                </div>";
            }
        ?>
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
        z-index: 20; /* Asegura que los botones queden interactivos */
    }
");
?>