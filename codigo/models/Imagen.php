<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "imagen".
 *
 * @property int $id
 * @property string|null $titulo
 * @property string|null $descripcion
 * @property string|null $nombre_Archivo
 * @property string $ruta_archivo
 * @property string|null $extension
 * @property string|null $notas
 */
class Imagen extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'imagen';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['ruta_archivo'], 'required'],
            [['titulo', 'descripcion', 'nombre_Archivo', 'ruta_archivo', 'extension', 'notas'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'titulo' => Yii::t('app', 'Titulo'),
            'descripcion' => Yii::t('app', 'Descripcion'),
            'nombre_Archivo' => Yii::t('app', 'Nombre Archivo'),
            'ruta_archivo' => Yii::t('app', 'Ruta Archivo'),
            'extension' => Yii::t('app', 'Extension'),
            'notas' => Yii::t('app', 'Notas'),
        ];
    }

    /**
     * Gets query for [[UsuarioImagens]].
     *
     * @return \yii\db\ActiveQuery | null
     */
    public function getUsuarioImagen()
    {
        // Un usuario solo tiene una imagen de perfil
        return $this->hasOne(UsuarioImagen::class, ['imagen_id' => 'id']);
    }

    /**
     * Gets the complete path of the image
     * @param bool $perfil whether to return the profile image path
     * @return string
     */
    public function getRutaCompleta($perfil = false)
    {
        if (empty($this->ruta_archivo)) {
            return Yii::getAlias('@web/images/perfiles/no-photo.png');
        }
        
        $path = $this->ruta_archivo;
        return Yii::getAlias('@web/' . $path);
    }
}
