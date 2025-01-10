<?php
/** @var yii\web\View $this */
/** @var yii\data\ActiveDataProvider $dataProvider */

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\grid\GridView;
use yii\data\ActiveDataProvider;
use yii\widgets\ListView;

$this->title = 'Portada';
?>
<div class="site-index">
    <div class="container-fluid">
        <div class="row">
            <!-- Botón para alternar el menú -->
            <!--<button id="toggleMenu" class="btn btn-outline-primary position-fixed" style="top: 20px; left: 20px; z-index: 1050;">
                <i class="bi bi-list"></i> Menú
            </button>-->

            <!-- Sidebar fijo -->
            <div id="sidebar" class="col-md-3 col-lg-2 bg-light sidebar position-fixed" style="top: 0; left: 0; bottom: 0; overflow-y: auto; height: 100vh; padding-top: 20px; padding-right: 15px; box-shadow: 4px 0 8px rgba(0, 0, 0, 0.1); border-radius: 0 10px 10px 0; background-color: #f9f9f9; transform: translateX(0); transition: transform 0.3s ease;">
                <div class="position-sticky mt-4">
                    <h5 class="text-center text-primary font-weight-bold mb-4">Selecciona un Filtro</h5>
                    <ul class="nav flex-column">
                        <?php foreach ($categorias as $categoria => $url): ?>
                            <li class="nav-item">
                            <style>
                                .nav-link:hover {
                                    color: black !important; 
                                    background-color: #d0e0f0 !important;
                                }
                            </style>
                                <a class="nav-link btn btn-outline-primary btn-lg w-100" href="<?= Yii::$app->urlManager->createUrl([$url]) ?>" style="font-size: 18px; padding: 12px; border-radius: 5px; transition: background-color 0.3s ease;">
                                    <!-- Añadir el ícono solo si la categoría tiene una condición -->
                                    <?php if ($categoria == 'Más Visitadas'): ?>
                                        <i class="bi bi-eye me-2"></i>
                                    <?php elseif ($categoria == 'Recomendadas'): ?>
                                        <i class="bi bi-star me-2"></i>
                                    <?php elseif ($categoria == 'Próximas'): ?>
                                        <i class="bi bi-geo-alt me-2"></i>
                                    <?php elseif ($categoria == 'Pasadas'): ?>
                                        <i class="bi bi-calendar-x me-2"></i>
                                    <?php elseif ($categoria == 'Nuevas'): ?>
                                        <i class="bi bi-plus-circle me-2"></i>
                                    <?php endif; ?>
                                    <?= Html::encode($categoria) ?>
                                </a>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </div>



            <!-- Contenido Principal -->
            <div class="col-md-9 col-lg-10 ms-sm-auto px-4" style="margin-left: 25%;">
                <div class="jumbotron text-center bg-transparent" style="margin: 50px 0;">
                    <h1 class="display-4"> ¡Bienvenido/a, <?= Html::encode(Yii::$app->user->identity->nick ?? 'Usuario') ?>!</h1>
                </div>

                <!-- Buscador -->
                <div class="search-container text-center mt-4">
                    <h2>Buscar Actividades</h2>
                    <?= Html::beginForm(['site/index2'], 'get', ['class' => 'search-form']) ?>
                        <div class="row justify-content-center">
                            <div class="col-md-8">
                                <div class="input-group">
                                    <?= Html::textInput('q', 
                                        Yii::$app->request->get('q'), 
                                        [
                                            'class' => 'form-control',
                                            'placeholder' => 'Buscar por título, descripción o lugar...',
                                        ]
                                    ) ?>
                                    <div class="input-group-append">
                                        <?= Html::submitButton('Buscar', ['class' => 'btn btn-primary']) ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?= Html::endForm() ?>
                </div>

                <!-- Resultados de búsqueda -->
                <?php if (isset($searchProvider) && $searchTerm !== ''): ?>
                    <div class="search-results mt-4">
                        <h3>Resultados de búsqueda para: "<?= Html::encode($searchTerm) ?>"</h3>
                        
                        <?php if ($searchProvider->getTotalCount() > 0): ?>
                            <?= GridView::widget([
                                'dataProvider' => $searchProvider,
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
                <?php endif; ?>

                </br></br>

                <!-- Carrusel de imágenes -->
                <style>
                    .size-carrusel {
                        width: 100%; 
                        height: 600px; 
                        object-fit: cover; 
                    }
                    /* para que no se vean los numeros en el carrousel */
                    .carousel-indicators [data-bs-target] {
                        color: transparent;
                        border: 0;
                    }
                </style>
                <div id="carouselExampleIndicators" class="carousel slide" data-bs-ride="carousel" data-bs-interval="5000">
                    <ol class="carousel-indicators">
                        <?php foreach ($imgActividades as $index => $imagen): ?>
                            <li data-bs-target="#carouselExampleIndicators" 
                                data-bs-slide-to="<?= $index ?>" 
                                class="<?= $index === 0 ? 'active' : '' ?>"></li>
                        <?php endforeach; ?>
                    </ol>

                    <div class="carousel-inner">
                    <?php foreach ($imgActividades as $index => $imagen): ?>
                        <div class="carousel-item <?= $index === 0 ? 'active' : '' ?> size-carrusel">
                            <a href="<?= isset($imagen['id']) ? Yii::$app->urlManager->createUrl(['actividades/actividad', 'id' => $imagen['actividad_id']]) : '#' ?>">
                                <img src="<?= Yii::getAlias('@web/images/actividades/' . Html::encode($imagen['nombre_Archivo'] . '.' . $imagen['extension'])) ?>"
                                    class="d-block w-100 fixed-size" 
                                    alt="Imagen <?= $index + 1 ?>"> 
                            </a>
                        </div>
                    <?php endforeach; ?>
                    </div>
                    <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        
                    </a>
                    <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        
                    </a>
                </div>

                <!-- Actividades Con más votos -->
                <div class="activities-section mt-5">
                    <h2 class="text-center mb-4">Actividades Recomendadas</h2>
                    <div class="row justify-content-center">
                        <?php if (!empty($masVotadas)) {
                            foreach ($masVotadas as $actividad): ?>
                                <div class="col-lg-6 mb-5">
                                    <div class="card h-100 shadow-lg">
                                        <?php if (!empty($actividad['nombre_Archivo'])): ?>
                                            <img class="card-img-top" 
                                                src="<?= Yii::getAlias('@web/images/actividades/' . Html::encode($actividad['nombre_Archivo'] . '.' . $actividad['extension'])) ?>"
                                                alt="<?= Html::encode($actividad['titulo']) ?>"
                                                style="height: 300px; object-fit: cover;">
                                        <?php else: ?>
                                            <img class="card-img-top" 
                                                src="<?= Yii::getAlias('@web/images/actividades/default.jpg') ?>"
                                                alt="<?= Html::encode($actividad['titulo']) ?>"
                                                style="height: 300px; object-fit: cover;">
                                        <?php endif; ?>

                                        <div class="card-body">
                                            <h4 class="card-title text-primary"><?= Html::encode($actividad['titulo']) ?></h4>
                                            <p class="card-text text-muted"><?= Html::encode($actividad['descripcion']) ?></p>
                                        </div>
                                        <div class="card-footer bg-white">
                                            <?= Html::a('Ver más', ['actividades/actividad', 'id' => $actividad['id']], 
                                                    ['class' => 'btn btn-outline-primary btn-block']) ?>
                                        </div>
                                    </div>
                                </div>
                            <?php  
                            endforeach; 
                        } else { ?>
                            <div class="col-md-12">
                                <p class="text-center">No hay actividades más buscadas en este momento.</p>
                            </div>
                        <?php } ?>
                    </div>
                </div>

                <!-- Actividades más visitadas -->
                <div class="activities-section mt-5">
                    <h2 class="text-center mb-4">Actividades Más Visitadas</h2>
                    <div class="row justify-content-center">
                        <?php if (!empty($masVisitadas)) {
                            foreach ($masVisitadas as $actividad): ?>
                                <div class="col-lg-6 mb-5">
                                    <div class="card h-100 shadow-lg">
                                        <?php if (!empty($actividad['nombre_Archivo'])): ?>
                                            <img class="card-img-top" 
                                                src="<?= Yii::getAlias('@web/images/actividades/' . Html::encode($actividad['nombre_Archivo'] . '.' . $actividad['extension'])) ?>"
                                                alt="<?= Html::encode($actividad['titulo']) ?>"
                                                style="height: 300px; object-fit: cover;">
                                        <?php else: ?>
                                            <img class="card-img-top" 
                                                src="<?= Yii::getAlias('@web/images/actividades/default.jpg') ?>"
                                                alt="<?= Html::encode($actividad['titulo']) ?>"
                                                style="height: 300px; object-fit: cover;">
                                        <?php endif; ?>

                                        <div class="card-body">
                                            <h4 class="card-title text-primary"><?= Html::encode($actividad['titulo']) ?></h4>
                                            <p class="card-text text-muted"><?= Html::encode($actividad['descripcion']) ?></p>
                                            <p class="card-text">
                                                <small class="text-muted">
                                                    Visitas: <?= Html::encode($actividad['contador_visitas']) ?>
                                                </small>
                                            </p>
                                        </div>
                                        <div class="card-footer bg-white">
                                            <?= Html::a('Ver más', ['actividades/actividad', 'id' => $actividad['id']], 
                                                    ['class' => 'btn btn-outline-primary btn-block']) ?>
                                        </div>
                                    </div>
                                </div>
                            <?php  
                            endforeach; 
                        } else { ?>
                            <div class="col-md-12">
                                <p class="text-center">No hay actividades más buscadas en este momento.</p>
                            </div>
                        <?php } ?>
                    </div>
                </div>


                <!-- Actividades más cercanas -->
                <div class="activities-section mt-5">
                    <h2 class="text-center mb-4">Próximas actividades</h2>
                    <div class="row justify-content-center">
                        <?php if (!empty($masProximas)) {
                            foreach ($masProximas as $actividad): ?>
                                <div class="col-lg-6 mb-5">
                                    <div class="card h-100 shadow-lg">
                                        <?php if (!empty($actividad['nombre_Archivo'])): ?>
                                            <img class="card-img-top" 
                                                src="<?= Yii::getAlias('@web/images/actividades/' . Html::encode($actividad['nombre_Archivo'] . '.' . $actividad['extension'])) ?>"
                                                alt="<?= Html::encode($actividad['titulo']) ?>"
                                                style="height: 300px; object-fit: cover;">
                                        <?php else: ?>
                                            <img class="card-img-top" 
                                                src="<?= Yii::getAlias('@web/images/actividades/default.jpg') ?>"
                                                alt="<?= Html::encode($actividad['titulo']) ?>"
                                                style="height: 300px; object-fit: cover;">
                                        <?php endif; ?>

                                        <div class="card-body">
                                            <h4 class="card-title text-primary"><?= Html::encode($actividad['titulo']) ?></h4>
                                            <p class="card-text text-muted"><?= Html::encode($actividad['descripcion']) ?></p>
                                            <p class="card-text">
                                                <small class="text-muted">
                                                Fecha de actividad: <?= Html::encode($actividad['fecha_celebracion']) ?>
                                                </small>
                                            </p>
                                        </div>
                                        <div class="card-footer bg-white">
                                            <?= Html::a('Ver más', ['actividades/actividad', 'id' => $actividad['id']], 
                                                    ['class' => 'btn btn-outline-primary btn-block']) ?>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; 
                        } else { ?>
                            <div class="col-md-12">
                                <p class="text-center">No hay actividades más cercanas en este momento.</p>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // Script para alternar la visibilidad del menú lateral
    document.getElementById("toggleMenu").addEventListener("click", function() {
        var sidebar = document.getElementById("sidebar");
        if (sidebar.style.transform === "translateX(0px)") {
            sidebar.style.transform = "translateX(-100%)";
        } else {
            sidebar.style.transform = "translateX(0)";
        }
    });
</script>