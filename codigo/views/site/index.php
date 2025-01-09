<?php

/** @var yii\web\View $this */

$this->title = 'Actividades y Eventos';
?>

<link rel="stylesheet" href="<?= Yii::$app->request->baseUrl ?>/css/estiloInicio.css">

<body>

<div class="site-index">

    <div class="jumbotron text-center bg-transparent">
        <h1 class="display-4">ACTIVIDADES Y EVENTOS EPSZ</h1>
        <img src="<?= Yii::$app->request->baseUrl ?>/images/actividades_eventos.png" alt="Logo" style="width: 30%;">

        <p class="lead">"Conecta con la cultura y el entretenimiento en Actividades y Eventos EPSZ, la plataforma que reúne la mayor oferta de eventos y actividades. Explora una amplia variedad de opciones, desde eventos locales hasta grandes espectáculos. Interactúa con otros usuarios, comparte tus experiencias y descubre recomendaciones personalizadas. Actividades y Eventos EPSZ es la comunidad donde la pasión por los eventos cobra vida."</p>
    </div>

    <div class="body-content">

        <div class="row">
            <div class="col-lg-4">

                <h2>Explora Actividades Locales</h2>
                <p>Descubre las mejores actividades locales en tu ciudad. Desde conciertos hasta exposiciones culturales, hay algo para todos. Únete a nosotros y encuentra eventos que te apasionen.</p>
                <img src="<?= Yii::$app->request->baseUrl ?>/images/imagen3.jpg" alt="Imagen 1">

            </div>
            <div class="col-lg-4">
            
                <h2>Conoce Próximos Eventos</h2>
                <p>Entérate de los eventos más esperados. Ya sea un festival, una conferencia o una reunión comunitaria, mantente informado sobre lo que está por venir y no te pierdas de nada.</p>
                <img src="<?= Yii::$app->request->baseUrl ?>/images/imagen2.jpg" alt="Imagen 2">

            </div>
            <div class="col-lg-4">

                <h2>Conecta con la Comunidad</h2>
                <p>Interactúa con otros usuarios, comparte experiencias y consejos, y sé parte de la comunidad que disfruta de actividades y eventos. La cultura y el entretenimiento te están esperando.</p>
                <img src="<?= Yii::$app->request->baseUrl ?>/images/imagen1.jpg" alt="Imagen 3">

            </div>
        </div>

    </div>
</div>

<div class="divfinal text-center bg-transparent">
        <h3 class="display-4">¿TODO LISTO?</h3>

        <p class="under">
            ¡<a href="<?= Yii::$app->urlManager->createUrl(['/site/login']) ?>">Inicia Sesión</a> o 
            <a href="<?= Yii::$app->urlManager->createUrl(['/site/register']) ?>">Regístrate</a> en nuestro portal para continuar!
        </p>

    </div>

</body>

