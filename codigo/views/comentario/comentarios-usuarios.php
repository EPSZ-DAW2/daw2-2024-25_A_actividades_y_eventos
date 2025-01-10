<?php
use yii\helpers\Html;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use app\models\Comentario;
use yii\helpers\Url;
use yii\data\ArrayDataProvider;

/** @var yii\web\View $this */
/** @var app\models\ComentarioUsuario[] $comentariosUsuarios */

$this->title = 'Comentarios de Usuarios';

$dataProvider = new ArrayDataProvider([
    'allModels' => $comentariosUsuarios,
    'pagination' => [
        'pageSize' => 10,
    ],
    'sort' => [
        'attributes' => ['uSUARIO.nick', 'cOMENTARIO.texto'],
    ],
]);
?>
<div class="comentarios-usuarios">
    <h1><?= Html::encode($this->title) ?></h1>
    <p>
    <?= Html::a(Yii::t('app', 'Volver'), ['index'], ['class' => 'btn btn-primary']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'attribute' => 'uSUARIO.nick',
                'label' => 'Título de la Actividad',
            ],
            [
                'attribute' => 'cOMENTARIO.texto',
                'label' => 'Texto del Comentario',
            ],
            [
                'class' => ActionColumn::class,
                'template' => '{view} {update} {delete}',
                'buttons' => [
                    'view' => function ($url, $model) {
                        return Html::a('<span class="glyphicon glyphicon-eye-open"></span>', Url::to(['comentario/view', 'id' => $model->COMENTARIOid]), [
                            'title' => Yii::t('app', 'Ver'),
                        ]);
                    },
                    'update' => function ($url, $model) {
                        return Html::a('<span class="glyphicon glyphicon-pencil"></span>', Url::to(['comentario/update', 'id' => $model->COMENTARIOid]), [
                            'title' => Yii::t('app', 'Actualizar'),
                        ]);
                    },
                    'delete' => function ($url, $model) {
                        return Html::a('<span class="glyphicon glyphicon-trash"></span>', Url::to(['comentario/delete', 'id' => $model->COMENTARIOid]), [
                            'title' => Yii::t('app', 'Eliminar'),
                            'data' => [
                                'confirm' => Yii::t('app', '¿Estás seguro de que quieres eliminar este elemento?'),
                                'method' => 'post',
                            ],
                        ]);
                    },
                ],
            ]
        ],

    ]); ?>

</div>