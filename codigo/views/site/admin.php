<?php 
    use yii\helpers\Html;
    use app\components\User;
    use app\models\Roles;


    $this->title = 'Administracion';

?>
    <h2>Hola, <?= Yii::$app->user->identity->nick ?> !</h2>

    <p>
        Bienvenido al panel de administración de la aplicación. Como administrador que eres, 
        puedes gestionar las actividades, etiquetas, roles y usuarios de la aplicación.

    </p>
    
    <p>
        <?= Html::a('Gestion de actividades', ['actividades/administrador'], ['class' => 'btn btn-success']); ?>
        <?= Html::a('Gestion de etiquetas', ['etiquetas/index'], ['class' => 'btn btn-success']); ?>
        <?= Html::a('Gestion de roles', ['rol/index'], ['class' => 'btn btn-success']); ?>
        <?= Html::a('Gestion de usuarios', ['usuario/index'], ['class' => 'btn btn-success']); ?>
        <?= Html::a('Registro de actividades- LOG', ['registro-acciones/index'], ['class' => 'btn btn-success']); ?>
        
        <?php
        if (Yii::$app->user->hasRole(Roles::SYSADMIN)) {
            echo '<br><br>';
            echo '<p>Acciones de SysAdmin:</p>';
            echo Html::a('Gestion del servidor', ['parametros-servidor/index'], ['class' => 'btn btn-success', 'style' => 'margin-right: 10px;']);
            echo Html::a('Copia de seguridad', ['backup/index'], ['class' => 'btn btn-success', 'style' => 'margin-left: 10px;']);
        }
        ?>
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