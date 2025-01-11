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
     * @return array etiquetas de atributos personalizadas
     */
    public function attributeLabels(){
        return [
            'name' => 'Nombre',
            'email' => 'Correo electrónico',
            'subject' => 'Asunto',
            'body' => 'Mensaje',
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
            Yii::error('Validación exitosa. Intentando enviar correo...', __METHOD__); // Para depurar

            $sent = Yii::$app->mailer->compose()
                ->setTo($email)
                ->setFrom([Yii::$app->params['senderEmail'] => Yii::$app->params['senderName']])
                ->setReplyTo([$this->email => $this->name])
                ->setSubject($this->subject)
                ->setTextBody($this->body)
                ->send();

            if ($sent) {
                Yii::error('Correo enviado exitosamente', __METHOD__); // Para depurar
            } else {
                Yii::error('Error al enviar correo', __METHOD__); // Para depurar
            }

            return $sent;
        }
        
        Yii::error('Error de validación', __METHOD__); // Para depurar
        return false;
    }

    /**
     * Crea y guarda una notificación en la base de datos.
     *
     * @return bool si se pudo guardar la notificación.
     */
    public function createNotification()
    {
        Yii::error('Creando notificación...', __METHOD__); // Para depurar

        $notificacion = new Notificacion();
        $notificacion->fecha = date('Y-m-d H:i:s');
        $notificacion->codigo_de_clase = 'SOLICITUD_CONTACTO';
        $notificacion->USUARIOid = Yii::$app->user->id ?? 0; // Si no está logueado, se asigna 0
        $notificacion->USUARIOid2 = 1; // Administrador (puedes cambiar esto a otro ID si lo necesitas)
        $notificacion->ACTIVIDADid = 0; // Sin actividad relacionada
        $notificacion->texto = "Nuevo mensaje de contacto de {$this->name}: {$this->subject}";

        if ($notificacion->save()) {
            Yii::error('Notificación guardada exitosamente', __METHOD__); // Para depurar
            return true;
        } else {
            Yii::error('Error al guardar la notificación', __METHOD__); // Para depurar
        }

        return false;
    }
}
