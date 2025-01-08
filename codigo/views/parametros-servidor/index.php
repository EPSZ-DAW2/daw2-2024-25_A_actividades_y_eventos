<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'Parámetros del Servidor';
?>

<div class="parametros-servidor-index">
    <h1><?= Html::encode($this->title) ?></h1>

    <div class="row">
        <div class="col-md-6">
            <h2>Configuración PHP</h2>
            <?php $form = ActiveForm::begin(); ?>

            <?= $form->field($model, 'upload_max_filesize')->textInput(['placeholder' => 'Ejemplo: 10M, 128M']) ?>
            <?= $form->field($model, 'memory_limit')->textInput(['placeholder' => 'Ejemplo: 128M, 256M']) ?>
            </br>
            <div class="alert alert-warning">
                <strong>Nota:</strong> Los cambios en estos parámetros requieren reiniciar el servidor web para tomar efecto.
            </div>

            <div class="form-group">
                <?= Html::submitButton('Guardar', ['class' => 'btn btn-primary']) ?>
            </div>

            <?php ActiveForm::end(); ?>
        </div>

        <div class="col-md-6">
            <h2>Información del Servidor</h2>
            <div class="table-responsive">
                <table class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>Parámetro</th>
                            <th>Valor</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($serverInfo as $parameter => $value): ?>
                        <tr>
                            <td><?= Html::encode($parameter) ?></td>
                            <td><?= Html::encode($value) ?></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
