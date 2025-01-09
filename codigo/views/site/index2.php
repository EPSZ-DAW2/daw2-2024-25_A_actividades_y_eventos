<?php
/** @var yii\web\View $this */
/** @var yii\data\ActiveDataProvider $dataProvider */

use yii\helpers\Html;
use yii\widgets\ListView;

$this->title = 'Portada';
?>
<div class="site-index">

    <div class="row">

        <!-- Contenido Principal -->
        <div class="col-md-9 offset-md-3 body-content">
            <div class="jumbotron text-center bg-transparent" style="margin: 50px 0;">
                <h1 class="display-4"> ¡Bienvenido/a, <?= Html::encode(Yii::$app->user->identity->nick ?? 'Usuario') ?>!</h1>
                <p><?= Html::a('Actividades Pasadas', ['/actividades/actividades-pasadas'], ['class' => 'btn btn-default']) ?></p>
            </div>

            <!-- Carrusel de imágenes -->
            <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel" data-interval="5000">
                <ol class="carousel-indicators">
                    <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
                    <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
                    <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
                </ol>
                <div class="carousel-inner">
                    <div class="carousel-item active">
                        <img class="d-block w-100" src="https://images.ecestaticos.com/X6jKxwFNcSPcl3CEQuItXawaAc8=/0x0:2097x1430/1200x900/filters:fill(white):format(jpg)/f.elconfidencial.com%2Foriginal%2F614%2F40c%2Ff02%2F61440cf024b55a412a97e4c4c59fffbd.jpg" alt="First slide">
                    </div>
                    <div class="carousel-item">
                        <img class="d-block w-100" src="https://cdn0.geoenciclopedia.com/es/posts/8/0/0/montanas_8_orig.jpg" alt="Second slide">
                    </div>
                    <div class="carousel-item">
                        <img class="d-block w-100" src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQMtaQ0KL5OYEe7X621WkrV0SjxUdnW71ghRA&s" alt="Third slide">
                    </div>
                </div>
                <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="sr-only">Previous</span>
                </a>
                <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="sr-only">Next</span>
                </a>
            </div>

            <!-- Buscador -->
            <div class="search-container text-center mt-4">
                <h2>Buscar Actividades</h2>
                <form action="<?= Yii::$app->urlManager->createUrl(['site/index2']) ?>" method="get">
                    <input type="text" name="q" class="form-control" placeholder="Buscar actividades..." />
                    <button type="submit" class="btn btn-primary mt-2">Buscar</button>
                </form>
            </div>

            <!-- Actividades Recomendadas -->
            <div class="activities-section mt-5">
                <h2>Actividades Con más votos</h2>
                <?= ListView::widget([
                    'dataProvider' => $dataProvider,
                    'itemOptions' => ['class' => 'col-lg-4'],
                    'itemView' => function ($model, $key, $index, $widget) {
                        return '<div class="activity-item">
                                    <h4>' . Html::encode($model->titulo) . '</h4>
                                    <p>' . Html::encode($model->descripcion) . '</p>
                                    ' . (!empty($model->imagen_principal) ? '<img src="' . Yii::getAlias('@web') . '/images/' . Html::encode($model->imagen_principal) . '" alt="' . Html::encode($model->titulo) . '" class="img-fluid">' : '') . '
                                    <p><strong>Votos Positivos:</strong> ' . Html::encode($model->votosOK) . '</p>
                                    <p>' . Html::a('Ver', ['ver_actividad', 'id' => $model->id], ['class' => 'btn btn-info']) . '</p>
                                </div>';
                    },
                    'layout' => "{items}\n{pager}",
                ]) ?>
            </div>

            <!-- Actividades Más Cercanas, Más Nuevas y Más Visitadas -->
            <div class="activities-section mt-5">
                <h2>Actividades más cercanas</h2>
                <div class="row">
                    <!-- Más Cercanas -->
                    <?= ListView::widget([
                        'dataProvider' => $dataProvider3,
                        'itemOptions' => ['class' => 'col-lg-4'],
                        'itemView' => function ($model, $key, $index, $widget) {
                            return '<div class="activity-item">
                                        <h4>' . Html::encode($model->titulo) . '</h4>
                                        <p>' . Html::encode($model->descripcion) . '</p>
                                        ' . (!empty($model->imagen_principal) ? '<img src="' . Yii::getAlias('@web') . '/images/' . Html::encode($model->imagen_principal) . '" alt="' . Html::encode($model->titulo) . '" class="img-fluid">' : '') . '
                                        <p><strong>Fecha de celebración:</strong> ' . Html::encode($model->fecha_celebracion) . '</p>
                                        <p>' . Html::a('Ver', ['ver_actividad', 'id' => $model->id], ['class' => 'btn btn-info']) . '</p>
                                    </div>';
                        },
                        'layout' => "{items}\n{pager}",
                    ]) ?>


                    <!-- Más Visitadas -->
                    <div class="col-lg-4">
                        <h4>Más Visitadas</h4>
                        <?= ListView::widget([
                        'dataProvider' => $dataProvider2,
                        'itemOptions' => ['class' => 'col-lg-4'],
                        'itemView' => function ($model, $key, $index, $widget) {
                            return '<div class="activity-item">
                                        <h4>' . Html::encode($model->titulo) . '</h4>
                                        <p>' . Html::encode($model->descripcion) . '</p>
                                        ' . (!empty($model->imagen_principal) ? '<img src="' . Yii::getAlias('@web') . '/images/' . Html::encode($model->imagen_principal) . '" alt="' . Html::encode($model->titulo) . '" class="img-fluid">' : '') . '
                                        <p><strong>Visitas:</strong> ' . Html::encode($model->contador_visitas) . '</p>
                                        <p>' . Html::a('Ver', ['ver_actividad', 'id' => $model->id], ['class' => 'btn btn-info']) . '</p>
                                    </div>';
                        },
                        'layout' => "{items}\n{pager}",
                    ]) ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>