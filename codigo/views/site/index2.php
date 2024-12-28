<?php

/** @var yii\web\View $this */

use yii\helpers\Html;
use yii\widgets\Menu;

$this->title = 'Index 2';
?>
<div class="site-index">

    <div class="row">
        <!-- Menú Lateral de Categorías (Pegado al borde y ocultable) -->
        <div class="col-md-3 p-0">
            <div class="sidebar position-fixed" style="top: 50px; left: 10px; padding-right: 10px;  width: 250px; height: 100vh; background-color: #f8f9fa; box-shadow: 2px 0px 10px rgba(0,0,0,0.1); z-index: 1000;">
                <button class="btn btn-primary mt-3 ml-3" id="toggleSidebarBtn">Toggle Sidebar</button> <!-- Botón para ocultar/mostrar -->

                <h4 class="mt-4 ml-3">Categorías</h4>
                <ul class="list-group">
                    <?php
                    // Aquí puedes obtener las categorías desde la base de datos.
                    $categories = [
                        ['name' => 'Deportes', 'slug' => 'deportes'],
                        ['name' => 'Música', 'slug' => 'musica'],
                        ['name' => 'Arte', 'slug' => 'arte'],
                        ['name' => 'Cultura', 'slug' => 'cultura'],
                        ['name' => 'Tecnología', 'slug' => 'tecnologia'],
                    ];
                    foreach ($categories as $category): ?>
                        <li class="list-group-item">
                            <a href="<?= Yii::$app->urlManager->createUrl(['site/index2' /*'actividad/category', 'slug' => $category['slug']*/]) ?>" class="p-2">
                                <?= Html::encode($category['name']) ?>
                            </a>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>

        <!-- Contenido Principal -->
        <div class="col-md-9 offset-md-3">
            <div class="jumbotron text-center bg-transparent" style="margin: 50px 0;">
                <h1 class="display-4">Bienvenido, <?= Html::encode(Yii::$app->user->identity->username ?? 'Usuario') ?>!</h1>
            </div>

            <!-- Carrusel de imágenes -->
            <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
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
                <form action="<?= Yii::$app->urlManager->createUrl(['site/index2' /*'actividad/search'*/]) ?>" method="get">
                    <input type="text" name="q" class="form-control" placeholder="Buscar actividades..." />
                    <button type="submit" class="btn btn-primary mt-2">Buscar</button>
                </form>
            </div>

            <!-- Actividades Recomendadas -->
            <div class="recommended-activities mt-5">
                <h2>Actividades Recomendadas</h2>
                <div class="row">
                    <div class="col-lg-4">
                        <div class="activity-item">
                            <img src="https://via.placeholder.com/300x200" alt="Actividad 1" class="img-fluid">
                            <h4>Actividad 1</h4>
                            <p>Descripción breve de la actividad recomendada.</p>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="activity-item">
                            <img src="https://via.placeholder.com/300x200" alt="Actividad 2" class="img-fluid">
                            <h4>Actividad 2</h4>
                            <p>Descripción breve de la actividad recomendada.</p>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="activity-item">
                            <img src="https://via.placeholder.com/300x200" alt="Actividad 3" class="img-fluid">
                            <h4>Actividad 3</h4>
                            <p>Descripción breve de la actividad recomendada.</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Actividades Más Cercanas, Más Nuevas y Más Visitadas -->
            <div class="activities-section mt-5">
                <h2>Actividades Populares</h2>
                <div class="row">
                    <!-- Más Cercanas -->
                    <div class="col-lg-4">
                        <h4>Más Cercanas</h4>
                        <div class="activity-item">
                            <img src="https://via.placeholder.com/300x200" alt="Cercana 1" class="img-fluid">
                            <h5>Actividad Cercana 1</h5>
                            <p>Descripción de la actividad cercana.</p>
                        </div>
                    </div>
                    <!-- Más Nuevas -->
                    <div class="col-lg-4">
                        <h4>Más Nuevas</h4>
                        <div class="activity-item">
                            <img src="https://via.placeholder.com/300x200" alt="Nueva 1" class="img-fluid">
                            <h5>Actividad Nueva 1</h5>
                            <p>Descripción de la actividad nueva.</p>
                        </div>
                    </div>
                    <!-- Más Visitadas -->
                    <div class="col-lg-4">
                        <h4>Más Visitadas</h4>
                        <div class="activity-item">
                            <img src="https://via.placeholder.com/300x200" alt="Visitada 1" class="img-fluid">
                            <h5>Actividad Visitada 1</h5>
                            <p>Descripción de la actividad más visitada.</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Categorías Más Buscadas -->
            <div class="categories-section mt-5">
                <h2>Categorías Más Buscadas</h2>
                <div class="row">
                    <div class="col-lg-4">
                        <div class="category-item">
                            <img src="https://via.placeholder.com/300x200" alt="Categoría 1" class="img-fluid">
                            <h4>Categoría 1</h4>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="category-item">
                            <img src="https://via.placeholder.com/300x200" alt="Categoría 2" class="img-fluid">
                            <h4>Categoría 2</h4>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="category-item">
                            <img src="https://via.placeholder.com/300x200" alt="Categoría 3" class="img-fluid">
                            <h4>Categoría 3</h4>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

</div>

<!-- Script para ocultar/mostrar el menú lateral -->
<script>
    // Usando jQuery para ocultar/mostrar el menú lateral
    $('#toggleSidebarBtn').click(function() {
        $('.sidebar').toggleClass('d-none'); // Alterna la clase d-none para ocultar/mostrar
    });
</script>
