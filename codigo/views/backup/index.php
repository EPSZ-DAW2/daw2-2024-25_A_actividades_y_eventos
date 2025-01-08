<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var yii\base\DynamicModel $model */

$this->title = 'Copias de Seguridad';
?>
<h1><?= Html::encode($this->title) ?></h1>

<p>
    <?= Html::a('Descargar Copia de Seguridad', ['download'], ['class' => 'btn btn-success']) ?>
</p>

<h2>Restaurar Base de Datos</h2>

<?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]) ?>

    <?= $form->field($model, 'file')->fileInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Subir y Restaurar', ['class' => 'btn btn-primary']) ?>
    </div>

<?php ActiveForm::end() ?>
