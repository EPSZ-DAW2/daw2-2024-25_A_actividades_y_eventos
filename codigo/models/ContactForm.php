<?php

namespace app\models;

use Yii;
use yii\base\Model;

/**
 * ContactForm es el modelo detrás del formulario de contacto.
 */
class ContactForm extends Model
{
    public $name;
    public $email;
    public $subject;
    public $body;
    public $verifyCode;

    /**
     * @return array las reglas de validación.
     */
    public function rules()
    {
        return [
            // name, email, subject y body son obligatorios
            [['name', 'email', 'subject', 'body'], 'required', 'message' => 'Este campo es obligatorio.'],
            // email debe ser una dirección de correo válida
            ['email', 'email', 'message' => 'Por favor ingrese un correo electrónico válido.'],
            // verifyCode debe ser ingresado correctamente
            ['verifyCode', 'captcha', 'message' => 'El código de verificación es incorrecto.'],
        ];
    }

    /**
     * @return array etiquetas personalizadas para los atributos
     */
    public function attributeLabels()
    {
        return [
            'name' => 'Nombre',
            'email' => 'Correo electrónico',
            'subject' => 'Asunto',
            'body' => 'Mensaje',
            'verifyCode' => 'Código de verificación',
        ];
    }

    /**
     * Envía un correo electrónico a la dirección especificada usando la información recopilada por este modelo.
     * @param string $email la dirección de correo electrónico de destino
     * @return bool si el modelo pasa la validación
     */
    public function contact($email)
    {
        if ($this->validate()) {
            Yii::$app->mailer->compose()
                ->setTo($email)
                ->setFrom([Yii::$app->params['senderEmail'] => Yii::$app->params['senderName']])
                ->setReplyTo([$this->email => $this->name])
                ->setSubject($this->subject)
                ->setTextBody($this->body)
                ->send();

            return true;
        }
        return false;
    }
}
