<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Anuncio $model */

$this->title = 'Create Anuncio';
?>
<div class="anuncio-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
