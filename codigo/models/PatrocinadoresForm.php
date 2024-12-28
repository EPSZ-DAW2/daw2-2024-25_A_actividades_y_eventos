<?php
namespace app\models;

use Yii;
use yii\base\Model;

class PatrocinadoresForm extends Model
{
    // Campos que tendrá el formulario
    public $id;
    public $nick;
    public $password;
    public $email;
    public $nombre;
    public $apellidos;
    public $fecha_nacimiento;
    public $ubicacion;
    public $activo;
    public $fecha_registro;
    public $registro_confirmado;
    public $revisado;
    public $ultimo_acceso;
    public $intentos_acceso;
    public $bloqueado;
    public $fecha_bloqueo;
    public $motivo_bloqueo;
    public $notas;

    // Reglas de validación
    public function rules()
    {
        return [
            // Estos campos serán obligatorios
            [['nick', 'password', 'email', 'nombre', 'apellidos'], 'required','message' => 'Este campo es obligatorio'],
            // Validación de los campos de tipo fecha
            [['fecha_nacimiento', 'fecha_registro', 'ultimo_acceso', 'fecha_bloqueo'], 'safe'],
            // Validación de los campos numéricos
            [['activo', 'registro_confirmado', 'revisado', 'intentos_acceso', 'bloqueado'], 'integer'],
            // Validación de los campos booleanos
            [['motivo_bloqueo', 'notas'], 'string'],
            // Validación de la longitud de los campos
            [['nick', 'email', 'nombre', 'apellidos', 'ubicacion'], 'string', 'max' => 255],
            // Validación de la longitud de la contraseña (mínimo 8 caracteres)
            ['password', 'string', 'min' => 8, 'max' => 512, 'tooShort' => 'La contraseña debe tener como mínimo 8 caracteres'],
           
        ];
        
    }

    // Método para obtener las etiquetas de los campos
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'nick' => 'Nick',
            'password' => 'Contraseña',
            'email' => 'Email',
            'nombre' => 'Nombre',
            'apellidos' => 'Apellidos',
            'fecha_nacimiento' => 'Fecha de Nacimiento',
            'ubicacion' => 'Ubicación',
            'activo' => 'Activo',
            'fecha_registro' => 'Fecha de Registro',
            'registro_confirmado' => 'Registro Confirmado',
            'revisado' => 'Revisado',
            'ultimo_acceso' => 'Último Acceso',
            'intentos_acceso' => 'Intentos de Acceso',
            'bloqueado' => 'Bloqueado',
            'fecha_bloqueo' => 'Fecha de Bloqueo',
            'motivo_bloqueo' => 'Motivo de Bloqueo',
            'notas' => 'Notas',
        ];
    }
}
