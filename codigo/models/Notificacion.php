<?php

namespace app\models;

use Yii;
use \yii\db\ActiveRecord;

/**
 * This is the model class for table "notificaciones".
 *
 * @property int $id
 * @property string|null $fecha
 * @property string|null $codigo_de_clase
 * @property string|null $texto
 * @property int|null $USUARIOid
 * @property int|null $USUARIOid2
 * @property int|null $ACTIVIDADid
 * @property string|null $fecha_lectura
 * @property string|null $fecha_borrado
 * @property string|null $fecha_aceptacion
 *
 * @property Actividad $actividad0
 * @property Usuario $usuarioDestino
 * @property Usuario $usuarioOrigen
 */
class Notificacion extends ActiveRecord
{
    public static function tableName()
    {
        return 'notificacion';
    }

    public function rules()
    {
        return [
            [['fecha', 'fecha_lectura', 'fecha_borrado', 'fecha_aceptacion'], 'safe'],
            [['texto'], 'string'],
            [['USUARIOid', 'USUARIOid2', 'ACTIVIDADid'], 'integer'], // Eliminar 'comentario' si no existe en la tabla
            [['codigo_de_clase'], 'string', 'max' => 500],
            [['ACTIVIDADid'], 'exist', 'skipOnError' => true, 'targetClass' => Actividad::class, 'targetAttribute' => ['ACTIVIDADid' => 'id']],
            [['USUARIOid2'], 'exist', 'skipOnError' => true, 'targetClass' => Usuario::class, 'targetAttribute' => ['USUARIOid2' => 'id']],
            [['USUARIOid'], 'exist', 'skipOnError' => true, 'targetClass' => Usuario::class, 'targetAttribute' => ['USUARIOid' => 'id']],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'fecha' => Yii::t('app', 'Fecha'),
            'codigo_de_clase' => Yii::t('app', 'Cod Clase'),
            'texto' => Yii::t('app', 'Texto'),
            'USUARIOid' => Yii::t('app', 'Usuario Origen'),
            'USUARIOid2' => Yii::t('app', 'Usuario Destino'),
            'ACTIVIDADid' => Yii::t('app', 'Actividad'),
            'fecha_lectura' => Yii::t('app', 'Fecha Lectura'),
            'fecha_borrado' => Yii::t('app', 'Fecha Borrado'),
            'fecha_aceptacion' => Yii::t('app', 'Fecha Aceptacion'),
        ];
    }

    /**
     * Gets query for [[Actividad0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getActividad0()
    {
        return $this->hasOne(Actividad::class, ['id' => 'ACTIVIDADid']);
    }
    /**
     * Gets query for [[UsuarioDestino]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUsuarioDestino()
    {
        return $this->hasOne(Usuario::class, ['id' => 'USUARIOid2']);
    }

    /**
     * Gets query for [[UsuarioOrigen]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUsuarioOrigen()
    {
        return $this->hasOne(Usuario::class, ['id' => 'USUARIOid']);
    }
}
