<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "usuarios".
 *
 * @property int $id
 * @property string $nick
 * @property string $contraseña
 * @property string $email
 * @property string $nombre
 * @property string $apellidos
 * @property string $fecha_nacimiento
 * @property string|null $direccion
 * @property string $ubicacion
 * @property int|null $activo
 * @property string|null $fecha_hora_registro
 * @property int|null $registro_confirmado
 * @property int|null $revisado
 * @property string|null $ultimo_acceso
 * @property int|null $intentos_acceso
 * @property int|null $bloqueado
 * @property string|null $fecha_hora_bloqueo
 * @property string|null $motivo_bloqueo
 * @property float|null $valoracion_usuario
 * @property string|null $notas
 */
class Usuarios extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'usuarios';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nick', 'contraseña', 'email', 'nombre', 'apellidos', 'fecha_nacimiento', 'ubicacion'], 'required'],
            [['fecha_nacimiento', 'fecha_hora_registro', 'ultimo_acceso', 'fecha_hora_bloqueo'], 'safe'],
            [['activo', 'registro_confirmado', 'revisado', 'intentos_acceso', 'bloqueado'], 'integer'],
            [['motivo_bloqueo', 'notas'], 'string'],
            [['valoracion_usuario'], 'number'],
            [['nick'], 'string', 'max' => 50],
            [['contraseña', 'direccion', 'ubicacion'], 'string', 'max' => 255],
            [['email', 'nombre'], 'string', 'max' => 100],
            [['apellidos'], 'string', 'max' => 150],
            [['nick'], 'unique'],
            [['email'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'nick' => 'Nick',
            'contraseña' => 'Contraseña',
            'email' => 'Email',
            'nombre' => 'Nombre',
            'apellidos' => 'Apellidos',
            'fecha_nacimiento' => 'Fecha Nacimiento',
            'direccion' => 'Direccion',
            'ubicacion' => 'Ubicacion',
            'activo' => 'Activo',
            'fecha_hora_registro' => 'Fecha Hora Registro',
            'registro_confirmado' => 'Registro Confirmado',
            'revisado' => 'Revisado',
            'ultimo_acceso' => 'Ultimo Acceso',
            'intentos_acceso' => 'Intentos Acceso',
            'bloqueado' => 'Bloqueado',
            'fecha_hora_bloqueo' => 'Fecha Hora Bloqueo',
            'motivo_bloqueo' => 'Motivo Bloqueo',
            'valoracion_usuario' => 'Valoracion Usuario',
            'notas' => 'Notas',
        ];
    }
}
