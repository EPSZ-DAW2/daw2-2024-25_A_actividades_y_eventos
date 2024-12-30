<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "participante".
 *
 * @property int $id
 * @property int|null $actividad
 * @property string|null $usuario
 * @property string|null $fecha_registro
 * @property int|null $cancelado
 * @property string|null $fecha_cancelacion
 * @property string|null $motivo_cancelacion
 * @property string|null $notas
 *
 * @property Actividad $actividad0
 */
class Participante extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'participante';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['actividad', 'cancelado'], 'integer'],
            [['fecha_registro', 'fecha_cancelacion'], 'safe'],
            [['motivo_cancelacion', 'notas'], 'string'],
            [['usuario'], 'string', 'max' => 500],
            [['actividad'], 'exist', 'skipOnError' => true, 'targetClass' => Actividad::class, 'targetAttribute' => ['actividad' => 'id']],
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
            'usuario' => 'Usuario',
            'fecha_registro' => 'Fecha Registro',
            'cancelado' => 'Cancelado',
            'fecha_cancelacion' => 'Fecha Cancelacion',
            'motivo_cancelacion' => 'Motivo Cancelacion',
            'notas' => 'Notas',
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
}
