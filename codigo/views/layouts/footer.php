<?php
use yii\helpers\Html;
use yii\helpers\Url;

?>
<footer class="footer">
    <div class="container">
        <div class="row">
            <!-- Mapa Web -->
            <div class="col-md-3">
                <h4>Mapa Web</h4>
                <ul class="list-unstyled">
                    <li><?= Html::a('Home', ['/site/index']) ?></li>
                    <li><?= Html::a('About', ['/site/about']) ?></li>
                    <li><?= Html::a('Contact', ['/site/contact']) ?></li>
                    <li><?= Html::a('Test', ['/test/index']) ?></li>
                </ul>
            </div>
            <!-- Contacto -->
            <div class="col-md-3">
                <h4>Contacto</h4>
                <p>Dirección: Av. de Requejo, 33, 49029 Zamora</p>
                <p>Teléfono: <?= Html::a('+980 545 000') ?></p>
                <p>Email: <?= Html::a('politecnicazamora.usal.es', 'mailto:contacto@ejemplo.com') ?></p>
                <div class="map">
                    <?= Html::a('Ver ubicación', 'https://www.google.com/maps?hl=es&gl=es&um=1&ie=UTF-8&fb=1&sa=X&ftid=0xd391e26a194aa8b:0xc49cd8148e1acf64', ['target' => '_blank']) ?>
                </div>
            </div>
            <!-- Legales -->
            <div class="col-md-3">
                <h4>Legales</h4>
                <ul class="list-unstyled">
                    <li><?= Html::a('Aviso Legal', ['/site/legal']) ?></li>
                    <li><?= Html::a('Política de Privacidad', ['/site/politicaprivacidad']) ?></li>
                    <li><?= Html::a('Política de Cookies', ['/site/cookies']) ?></li>
                </ul>
            </div>
            <!-- Redes Sociales y Patrocinadores -->
            <div class="col-md-3">
                <h4>Síguenos</h4>
                <ul class="list-inline">
                    <li><?= Html::a(Html::img('@web/images/facebook-icon.png', ['alt' => 'Facebook']), 'https://facebook.com/empresa', ['target' => '_blank']) ?></li>
                    <li><?= Html::a(Html::img('@web/images/instagram-icon.png', ['alt' => 'Instagram']), 'https://instagram.com/empresa', ['target' => '_blank']) ?></li>
                </ul>
                <h4>Patrocinadores</h4>
                <div>
                    <?= Html::img('@web/images/logo-patrocinador.png', ['alt' => 'Patrocinador', 'class' => 'patrocinador-logo']) ?>
                </div>
            </div>
        </div>
        <!-- Derechos de Autor -->
        <div class="footer-bottom text-center">
            <p>© <?= date('Y') ?> Equipo2425a_eventos. Todos los derechos reservados.</p>
            <p>Diseñado y desarrollado por <?= Html::a('Equipo2425a_eventos', 'https://github.com/EPSZ-DAW2/daw2-2024-25_A_actividades_y_eventos', ['target' => '_blank']) ?></p>
        </div>
    </div>
</footer>
