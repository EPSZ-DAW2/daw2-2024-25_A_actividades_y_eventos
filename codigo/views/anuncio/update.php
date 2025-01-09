<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Anuncio $model */

$this->title = 'Update Anuncio: ' . $model->id;
?>
<div class="anuncio-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
