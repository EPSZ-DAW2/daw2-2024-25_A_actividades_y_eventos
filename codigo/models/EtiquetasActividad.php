<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "etiquetas_actividad".
 *
 * @property int $id
 * @property int|null $etiqueta
 * @property string|null $actividad
 *
 * @property Actividad[] $actividads
 * @property Etiquetas $etiqueta0
 */
class EtiquetasActividad extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'etiquetas_actividad';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['etiqueta'], 'integer'],
            [['actividad'], 'string', 'max' => 500],
            [['etiqueta'], 'exist', 'skipOnError' => true, 'targetClass' => Etiquetas::class, 'targetAttribute' => ['etiqueta' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'etiqueta' => 'Etiqueta',
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
        return $this->hasMany(Actividad::class, ['etiquetas' => 'id']);
    }

    /**
     * Gets query for [[Etiqueta0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getEtiqueta0()
    {
        return $this->hasOne(Etiquetas::class, ['id' => 'etiqueta']);
    }
}
