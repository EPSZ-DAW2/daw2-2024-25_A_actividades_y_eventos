<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "usuario_imagen".
 *
 * @property int $usuario_id
 * @property int $imagen_id
 *
 * @property Imagen $imagen
 * @property Usuario $usuario
 */
class UsuarioImagen extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'usuario_imagen';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['usuario_id', 'imagen_id'], 'required'],
            [['usuario_id', 'imagen_id'], 'integer'],
            [['imagen_id'], 'exist', 'skipOnError' => true, 'targetClass' => Imagen::class, 'targetAttribute' => ['imagen_id' => 'id']],
            [['usuario_id'], 'exist', 'skipOnError' => true, 'targetClass' => Usuario::class, 'targetAttribute' => ['usuario_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'usuario_id' => Yii::t('app', 'Usuario ID'),
            'imagen_id' => Yii::t('app', 'Imagen ID'),
        ];
    }

    /**
     * Gets query for [[Imagen]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getImagen()
    {
        return $this->hasOne(Imagen::class, ['id' => 'imagen_id'])->select(['id', 'ruta_archivo', 'nombre_Archivo', 'extension']);
    }

    /**
     * Gets query for [[Usuario]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUsuario()
    {
        return $this->hasOne(Usuario::class, ['id' => 'usuario_id']);
    }
}
