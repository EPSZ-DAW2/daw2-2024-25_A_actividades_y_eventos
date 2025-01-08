<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Roles */
/* @var $usuarios array */

?>
    <?= Html::a('Lista de roles', ['index'], ['class' => 'btn btn-secondary']) ?>

<div class="roles-assign">
    <?php $form = ActiveForm::begin([
        'action' => ['rol/assign', 'id' => $model->id],
        'method' => 'post',
    ]); ?>

    <?= $form->field($model, 'nombre_rol')->dropDownList($model->getRoleOptions(), ['prompt' => 'Seleccione un rol', 'name' => 'rol']) ?>

    <?= $form->field($usuarios, 'id')->dropDownList($usuarios->getUsuarioOptions(), ['prompt' => 'Seleccione un usuario', 'name' => 'usuario']) ?>

    <div class="form-group">
        <?= Html::submitButton('Asignar', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>
