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