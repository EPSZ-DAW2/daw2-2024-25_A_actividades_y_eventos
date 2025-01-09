<?php
/* @var $this yii\web\View */
/* @var $actividades array */

use yii\helpers\Html;
use yii\grid\GridView;

$this->title = 'Actividades Pasadas';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="actividades-pasadas">
    <h1><?= Html::encode($this->title) ?></h1>

    <?php if (!empty($actividades)): ?>
        <?= GridView::widget([
            'dataProvider' => new \yii\data\ArrayDataProvider([
                'allModels' => $actividades,
                'pagination' => [
                    'pageSize' => 10,
                ],
            ]),
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],
                'titulo',
                'descripcion',
                [
                    'attribute' => 'fecha_celebracion',
                    'format' => ['date', 'php:Y-m-d'],
                ],
                [
                    'class' => 'yii\grid\ActionColumn',
                    'template' => '{view}',
                    'buttons' => [
                        'view' => function ($url, $model) {
                            return Html::a('Ver', ['ver_actividad', 'id' => $model['id']], ['class' => 'btn btn-primary']);
                        },
                    ],
                ],
            ],
        ]); ?>
    <?php else: ?>
        <p>No has participado en actividades pasadas.</p>
    <?php endif; ?>
</div>