<?php
/* @var $this yii\web\View */
/* @var $actividades app\models\Actividad[] */

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\grid\GridView;
use yii\data\ActiveDataProvider;
use app\models\Roles;

$this->title = 'Actividades';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="actividades-index">
    <div class="text-center mb-4">
        <h1><?= Html::encode($this->title) ?></h1>
    </div>

    <?php if (!Yii::$app->user->isGuest): ?>
        <div class="text-center mb-4">
            <?= Html::a('Crear Actividad', ['crear'], ['class' => 'btn btn-success btn-lg']) ?>
        </div>
    <?php endif; ?>

    <div class="text-center mb-4">
        <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-3 justify-content-center">
            <div class="col">
                <a href="<?= Yii::$app->urlManager->createUrl(['actividades/recomendadas']) ?>" class="btn btn-outline-primary btn-lg w-100">
                    <i class="bi bi-star me-2"></i> Actividades Recomendadas
                </a>
            </div>
            <div class="col">
                <a href="<?= Yii::$app->urlManager->createUrl(['actividades/mas-proximas']) ?>" class="btn btn-outline-primary btn-lg w-100">
                    <i class="bi bi-geo-alt me-2"></i> Actividades Más Cercanas
                </a>
            </div>
            <div class="col">
                <a href="<?= Yii::$app->urlManager->createUrl(['actividades/mas-visitadas']) ?>" class="btn btn-outline-primary btn-lg w-100">
                    <i class="bi bi-eye me-2"></i> Actividades Más Visitadas
                </a>
            </div>
            <!--<div class="col">
                <a href="<?= Yii::$app->urlManager->createUrl(['actividades/mas-buscadas']) ?>" class="btn btn-outline-primary btn-lg w-100">
                    <i class="bi bi-search me-2"></i> Actividades Más Buscadas
                </a>
            </div>-->
            <div class="col">
                <a href="<?= Yii::$app->urlManager->createUrl(['actividades/pasadas']) ?>" class="btn btn-outline-primary btn-lg w-100">
                    <i class="bi bi-calendar-x me-2"></i> Actividades Pasadas
                </a>
            </div>
            <div class="col">
                <a href="<?= Yii::$app->urlManager->createUrl(['actividades/nuevas']) ?>" class="btn btn-outline-primary btn-lg w-100">
                    <i class="bi bi-plus-circle me-2"></i> Actividades Nuevas
                </a>
            </div>
        </div>
    </div>

    <div class="text-center mb-4">
        <a href="<?= Yii::$app->urlManager->createUrl(['actividades/actividades-etiquetas']) ?>" class="btn btn-outline-info btn-lg">
            <i class="bi bi-tags me-2"></i> Actividades por Etiquetas
        </a>
    </div>


    <!-- Buscador -->
    <div class="search-container text-center mt-4 mb-4">
        <h2>Buscar Actividades</h2>
        <?= Html::beginForm(['actividades/index'], 'get', ['class' => 'search-form']) ?>
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="input-group">
                        <?= Html::textInput('q', Yii::$app->request->get('q'), [
                            'class' => 'form-control',
                            'placeholder' => 'Buscar por título, descripción o lugar...',
                        ]) ?>
                        <div class="input-group-append">
                            <?= Html::submitButton('Buscar', ['class' => 'btn btn-primary']) ?>
                        </div>
                    </div>
                </div>
            </div>
        <?= Html::endForm() ?>
    </div>

    <!-- Resultados de búsqueda -->
    <?php if (isset($dataProvider) && $searchTerm !== ''): ?>
        <div class="search-results mt-4">
            <h3>Resultados de búsqueda para: "<?= Html::encode($searchTerm) ?>"</h3>

            <?php if ($dataProvider->getTotalCount() > 0): ?>
                <?= GridView::widget([
                    'dataProvider' => $dataProvider,
                    'columns' => [
                        [
                            'attribute' => 'titulo',
                            'format' => 'raw',
                            'value' => function($model) {
                                return Html::a(
                                    Html::encode($model->titulo),
                                    ['actividades/actividad', 'id' => $model->id],
                                    ['class' => 'activity-title']
                                );
                            }
                        ],
                        'descripcion:ntext',
                        [
                            'attribute' => 'fecha_celebracion',
                            'format' => ['date', 'php:d-m-Y H:i']
                        ],
                        'lugar_celebracion',
                    ],
                    'layout' => "{summary}\n{items}\n{pager}",
                    'emptyText' => 'No se encontraron actividades.',
                    'summary' => 'Mostrando {begin}-{end} de {totalCount} actividades.',
                ]); ?>
            <?php else: ?>
                <div class="alert alert-info">
                    <p>No se encontraron actividades que coincidan con "<?= Html::encode($searchTerm) ?>"</p>
                    <p>Sugerencias:</p>
                    <ul>
                        <li>Revise la ortografía</li>
                        <li>Use términos más generales</li>
                        <li>Pruebe con menos palabras</li>
                    </ul>
                </div>
            <?php endif; ?>
        </div>
    <?php else: ?>
        <!-- Lista de actividades normal -->
        <div class="row">
            <div class="col-lg-12">
                <h2>Lista de Actividades</h2>
                <?php if (!empty($actividades)): ?>
                    <div class="row">
                        <?php foreach ($actividades as $actividad): ?>
                            <div class="col-md-4 mb-4">
                                <div class="card shadow-sm h-100 actividad-card" style="position: relative;">
                                    <?php 
                                        // Buscar si la actividad tiene una imagen asociada
                                        $imagen = null;
                                        foreach ($imgActividades as $img) {
                                            if ($img['actividad_id'] == $actividad->id) {
                                                $imagen = $img;
                                                break;
                                            }
                                        }

                                        if ($imagen): ?>
                                            <img 
                                                src="<?= Yii::getAlias('@web/images/actividades/' . Html::encode($img['nombre_Archivo'] . '.' . $img['extension'])) ?>"  
                                                alt="<?= Html::encode($actividad->titulo) ?>" 
                                                class="card-img-top" style="height: 180px; object-fit: cover;">
                                        <?php else: ?>
                                            <img 
                                                src="<?= Yii::getAlias('@web/images/actividades/default.jpg') ?>" 
                                                alt="<?= Html::encode($actividad->titulo) ?>" 
                                                class="card-img-top" style="height: 180px; object-fit: cover;">
                                        <?php endif; ?>

                                    <div class="card-body">
                                        <h5 class="card-title"><?= Html::encode($actividad->titulo) ?></h5>
                                        <p class="card-text"><?= Html::encode($actividad->descripcion) ?></p>
                                    </div>
                                    
                                    <!-- Información adicional que aparece al pasar el ratón -->
                                    <div class="actividad-info">
                                        <p><strong>Fecha de Celebración:</strong> <?= Yii::$app->formatter->asDate($actividad->fecha_celebracion) ?></p>
                                        <p class="card-text"><strong>Lugar:</strong> <?= Html::encode($actividad['lugar_celebracion'] ?? 'No especificado') ?></p>
                                        <p class="card-text"><strong>Duración estimada:</strong> <?= Html::encode($actividad['duracion_estimada'] ?? 'No especificado') ?> minutos</p>
                                        <?php if ($actividad['edad_recomendada'] > 0): ?>
                                            <p class="card-text"><strong>Edad recomendada:</strong> <?= Html::encode($actividad['edad_recomendada'] ?? 'No especificado') ?></p>
                                        <?php endif; ?>
                                        <?php if ($actividad['contador_visitas'] > 0): ?>
                                            <p class="card-text"><strong>Visitas:</strong> <?= Html::encode($actividad['contador_visitas']) ?></p>
                                        <?php endif; ?>
                                        <p class="card-text"><strong>Para más información haga clic en Ver Detalles y podrá informarse al completo y se actualizarán los cambios que puedan surgir</strong></p>
                                    </div>
                                    
                                    <div class="card-footer d-flex justify-content-between">
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
                    </div>
                <?php else: ?>
                    <p>No hay actividades disponibles en este momento.</p>
                <?php endif; ?>
            </div>
        </div>
    <?php endif; ?>
</div>

<?php
$this->registerCss("
    .activity-title { 
        color: #007bff;
        text-decoration: none;
        font-weight: bold;
    }
    .activity-title:hover {
        text-decoration: underline;
    }

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