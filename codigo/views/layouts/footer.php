<?php
use yii\helpers\Html;
use yii\helpers\Url;

/** @var yii\web\View $this */
$this->registerCssFile(Yii::$app->request->baseUrl . '/css/estiloFooter.css', ['depends' => [yii\web\YiiAsset::class]]);

?>

<footer class="footer">
    <div class="container22">
        <div class="rowdest">
            <!-- Mapa Web -->
            <div class="col-md-3">
                <h4>Mapa Web</h4>
                <ul class="list-unstyled">
                    <li><?= Html::a('Inicio', ['/site/index']) ?></li>
                    <li><?= Html::a('Sobre nosotros', ['/site/about']) ?></li>
                    <li><?= Html::a('Contacto', ['/site/contact']) ?></li>
                </ul>
            </div>

            <!-- Contacto -->
            <div class="col-md-3">
                <h4>Contacto</h4>
                <?php
                    // API Key de Google Maps
                    $apiKey = 'AIzaSyAwkqhsAcJIftL32sor2fYd5Q7-zaOkc5A';
                    $direccionFooter = "Avenida de Requejo, 33, 49029 Zamora";
                    $direccionEncodedFooter = urlencode($direccionFooter);
                    $urlFooter = "https://maps.googleapis.com/maps/api/geocode/json?address=$direccionEncodedFooter&components=country:ES&key=$apiKey";
                    $responseFooter = file_get_contents($urlFooter);
                    $dataFooter = json_decode($responseFooter, true);

                    if ($dataFooter['status'] == 'OK') {
                        $latFooter = $dataFooter['results'][0]['geometry']['location']['lat'];
                        $lngFooter = $dataFooter['results'][0]['geometry']['location']['lng'];
                    } else {
                        $latFooter = null;
                        $lngFooter = null;
                    }

                    // Agregar mapa del footer
                    if ($latFooter && $lngFooter) {
                        echo "<div style='display: flex; justify-content: center; align-items: center;'>
                            <div id='map-footer' style='width: 100%; height: 200px;'></div>
                        </div>";
                    }
                ?>
                <br>
                <p>Avenida de Requejo, 33, 49029 Zamora</p>
                <p>Teléfono: <?= Html::a('(+34) 980 545 000') ?></p>
                <p>+ Info: <?= Html::a('politecnicazamora.usal.es', 'https://politecnicazamora.usal.es', ['target' => '_blank']) ?></p>
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
                    <li><?= Html::a(Html::img('@web/images/logofacebook.png', ['alt' => 'Facebook']), 'https://facebook.com/empresa', ['target' => '_blank']) ?></li>
                    <li><?= Html::a(Html::img('@web/images/logoinstagram.png', ['alt' => 'Instagram']), 'https://instagram.com/empresa', ['target' => '_blank']) ?></li>
                </ul>
                <h4 class="especial">Patrocinadores</h4>
                <div>
                    <?= Html::img('@web/images/usal.png', ['alt' => 'Patrocinador', 'class' => 'patrocinador-logo']) ?>
                </div>
            </div>
        </div>

        <!-- Derechos de Autor -->
        <div class="footer-bottom text-center">
            <p>© <?= date('Y') ?> Equipo2425a_eventos. Todos los derechos reservados.</p>
            <p>Diseñado y desarrollado por <?= Html::a('Equipo2425a_eventos', 'https://github.com/EPSZ-DAW2/daw2-2024-25_A_actividades_y_eventos', ['target' => '_blank']) ?></p>
        </div>
    </div>

    <?php
        $latActividad = $this->params['latActividad'] ?? null;
        $lngActividad = $this->params['lngActividad'] ?? null;

        // Script único para inicializar ambos mapas
        if (($latActividad && $lngActividad) || ($latFooter && $lngFooter))
        {
            echo "<script>
                function initMaps() {
                    // Mapa de Actividad
                    if (document.getElementById('map-actividad')) {
                        var actividadLocation = {lat: $latActividad, lng: $lngActividad};
                        var actividadMap = new google.maps.Map(document.getElementById('map-actividad'), {
                            zoom: 15,
                            center: actividadLocation
                        });
                        new google.maps.Marker({position: actividadLocation, map: actividadMap});
                    }

                    // Mapa del Footer
                    if (document.getElementById('map-footer')) {
                        var footerLocation = {lat: $latFooter, lng: $lngFooter};
                        var footerMap = new google.maps.Map(document.getElementById('map-footer'), {
                            zoom: 15,
                            center: footerLocation
                        });
                        new google.maps.Marker({position: footerLocation, map: footerMap});
                    }
                }
            </script>";
            echo "<script async defer src='https://maps.googleapis.com/maps/api/js?key=$apiKey&callback=initMaps'></script>";
        }
    ?>
</footer>