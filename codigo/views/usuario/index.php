<?php

use app\models\Usuario;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var app\models\UsuarioSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = Yii::t('app', 'Usuarios');
?>
<div class="usuario-index">

    <h1>Gestion de usuarios</h1>

    <p>
        <?= Html::a(Yii::t('app', 'Crear nuevo usuario'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php  ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            'id',
            'nick',
            'email:email',
            'edad',
            'rol.nombre_rol',
            //'apellidos',
            //'fecha_nacimiento',
            //'activo',
            //'fecha_registor',
            //'registro_confirmado',
            //'fecha_bloqueo',
            //'motivo_bloqueo',
            //'notas',
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, Usuario $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                }
            ],
        ],
    ]); ?>




</div>
