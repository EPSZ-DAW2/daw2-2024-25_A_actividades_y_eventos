<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "registro_acciones".
 *
 * @property int $id
 * @property string|null $usuario_accion
 * @property string|null $fecha_accion
 * @property string|null $accion
 */
class RegistroAcciones extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'registro_acciones';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['fecha_accion'], 'safe'],
            [['accion'], 'string'],
            [['usuario_accion'], 'string', 'max' => 500],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'usuario_accion' => 'Usuario Acción',
            'fecha_accion' => 'Fecha Acción',
            'accion' => 'Acción',
        ];
    }
}
