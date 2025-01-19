<?php
use yii\helpers\Html;
/** @var yii\web\View $this */

$this->title = 'Política de Privacidad';
?>
<h1>Política de Privacidad</h1>
<p>
    En cumplimiento del Reglamento (UE) 2016/679 del Parlamento Europeo y del Consejo de 27 de abril de 2016 (RGPD), informamos sobre cómo se recogen, usan y protegen los datos personales que usted proporciona a través de este sitio web.
</p>

<h2>Derechos del Usuario</h2>
<p>
    Usted tiene derecho a acceder, rectificar, suprimir, limitar u oponerse al tratamiento de sus datos, así como a la portabilidad de los mismos. Para ejercer sus derechos, puede contactar al responsable del tratamiento en <?= Html::a('contacto@ejemplo.com', 'mailto:contacto@ejemplo.com') ?>.
</p>

<h2>Protección de Datos</h2>
<p>
    A los efectos de la Ley Orgánica 15/1999, de 13 de diciembre, de Protección de Datos de Carácter Personal (LOPD), informamos al Usuario de que los datos de carácter personal referentes a personas físicas, recabados en cualquiera de las secciones del Sitio Web, o cualesquiera otros proporcionados por el Usuario a lo largo de la relación con la empresa Distribuninet, S.L. (Equipo2425a_eventos), así como aquellos que se recojan como consecuencia de la prestación que se establezca, serán incluidos en ficheros de datos de carácter personal cuyo responsable es Equipo2425a_eventos, y cuya finalidad es la gestión y control de la relación contractual o negocial establecida, la realización de contactos diversos, así como la gestión de facturación, contable y fiscal exigible legalmente.
</p>
<p>
    El tratamiento tiene igualmente como finalidad el remitirle información sobre bienes y servicios que puedan ser de su interés, ampliar y mejorar nuestros servicios adecuando nuestras ofertas a sus preferencias o necesidades, permitirle una navegación personalizada, diseñar nuevos productos y servicios y el envío de cuestionarios por cualquier medio, cuya contestación es voluntaria, salvo que en ellos se disponga otra cosa. Los campos marcados con "Requerido" son de carácter obligatorio, por lo que la no cumplimentación de dichos campos impedirá al Usuario disfrutar de algunos de los Servicios e informaciones ofrecidos por el Sitio Web.
</p>
<p>
    Los datos personales recabados por Equipo2425a_eventos gozarán de la protección adecuada conforme a lo establecido en el Real Decreto 994/1999, de 11 de junio, por el que se aprueba el Reglamento de Medidas de Seguridad que desarrolla el artículo 9 de la LOPD.
</p>
<p>
    Por medio de la aceptación de las presentes Condiciones Generales, el Usuario garantiza que los datos e informaciones proporcionados a Equipo2425a_eventos a través del Sitio Web o por cualquier otro medio son los suyos propios; en caso contrario, el Usuario garantiza disponer del consentimiento expreso de los titulares de los datos e informaciones para su comunicación a Equipo2425a_eventos, con el objeto de que puedan ser incorporados a nuestros ficheros en las condiciones y con las finalidades establecidas en las presentes Condiciones Generales.
</p>
<p>
    Equipo2425a_eventos, como responsable del fichero, garantiza el ejercicio de los derechos de acceso, rectificación, oposición y cancelación de los datos aportados. Para ello el usuario, podrá ponerse en contacto mediante los distintos medios de comunicación indicados más arriba así como en la sección CONTACTO de la Web.
</p>
<p>
    Se reserva el derecho de modificar su política de protección de datos de acuerdo con su criterio, o a causa de un cambio legislativo, jurisprudencial o en la práctica empresarial. Si Equipo2425a_eventos introduce una modificación, el nuevo texto será publicado en esta misma página (Sitio Web), donde el usuario podrá tener conocimiento de la política de protección de datos. En cualquier caso, la relación con los usuarios se regirá por las normas previstas en el momento preciso en el que se accede al sitio Web.
</p>

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