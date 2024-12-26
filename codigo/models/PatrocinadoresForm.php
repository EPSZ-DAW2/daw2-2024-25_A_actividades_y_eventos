<?php
namespace app\models;

use Yii;
use yii\base\Model;

class PatrocinadoresForm extends Model
{
    // Campos que tendrá el formulario
    public $nombre;
    public $apellido;
    public $password;
    public $email;

    // Reglas de validación
    public function rules()
    {
        return [
            // Estos campos serán obligatorios
            [['nombre', 'apellido', 'email', 'password'], 'required', 'message' => 'Este campo es obligatorio'],
            
            // Validando que el nombre y apellido solo contengan letras
            [['nombre', 'apellido'], 'match', 'pattern' => '/^[a-zA-Z ñÑáéíóúüç]*$/', 'message' => 'El nombre solo puede estar formado por letras'],
            
            // Validación del correo electrónico
            ['email', 'email', 'message' => 'El email es incorrecto'],
            
            // Validación de la longitud de la contraseña (mínimo 8 caracteres)
            ['password', 'string', 'min' => 8, 'tooShort' => 'La contraseña debe tener como mínimo 8 caracteres'],
        ];
    }

    // Método para obtener las etiquetas de los campos
    public function attributeLabels()
    {
        return [
            'nombre' => 'Nombre',
            'apellido' => 'Apellido',
            'email' => 'Email',
            'password' => 'Contraseña',
        ];
    }
}
