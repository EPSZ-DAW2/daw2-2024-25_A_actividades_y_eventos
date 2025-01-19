<?php 
    use yii\helpers\Html;

    $this->title = 'Vista moderador';
?>

<h2>Hola, <?= Yii::$app->user->identity->nick ?> !</h2>

<p>
    Bienvenido al panel de moderación de la aplicación. Como moderador que eres, 
    puedes gestionar las actividades y comentarios de la aplicación.
</p>

<p>
    <?= Html::a('Gestion de actividades', ['actividades/administrador'], ['class' => 'btn btn-success']); ?>
    <?= Html::a('Gestion de comentarios', ['comentario/index'], ['class' => 'btn btn-success']); ?>
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