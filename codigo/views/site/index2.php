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

    <div class="row">

        <!-- Contenido Principal -->
        <div class="col-md-9 offset-md-3 body-content">
            <div class="jumbotron text-center bg-transparent" style="margin: 50px 0;">
                <h1 class="display-4"> ¡Bienvenido/a, <?= Html::encode(Yii::$app->user->identity->nick ?? 'Usuario') ?>!</h1>
            </div>

            <!-- Carrusel de imágenes -->
            <div id="carouselExampleIndicators" class="carousel slide" data-bs-ride="carousel" data-bs-interval="5000">
                <ol class="carousel-indicators">
                    <li data-bs-target="#carouselExampleIndicators" class="active"></li>
                    <li data-bs-target="#carouselExampleIndicators" ></li>
                    <li data-bs-target="#carouselExampleIndicators" ></li>
                </ol>
                <div class="carousel-inner">
                    <div class="carousel-item active">
                        <img src="https://images.ecestaticos.com/X6jKxwFNcSPcl3CEQuItXawaAc8=/0x0:2097x1430/1200x900/filters:fill(white):format(jpg)/f.elconfidencial.com%2Foriginal%2F614%2F40c%2Ff02%2F61440cf024b55a412a97e4c4c59fffbd.jpg" 
                            class="d-block w-100 fixed-size" alt="First slide">
                    </div>
                    <div class="carousel-item">
                        <img src="https://cdn0.geoenciclopedia.com/es/posts/8/0/0/montanas_8_orig.jpg" 
                            class="d-block w-100 fixed-size" alt="Second slide">
                    </div>
                    <div class="carousel-item">
                        <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQMtaQ0KL5OYEe7X621WkrV0SjxUdnW71ghRA&s" 
                            class="d-block w-100 fixed-size" alt="Third slide">
                    </div>
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

            <!-- Actividades Con más votos -->
            <div class="activities-section mt-5">
                <h2>Actividades con más votos</h2>
                <div class="row">
                    <?php foreach ($masVotadas as $actividad): ?>
                        <div class="col-lg-4 mb-4">
                            <div class="card h-100">
                                <?php if (!empty($actividad['nombre_Archivo'])): ?>
                                    <img class="card-img-top" 
                                         src="<?= Yii::getAlias('@web/images/actividades/' . Html::encode($actividad['nombre_Archivo'] . '.' . $actividad['extension'])) ?>"
                                         alt="<?= Html::encode($actividad['titulo']) ?>">
                                <?php endif; ?>
                                <div class="card-body">
                                    <h5 class="card-title"><?= Html::encode($actividad['titulo']) ?></h5>
                                    <p class="card-text"><?= Html::encode($actividad['descripcion']) ?></p>
                                    <p class="card-text">
                                        <small class="text-muted">
                                            Votos positivos: <?= Html::encode($actividad['votosOK']) ?>
                                        </small>
                                    </p>
                                    <?= Html::a('Ver más', ['actividades/actividad', 'id' => $actividad['id']], 
                                             ['class' => 'btn btn-primary']) ?>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>


            <!-- Actividades más visitadas -->
            <div class="activities-section mt-5">
                <h2>Actividades más visitadas</h2>
                <div class="row">
                <?php if (!empty($masVisitadas)) {
                        foreach ($masVisitadas as $actividad): ?>
                            
                                <div class="col-lg-4 mb-4">
                                    <div class="card h-100">
                                        <?php if (!empty($actividad['nombre_Archivo'])): ?>
                                            <img class="card-img-top" 
                                                src="<?= Yii::getAlias('@web/images/actividades/' . Html::encode($actividad['nombre_Archivo'] . '.' . $actividad['extension'])) ?>"
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
                                            <?= Html::a('Ver más', ['actividades/actividad', 'id' => $actividad['id']], 
                                                    ['class' => 'btn btn-primary']) ?>
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
                <h2>Actividades más cercanas</h2>
                <div class="row">
                <?php if (!empty($masProximas)) {
                        foreach ($masProximas as $actividad):  ?>
                                <div class="col-lg-4 mb-4">
                                    <div class="card h-100">
                                        <?php if (!empty($actividad['nombre_Archivo'])): ?>
                                            <img class="card-img-top" 
                                                src="<?= Yii::getAlias('@web/images/actividades/' . Html::encode($actividad['nombre_Archivo'] . '.' . $actividad['extension'])) ?>"
                                                alt="<?= Html::encode($actividad['titulo']) ?>">
                                        <?php endif; ?>
                                        <div class="card-body">
                                            <h5 class="card-title"><?= Html::encode($actividad['titulo']) ?></h5>
                                            <p class="card-text"><?= Html::encode($actividad['descripcion']) ?></p>
                                            <p class="card-text">
                                                <small class="text-muted">
                                                    Fecha de actividad: <?= Html::encode($actividad['fecha_celebracion']) ?>
                                                </small>
                                            </p>
                                            <?= Html::a('Ver más', ['actividades/actividad', 'id' => $actividad['id']], 
                                                    ['class' => 'btn btn-primary']) ?>
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