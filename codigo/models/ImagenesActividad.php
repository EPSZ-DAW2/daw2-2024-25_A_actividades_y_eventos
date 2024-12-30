<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "imagenes_actividad".
 *
 * @property int $id
 * @property int|null $imagen
 * @property string|null $actividad
 * @property int|null $orden
 *
 * @property Actividad[] $actividads
 * @property Imagen $imagen0
 */
class ImagenesActividad extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'imagenes_actividad';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['imagen', 'orden'], 'integer'],
            [['actividad'], 'string', 'max' => 500],
            [['imagen'], 'exist', 'skipOnError' => true, 'targetClass' => Imagen::class, 'targetAttribute' => ['imagen' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'imagen' => 'Imagen',
            'actividad' => 'Actividad',
            'orden' => 'Orden',
        ];
    }

    /**
     * Gets query for [[Actividads]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getActividads()
    {
        return $this->hasMany(Actividad::class, ['imagenes_adicionales' => 'id']);
    }

    /**
     * Gets query for [[Imagen0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getImagen0()
    {
        return $this->hasOne(Imagen::class, ['id' => 'imagen']);
    }
}
