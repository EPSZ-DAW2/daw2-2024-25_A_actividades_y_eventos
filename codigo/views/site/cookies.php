<?php
use yii\helpers\Html;

$this->title = 'Política de Cookies';
?>
<h1>Política de Cookies</h1>
<p>
    Equipo2425a_eventos utiliza cookies con la finalidad de prestarle una mejor experiencia en su navegación. Asimismo, en caso de que preste su consentimiento, utilizaremos cookies que nos permitan obtener más información acerca de sus preferencias y personalizar nuestro Sitio Web de conformidad con sus intereses individuales, para que tenga una navegación más fluida y personalizada.
</p>
<p>
    Una cookie es un pequeño archivo que se descarga en el dispositivo del usuario, con la finalidad de almacenar datos e información que podrán ser actualizados y recuperados por la entidad responsable de su instalación.
</p>
<p>
    La información recabada a través de las cookies puede incluir la fecha y hora de visitas al sitio web, las distintas pestañas que usted ha visionado o el tiempo que ha permanecido en el mismo.
</p>

<h2>¿Qué tipos de cookies utiliza este sitio web?</h2>

<h3>Cookies propias</h3>
<p>
    Son enviadas a su dispositivo y gestionadas exclusivamente por nosotros para el mejor funcionamiento del sitio web. La información que recabamos se emplea para mejorar la calidad de nuestro servicio y su experiencia como usuario.
</p>

<h3>Cookies de terceros</h3>
<p>
    Son aquellas que se envían a su dispositivo desde un equipo o dominio que no es gestionado por nosotros, sino por otra entidad colaboradora. Las cookies analíticas utilizadas por Google, o las utilizadas por las redes sociales para ofrecer al usuario la posibilidad de compartir o recomendar contenidos de nuestra página web en las mismas.
</p>

<h2>Cookies utilizadas</h2>
<p>
    A continuación, se detallan todas las cookies utilizadas por este sitio web, así como sus características y finalidades:
</p>
<ul>
    <li><strong>Google:</strong> Registra de forma anónima su visita y las páginas que visitó, entre otras métricas, ayudándonos a determinar la idoneidad de nuestros contenidos, diseños o modificaciones, y permitiéndonos hacer mejoras a la tienda online. Usa las cookies __utma, __utmb, __utmc, __utmt, __utmz, _ga, _gat y _gid.</li>
    <li><strong>Facebook, Adwords:</strong> Se usa para asegurar que el recuento de compartir el contenido en redes sociales es correcto y puede ser empleado para acciones publicitarias.</li>
    <li><strong>SPC:</strong> El sistema de la web trabaja con varias cookies, para la identificación segura de sesión, una vez inicia sesión con su usuario, así como la Cookie UE, para informarle de sus derechos.</li>
</ul>

<h2>¿Cómo puedo configurar o deshabilitar las cookies que utiliza este sitio web?</h2>
<p>
    Para restringir o bloquear las cookies, debe modificar la configuración del navegador que utilice en su dispositivo. Para mayor información, emplee un buscador (Google, Yahoo, MSN, DuckDuckGo, …) y busque cómo deshabilitar cookies en su navegador.
</p>

<h2>Cambios en la Política de Cookies</h2>
<p>
    Es posible que actualicemos la Política de Cookies de nuestro sitio web, por ello le recomendamos revisar esta política cada vez que acceda a nuestro Sitio Web con el objetivo de estar adecuadamente informado sobre cómo y para qué usamos las cookies. La Política de Cookies se actualizó por última vez a fecha 29-08-2018.
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