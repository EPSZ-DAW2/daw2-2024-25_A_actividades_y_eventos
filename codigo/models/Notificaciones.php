<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "notificaciones".
 *
 * @property int $id
 * @property string|null $fecha
 * @property string|null $codigo_de_clase
 * @property string|null $texto
 * @property int|null $USUARIOid
 * @property int|null $USUARIOid2
 * @property int|null $actividad
 * @property int|null $comentario
 * @property string|null $fecha_lectura
 * @property string|null $fecha_borrado
 * @property string|null $fecha_aceptacion
 *
 * @property Actividad $actividad0
 * @property Comentario $comentario0
 * @property Usuario $usuarioDestino
 * @property Usuario $usuarioOrigen
 */
class Notificaciones extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'notificaciones';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['fecha', 'fecha_lectura', 'fecha_borrado', 'fecha_aceptacion'], 'safe'],
            [['texto'], 'string'],
            [['USUARIOid', 'USUARIOid2', 'ACTIVIDADid', 'comentario'], 'integer'],
            [['codigo_de_clase'], 'string', 'max' => 500],
            [['ACTIVIDADid'], 'exist', 'skipOnError' => true, 'targetClass' => Actividad::class, 'targetAttribute' => ['actividad' => 'id']],
            [['comentario'], 'exist', 'skipOnError' => true, 'targetClass' => Comentario::class, 'targetAttribute' => ['comentario' => 'id']],
            [['USUARIOid2'], 'exist', 'skipOnError' => true, 'targetClass' => Usuario::class, 'targetAttribute' => ['USUARIOid2' => 'id']],
            [['USUARIOid'], 'exist', 'skipOnError' => true, 'targetClass' => Usuario::class, 'targetAttribute' => ['USUARIOid' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'fecha' => 'Fecha',
            'codigo_de_clase' => 'Cod Clase',
            'texto' => 'Texto',
            'USUARIOid' => 'Usuario Origen',
            'USUARIOid2' => 'Usuario Destino',
            'ACTIVIDADid' => 'Actividad',
            'comentario' => 'Comentario',
            'fecha_lectura' => 'Fecha Lectura',
            'fecha_borrado' => 'Fecha Borrado',
            'fecha_aceptacion' => 'Fecha Aceptacion',
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
     * Gets query for [[Comentario0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getComentario0()
    {
        return $this->hasOne(Comentario::class, ['id' => 'comentario']);
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
