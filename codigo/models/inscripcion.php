<?php

/*

CREATE TABLE `INSCRIPCION` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `usuario_id` INT NOT NULL,
  `actividad_id` INT NOT NULL,
  `fecha_inscripcion` DATETIME DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (`usuario_id`) REFERENCES `USUARIO`(`id`),
  FOREIGN KEY (`actividad_id`) REFERENCES `ACTIVIDAD`(`id`)
);

*/

namespace app\models;

use Yii;
use app\models\Actividad;
use app\models\Usuario;

/**
 * This is the model class for table "INSCRIPCION".
 *
 * @property int $id
 * @property int $usuario_id
 * @property int $actividad_id
 * @property string $fecha_inscripcion
 *
 * @property Actividad $actividad
 * @property Usuario $usuario
 */
class Inscripcion extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'INSCRIPCION';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['usuario_id', 'actividad_id'], 'required'],
            [['usuario_id', 'actividad_id'], 'integer'],
            [['fecha_inscripcion'], 'safe'],
            [['actividad_id'], 'exist', 'skipOnError' => true, 'targetClass' => Actividad::class, 'targetAttribute' => ['actividad_id' => 'id']],
            [['usuario_id'], 'exist', 'skipOnError' => true, 'targetClass' => Usuario::class, 'targetAttribute' => ['usuario_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'usuario_id' => 'Usuario',
            'actividad_id' => 'Actividad',
            'fecha_inscripcion' => 'Fecha de Inscripción',
        ];
    }

    /**
     * Gets query for [[Actividad]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getActividad()
    {
        return $this->hasOne(Actividad::class, ['id' => 'actividad_id']);
    }

    /**
     * Gets query for [[Usuario]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUsuario()
    {
        return $this->hasOne(Usuario::class, ['id' => 'usuario_id']);
    }
}
