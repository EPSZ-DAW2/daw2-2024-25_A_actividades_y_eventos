<?php

/** @var yii\web\View $this */
/** @var yii\bootstrap5\ActiveForm $form */
/** @var app\models\Usuario $model */

use yii\bootstrap5\ActiveForm;
use yii\helpers\Html;

$this->title = 'Registro de usuario';

$this->registerCssFile('@web/css/estiloFormularios.css', [
    'depends' => [\yii\bootstrap5\BootstrapAsset::class],
]);

?>

<div class="site-login">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>Por favor, complete los siguientes campos para registrarse:</p>

    <?php $form = ActiveForm::begin([
        'id' => 'register-form',
        'layout' => 'horizontal',
        'fieldConfig' => [
            'template' => "<div>{label}</div><div>{input}</div><div>{error}</div>", // Asegura que las etiquetas se muestren
            'labelOptions' => ['class' => 'col-form-label'], // Etiqueta al lado
            'inputOptions' => ['class' => 'form-control'], // Asegura que los inputs tengan el ancho completo
            'errorOptions' => ['class' => 'invalid-feedback'],
        ],
    ]); ?>

    <!-- Campo Nombre -->
    <div class="form-group1">
        <?= $form->field($model, 'nombre')->textInput([
            'autofocus' => true,
            'placeholder' => 'Tu nombre',
        ]) ?>
    </div>

    <!-- Campo Apellidos -->
    <div class="form-group1">
        <?= $form->field($model, 'apellidos')->textInput([
            'placeholder' => 'Tus apellidos',
        ]) ?>
    </div>

    <!-- Campo Email -->
    <div class="form-group1">
        <?= $form->field($model, 'email')->input('email', [
            'placeholder' => 'Tu correo electrónico',
        ]) ?>
    </div>

    <!-- Campo Nick -->
    <div class="form-group1">
        <?= $form->field($model, 'nick')->textInput([
            'placeholder' => 'Tu nickname',
        ]) ?>
    </div>

    <!-- Campo Contraseña -->
    <div class="form-group1">
        <?= $form->field($model, 'password')->passwordInput([
            'placeholder' => 'Al menos 8 caracteres',
        ]) ?>
    </div>

    <!-- Campo Fecha de Nacimiento -->
    <div class="form-group1">
        <?= $form->field($model, 'fecha_nacimiento')->input('date') ?>
    </div>

    <!-- Botón Enviar -->
    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'REGISTRARSE'), [
            'class' => 'btn btn-primaryy',
            'name' => 'register-button',
        ]) ?>
    </div>

    <section class="form-group my-2">
        <p>Al registrarse, usted asume ser un usuario <strong>mayor de 16 años</strong> y acepta los <?= Html::a('términos y condiciones', ['site/politicaprivacidad']) ?></p>
    </section>

    <?php ActiveForm::end(); ?>
</div>


<div class = "d-none">
        <?php
            // API Key de Google Maps
            $apiKey = 'AIzaSyAwkqhsAcJIftL32sor2fYd5Q7-zaOkc5A';
            $direccionActividad = "plaza marina 1, 49004 Zamora";
            $direccionEncodedActividad = urlencode($direccionActividad);
            $urlActividad = "https://maps.googleapis.com/maps/api/geocode/json?address=$direccionEncodedActividad&components=country:ES&key=$apiKey";
            $responseActividad = file_get_contents($urlActividad);
            $dataActividad = json_decode($responseActividad, true);

            if ($dataActividad['status'] == 'OK') {
                $latActividad = $dataActividad['results'][0]['geometry']['location']['lat'];
                $lngActividad = $dataActividad['results'][0]['geometry']['location']['lng'];
            } else {
                $latActividad = null;
                $lngActividad = null;
            }

            $this->params['latActividad'] = $latActividad;
            $this->params['lngActividad'] = $lngActividad;


            // Agregar mapa de actividad
            if ($latActividad && $lngActividad) {
                echo "<div style='display: flex; justify-content: center; align-items: center;'>
                    <div id='map-actividad' style='width: 100%; height: 200px;'></div>
                </div>";
            }
        ?>
    </div>