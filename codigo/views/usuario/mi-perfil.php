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
    <?php if ($imagenPerfil !== null): ?>
        <?= Html::img($imagenPerfil->getRutaCompleta(), [
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
    </tbody>
</table>

<?= Html::a('Editar Perfil', ['usuario/editar-perfil'], ['class' => 'btn btn-warning']) ?>

</br>

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
