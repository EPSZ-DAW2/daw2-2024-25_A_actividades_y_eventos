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
        // other columns as needed
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
                        'data-confirm' => '¿Está seguro de que desea eliminar esta notificación?',
                        'data-method' => 'post',
                    ]);
                },
            ],
        ],
    ],
]); ?>

