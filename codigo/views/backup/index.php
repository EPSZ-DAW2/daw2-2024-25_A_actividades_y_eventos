<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var yii\base\DynamicModel $model */

$this->title = 'Copias de Seguridad';
?>
<h1><?= Html::encode($this->title) ?></h1>

<?php if (Yii::$app->session->hasFlash('success')): ?>
    <div class="alert alert-success alert-dismissible">
        <button type="button" class="close" data-dismiss="alert">&times;</button>
        <?= Yii::$app->session->getFlash('success') ?>
    </div>
<?php endif; ?>

<?php if (Yii::$app->session->hasFlash('error')): ?>
    <div class="alert alert-danger alert-dismissible">
        <button type="button" class="close" data-dismiss="alert">&times;</button>
        <?= Yii::$app->session->getFlash('error') ?>
    </div>
<?php endif; ?>

<p>
    <?= Html::a('Descargar Copia de Seguridad', ['download'], ['class' => 'btn btn-success']) ?>
</p>

<div class="alert alert-info">
    <h4><i class="glyphicon glyphicon-info-sign"></i> Información para Restauración</h4>
    <p>Para restaurar una copia de seguridad, siga estos pasos:</p>
    <ol>
        <li>Acceda a phpMyAdmin o al gestor de bases de datos MySQL que utilice</li>
        <li>Seleccione la base de datos que desea restaurar</li>
        <li>Use la opción "Importar" o "Restore"</li>
        <li>Seleccione el archivo SQL de la copia de seguridad</li>
        <li>Ejecute la restauración</li>
    </ol>
    <p><strong>Nota:</strong> Este proceso debe ser realizado por el administrador del sistema para garantizar la integridad de los datos.</p>
</div>

<?php
// Eliminar o comentar todo el código del formulario y el script JS que ya no se necesita
?>
