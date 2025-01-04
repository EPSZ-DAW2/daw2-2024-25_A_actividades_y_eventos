<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "actividad".
 *
 * @property int $id
 * @property string|null $titulo
 * @property string|null $descripcion
 * @property string|null $fecha_celebracion
 * @property int|null $duracion_estimada
 * @property string|null $lugar_celebracion
 * @property string|null $detalles
 * @property string|null $notas
 * @property int|null $edad_recomendada
 * @property int|null $votosOK
 * @property int|null $votosKO
 
 */
class Actividad extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'ACTIVIDAD';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['fecha_celebracion'], 'safe'],
            [['duracion_estimada', 'edad_recomendada', 'votosOK', 'votosKO'], 'integer'],
            [['titulo', 'descripcion', 'lugar_celebracion', 'detalles', 'notas'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'titulo' => 'Titulo',
            'descripcion' => 'Descripcion',
            'fecha_celebracion' => 'Fecha Celebracion',
            'duracion_estimada' => 'Duracion Estimada',
            'lugar_celebracion' => 'Lugar Celebracion',
            'detalles' => 'Detalles',
            'notas' => 'Notas',
            'edad_recomendada' => 'Edad Recomendada',
            'votosOK' => 'Votos Ok',
            'votosKO' => 'Votos Ko'
        ];
    }
}
