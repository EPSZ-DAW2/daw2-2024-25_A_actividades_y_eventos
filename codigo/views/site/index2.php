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
    <div class="container">

        <!-- Menú desplegable para categorías -->
        <div class="dropdown mb-4 text-center">
            <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                Selecciona un Filtro
            </button>
            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                <?php foreach ($categorias as $categoria): ?>
                    <li>
                        <?php if (strtolower($categoria) === 'recomendadas'): ?>
                            <!-- Enlace específico para la categoría "Recomendadas" -->
                            <a class="dropdown-item" href="<?= Yii::$app->urlManager->createUrl(['actividades/recomendadas']) ?>">
                                <?= Html::encode($categoria) ?>
                            </a>
                        <?php elseif (strtolower($categoria) === 'próximas'): ?>
                            <!-- Enlace específico para la categoría "Próximas" -->
                            <a class="dropdown-item" href="<?= Yii::$app->urlManager->createUrl(['actividades/mas-proximas']) ?>">
                                <?= Html::encode($categoria) ?>
                            </a>
                        <?php elseif (strtolower($categoria) === 'mas buscadas'): ?>
                            <!-- Enlace específico para la categoría "Mas Buscadas" -->
                            <a class="dropdown-item" href="<?= Yii::$app->urlManager->createUrl(['actividades/mas-buscadas']) ?>">
                                <?= Html::encode($categoria) ?>
                            </a>
                        <?php elseif (strtolower($categoria) === 'más visitadas'): ?>
                            <!-- Enlace específico para la categoría "Mas Visitadas" -->
                            <a class="dropdown-item" href="<?= Yii::$app->urlManager->createUrl(['actividades/mas-visitadas']) ?>">
                                <?= Html::encode($categoria) ?>
                            </a>
                        <?php elseif (strtolower($categoria) === 'pasadas'): ?>
                            <!-- Enlace específico para la categoría "Pasadas" -->
                            <a class="dropdown-item" href="<?= Yii::$app->urlManager->createUrl(['actividades/actividades-pasadas']) ?>">
                                <?= Html::encode($categoria) ?>
                            </a>
                        <?php else: ?>
                            <!-- Enlaces genéricos para otras categorías -->
                            <a class="dropdown-item" href="<?= Yii::$app->urlManager->createUrl(['site/' . strtolower(str_replace(' ', '_', $categoria))]) ?>">
                                <?= Html::encode($categoria) ?>
                            </a>
                        <?php endif; ?>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>




        <div class="row justify-content-center"> <!-- Centra las columnas en la fila -->
            <!-- Contenido Principal -->
            <div class="col-md-12 col-lg-12 body-content">
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
                        <span class="sr-only">Anterior</span>
                    </a>
                    <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="sr-only">Siguiente</span>
                    </a>
                </div>

                

                <!-- Actividades Con más votos -->
                <div class="activities-section mt-5">
                    <h2 class="text-center mb-4">Actividades Recomendadas</h2>
                    <style>
                        .fixed-size-img {
                            width: 100%; 
                            height: 200px; 
                            object-fit: cover; 
                        } 
                    </style>
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
                            <?php  
                            endforeach; 
                        } else { ?>
                            <div class="col-md-12">
                                <p class="text-center">No hay actividades más buscadas en este momento.</p>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
