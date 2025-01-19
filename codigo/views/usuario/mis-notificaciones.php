<?php
use yii\helpers\Html;
use yii\grid\GridView;
use yii\bootstrap\Modal;
use yii\helpers\Url;

/** @var yii\web\View $this */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Mis Notificaciones';
?>
<h1><?= Html::encode($this->title) ?></h1>

<!-- Mensajes flash para éxito o error -->
<?php if (Yii::$app->session->hasFlash('success')): ?>
    <div class="alert alert-success">
        <?= Yii::$app->session->getFlash('success') ?>
    </div>
    <script type="text/javascript">
        setTimeout(function() {
            window.location.href = document.referrer;  // Redirigir a la página anterior
        }, 3000); // Redirigir después de 3 segundos
    </script>
<?php endif; ?>

<?php if (Yii::$app->session->hasFlash('error')): ?>
    <div class="alert alert-danger">
        <?= Yii::$app->session->getFlash('error') ?>
    </div>
    <script type="text/javascript">
        setTimeout(function() {
            window.location.href = document.referrer;  // Redirigir a la página anterior
        }, 3000); // Redirigir después de 3 segundos
    </script>
<?php endif; ?>

<!-- GridView con las notificaciones -->
<?= GridView::widget([
    'dataProvider' => $dataProvider,
    'columns' => [
        ['class' => 'yii\grid\SerialColumn'],
        [
            'attribute' => 'codigo_de_clase',
            'label' => 'Tipo de notificación',
        ],
        [
            'attribute' => 'fecha',
            'label' => 'Fecha',
        ],
        [
            'attribute' => 'USUARIOid',
            'label' => 'Usuario origen de la notificación',
        ],
        [
            'attribute' => 'ACTIVIDADid',
            'label' => 'ID de Actividad',
            'value' => function ($model) {
                return in_array($model->codigo_de_clase, ['SOLICITUD_BAJA', 'SOLICITUD_CONTACTO']) ? 'no procede' : $model->ACTIVIDADid;
            },
        ],
        [
            'attribute' => 'texto',
            'label' => 'Texto de la Notificación',
            'value' => function ($model) {
                return in_array($model->codigo_de_clase, ['SOLICITUD_BAJA', 'SOLICITUD_CONTACTO']) ? 'no procede' : $model->texto;
            },
        ],
        [
            'class' => 'yii\grid\ActionColumn',
            'template' => '{view} {delete}',
            'buttons' => [
                'view' => function ($url, $model) {
                    return Html::a('Ver', ['notificacion/view', 'id' => $model->id], ['class' => 'btn btn-primary']);
                },
                'delete' => function ($url, $model) {
                    return Html::a('Eliminar', ['notificacion/eliminar', 'id' => $model->id], [
                        'class' => 'btn btn-danger',
                        'data-method' => 'post',
                    ]);
                },
            ],
        ],
    ],
]); ?>

<?php
$this->registerJs("
    $('.btn-danger').on('click', function(e) {
        e.preventDefault();
        var url = $(this).attr('href');
        if (confirm('¿Está seguro de que desea eliminar esta notificación?')) {
            $.post(url, function() {
                location.reload();
            });
        }
    });
");
?>

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