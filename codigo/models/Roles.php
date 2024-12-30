<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "roles".
 *
 * @property int $id
 * @property string|null $nombre_usuario
 * @property string|null $rol
 *
 * @property Usuario $nombreUsuario
 * @property Patrocinadores[] $patrocinadores
 */
class Roles extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'roles';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nombre_usuario', 'rol'], 'string', 'max' => 500],
            [['nombre_usuario'], 'exist', 'skipOnError' => true, 'targetClass' => Usuario::class, 'targetAttribute' => ['nombre_usuario' => 'nick']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'nombre_usuario' => Yii::t('app', 'Nombre Usuario'),
            'rol' => Yii::t('app', 'Rol'),
        ];
    }

    /**
     * Gets query for [[NombreUsuario]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getNombreUsuario()
    {
        return $this->hasOne(Usuario::class, ['nick' => 'nombre_usuario']);
    }

    /**
     * Gets query for [[Patrocinadores]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPatrocinadores()
    {
        return $this->hasMany(Patrocinadores::class, ['PROPIETARIO' => 'nombre_usuario']);
    }
}
