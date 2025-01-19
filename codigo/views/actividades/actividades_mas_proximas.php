<?php
/** @var yii\web\View $this */
/** @var app\models\Actividad[] $actividadesEsteMes */
/** @var app\models\Actividad[] $actividadesProximoMes */
/** @var app\models\Actividad[] $actividadesSiguientes */

use yii\helpers\Html;
use app\models\Roles;

$this->title = 'Actividades Próximas';

$this->params['breadcrumbs'][] = ['label' => 'Actividades', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<h1 class="text-center mb-4"><?= Html::encode($this->title) ?></h1>

<!-- Actividades de Este Mes -->
<h2 class="text-center mb-4">Este Mes</h2>
<div class="actividades-list">
    <?php if (!empty($actividadesEsteMes)): ?>
        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
            <?php foreach ($actividadesEsteMes as $actividad): ?>
                <div class="col">
                    <div class="card shadow-sm h-100 actividad-card">
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
                            <p class="card-text"><?= Html::encode($actividad['descripcion']) ?></p>
                            <p class="card-text"><strong>Fecha:</strong> <?= Html::encode($actividad['fecha_celebracion']) ?></p>
                        </div>
                        
                        
                        <!-- Información adicional que aparece al pasar el ratón -->
                        <div class="actividad-info">
                            <p class="card-text"><strong>Fecha:</strong> <?= Html::encode($actividad['fecha_celebracion']) ?></p>
                            <p class="card-text"><strong>Lugar:</strong> <?= Html::encode($actividad['lugar_celebracion'] ?? 'No especificado') ?></p>
                            <p class="card-text"><strong>Duración estimada:</strong> <?= Html::encode($actividad['duracion_estimada'] ?? 'No especificado') ?> minutos</p>
                            <?php if ($actividad['edad_recomendada'] > 0): ?>
                                <p class="card-text"><strong>Edad recomendada:</strong> <?= Html::encode($actividad['edad_recomendada'] ?? 'No especificado') ?></p>
                            <?php endif; ?>
                            <?php if ($actividad['contador_visitas'] > 0): ?>
                                <p class="card-text"><strong>Visitas:</strong> <?= Html::encode($actividad['contador_visitas']) ?></p>
                            <?php endif; ?>
                            <p class="card-text"><strong>Para más información haga clic en ver y podrá informarse al completo y se actualizarán los cambios que puedan surgir</strong></p>
                        </div>

                        <div class="card-footer d-flex justify-content-between">
                            <?= Html::a('Ver', 
                                [Yii::$app->user->hasRole([Roles::MODERADOR, Roles::ADMINISTRADOR, Roles::SYSADMIN]) ? 'ver_actividad' : 'actividad', 'id' => $actividad['id']], 
                                ['class' => 'btn btn-primary']) ?>
                            <?php if (Yii::$app->user->hasRole([Roles::MODERADOR, Roles::ADMINISTRADOR, Roles::SYSADMIN])): ?>
                                <?= Html::a('Editar', ['editar', 'id' => $actividad['id']], ['class' => 'btn btn-warning']) ?>
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
            No hay actividades este mes.
        </div>
    <?php endif; ?>
</div>

<!-- Actividades del Próximo Mes -->
<h2 class="text-center mb-4">Próximo Mes</h2>
<div class="actividades-list">
    <?php if (!empty($actividadesProximoMes)): ?>
        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
            <?php foreach ($actividadesProximoMes as $actividad): ?>
                <div class="col">
                    <div class="card shadow-sm h-100 actividad-card">
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
                            <p class="card-text"><?= Html::encode($actividad['descripcion']) ?></p>
                            <p class="card-text"><strong>Fecha:</strong> <?= Html::encode($actividad['fecha_celebracion']) ?></p>
                        </div>
                        
                        
                        <!-- Información adicional que aparece al pasar el ratón -->
                        <div class="actividad-info">
                            <p class="card-text"><strong>Fecha:</strong> <?= Html::encode($actividad['fecha_celebracion']) ?></p>
                            <p class="card-text"><strong>Lugar:</strong> <?= Html::encode($actividad['lugar_celebracion'] ?? 'No especificado') ?></p>
                            <p class="card-text"><strong>Duración estimada:</strong> <?= Html::encode($actividad['duracion_estimada'] ?? 'No especificado') ?> minutos</p>
                            <?php if ($actividad['edad_recomendada'] > 0): ?>
                                <p class="card-text"><strong>Edad recomendada:</strong> <?= Html::encode($actividad['edad_recomendada'] ?? 'No especificado') ?></p>
                            <?php endif; ?>
                            <?php if ($actividad['contador_visitas'] > 0): ?>
                                <p class="card-text"><strong>Visitas:</strong> <?= Html::encode($actividad['contador_visitas']) ?></p>
                            <?php endif; ?>
                            <p class="card-text"><strong>Para más información haga clic en ver y podrá informarse al completo y se actualizarán los cambios que puedan surgir</strong></p>
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
            No hay actividades el próximo mes.
        </div>
    <?php endif; ?>
</div>

<!-- Actividades Siguientes -->
<h2 class="text-center mb-4">Próximas...</h2>
<div class="actividades-list">
    <?php if (!empty($actividadesSiguientes)): ?>
        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
            <?php foreach ($actividadesSiguientes as $actividad): ?>
                <div class="col">
                    <div class="card shadow-sm h-100 actividad-card">
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
                            <p class="card-text"><?= Html::encode($actividad['descripcion']) ?></p>
                            <p class="card-text"><strong>Fecha:</strong> <?= Html::encode($actividad['fecha_celebracion']) ?></p>
                        </div>


                        <!-- Información adicional que aparece al pasar el ratón -->
                        <div class="actividad-info">
                            <p class="card-text"><strong>Fecha:</strong> <?= Html::encode($actividad['fecha_celebracion']) ?></p>
                            <p class="card-text"><strong>Lugar:</strong> <?= Html::encode($actividad['lugar_celebracion'] ?? 'No especificado') ?></p>
                            <p class="card-text"><strong>Duración estimada:</strong> <?= Html::encode($actividad['duracion_estimada'] ?? 'No especificado') ?> minutos</p>
                            <?php if ($actividad['edad_recomendada'] > 0): ?>
                                <p class="card-text"><strong>Edad recomendada:</strong> <?= Html::encode($actividad['edad_recomendada'] ?? 'No especificado') ?></p>
                            <?php endif; ?>
                            <?php if ($actividad['contador_visitas'] > 0): ?>
                                <p class="card-text"><strong>Visitas:</strong> <?= Html::encode($actividad['contador_visitas']) ?></p>
                            <?php endif; ?>
                            <p class="card-text"><strong>Para más información haga clic en ver y podrá informarse al completo y se actualizarán los cambios que puedan surgir</strong></p>
                        </div>

                        <div class="card-footer d-flex justify-content-between">
                            <?= Html::a('Ver', 
                                [Yii::$app->user->hasRole([Roles::MODERADOR, Roles::ADMINISTRADOR, Roles::SYSADMIN]) ? 'actividad' : 'ver_actividad', 'id' => $actividad['id']], 
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
            No hay más actividades próximas.
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