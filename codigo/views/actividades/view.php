<?php
use yii\helpers\Html;

$this->title = $model->titulo;
?>

<h1><?= Html::encode($this->title) ?></h1>

<p><strong>Descripción:</strong> <?= Html::encode($model->descripcion) ?></p>
<p><strong>Imagen Principal:</strong> 
    <?php if ($model->imagen_principal): ?>
        <img src="data:image/jpeg;base64,<?= base64_encode($model->imagen_principal) ?>" alt="<?= Html::encode($model->titulo) ?>" style="max-width: 100%; height: auto;">
    <?php else: ?>
        No disponible
    <?php endif; ?>
</p>
<p><strong>Fecha de Celebración:</strong> <?= Html::encode($model->fecha_celebracion) ?></p>
<p><strong>Lugar de Celebración:</strong> <?= Html::encode($model->lugar_celebracion) ?></p>

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
