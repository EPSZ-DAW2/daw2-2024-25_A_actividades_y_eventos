<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

/**
 * This is the model class for table "usuario".
 *
 * @property int $id
 * @property string|null $nick
 * @property string|null $password
 * @property string|null $email
 * @property string|null $nombre
 * @property string|null $apellidos
 * @property string|null $fecha_nacimiento
 * @property string|null $ubicacion
 * @property int|null $activo
 * @property string|null $fecha_registro
 * @property int|null $registro_confirmado
 * @property int|null $revisado
 * @property string|null $ultimo_acceso
 * @property int|null $intentos_acceso
 * @property int|null $bloqueado
 * @property string|null $fecha_bloqueo
 * @property string|null $motivo_bloqueo
 * @property string|null $notas
 *
 * @property Notificacion[] $notificaciones
 * @property Notificacion[] $notificaciones0
 * @property Roles[] $roles
 * @property Seguimiento[] $seguimientos
 */
class Usuario extends ActiveRecord implements IdentityInterface
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        // return '{{%usuario}}';
        return 'usuario';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['fecha_nacimiento', 'fecha_registro', 'ultimo_acceso', 'fecha_bloqueo'], 'safe'],
            [['activo', 'registro_confirmado', 'revisado', 'intentos_acceso', 'bloqueado'], 'integer'],
            [['notas'], 'string'],
            [['nick', 'password', 'email', 'nombre', 'apellidos', 'ubicacion', 'motivo_bloqueo'], 'string', 'max' => 500],
            [['nick', 'email'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'nick' => Yii::t('app', 'Nick'),
            'password' => Yii::t('app', 'Password'),
            'email' => Yii::t('app', 'Email'),
            'nombre' => Yii::t('app', 'Nombre'),
            'apellidos' => Yii::t('app', 'Apellidos'),
            'fecha_nacimiento' => Yii::t('app', 'Fecha Nacimiento'),
            'ubicacion' => Yii::t('app', 'Ubicacion'),
            'activo' => Yii::t('app', 'Activo'),
            'fecha_registro' => Yii::t('app', 'Fecha Registro'),
            'registro_confirmado' => Yii::t('app', 'Registro Confirmado'),
            'revisado' => Yii::t('app', 'Revisado'),
            'ultimo_acceso' => Yii::t('app', 'Ultimo Acceso'),
            'intentos_acceso' => Yii::t('app', 'Intentos Acceso'),
            'bloqueado' => Yii::t('app', 'Bloqueado'),
            'fecha_bloqueo' => Yii::t('app', 'Fecha Bloqueo'),
            'motivo_bloqueo' => Yii::t('app', 'Motivo Bloqueo'),
            'notas' => Yii::t('app', 'Notas'),
        ];
    }

    public function getId(){
        return $this->id;
    }

    public static function findIdentity($id){
        return static::findOne($id);
    }

    public static function findByNick($nick){
        return static::findOne(['nick' => $nick]);
    }

    public function validatePassword($password){
        //TO DO: Encriptar la contraseña
        return $this->password === $password;
    }

    public static function findIdentityByAccessToken($token, $type = null){
        //TO DO: Implementar la busqueda por token
        return null;
    }

    public function getAuthKey()
    {
        //TO DO: Implementar la generación de clave de autenticación
        return null; 
    }

    public function validateAuthKey($authKey){
        // TO DO: Implementar la validación de la clave de autenticación
        return false; 
    }

    /**
     * Atributo virtual que devuelve el nombre competo
     */
    public function getNombreCompleto(){
        $nombreCompleto = "$this->nombre $this->apellidos";
        return $nombreCompleto;
    }



    /**
     * Gets query for [[Notificaciones]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getNotificaciones()
    {
        return $this->hasMany(Notificacion::class, ['usuario_destino' => 'id']);
    }

    /**
     * Gets query for [[Notificaciones0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getNotificaciones0()
    {
        return $this->hasMany(Notificacion::class, ['usuario_origen' => 'id']);
    }

    /**
     * Gets query for [[Roles]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getRoles()
    {
        return $this->hasMany(Roles::class, ['nombre_usuario' => 'nick']);
    }

    /**
     * Gets query for [[Seguimientos]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSeguimientos()
    {
        return $this->hasMany(Seguimiento::class, ['usuario_seguidor' => 'id']);
    }
}
