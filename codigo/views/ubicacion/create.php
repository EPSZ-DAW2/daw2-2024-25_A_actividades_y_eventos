<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Ubicacion $model */

$this->title = 'Create Ubicacion';
$this->params['breadcrumbs'][] = ['label' => 'Ubicacions', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="ubicacion-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
