<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "etiqueta".
 *
 * @property int $id
 * @property string|null $nombre
 * @property string|null $descripcion
 */
class Etiqueta extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'etiquetas';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nombre', 'descripcion'], 'string', 'max' => 255],
            [['nombre', 'descripcion'], 'default', 'value' => null],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'nombre' => 'Nombre',
            'descripcion' => 'Descripción',
        ];
    }

    public function getActividades()
    {
        return $this->hasMany(Actividad::class, ['id' => 'ACTIVIDADid'])
            ->viaTable('ETIQUETAS_ACTIVIDAD', ['ETIQUETASid' => 'id']);
    }
}
