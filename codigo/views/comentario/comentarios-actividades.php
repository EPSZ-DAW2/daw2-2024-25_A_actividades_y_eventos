<?php
use yii\helpers\Html;
use yii\grid\GridView;
use yii\data\ArrayDataProvider;
use yii\grid\ActionColumn;
use yii\helpers\Url;

/** @var yii\web\View $this */
/** @var app\models\ComentarioActividad[] $comentariosActividades */

$this->title = 'Comentarios de Actividades';

$dataProvider = new ArrayDataProvider([
    'allModels' => $comentariosActividades,
    'pagination' => [
        'pageSize' => 10,
    ],
    'sort' => [
        'attributes' => ['aCTIVIDAD.titulo', 'cOMENTARIO.texto'],
    ],
]);
?>
<div class="comentarios-actividades">
    <h1><?= Html::encode($this->title) ?></h1>
    <p>
    <?= Html::a(Yii::t('app', 'Volver'), ['index'], ['class' => 'btn btn-primary']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'attribute' => 'aCTIVIDAD.titulo',
                'label' => 'Título de la Actividad',
            ],
            [
                'attribute' => 'cOMENTARIO.texto',
                'label' => 'Texto del Comentario',
            ],
            [
                'attribute' => 'cOMENTARIO.numero_de_denuncias',
                'label' => 'Numero de denuncias',
            ],
            [
                'class' => ActionColumn::class,
                'urlCreator' => function ($action, $model, $key, $index) {
                    return Url::toRoute([$action, 'id' => $model->COMENTARIOid]);
                }
            ],
        ],

    ]); ?>
</div>

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