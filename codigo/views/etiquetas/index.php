<?php
/* @var $this yii\web\View */
/* @var $etiquetas app\models\Etiqueta[] */

use yii\helpers\Html;

$this->title = 'Etiquetas';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="etiquetas-index"></div>
    <h1><?= Html::encode($this->title) ?></h1>
    <p><?= Html::a('Crear Etiqueta', ['create'], ['class' => 'btn btn-success']) ?></p>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Descripción</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($etiquetas as $etiqueta): ?>
                <tr></tr>
                    <td><?= Html::encode($etiqueta->id) ?></td>
                    <td><?= Html::encode($etiqueta->nombre) ?></td>
                    <td><?= Html::encode($etiqueta->descripcion) ?></td>
                    <td>
                        <?= Html::a('Ver', ['view', 'id' => $etiqueta->id], ['class' => 'btn btn-primary']) ?>
                        <?= Html::a('Actualizar', ['update', 'id' => $etiqueta->id], ['class' => 'btn btn-warning']) ?>
                        <?= Html::a('Eliminar', ['delete', 'id' => $etiqueta->id], [
                            'class' => 'btn btn-danger',
                            'data' => [
                                'confirm' => '¿Estás seguro de que quieres eliminar esta etiqueta?',
                                'method' => 'post',
                            ],
                        ]) ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
