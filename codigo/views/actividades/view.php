<?php
use yii\helpers\Html;

$this->title = $model->titulo;
?>

<h1><?= Html::encode($this->title) ?></h1>

<p><strong>Descripción:</strong> <?= Html::encode($model->descripcion) ?></p>
<p><strong>Imagen:</strong> <?= Html::encode($model->imagen) ?></p>
<p><strong>Fecha de Inicio:</strong> <?= Html::encode($model->fecha_inicio) ?></p>
<p><strong>Fecha de Fin:</strong> <?= Html::encode($model->fecha_fin) ?></p>

<p>
    <?= Html::a('Actualizar', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
    <?= Html::a('Eliminar', ['delete', 'id' => $model->id], [
        'class' => 'btn btn-danger',
        'data' => [
            'confirm' => '¿Estás seguro de que deseas eliminar esta actividad?',
            'method' => 'post',
        ],
    ]) ?>
</p>
