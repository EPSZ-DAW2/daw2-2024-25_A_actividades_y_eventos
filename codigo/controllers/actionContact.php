<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use app\models\ContactForm;
use app\models\Notificacion;

class SiteController extends Controller
{
    public function actionContact()
    {
        $model = new ContactForm();

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            Yii::error('Formulario cargado y validado correctamente', __METHOD__); // Para depurar

            // Intentamos enviar el correo electrónico
            $emailSent = $model->contact(Yii::$app->params['adminEmail']);
            Yii::error('Correo enviado: ' . ($emailSent ? 'Sí' : 'No'), __METHOD__); // Para depurar

            // Intentamos crear la notificación
            $notificationCreated = $model->createNotification();
            Yii::error('Notificación creada: ' . ($notificationCreated ? 'Sí' : 'No'), __METHOD__); // Para depurar

            if ($emailSent && $notificationCreated) {
                Yii::$app->session->setFlash('contactFormSubmitted', true);
            } else {
                Yii::$app->session->setFlash('contactFormFailed', 'No se pudo enviar el formulario o crear la notificación.');
            }

            return $this->refresh(); // Refresca la página después de procesar
        }

        return $this->render('contact', [
            'model' => $model,
        ]);
    }
    
    public function actionCrearNotificacion($codigo, $name, $subject, $body)
    {
        $notificacion = new Notificacion();
        $notificacion->codigo_de_clase = $codigo;
        $notificacion->fecha = date('Y-m-d H:i:s');
        $notificacion->USUARIOid = Yii::$app->user->id ?? 0; // El usuario actual
        $notificacion->USUARIOid2 = 1; // El administrador (usuario con ID 1)
        $notificacion->ACTIVIDADid = 0; // Sin actividad relacionada

        // Usamos el nombre y asunto del formulario de contacto
        $notificacion->texto = "Nuevo mensaje de contacto de {$name}: {$subject} - Mensaje: {$body}";

        if ($notificacion->save()) {
            Yii::$app->session->setFlash('success', 'Notificación creada exitosamente.');
        } else {
            Yii::$app->session->setFlash('error', 'Error al crear la notificación.');
        }

        return $this->redirect(['usuario/mi-perfil']);
    }
}
