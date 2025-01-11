<?php

/** @var yii\web\View $this */
/** @var yii\bootstrap5\ActiveForm $form */
/** @var app\models\ContactForm $model */

use yii\bootstrap5\ActiveForm;
use yii\bootstrap5\Html;

$this->title = 'Contacto';
$this->params['breadcrumbs'][] = $this->title;
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
            <div class="col-lg-5">
                <?php $form = ActiveForm::begin([
                    'id' => 'contact-form',
                    'action' => ['site/contact'],  // Acción del formulario
                ]); ?>

                    <?= $form->field($model, 'name')->textInput(['autofocus' => true, 'placeholder' => 'Tu nombre']) ?>
                    <?= $form->field($model, 'email')->input('email', ['placeholder' => 'Tu correo electrónico']) ?>
                    <?= $form->field($model, 'subject')->textInput(['placeholder' => 'Asunto del mensaje']) ?>
                    <?= $form->field($model, 'body')->textarea(['rows' => 6, 'placeholder' => 'Escribe tu mensaje aquí']) ?>

                    <div class="form-group">
                        <?= Html::submitButton('Enviar', ['class' => 'btn btn-primary', 'name' => 'contact-button']) ?>
                    </div>

                <?php ActiveForm::end(); ?>
            </div>
        </div>
    <?php endif; ?>
</div>
