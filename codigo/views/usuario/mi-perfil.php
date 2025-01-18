<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\Usuario $model */
/** @var app\models\Imagen $imagenPerfil */

$this->title = 'Mi Perfil';
?>
<h1><?= Html::encode($this->title) ?></h1>


<div>
    <?php if ($imagenPerfil !== null && !empty($imagenPerfil->ruta_archivo)): ?>
        <?= Html::img($imagenPerfil->getRutaCompleta(true), [
            'alt' => 'Imagen de Perfil',
            'class' => 'img-thumbnail',
            'style' => 'max-width: 200px; max-height: 200px;'
        ]) ?>
    <?php else: ?>
        <?= Html::img(Yii::getAlias('@web/images/perfiles/no-photo.png'), [
            'alt' => 'Imagen por defecto',
            'class' => 'img-thumbnail',
            'style' => 'max-width: 200px; max-height: 200px;'
        ]) ?>
    <?php endif; ?>
</div>
</br>
<?php $form = ActiveForm::begin([
    'id' => 'profile-form',
    'options' => ['enctype' => 'multipart/form-data'], // Añadir enctype para subir archivos
    'fieldConfig' => [
        'template' => "{label}\n<div class=\"col-lg-12\">{input}</div>\n<div class=\"col-lg-12\">{error}</div>",
        'labelOptions' => ['class' => 'col-lg-12 control-label'],
    ],
]); ?>

<?= $form->field($model, 'imageFile')->fileInput()->label('Subir nueva foto de perfil') ?>
</br>
<div class="form-group">
    <div class="col-lg-12">
        <?= Html::submitButton('Guardar nueva imagen', ['class' => 'btn btn-success']) ?>
    </div>
</div>

<?php ActiveForm::end(); ?>

</br>
<table class="table table-striped table-bordered">
    <tbody>
        <tr>
            <td>Nombre de usuario</td>
            <td><?= Html::encode($model->nick) ?></td>
        </tr>
        <tr>
            <td>Email</td>
            <td><?= Html::encode($model->email) ?></td>
        </tr>
        <tr>
            <td>Nombre</td>
            <td><?= Html::encode($model->nombre) ?></td>
        </tr>
        <tr>
            <td>Apellidos</td>
            <td><?= Html::encode($model->apellidos) ?></td>
        </tr>
        <tr>
            <td>Edad</td>
            <td><?= Html::encode($model->edad) ?></td>
        </tr>
        <tr>
            <td>Activo</td>
            <td><?= $model->activo ? '✔️' : '❌' ?></td>
        </tr>
        <tr>
            <td>Registro confirmado</td>
            <td><?= $model->registro_confirmado ? '✔️' : '❌' ?></td>
        </tr>
        <tr>
            <td>Token</td>
            <td><?= Html::encode($model->token) ?></td>
        </tr>
    </tbody>
</table>

<?= Html::a('Editar Perfil', ['usuario/editar-perfil'], ['class' => 'btn btn-warning']) ?>

</br>
</br>

<h2>Configuración de Avisos</h2>
</br>
<div class="form-group">
    <div class="col-lg-12">
        <?php 
        $showNotifications = !isset($_SESSION['hide_notifications']);
        echo Html::a(
            $showNotifications ? 'Desactivar indicador de notificaciones' : 'Activar indicador de notificaciones',
            ['usuario/toggle-notifications'],
            [
                'class' => 'btn btn-' . ($showNotifications ? 'secondary' : 'primary'),
                'data' => ['method' => 'post'],
            ]
        );
        ?>
    </div>
</div>

</br>
</br>

<h2>Solitud de soporte al administrador del sitio</h2>
</br>
<!-- Botones para crear notificaciones -->
<div class="form-group">
    <div class="col-lg-12">
        <?= Html::a('Solicitud de Baja', ['usuario/crear-notificacion', 'codigo' => 'SOLICITUD_BAJA'], ['class' => 'btn btn-danger']) ?>
        <?= Html::a('Solicitud de Contacto', ['usuario/crear-notificacion', 'codigo' => 'SOLICITUD_CONTACTO'], ['class' => 'btn btn-warning']) ?>
    </div>
</div>

</br>
