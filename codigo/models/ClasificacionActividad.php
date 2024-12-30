<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "clasificacion_actividad".
 *
 * @property int $id
 * @property int|null $clasificacion
 * @property string|null $actividad
 *
 * @property Actividad[] $actividads
 * @property Clasificacion $clasificacion0
 */
class ClasificacionActividad extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'clasificacion_actividad';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['clasificacion'], 'integer'],
            [['actividad'], 'string', 'max' => 500],
            [['clasificacion'], 'exist', 'skipOnError' => true, 'targetClass' => Clasificacion::class, 'targetAttribute' => ['clasificacion' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'clasificacion' => 'Clasificacion',
            'actividad' => 'Actividad',
        ];
    }

    /**
     * Gets query for [[Actividads]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getActividads()
    {
        return $this->hasMany(Actividad::class, ['clasificacion' => 'id']);
    }

    /**
     * Gets query for [[Clasificacion0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getClasificacion0()
    {
        return $this->hasOne(Clasificacion::class, ['id' => 'clasificacion']);
    }
}
