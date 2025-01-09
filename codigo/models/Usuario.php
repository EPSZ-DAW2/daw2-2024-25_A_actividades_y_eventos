<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;
use yii\db\Query;
use yii\web\IdentityInterface;
use yii\web\UploadedFile;

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
 * @property int|null $activo
 * @property string|null $fecha_registor
 * @property int|null $registro_confirmado
 * @property string|null $fecha_bloqueo
 * @property string|null $motivo_bloqueo
 * @property string|null $notas
 * @property int|null $imagen_id
 *
 * @property Imagen $imagen
 */
class Usuario extends ActiveRecord implements IdentityInterface
{
    public $currentPassword;
    public $newPassword;
    public $confirmNewPassword;
    public $newEmail;
    public $confirmNewEmail;
    public $imageFile;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'usuario';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['notas'], 'string'],
            [['nick', 'email'], 'unique'],
            [['nick', 'password', 'email', 'nombre', 'apellidos', 'motivo_bloqueo'], 'string', 'max' => 500],
            [['fecha_nacimiento', 'fecha_registor', 'fecha_bloqueo'], 'safe'],
            [['activo', 'registro_confirmado', 'imagen_id'], 'integer'],
            [['nick', 'password', 'email', 'nombre', 'apellidos', 'motivo_bloqueo', 'notas'], 'string', 'max' => 255],
            [['currentPassword', 'newPassword', 'confirmNewPassword'], 'required', 'on' => 'changePassword'],
            ['newPassword', 'compare', 'compareAttribute' => 'confirmNewPassword', 'on' => 'changePassword'],
            [['newEmail', 'confirmNewEmail'], 'required', 'on' => 'changeEmail'],
            ['newEmail', 'email', 'on' => 'changeEmail'],
            ['newEmail', 'compare', 'compareAttribute' => 'confirmNewEmail', 'on' => 'changeEmail'],
            ['newEmail', 'email', 'on' => 'changeEmail'],
            [['imageFile'], 'file', 'extensions' => 'png, jpg, jpeg', 'maxSize' => 1024 * 1024 * 2], // 2MB max
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
            'password' => Yii::t('app', 'Contraseña'),
            'email' => Yii::t('app', 'Correo Electrónico'),
            'nombre' => Yii::t('app', 'Nombre'),
            'apellidos' => Yii::t('app', 'Apellidos'),
            'fecha_nacimiento' => Yii::t('app', 'Fecha de Nacimiento'),
            'activo' => Yii::t('app', 'Activo'),
            'fecha_registor' => Yii::t('app', 'Fecha de Registro'),
            'registro_confirmado' => Yii::t('app', 'Registro Confirmado'),
            'fecha_bloqueo' => Yii::t('app', 'Fecha de Bloqueo'),
            'motivo_bloqueo' => Yii::t('app', 'Motivo de Bloqueo'),
            'notas' => Yii::t('app', 'Notas'),
            'imagen_id' => Yii::t('app', 'Imagen ID'),
            'imageFile' => Yii::t('app', 'Subir nueva foto de perfil'),
        ];
    }

    public function getEdad(){
        $fechaNacimiento = new \DateTime($this->fecha_nacimiento);
        $hoy = new \DateTime();
        $edad = $hoy->diff($fechaNacimiento);
        return $edad->y;
    }

    public function getId(){
        return $this->id;
    }

    public function getRol(){
        return $this->hasOne(Roles::class, ['id' => 'ROLESid'])
            ->viaTable('usuario_roles', ['USUARIOid' => 'id']);
    }

    /**
     * Metodo para asignar un rol a un usuario (refactorizar)
     * 
     */
    public function asignarRol($rol){
        $db = Yii::$app->db;
        $db->createCommand('INSERT INTO usuario_roles (USUARIOid, ROLESid) VALUES (:usuario, :rol)')
            ->bindValue(':usuario', $this->id)
            ->bindValue(':rol', $rol)
            ->execute();
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
        return $this->hasMany(Notificacion::class, ['USUARIOid2' => 'id']);
    }

    /**
     * Gets query for [[Notificaciones0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getNotificaciones0()
    {
        return $this->hasMany(Notificacion::class, ['USUARIOid' => 'id']);
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

    /**
     * Cambia la contraseña del usuario después de validar los datos proporcionados.
     *
     * @return bool Si la contraseña se cambió con éxito.
     */
    public function changePassword()
    {
        // Validar que la contraseña actual sea correcta
        if (!$this->validatePassword($this->currentPassword)) {
            $this->addError('currentPassword', 'La contraseña actual es incorrecta.');
            return false;
        }

        // Verificar que la nueva contraseña y su confirmación coincidan
        if ($this->newPassword !== $this->confirmNewPassword) {
            $this->addError('confirmNewPassword', 'La nueva contraseña y su confirmación no coinciden.');
            return false;
        }

        // Aquí puedes agregar validaciones adicionales para la nueva contraseña si es necesario
        if (strlen($this->newPassword) < 8) { // Ejemplo: longitud mínima de 8 caracteres
            $this->addError('newPassword', 'La nueva contraseña debe tener al menos 8 caracteres.');
            return false;
        }

        // OJO-REVISAR - HACER HASH
        // Cambiar la contraseña 
        $this->password = $this->newPassword;

        // Guardar los cambios en la base de datos
        if ($this->save(false, ['password'])) {
            return true;
        }

        $this->addError('password', 'No se pudo actualizar la contraseña.');
        return false;
    }

    public function changeEmail()
    {
        if (!$this->validate()) {
            return false;
        }

        $this->email = $this->newEmail;
        return $this->save(false);
    }

    public function scenarios()
    {
        return array_merge(parent::scenarios(), [
            'changePassword' => ['currentPassword', 'newPassword', 'confirmNewPassword'],
            'changeEmail' => ['newEmail', 'confirmNewEmail'],
            'registerNewUser' => ['nick', 'password', 'email', 'nombre', 'apellidos', 'fecha_nacimiento'],
        ]);
    }

    public function getUsuarioOptions()
    {
        $usuarios = self::find()->all();
        $usuarioOptions = [];
        foreach ($usuarios as $usuario) {
            $usuarioOptions[$usuario->id] = $usuario->nick;
        }
        return $usuarioOptions;
    }

    public function getImagen(){
        return $this->hasOne(UsuarioImagen::class, ['usuario_id' => 'id']);
    }
}
