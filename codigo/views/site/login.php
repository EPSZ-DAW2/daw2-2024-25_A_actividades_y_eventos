<?php

/** @var yii\web\View $this */
/** @var yii\bootstrap5\ActiveForm $form */
/** @var app\models\LoginForm $model */

use yii\bootstrap5\ActiveForm;
use yii\bootstrap5\Html;

$this->title = 'Inicio de sesión';

// Estilos del Formulario

$this->registerCssFile('@web/css/estiloFormularios.css', [
    'depends' => [\yii\bootstrap5\BootstrapAsset::class],
]);
?>

<div class="site-login">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>Por favor, rellene este formulario para iniciar sesión:</p>

    <?php $form = ActiveForm::begin([
        'id' => 'login-form',
        'layout' => 'horizontal',
        'fieldConfig' => [
            'template' => "{label}\n<div>{input}</div>\n<div>{error}</div>",
            'labelOptions' => ['class' => 'col-form-label'],
            'inputOptions' => ['class' => 'form-control'], 
            'errorOptions' => ['class' => 'invalid-feedback'],
        ],
    ]); ?>

    <div class="form-group1">
        <?= $form->field($model, 'username')->textInput([
            'autofocus' => true,
            'placeholder' => 'Nombre de usuario',
        ]) ?>
    </div>

    <div class="form-group1">
        <?= $form->field($model, 'password')->passwordInput([
            'placeholder' => 'Contraseña',
        ]) ?>
    </div>

    <div class="form-group">
        <?= $form->field($model, 'rememberMe')->checkbox([
        'value' => 0, 
        'checked' => false, 
        'template' => "<div class=\"custom-control custom-checkbox\">{input} {label}</div>\n<div>{error}</div>",
        ]) ?>
    </div>

    <div class="form-group">
        <?= Html::submitButton('INICIAR SESION', [
            'class' => 'btn btn-primaryy',
            'name' => 'login-button',
        ]) ?>
    </div>

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