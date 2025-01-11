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

    <?php if (Yii::$app->session->hasFlash('contactFormSubmitted')): ?>

        <div class="alert alert-success">
        ¡Solicitud de Contacto enviada con éxito! Por Favor, espere a que un Administrador se ponga en contacto con usted.
        </div>

        <p>
            <?php if (Yii::$app->mailer->useFileTransport): ?>
                <!--¡Solicitud de Contacto enviada con éxito! Por Favor, espere a que un Administrador se ponga en contacto con usted.
                Dado que la aplicación está en modo de desarrollo, el correo no se envía, sino que se guarda como un archivo en <code><?= Yii::getAlias(Yii::$app->mailer->fileTransportPath) ?></code>.
                Por favor, configura la propiedad <code>useFileTransport</code> del componente <code>mail</code> para que sea falsa si deseas enviar correos electrónicos.-->
            <?php endif; ?>
        </p>

    <?php else: ?>

        <p>
            Si tienes consultas comerciales u otras preguntas, por favor completa el siguiente formulario para ponerte en contacto con nosotros. Gracias.
        </p>

        <div class="row">
            <div class="col-lg-5">

                <?php $form = ActiveForm::begin(['id' => 'contact-form']); ?>

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
