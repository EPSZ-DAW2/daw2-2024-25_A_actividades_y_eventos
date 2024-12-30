<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "seguimientos".
 *
 * @property int $id
 * @property string|null $fecha_seguimiento
 * @property int|null $actividad
 * @property int|null $usuario_seguidor
 *
 * @property Actividad $actividad0
 * @property Usuario $usuarioSeguidor
 */
class Seguimientos extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'seguimientos';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['fecha_seguimiento'], 'safe'],
            [['actividad', 'usuario_seguidor'], 'integer'],
            [['actividad'], 'exist', 'skipOnError' => true, 'targetClass' => Actividad::class, 'targetAttribute' => ['actividad' => 'id']],
            [['usuario_seguidor'], 'exist', 'skipOnError' => true, 'targetClass' => Usuario::class, 'targetAttribute' => ['usuario_seguidor' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'fecha_seguimiento' => 'Fecha Seguimiento',
            'actividad' => 'Actividad',
            'usuario_seguidor' => 'Usuario Seguidor',
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
     * Gets query for [[UsuarioSeguidor]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUsuarioSeguidor()
    {
        return $this->hasOne(Usuario::class, ['id' => 'usuario_seguidor']);
    }
}
