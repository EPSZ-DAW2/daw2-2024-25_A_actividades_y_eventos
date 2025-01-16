<?php

/** @var yii\web\View $this */
$this->registerCssFile(Yii::$app->request->baseUrl . '/css/estiloHeader.css', ['depends' => [yii\web\YiiAsset::class]]);
$this->registerCssFile('https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.5.0/font/bootstrap-icons.min.css');
/** @var string $content */

use app\assets\AppAsset;
use app\widgets\Alert;
use yii\bootstrap5\Breadcrumbs;
use yii\bootstrap5\Html;
use yii\bootstrap5\Nav;
use yii\bootstrap5\NavBar;
use app\models\Roles;
use app\models\Notificacion;

AppAsset::register($this);

$this->registerCsrfMetaTags();
$this->registerMetaTag(['charset' => Yii::$app->charset], 'charset');
$this->registerMetaTag(['name' => 'viewport', 'content' => 'width=device-width, initial-scale=1, shrink-to-fit=no']);
$this->registerMetaTag(['name' => 'description', 'content' => $this->params['meta_description'] ?? '']);
$this->registerMetaTag(['name' => 'keywords', 'content' => $this->params['meta_keywords'] ?? '']);
$this->registerLinkTag(['rel' => 'icon', 'type' => 'image/x-icon', 'href' => Yii::getAlias('@web/favicon.ico')]);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>" class="h-100">
<head>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
    <style>
    .badge-notification {
        position: absolute;
        top: -5px;
        right: -5px;
        padding: 5px 10px;
        border-radius: 50%;
        background-color: red;
        color: white;
        font-size: 12px;
    }
    .navbar-nav {
        display: flex;
        justify-content: center; /* Centra los items de navegación */
        flex-wrap: wrap; /* Permite que los items se ajusten en varias filas si es necesario */
    }
    .navbar-nav .nav-item {
        margin: 5px; /* Añade un pequeño margen entre los items */
    }
    .navbar-nav.ms-auto {
        display: flex;
        justify-content: center; /* Centra los botones de usuario */
    }
    .navbar-nav.ms-auto .nav-item {
        margin: 5px; /* Añade un margen entre los botones */
    }
    </style>
</head>
<body class="d-flex flex-column h-100">
<?php $this->beginBody() ?>

<header id="header">
    <?php
    // Barra de navegación principal
    NavBar::begin([
        'brandLabel' => '', 
        'brandUrl' => Yii::$app->homeUrl,
        'options' => ['class' => 'navbar-expand-md navbar-dark bg-dark fixed-top']
    ]);
    ?>

    <!-- Barra de navegación -->
    <nav class="navbar navbar-expand-md navbar-dark bg-dark fixed-top">
        <div class="container">
            <!-- Logo con imagen -->
            <a class="navbar-brand" href="<?= Yii::$app->homeUrl ?>">
                <img src="<?= Yii::$app->request->baseUrl ?>/images/actividades_eventos.png" alt="Logo" style="max-height: 40px; margin-right: 10px; margin-left: -40px;">
                ACTIVIDADES Y EVENTOS 
            </a>

            <!-- Botón de menú hamburguesa para pantallas pequeñas -->
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <!-- Menú de navegación principal -->
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav mx-auto mb-2 mb-md-0"> <!-- Agregado mx-auto para centrar -->
                    <?php if (!Yii::$app->user->isGuest): ?>
                        <li class="nav-item">
                            <?= Html::a('Mis Actividades', ['/actividades/mis-actividades'], ['class' => 'nav-link']) ?>
                        </li>
                    <?php endif; ?>
                    <li class="nav-item">
                        <?= Html::a('Sobre nosotros', ['/site/about'], ['class' => 'nav-link']) ?>
                    </li>
                    <li class="nav-item">
                        <?= Html::a('Contacto', ['/site/contact'], ['class' => 'nav-link']) ?>
                    </li>
                </ul>

                <!-- Opciones para usuarios logueados o no -->
                <ul class="navbar-nav mx-auto d-flex justify-content-center align-items-center flex-column flex-sm-row"> 
                    <?php if (Yii::$app->user->isGuest): ?>
                        <li class="nav-item">
                            <?= Html::a('Iniciar sesión', ['site/login'], ['class' => 'btn btn-sm btn-light mx-2']) ?>
                        </li>
                        <li class="nav-item">
                            <?= Html::a('Registrarse', ['site/register'], ['class' => 'btn btn-sm btn-primary mx-2']) ?>
                        </li>
                    <?php else: 
                        if (Yii::$app->user->hasRole([Roles::ADMINISTRADOR, Roles::SYSADMIN])) {
                            echo '<li class="nav-item">';
                            echo Html::a('Administración', ['site/admin'], [
                                'class' => 'btn btn-sm btn-warning mx-2',
                            ]);
                            echo '</li>';
                        } else if (Yii::$app->user->hasRole([Roles::MODERADOR])) {
                            echo '<li class="nav-item">';
                            echo Html::a('Moderación', ['site/moderador'], [
                                'class' => 'btn btn-sm btn-secondary mx-2',
                            ]);
                            echo '</li>';
                        }

                        $pendingNotifications = 0;
                        if (!Yii::$app->user->isGuest) {
                            $pendingNotifications = Notificacion::find()->where(['USUARIOid' => Yii::$app->user->id, 'fecha_lectura' => null])->count();
                        }
                        ?>
                        <div class="d-flex flex-wrap justify-content-center">
                            <li class="nav-item">
                                <?= Html::a('', ['usuario/mi-perfil'], ['class' => 'btn btn-sm btn-secondary mx-1 bi bi-person', 'data-method' => 'post']) ?>
                            </li>
                            <li class="nav-item position-relative">
                                <?= Html::a('<i class="bi bi-bell"></i>' . ($pendingNotifications > 0 ? '<span class="badge-notification">' . $pendingNotifications . '</span>' : ''), ['usuario/mis-notificaciones'], ['class' => 'btn btn-sm btn-info mx-1']) ?>
                            </li>
                            <li class="nav-item">
                                <?= Html::a('', ['site/logout'], ['class' => 'btn btn-sm btn-danger mx-1 bi bi-door-open', 'data-method' => 'post']) ?>
                            </li>
                        </div>
                    <?php endif; ?>
                </ul>


            </div>
        </div>
    </nav>

    <?php NavBar::end(); ?>
</header>

<main id="main" class="flex-shrink-0" role="main">
    <div class="container">
        <?php if (!empty($this->params['breadcrumbs'])): ?>
            <?= Breadcrumbs::widget(['links' => $this->params['breadcrumbs']]) ?>
        <?php endif ?>
        <?= Alert::widget() ?>
        <?= $content ?>
    </div>
</main>

<?= $this->render('footer') ?>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
