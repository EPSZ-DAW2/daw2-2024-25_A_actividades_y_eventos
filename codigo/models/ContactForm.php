<?php

namespace app\models;

use Yii;
use yii\base\Model;
use app\models\Notificacion;

/**
 * ContactForm es el modelo detrás del formulario de contacto.
 */
class ContactForm extends Model
{
    public $name;
    public $email;
    public $subject;
    public $body;

    /**
     * @return array las reglas de validación.
     */
    public function rules()
    {
        return [
            [['name', 'email', 'subject', 'body'], 'required', 'message' => 'Este campo es obligatorio.'],
            ['email', 'email', 'message' => 'Por favor ingrese un correo electrónico válido.'],
        ];
    }

    /**
     * Envía un correo electrónico a la dirección especificada usando la información recopilada por este modelo.
     * @param string $email la dirección de correo electrónico de destino.
     * @return bool si el correo fue enviado correctamente.
     */
    public function contact($email)
    {
        if ($this->validate()) {
            return Yii::$app->mailer->compose()
                ->setTo($email)
                ->setFrom([Yii::$app->params['senderEmail'] => Yii::$app->params['senderName']])
                ->setReplyTo([$this->email => $this->name])
                ->setSubject($this->subject)
                ->setTextBody($this->body)
                ->send();
        }
        return false;
    }

    /**
     * Crea y guarda una notificación en la base de datos.
     *
     * @return bool si se pudo guardar la notificación.
     */
    public function createNotification()
    {
        $notificacion = new Notificacion();
        $notificacion->fecha = date('Y-m-d H:i:s');
        $notificacion->codigo_de_clase = 'SOLICITUD_CONTACTO'; // Tipo de notificación
        $notificacion->USUARIOid = Yii::$app->user->id ?? 0; // Usuario origen (si no está logueado, se asigna 0)
        $notificacion->USUARIOid2 = 0; // Usuario destino (puede ajustarse según necesidades)
        $notificacion->ACTIVIDADid = 0; // No aplica para esta notificación
        $notificacion->texto = "Nuevo mensaje de contacto de {$this->name}: {$this->subject}";
        
        return $notificacion->save();
    }
}
