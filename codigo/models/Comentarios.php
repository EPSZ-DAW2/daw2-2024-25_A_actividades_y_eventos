<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "comentarios".
 *
 * @property int $id
 * @property int|null $actividad
 * @property int|null $comentario
 *
 * @property Actividad $actividad0
 * @property Actividad[] $actividads
 * @property Comentario $comentario0
 */
class Comentarios extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'comentarios';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['actividad', 'comentario'], 'integer'],
            [['actividad'], 'exist', 'skipOnError' => true, 'targetClass' => Actividad::class, 'targetAttribute' => ['actividad' => 'id']],
            [['comentario'], 'exist', 'skipOnError' => true, 'targetClass' => Comentario::class, 'targetAttribute' => ['comentario' => 'id']],
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
            'comentario' => 'Comentario',
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
        return $this->hasMany(Actividad::class, ['comentarios' => 'id']);
    }

    /**
     * Gets query for [[Comentario0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getComentario0()
    {
        return $this->hasOne(Comentario::class, ['id' => 'comentario']);
    }
}
