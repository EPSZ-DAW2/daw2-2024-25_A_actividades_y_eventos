<?php

use app\models\RegistroAcciones;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var app\models\RegistroAccionesSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = Yii::t('app', 'Registro Acciones');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="registro-acciones-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Create Registro Acciones'), ['create'], ['class' => 'btn btn-success']) ?>
        <?= Html::a(Yii::t('app', 'Elimina todos los Logs'), ['delete-all'], [
            'class' => 'btn btn-danger',
            'data-confirm' => '¿Está seguro de que desea eliminar todos los registros de acciones?',
            'data-method' => 'post',
        ]) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'usuario_accion',
            'fecha_accion',
            'accion:ntext',
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, RegistroAcciones $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                 }
            ],
        ],
    ]); ?>


</div>
