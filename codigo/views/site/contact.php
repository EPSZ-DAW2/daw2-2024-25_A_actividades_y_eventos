<?php

/** @var yii\web\View $this */
/** @var yii\bootstrap5\ActiveForm $form */
/** @var app\models\ContactForm $model */

use yii\bootstrap5\ActiveForm;
use yii\bootstrap5\Html;

$this->title = 'Contacto';
$this->params['breadcrumbs'][] = $this->title;

$this->registerCssFile('@web/css/estiloFormularios.css', [
    'depends' => [\yii\bootstrap5\BootstrapAsset::class],
]);

?>

<div class="site-contact">
    <h1><?= Html::encode($this->title) ?></h1>

    <!-- Mensaje de éxito -->
    <?php if (Yii::$app->session->hasFlash('contactFormSubmitted')): ?>
        <div class="alert alert-success">
            ¡Solicitud de Contacto enviada con éxito! Por favor, espere a que un Administrador se ponga en contacto con usted.
        </div>
    <?php endif; ?>

    <!-- Mensaje de error -->
    <?php if (Yii::$app->session->hasFlash('contactFormFailed')): ?>
        <div class="alert alert-danger">
            <?= Yii::$app->session->getFlash('contactFormFailed'); ?>
        </div>
    <?php endif; ?>

    <?php if (!Yii::$app->session->hasFlash('contactFormSubmitted')): ?>
        <p>
            Si tienes consultas comerciales u otras preguntas, por favor completa el siguiente formulario para ponerte en contacto con nosotros. Gracias.
        </p>

        <div class="row">
            <div class="col-lg-12"> 
                <?php $form = ActiveForm::begin([
                    'id' => 'contact-form',
                    'action' => ['site/contact'],  
                    'options' => ['class' => 'site-login'],  
                ]); ?>

                    <!-- Campos del formulario -->
                    <div class="form-group1">
                        <?= $form->field($model, 'name')->textInput([
                            'autofocus' => true,
                            'placeholder' => 'Tu nombre',
                            'class' => 'form-control'  
                        ]) ?>
                    </div>

                    <div class="form-group1">
                        <?= $form->field($model, 'email')->input('email', [
                            'placeholder' => 'Tu correo electrónico',
                            'class' => 'form-control'  
                        ]) ?>
                    </div>

                    <div class="form-group1">
                        <?= $form->field($model, 'subject')->textInput([
                            'placeholder' => 'Asunto del mensaje',
                            'class' => 'form-control'  
                        ]) ?>
                    </div>

                    <div class="form-group1">
                        <?= $form->field($model, 'body')->textarea([
                            'rows' => 6,
                            'placeholder' => 'Escribe tu mensaje aquí',
                            'class' => 'form-control'  
                        ]) ?>
                    </div>

                    <div class="form-group">
                        <?= Html::submitButton('ENVIAR', ['class' => 'btn btn-primaryy', 'name' => 'contact-button']) ?>
                    </div>

                <?php ActiveForm::end(); ?>
            </div>
        </div>
    <?php endif; ?>
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