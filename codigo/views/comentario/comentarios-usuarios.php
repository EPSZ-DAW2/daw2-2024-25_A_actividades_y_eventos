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