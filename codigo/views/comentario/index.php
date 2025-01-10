<?php

use app\models\Comentario;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var app\models\ComentarioSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = Yii::t('app', 'Comentarios');
?>
<div class="comentario-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Crear nuevo comentario'), ['create'], ['class' => 'btn btn-success mb-4']) ?>
        <br>
        <?= Html::a(Yii::t('app', 'Ver comentarios de actividades'), ['comentarios-actividades'], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app', 'Ver comentarios de usuarios'), ['comentarios-usuarios'], ['class' => 'btn btn-primary']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            'id',
            'texto',
            'comentario_relacionado',
            'cerrado_comentario',
            'numero_de_denuncias',
            //'fecha_bloque',
            //'motivos_bloqueo',
            //'USUARIOid',
            //'ACTIVIDADid',
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, Comentario $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                }
            ],
        ],
    ]); ?>


</div>
