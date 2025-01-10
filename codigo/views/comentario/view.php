<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var app\models\Comentario $model */

$this->title = "Comentario $model->id";
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Comentarios'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="comentario-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Editar'), ['update', 'id' => $model->id], ['class' => 'btn btn-warning']) ?>
        <?= Html::a(Yii::t('app', 'Eliminar'), ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('app', '¿Esta seguro de querer eliminar este elemento?'),
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'texto',
            'comentario_relacionado',
            'cerrado_comentario',
            'numero_de_denuncias',
            'fecha_bloque',
            'motivos_bloqueo',
            'USUARIOid',
            'ACTIVIDADid',
        ],
    ]) ?>

</div>
