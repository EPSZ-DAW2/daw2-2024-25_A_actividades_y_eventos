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
    public function rules(){
        return [
            [['notas'], 'string'],
            [['nick', 'email'], 'unique'],
            [['nick', 'password', 'email', 'nombre', 'apellidos', 'motivo_bloqueo'], 'string', 'max' => 500],
            [['fecha_nacimiento', 'fecha_registor', 'fecha_bloqueo'], 'safe'],
            [['activo', 'registro_confirmado', 'imagen_id'], 'integer'],
            [['nick', 'password', 'email', 'nombre', 'apellidos', 'motivo_bloqueo', 'notas'], 'string', 'max' => 255],
            

            //Creo las reglas para el escenario registerNewUser
            [['nick', 'password', 'email', 'nombre', 'apellidos', 'fecha_nacimiento'], 'required', 'on' => 'registerNewUser'],
            [['email'], 'email', 'on' => 'registerNewUser', 'message' => 'El formato del correo electrónico no es válido.'],
            [['password'], 'string', 'min' => 8, 'on' => 'registerNewUser', 'message' => 'La contraseña debe tener al menos 8 caracteres.'], // Mínimo 8 caracteres
            [['fecha_nacimiento'], 'date', 'format' => 'yyyy-MM-dd', 'on' => 'registerNewUser', 'message' => 'El formato de la fecha de nacimiento no es válido.'],
            [['fecha_nacimiento'], 'compare', 'compareValue' => date('Y-m-d', strtotime('-16 years')), 'operator' => '<=', 'on' => 'registerNewUser', 'message' => 'Debes tener al menos 16 años para registrarte.'],

            [['currentPassword', 'newPassword', 'confirmNewPassword'], 'string', 'on' => 'changeData'],
            [['newEmail', 'confirmNewEmail'], 'email', 'on' => 'changeData', 'message' => 'El formato del correo electrónico no es válido.'],
            [['newPassword'], 'string', 'min' => 8, 'on' => 'changeData', 'message' => 'La contraseña debe tener al menos 8 caracteres.'], // Mínimo 8 caracteres

            ['newPassword', 'compare', 'compareAttribute' => 'confirmNewPassword', 'on' => 'changeData', 'message' => 'Las contraseñas no coinciden.'], // Validación de comparación
            ['newEmail', 'compare', 'compareAttribute' => 'confirmNewEmail', 'on' => 'changeData', 'message' => 'Los correos electrónicos no coinciden.'],

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
            'currentPassword' => Yii::t('app', 'Contraseña actual'),
            'newPassword' => Yii::t('app', 'Nueva contraseña'),
            'confirmNewPassword' => Yii::t('app', 'Confirmar nueva contraseña'),
            'newEmail' => Yii::t('app', 'Nuevo correo electrónico'),
            'confirmNewEmail' => Yii::t('app', 'Confirmar nuevo correo electrónico'),
        ];
    }

    public function getEdad()
    {
        $fechaNacimiento = new \DateTime($this->fecha_nacimiento);
        $hoy = new \DateTime();
        $edad = $hoy->diff($fechaNacimiento);
        return $edad->y;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getRol()
    {
        return $this->hasOne(Roles::class, ['id' => 'ROLESid'])
            ->viaTable('usuario_roles', ['USUARIOid' => 'id']);
    }

    public function asignarRol($rol)
    {
        $db = Yii::$app->db;
        $db->createCommand('INSERT INTO usuario_roles (USUARIOid, ROLESid) VALUES (:usuario, :rol)')
            ->bindValue(':usuario', $this->id)
            ->bindValue(':rol', $rol)
            ->execute();
    }

    public static function findIdentity($id)
    {
        return static::findOne($id);
    }

    public static function findByNick($nick)
    {
        return static::findOne(['nick' => $nick]);
    }

    public function validatePassword($password)
    {
        // Validar la contraseña usando el hash almacenado
        return Yii::$app->getSecurity()->validatePassword($password, $this->password);
    }

    public static function findIdentityByAccessToken($token, $type = null)
    {
        return null;
    }

    public function getAuthKey()
    {
        return null;
    }

    public function validateAuthKey($authKey)
    {
        return false;
    }

    public function setPassword($password)
    {
        // Generar hash y asignarlo a la propiedad password
        $this->password = Yii::$app->getSecurity()->generatePasswordHash($password);
        
        // Generar token y asignarlo a la propiedad token
        $this->token = Yii::$app->getSecurity()->generateRandomString() . '_' . time();
    }

    public function changePassword()
    {
        if (!$this->validatePassword($this->currentPassword)) {
            $this->addError('currentPassword', 'La contraseña actual es incorrecta.');
            return false;
        }

        if ($this->newPassword !== $this->confirmNewPassword) {
            $this->addError('confirmNewPassword', 'La nueva contraseña y su confirmación no coinciden.');
            return false;
        }

        if (strlen($this->newPassword) < 8) {
            $this->addError('newPassword', 'La nueva contraseña debe tener al menos 8 caracteres.');
            return false;
        }

        // Asignar y guardar el nuevo hash de la contraseña
        $this->setPassword($this->newPassword);

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

    public function changeData(){
        // Cambiar contraseña
        if ($this->currentPassword && $this->newPassword && $this->confirmNewPassword) {
            if (!$this->changePassword()) {
                return false;
            }
        }

        // Cambiar email
        if ($this->newEmail && $this->confirmNewEmail) {
            if (!$this->changeEmail()) {
                return false;
            }
        }

        return true;
    }

    public function scenarios()
    {
        return array_merge(parent::scenarios(), [
            'changePassword' => ['currentPassword', 'newPassword', 'confirmNewPassword'],
            'changeEmail' => ['newEmail', 'confirmNewEmail'],
            'registerNewUser' => ['nick', 'password', 'email', 'nombre', 'apellidos', 'fecha_nacimiento'],
            'changeData' => ['currentPassword', 'newPassword', 'confirmNewPassword', 'newEmail', 'confirmNewEmail'],
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

    public function getImagen()
    {
        return $this->hasOne(UsuarioImagen::class, ['usuario_id' => 'id']);
    }
}