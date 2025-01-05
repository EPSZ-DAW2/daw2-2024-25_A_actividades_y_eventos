<?php
/* @var $this yii\web\View */
/* @var $etiqueta app\models\Etiqueta */

use yii\helpers\Html;

$this->title = $etiqueta->nombre;
$this->params['breadcrumbs'][] = ['label' => 'Etiquetas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="etiqueta-view">
    <h1><?= Html::encode($this->title) ?></h1>
    <p>
        <?= Html::a('Editar', ['update', 'id' => $etiqueta->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Eliminar', ['delete', 'id' => $etiqueta->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => '¿Estás seguro de que quieres eliminar esta etiqueta?',
                'method' => 'post',
            ],
        ]) ?>
        <?= Html::a('Volver a la lista', ['index'], ['class' => 'btn btn-secondary']) ?>

    </p>
    <table class="table table-bordered">
        <tr>
            <th>ID</th>
            <td><?= Html::encode($etiqueta->id) ?></td>
        </tr>
        <tr>
            <th>Nombre</th>
            <td><?= Html::encode($etiqueta->nombre) ?></td>
        </tr>
        <tr>
            <th>Descripción</th>
            <td><?= Html::encode($etiqueta->descripcion) ?></td>
        </tr>
    </table>
</div>
