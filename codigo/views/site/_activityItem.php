<?php
use yii\helpers\Html;

/* @var $model app\models\Actividad */
?>

<div class="col-lg-4">
    <div class="activity-item">
        <h4><?= Html::encode($model->titulo) ?></h4>
        <p><?= Html::encode($model->descripcion) ?></p>
        <?php if (!empty($model->imagen_principal)): ?>
            <img src="<?= Yii::getAlias('@web/images/' . Html::encode($model->imagen_principal)) ?>" 
                 alt="<?= Html::encode($model->titulo) ?>" 
                 class="img-fluid">
        <?php endif; ?>
        <p><strong>Fecha:</strong> <?= Yii::$app->formatter->asDate($model->fecha_celebracion) ?></p>
        <?= Html::a('Ver Detalles', ['actividades/ver_actividad', 'id' => $model->id], ['class' => 'btn btn-info']) ?>
    </div>
</div>
