<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "patrocinios_actividad".
 *
 * @property int $id
 * @property int|null $actividad
 * @property int|null $anuncio
 *
 * @property Actividad $actividad0
 * @property Actividad[] $actividads
 * @property Anuncio $anuncio0
 */
class PatrociniosActividad extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'patrocinios_actividad';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['actividad', 'anuncio'], 'integer'],
            [['actividad'], 'exist', 'skipOnError' => true, 'targetClass' => Actividad::class, 'targetAttribute' => ['actividad' => 'id']],
            [['anuncio'], 'exist', 'skipOnError' => true, 'targetClass' => Anuncio::class, 'targetAttribute' => ['anuncio' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'actividad' => 'Actividad',
            'anuncio' => 'Anuncio',
        ];
    }

    /**
     * Gets query for [[Actividad0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getActividad0()
    {
        return $this->hasOne(Actividad::class, ['id' => 'actividad']);
    }

    /**
     * Gets query for [[Actividads]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getActividads()
    {
        return $this->hasMany(Actividad::class, ['patrocinios_actividad' => 'id']);
    }

    /**
     * Gets query for [[Anuncio0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAnuncio0()
    {
        return $this->hasOne(Anuncio::class, ['id' => 'anuncio']);
    }
}
