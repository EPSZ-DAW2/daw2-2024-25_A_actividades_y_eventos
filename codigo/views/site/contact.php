<?php

/** @var yii\web\View $this */
/** @var yii\bootstrap5\ActiveForm $form */
/** @var app\models\ContactForm $model */

use yii\bootstrap5\ActiveForm;
use yii\bootstrap5\Html;
use yii\captcha\Captcha;

$this->title = 'Contacto';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-contact">
    <h1><?= Html::encode($this->title) ?></h1>

    <?php if (Yii::$app->session->hasFlash('contactFormSubmitted')): ?>

        <div class="alert alert-success">
            Gracias por contactarnos. Te responderemos lo antes posible.
        </div>

        <p>
            Ten en cuenta que si tienes habilitado el depurador de Yii, podrás ver el mensaje de correo en el panel de correo del depurador.
            <?php if (Yii::$app->mailer->useFileTransport): ?>
                Dado que la aplicación está en modo de desarrollo, el correo no se envía, sino que se guarda como un archivo en <code><?= Yii::getAlias(Yii::$app->mailer->fileTransportPath) ?></code>.
                Por favor, configura la propiedad <code>useFileTransport</code> del componente <code>mail</code> para que sea falsa si deseas enviar correos electrónicos.
            <?php endif; ?>
        </p>

    <?php else: ?>

        <p>
            Si tienes consultas comerciales u otras preguntas, por favor completa el siguiente formulario para ponerte en contacto con nosotros. Gracias.
        </p>

        <div class="row">
            <div class="col-lg-5">

                <?php $form = ActiveForm::begin(['id' => 'contact-form']); ?>

                    <?= $form->field($model, 'name')->textInput(['autofocus' => true]) ?>

                    <?= $form->field($model, 'email') ?>

                    <?= $form->field($model, 'subject') ?>

                    <?= $form->field($model, 'body')->textarea(['rows' => 6]) ?>

                    <?= $form->field($model, 'verifyCode')->widget(Captcha::class, [
                        'template' => '<div class="row"><div class="col-lg-3">{image}</div><div class="col-lg-6">{input}</div></div>',
                    ]) ?>

                    <div class="form-group">
                        <?= Html::submitButton('Enviar', ['class' => 'btn btn-primary', 'name' => 'contact-button']) ?>
                    </div>

                <?php ActiveForm::end(); ?>

            </div>
        </div>

    <?php endif; ?>
</div>
