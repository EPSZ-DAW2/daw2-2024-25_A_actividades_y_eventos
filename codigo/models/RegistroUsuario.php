<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "registro_usuario".
 *
 * @property int $id
 * @property string|null $fecha_creacion
 * @property string|null $usuario_creador
 * @property string|null $fecha_mod
 * @property string|null $usuario_mod
 *
 * @property Actividad[] $actividads
 */
class RegistroUsuario extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'registro_usuario';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['fecha_creacion', 'fecha_mod'], 'safe'],
            [['usuario_creador', 'usuario_mod'], 'string', 'max' => 500],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'fecha_creacion' => 'Fecha Creacion',
            'usuario_creador' => 'Usuario Creador',
            'fecha_mod' => 'Fecha Mod',
            'usuario_mod' => 'Usuario Mod',
        ];
    }

    /**
     * Gets query for [[Actividads]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getActividads()
    {
        return $this->hasMany(Actividad::class, ['registro_usuario' => 'id']);
    }
}
