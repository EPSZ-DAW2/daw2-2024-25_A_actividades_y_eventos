<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use app\models\ContactForm;

class SiteController extends Controller
{
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            // Envía el correo electrónico
            $emailSent = $model->contact(Yii::$app->params['adminEmail']);
            
            // Crea la notificación
            $notificationCreated = $model->createNotification();

            if ($emailSent && $notificationCreated) {
                Yii::$app->session->setFlash('contactFormSubmitted', true);
            } else {
                Yii::$app->session->setFlash('contactFormFailed', 'No se pudo enviar el formulario o crear la notificación.');
            }

            return $this->refresh();
        }

        return $this->render('contact', [
            'model' => $model,
        ]);
    }
}
