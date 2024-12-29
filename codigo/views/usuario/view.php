<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var app\models\Usuarios $model */

$this->title = $model->nombreCompleto;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Usuarios'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="usuarios-view">

    <h1><?= Html::encode($model->nombreCompleto) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Editar'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app', 'Eliminar'), ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('app', 'Está seguro de querer eliminar este usuario?'),
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'nick',
            'password',
            'email:email',
            'nombre',
            'apellidos',
            'fecha_nacimiento',
            'direccion',
            'ubicacion',
            'activo',
            'fecha_registro',
            'registro_confirmado',
            'revisado',
            'ultimo_acceso',
            'intentos_acceso',
            'bloqueado',
            'fecha_hora_bloqueo',
            'motivo_bloqueo:ntext',
            'notas:ntext',
        ],
    ]) ?>

</div>
