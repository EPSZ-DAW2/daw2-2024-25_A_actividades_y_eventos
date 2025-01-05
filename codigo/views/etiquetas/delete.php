<?php
/* @var $this yii\web\View */
/* @var $model app\models\Etiqueta */

use yii\helpers\Html;

$this->title = 'Eliminar Etiqueta: ' . $model->nombre;
$this->params['breadcrumbs'][] = ['label' => 'Etiquetas', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->nombre, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Eliminar';
?>
<div class="etiqueta-delete">
    <h1><?= Html::encode($this->title) ?></h1>
    <p>¿Estás seguro de que quieres eliminar esta etiqueta?</p>
    <?= Html::a('Eliminar', ['delete', 'id' => $model->id], [
        'class' => 'btn btn-danger',
        'data' => [
            'confirm' => '¿Estás seguro de que quieres eliminar esta etiqueta?',
            'method' => 'post',
        ],
    ]) ?>
</div>
